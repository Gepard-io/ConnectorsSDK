<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\DTO\Taxonomy;

use GepardIO\ConnectorsSDK\DTO\Taxonomy\FeatureValueL10n;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class FeatureValueL10nTest extends TestCase
{
    public function testCreateFeatureValueL10nExpectSuccess(): void
    {
        $featureValueL10n = new FeatureValueL10n('Value', 'en-GB');
        $featureValueL10nData = $featureValueL10n->toArray();

        self::assertSame('Value', $featureValueL10n->getValue());
        self::assertSame('en-GB', $featureValueL10n->getLocale());
        self::assertTrue($featureValueL10n->equals(new FeatureValueL10n('Value', 'en-GB')));
        self::assertFalse($featureValueL10n->equals(new FeatureValueL10n('Another value', 'es-ES')));
        self::assertIsArray($featureValueL10n->toArray());
        self::assertSame('en-GB', $featureValueL10nData['locale']);
        self::assertSame('Value', $featureValueL10nData['value']);
    }

    public function testCreateFeatureValueL10nWithEmptyValueExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new FeatureValueL10n('', 'en-GB');
    }

    public function testCreateFeatureValueL10nWithEmptyLocaleExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new FeatureValueL10n('Value', '');
    }
}
