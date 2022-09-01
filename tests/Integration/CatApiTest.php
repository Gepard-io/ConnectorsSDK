<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\Integration;

use GepardIO\ConnectorsSDK\DTO\Product\Product;
use GepardIO\ConnectorsSDK\Payload;
use GepardIO\ConnectorsSDK\Tests\Integration\CatApi\CatApiConnector;
use GepardIO\ConnectorsSDK\Tests\Integration\CatApi\ListQuery;
use GepardIO\ConnectorsSDK\Tests\Integration\CatApi\UpvoteCommand;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

/**
 * How to execute this test:
 *
 * 1. Register and get token from https://thecatapi.com/
 * 2. Copy .env.dist to .env and write token value to CAT_API_TOKEN variable
 * 3. Execute `composer test:integration`
 *
 */
final class CatApiTest extends TestCase
{
    /**
     * Example of "query" usage to get product DTO instances and perform some assertions.
     *
     * @return void
     * @throws \Assert\AssertionFailedException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testListQuery(): void
    {
        $connector = new CatApiConnector(new NullLogger());
        /** @var ListQuery $query */
        $query = $connector->getQuery(ListQuery::getId());

        $products = \iterator_to_array($query->execute());
        $this->assertCount(10, $products);

        /** @var \GepardIO\ConnectorsSDK\DTO\Product\Product[] $products */
        foreach ($products as $product) {
            $this->assertProduct($product);
        }
    }

    /**
     * Example of "query" usage with custom settings to get product DTO instances and perform some assertions.
     *
     * @return void
     * @throws \Assert\AssertionFailedException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testListQueryWithSettings(): void
    {
        $connector = new CatApiConnector(new NullLogger());
        /** @var ListQuery $query */
        $query = $connector->getQuery(
            ListQuery::getId(),
            [
                ListQuery::CONFIG_ORDER => 'ASC',
                ListQuery::CONFIG_LIMIT => 5,
            ]
        );

        $products = \iterator_to_array($query->execute());
        $this->assertCount(5, $products);

        /** @var \GepardIO\ConnectorsSDK\DTO\Product\Product[] $products */
        foreach ($products as $product) {
            $this->assertProduct($product);
        }
    }

    /**
     * Example of "command" usage to upvote random 2 "products" (cat images)
     *
     * @return void
     */
    public function testUpvoteCommand(): void
    {
        $connector = new CatApiConnector(new NullLogger());

        // Load "products" from query
        /** @var ListQuery $query */
        $query = $connector->getQuery(
            ListQuery::getId(),
            [
                ListQuery::CONFIG_LIMIT => 2,
            ]
        );
        $products = \iterator_to_array($query->execute());
        $identifiers = \array_map(
            static fn(Product $product) => $product->getIdentifier()->getId(),
            $products
        );

        /** @var UpvoteCommand $command */
        $command = $connector->getCommand(
            UpvoteCommand::class,
            [
                UpvoteCommand::CONFIG_NUMBER => 2
            ]
        );

        // Each command that is intended to do something with "products" receives payload instance with
        // the list of items
        $payload = new Payload($products);

        // Example will return list of "product" IDs which were upvoted
        /** @var Payload $result */
        $result = $command->execute($payload);

        $this->assertCount(2, $result);
        $this->assertEquals($identifiers, \array_keys($result->toArray()));
    }


    private function assertProduct(Product $product): void
    {
        $this->assertNotEmpty($product->getIdentifier()->getId());
        $this->assertSame($product->getIdentifier()->getId(), $product->getIdentifier()->getMpn());
        $this->assertEquals('Cat', $product->getBrand()->getL10n()[0]->getName());
        $this->assertEquals('cat', $product->getBrand()->getId());
        $this->assertEquals('Cat own name for ' . $product->getIdentifier()->getId(), $product->getModelName());
        $this->assertCount(1, $product->getGallery());
        $this->assertCount(4, $product->getFeatures());
    }
}
