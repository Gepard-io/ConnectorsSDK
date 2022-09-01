<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\Unit\DTO\Taxonomy;

use GepardIO\ConnectorsSDK\DTO\Taxonomy\FeatureL10n;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\TaxonomyL10nInterface;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class FeatureL10nTest extends TestCase
{
    public function testCreateFeatureL10nExpectSuccess(): void
    {
        $featureL10n = new FeatureL10n(
            'Name',
            'en-GB',
            'Description',
            'Example'
        );
        $featureL10nData = $featureL10n->toArray();

        self::assertInstanceOf(TaxonomyL10nInterface::class, $featureL10n);
        self::assertSame('Name', $featureL10n->getName());
        self::assertSame('en-GB', $featureL10n->getLocale());
        self::assertSame('Description', $featureL10n->getDescription());
        self::assertSame('Example', $featureL10n->getExample());
        self::assertTrue($featureL10n->equals(new FeatureL10n('Name', 'en-GB')));
        self::assertFalse($featureL10n->equals(new FeatureL10n('Another name', 'es-ES')));
        self::assertIsArray($featureL10n->toArray());
        self::assertSame('en-GB', $featureL10nData['locale']);
        self::assertSame('Name', $featureL10nData['name']);
        self::assertSame('Description', $featureL10nData['description']);
        self::assertSame('Example', $featureL10nData['example']);
    }

    public function testCreateFeatureL10nWithOptionalParamsExpectSuccess(): void
    {
        $featureL10n = new FeatureL10n('Name', 'en-GB');
        $featureL10nData = $featureL10n->toArray();

        self::assertNull($featureL10n->getDescription());
        self::assertNull($featureL10n->getDescription());
        self::assertIsArray($featureL10n->toArray());
        self::assertNull($featureL10nData['description']);
        self::assertNull($featureL10nData['example']);
    }

    public function testCreateFeatureL10nWithEmptyNameExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new FeatureL10n('', 'en-GB');
    }

    public function testCreateFeatureL10nWithEmptyLocaleExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new FeatureL10n('Name', '');
    }
}
