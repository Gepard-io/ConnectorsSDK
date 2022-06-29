<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests;

use GepardIO\ConnectorsSDK\Payload;
use PHPUnit\Framework\TestCase;

final class PayloadTest extends TestCase
{
    public function testPayloadGetData(): void
    {
        $payload = new Payload(['firstKey' => 'firstValue', 'secondKey' => 'secondValue']);

        self::assertSame('firstValue', $payload['firstKey']);
        self::assertSame('secondValue', $payload['secondKey']);
        self::assertSame('firstValue', $payload->get('firstKey'));
        self::assertSame('secondValue', $payload->get('secondKey'));
        self::assertTrue($payload->has('firstKey'));
        self::assertTrue($payload->has('secondKey'));
        self::assertEquals(['firstKey' => 'firstValue', 'secondKey' => 'secondValue'], $payload->toArray());
    }

    public function testCanIndirectlyModifyLikeAnArray(): void
    {
        $payload = new Payload(['firstKey' => 'firstValue', 'secondKey' => 'secondValue']);

        self::assertNull($payload['missing']);
        $payload['firstKey'] = 'newFirstValue';
        self::assertEquals('newFirstValue', $payload['firstKey']);
        unset($payload['secondKey']);
        self::assertNull($payload['secondKey']);
    }

    public function testPayloadIterateData(): void
    {
        $payload = new Payload(['firstKey' => 'firstValue', 'secondKey' => 'secondValue']);

        self::assertIsIterable($payload);
        self::assertSame(2, $payload->count());
        self::assertSame('firstValue', $payload->getIterator()->current());
    }
}
