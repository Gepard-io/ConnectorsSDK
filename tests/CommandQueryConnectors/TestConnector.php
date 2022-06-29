<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\CommandQueryConnectors;

use GepardIO\ConnectorsSDK\Connector;
use Nette\Schema\Expect;

final class TestConnector extends Connector
{
    public static function getId(): string
    {
        return 'connectorId';
    }

    public static function getDescription(): string
    {
        return 'Connector description';
    }

    public function getQueries(): array
    {
        return [
            TestQuery::class,
        ];
    }

    public function getCommands(): array
    {
        return [
            TestCommand::class,
        ];
    }

    public function getSettings(): array
    {
        return [
            'user' => Expect::string()->required()->default('testUser'),
            'password' => Expect::string()->required()->default('testPassword'),
        ];
    }
}
