<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\Integration\CatApi;

use GepardIO\ConnectorsSDK\AssertHelper;
use GepardIO\ConnectorsSDK\Connector;
use Nette\Schema\Expect;

class CatApiConnector extends Connector
{
    public const CONFIG_TOKEN = 'token';


    public static function getId(): string
    {
        return 'cat-api';
    }

    public static function getDescription(): string
    {
        return 'Example of the ConnectorSDK library usage';
    }

    public function getSettings(): array
    {
        return [
            self::CONFIG_TOKEN => Expect::string($_ENV['CAT_API_TOKEN'])->assert(AssertHelper::notEmptyTrimmedString()),
        ];
    }

    public function getQueries(): array
    {
        return [
            ListQuery::class,
        ];
    }

    public function getCommands(): array
    {
        return [
            UpvoteCommand::class,
        ];
    }

}
