<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\Integration\CatApi;

use GepardIO\ConnectorsSDK\AbstractConnectorCommand;
use GepardIO\ConnectorsSDK\Payload;
use GepardIO\ConnectorsSDK\PayloadInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Nette\Schema\Expect;

class UpvoteCommand extends AbstractConnectorCommand
{
    public const CONFIG_NUMBER = 'number';


    public static function getId(): string
    {
        return 'upvote-cats';
    }

    public static function getDescription(): string
    {
        return 'Loop over list of cats (products) and randomly upvote several of them';
    }

    public function getSettings(): array
    {
        return [
            self::CONFIG_NUMBER => Expect::int()->required()->default(1),
        ];
    }

    /**
     * "Simulate processing" of the product using Cat API - upvote image using "product" (cat) ID
     *
     * @param \GepardIO\ConnectorsSDK\PayloadInterface $payload
     *
     * @return \GepardIO\ConnectorsSDK\PayloadInterface|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function execute(PayloadInterface $payload): ?PayloadInterface
    {
        $client = new Client();
        $headers = [
            'Content-Type' => 'application/json',
            'x-api-key' => $this->config->get(CatApiConnector::CONFIG_TOKEN),
        ];

        $result = new Payload();

        /** @var \GepardIO\ConnectorsSDK\DTO\Product\Product $product */
        foreach ($payload->getIterator() as $product) {
            $body = [
                'image_id' => $product->getIdentifier()->getId(),
                'value' => 1,
            ];

            $request = new Request('POST', 'https://api.thecatapi.com/v1/votes', $headers, \json_encode($body));
            $res = $client->send($request);
            $response = \json_decode($res->getBody()->getContents(), true);
            if ($response['message'] === 'SUCCESS') {
                $result->set($response['image_id'], $response);
            }
        }

        return $result;
    }
}
