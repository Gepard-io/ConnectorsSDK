<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\DTO\Product;

use GepardIO\ConnectorsSDK\DTO\Product\AdditionalIdentifier;
use GepardIO\ConnectorsSDK\DTO\Product\Identifier;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class IdentifierTest extends TestCase
{
    public function testCreateIdentifierExpectSuccess(): void
    {
        $identifier = new Identifier(
            'testId',
            'test-mpn',
            new AdditionalIdentifier(AdditionalIdentifier::TYPE_GTIN, 'en-GB', '9031101'),
            new AdditionalIdentifier(AdditionalIdentifier::TYPE_GTIN, 'es-ES', '978020137962'),
            new AdditionalIdentifier(AdditionalIdentifier::TYPE_MPN, 'en-GB', 'test-mpn1'),
            new AdditionalIdentifier(AdditionalIdentifier::TYPE_MPN, 'es-ES', 'test-mpn2')
        );

        self::assertSame('testId', $identifier->getId());
        self::assertSame('test-mpn', $identifier->getMpn());
        self::assertIsArray($identifier->getAdditionalIdentifiers());
        self::assertCount(4, $identifier->getAdditionalIdentifiers());
    }

    public function testCreateIdentifierWithoutAdditionalIdentifiersExpectSuccess(): void
    {
        $identifier = new Identifier('testId', 'test-mpn');
        self::assertEmpty($identifier->getAdditionalIdentifiers());
    }

    public function testCreateIdentifierWithEmptyIdExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Identifier('', 'test-mpn');
    }

    public function testCreateBrandWithEmptyMpnExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Identifier('testId', '');
    }
}
