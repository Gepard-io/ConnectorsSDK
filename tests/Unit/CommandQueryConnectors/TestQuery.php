<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\Unit\CommandQueryConnectors;

use GepardIO\ConnectorsSDK\AbstractConnectorQuery;
use GepardIO\ConnectorsSDK\AssertHelper;
use GepardIO\ConnectorsSDK\Payload;
use Nette\Schema\Expect;

final class TestQuery extends AbstractConnectorQuery
{
    public static function getId(): string
    {
        return 'queryId';
    }

    public static function getDescription(): string
    {
        return 'Query description';
    }

    public function execute(): iterable
    {
        $payloadData = [
            'category' => $this->config->get('category'),
            'brand' => $this->config->get('brand'),
            'productId' => $this->config->get('productId'),
            'productInfo' => 'Product Info',
        ];

        yield new Payload($payloadData);
    }

    public function getSettings(): array
    {
        return [
            'category' => Expect::string()->required(),
            'brand' => Expect::string()->assert(AssertHelper::notEmptyString())->default('DEFAULT-BRAND'),
            'productId' => Expect::string()->nullable()->default(null),
        ];
    }
}
