<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\Integration\CatApi;

use GepardIO\ConnectorsSDK\AbstractConnectorQuery;
use GepardIO\ConnectorsSDK\DTO\Product\Brand;
use GepardIO\ConnectorsSDK\DTO\Product\Category;
use GepardIO\ConnectorsSDK\DTO\Product\Feature;
use GepardIO\ConnectorsSDK\DTO\Product\FeatureL10n;
use GepardIO\ConnectorsSDK\DTO\Product\Identifier;
use GepardIO\ConnectorsSDK\DTO\Product\Image;
use GepardIO\ConnectorsSDK\DTO\Product\ImageItem;
use GepardIO\ConnectorsSDK\DTO\Product\ProductBuilder;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\BrandL10n;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\CategoryFeature;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\CategoryL10n;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\Feature as TaxonomyFeature;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Nette\Schema\Expect;

class ListQuery extends AbstractConnectorQuery
{
    public const CONFIG_ORDER = 'order';
    public const CONFIG_LIMIT = 'limit';
    public const CONFIG_PAGE = 'page';
    public const CONFIG_HAS_BREEDS = 'has_breeds';


    public static function getId(): string
    {
        return 'list-cats';
    }

    public static function getDescription(): string
    {
        return 'Load list of cats and parse them as a Products';
    }

    public function getSettings(): array
    {
        return [
            self::CONFIG_ORDER => Expect::anyOf('RANDOM', 'ASC', 'DESC')->default('RANDOM'),
            self::CONFIG_LIMIT => Expect::int()->min(1)->max(25)->default(10),
            self::CONFIG_PAGE => Expect::int()->min(1)->default(1),
        ];
    }

    /**
     * @return \GepardIO\ConnectorsSDK\DTO\Product\Product[]
     * @throws \Assert\AssertionFailedException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function execute(): iterable
    {
        $url = 'https://api.thecatapi.com/v1/images/search';
        $query = [
            'format' => 'json',
            self::CONFIG_LIMIT => $this->config->get(self::CONFIG_LIMIT),
            self::CONFIG_ORDER => $this->config->get(self::CONFIG_ORDER),
            self::CONFIG_PAGE => $this->config->get(self::CONFIG_PAGE),
            self::CONFIG_HAS_BREEDS => 1,
        ];

        $url .= '?' . \http_build_query($query);

        $client = new Client();
        $headers = [
            'Content-Type' => 'application/json',
            'x-api-key' => $this->config->get(CatApiConnector::CONFIG_TOKEN),
        ];

        $request = new Request('GET', $url, $headers);
        $res = $client->send($request);

        $body = \json_decode($res->getBody()->getContents(), true);

        foreach ($body as $catInfo) {
            $categoryId = $catInfo['breeds'][0]['id'];

            // "Simulate" product using Cat API response
            $builder = new ProductBuilder(
                new Identifier($catInfo['id'], $catInfo['id']),
                new Brand('cat', new BrandL10n('Cat', 'en-GB')),
                new Category($categoryId, new CategoryL10n($catInfo['breeds'][0]['name'], 'en-GB')),
                'Cat own name for ' . $catInfo['id']
            );

            $builder->setGallery(
                new Image(
                    $catInfo['id'],
                    1,
                    true,
                    ['en-GB'],
                    new ImageItem(ImageItem::TYPE_HIGH, $catInfo['url'], $catInfo['width'], $catInfo['height'])
                )
            );

            $builder->setFeatures(
                new Feature(
                    'temperament',
                    $categoryId,
                    TaxonomyFeature::TYPE_MULTI_SELECT,
                    CategoryFeature::PRIORITY_MANDATORY,
                    [
                        new FeatureL10n(
                            'en-GB',
                            'Temperament',
                            \array_map('trim', \explode(',', $catInfo['breeds'][0]['temperament']))
                        ),
                    ]
                ),
                new Feature(
                    'origin',
                    $categoryId,
                    TaxonomyFeature::TYPE_STRING,
                    CategoryFeature::PRIORITY_MANDATORY,
                    [new FeatureL10n('en-GB', 'Country of origin', [$catInfo['breeds'][0]['origin']])]
                ),
                new Feature(
                    'life_span',
                    $categoryId,
                    TaxonomyFeature::TYPE_STRING,
                    CategoryFeature::PRIORITY_MANDATORY,
                    [new FeatureL10n('en-GB', 'Life span', [$catInfo['breeds'][0]['life_span']])]
                ),
                new Feature(
                    'experimental',
                    $categoryId,
                    TaxonomyFeature::TYPE_BOOLEAN,
                    CategoryFeature::PRIORITY_OPTIONAL,
                    [new FeatureL10n('en-GB', 'Experimental', [(string)$catInfo['breeds'][0]['experimental']])]
                )
            );

            yield $builder->build();
        }
    }
}
