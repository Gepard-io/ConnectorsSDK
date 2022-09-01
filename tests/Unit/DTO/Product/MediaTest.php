<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\Unit\DTO\Product;

use GepardIO\ConnectorsSDK\DTO\Product\Media;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class MediaTest extends TestCase
{
    public function testCreateMediaExpectSuccess(): void
    {
        $media = new Media(
            'leaflet',
            'pdf',
            'https://company.test/picture.jpg',
            ['en-GB', 'es-ES'],
            'Description',
            100
        );
        $media
            ->setExtraItemByKey('key1', 'value1')
            ->setExtraItemByKey('key2', 'value2');
        $locales = $media->getLocales();

        self::assertSame('leaflet', $media->getType());
        self::assertSame('pdf', $media->getContentType());
        self::assertSame('https://company.test/picture.jpg', $media->getUrl());
        self::assertSame(100, $media->getSize());
        self::assertIsArray($media->getLocales());
        self::assertEqualsCanonicalizing(['en-GB', 'es-ES'], $media->getLocales());
        self::assertSame('en-GB', $locales[0]);
        self::assertSame('es-ES', $locales[1]);
        self::assertSame('Description', $media->getDescription());
        self::assertSame('value1', $media->getExtraItemByKey('key1'));
        self::assertSame('value2', $media->getExtraItemByKey('key2'));
    }

    public function testCreateMediaWithOptionalParamsExpectSuccess(): void
    {
        $media = new Media(
            'leaflet',
            'pdf',
            'https://company.test/picture.jpg',
            ['en-GB', 'es-ES']
        );

        self::assertNull($media->getDescription());
    }

    public function testCreateMediaWithEmptyTypeExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Media(
            '',
            'pdf',
            'https://company.test/picture.jpg',
            ['en-GB', 'es-ES']
        );
    }

    public function testCreateMediaWithDuplicateLocalesExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Media(
            'leaflet',
            'pdf',
            'https://company.test/picture.jpg',
            ['en-GB', 'en-GB']
        );
    }

    public function testCreateMediaWithWrongSizeExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Media(
            'leaflet',
            'pdf',
            'https://company.test/picture.jpg',
            ['en-GB', 'es-ES'],
            'description',
            0
        );
    }

    public function testCreateMediaWithWrongUrlExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Media(
            'leaflet',
            'pdf',
            'wrong url',
            ['en-GB', 'es-ES']
        );
    }
}
