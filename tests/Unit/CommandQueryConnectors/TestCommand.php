<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\Unit\CommandQueryConnectors;

use GepardIO\ConnectorsSDK\AbstractConnectorCommand;
use GepardIO\ConnectorsSDK\PayloadInterface;
use Nette\Schema\Expect;

final class TestCommand extends AbstractConnectorCommand
{
    public static function getId(): string
    {
        return 'commandId';
    }

    public static function getDescription(): string
    {
        return 'Command description';
    }

    public function execute(PayloadInterface $payload): ?PayloadInterface
    {
        $payload->set('format', $this->config->get('format'));
        $payload->set('productId', 'newId');

        return $payload;
    }

    public function getSettings(): array
    {
        return [
            'format' => Expect::string()->required(),
        ];
    }
}
