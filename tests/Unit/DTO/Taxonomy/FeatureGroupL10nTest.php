<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\Unit\DTO\Taxonomy;

use GepardIO\ConnectorsSDK\DTO\Taxonomy\FeatureGroupL10n;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\TaxonomyL10nInterface;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class FeatureGroupL10nTest extends TestCase
{
    public function testCreateFeatureGroupL10nExpectSuccess(): void
    {
        $featureGroupL10n = new FeatureGroupL10n('Name', 'en-GB', 'Description');
        $featureGroupL10nData = $featureGroupL10n->toArray();

        self::assertInstanceOf(TaxonomyL10nInterface::class, $featureGroupL10n);
        self::assertSame('Name', $featureGroupL10n->getName());
        self::assertSame('en-GB', $featureGroupL10n->getLocale());
        self::assertSame('Description', $featureGroupL10n->getDescription());
        self::assertTrue($featureGroupL10n->equals(new FeatureGroupL10n('Name', 'en-GB')));
        self::assertFalse($featureGroupL10n->equals(new FeatureGroupL10n('Another name', 'es-ES')));
        self::assertIsArray($featureGroupL10n->toArray());
        self::assertSame('en-GB', $featureGroupL10nData['locale']);
        self::assertSame('Name', $featureGroupL10nData['name']);
        self::assertSame('Description', $featureGroupL10nData['description']);
    }

    public function testCreateFeatureGroupL10nWithoutDescriptionExpectSuccess(): void
    {
        $featureGroupL10n = new FeatureGroupL10n('Name', 'en-GB');
        $featureGroupL10nData = $featureGroupL10n->toArray();

        self::assertNull($featureGroupL10n->getDescription());
        self::assertNull($featureGroupL10nData['description']);
    }

    public function testCreateFeatureGroupL10nWithEmptyNameExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new FeatureGroupL10n('', 'en-GB');
    }

    public function testCreateFeatureGroupL10nWithEmptyLocaleExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new FeatureGroupL10n('Name', '');
    }
}
