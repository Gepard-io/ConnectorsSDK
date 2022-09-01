<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\Unit\DTO\Product;

use GepardIO\ConnectorsSDK\DTO\Product\Description;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class DescriptionTest extends TestCase
{
    public function testCreateDescriptionExpectSuccess(): void
    {
        $description = new Description(
            'en-GB',
            'Title',
            'Short description',
            'Long description',
            'Warranty Info',
            'Short summary',
            'Long summary'
        );
        $description
            ->setExtraItemByKey('key1', 'value1')
            ->setExtraItemByKey('key2', 'value2');

        self::assertSame('en-GB', $description->getLocale());
        self::assertSame('Title', $description->getTitle());
        self::assertSame('Short description', $description->getShort());
        self::assertSame('Long description', $description->getLong());
        self::assertSame('Warranty Info', $description->getWarrantyInfo());
        self::assertSame('Short summary', $description->getShortSummary());
        self::assertSame('Long summary', $description->getLongSummary());
        self::assertSame('value1', $description->getExtraItemByKey('key1'));
        self::assertSame('value2', $description->getExtraItemByKey('key2'));
    }

    public function testCreateDescriptionWithOptionalParamsExpectSuccess(): void
    {
        $description = new Description('en-GB', 'Title', 'Short description', 'Long description');

        self::assertNull($description->getWarrantyInfo());
        self::assertNull($description->getShortSummary());
        self::assertNull($description->getLongSummary());
    }

    public function testCreateDescriptionWithEmptyLocaleExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Description(
            '',
            'Title',
            'Short description',
            'Long description'
        );
    }

    public function testCreateDescriptionWithEmptyTitleExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Description(
            'en-GB',
            '',
            'Short description',
            'Long description'
        );
    }

    public function testCreateDescriptionWithEmptyShortDescriptionExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Description(
            'en-GB',
            'Title',
            '',
            'Long description'
        );
    }

    public function testCreateDescriptionWithEmptyWarrantyInfoExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Description(
            'en-GB',
            'Title',
            'Short description',
            'Long description',
            ''
        );
    }

    public function testCreateDescriptionWithEmptyShortSummaryExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Description(
            'en-GB',
            'Title',
            'Short description',
            'Long description',
            'Warranty Info',
            ''
        );
    }

    public function testCreateDescriptionWithEmptyLongSummaryExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Description(
            'en-GB',
            'Title',
            'Short description',
            'Long description',
            null,
            null,
            ''
        );
    }
}
