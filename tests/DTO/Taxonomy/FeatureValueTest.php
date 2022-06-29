<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\DTO\Taxonomy;

use GepardIO\ConnectorsSDK\DTO\Taxonomy\FeatureValue;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\FeatureValueL10n;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class FeatureValueTest extends TestCase
{
    public function testCreateFeatureValueExpectSuccess(): void
    {
        $featureValueL10n = [
            new FeatureValueL10n('Value (en-GB)', 'en-GB'),
            new FeatureValueL10n('Value (es-ES)', 'es-ES'),
        ];
        $featureValue = new FeatureValue('testId', $featureValueL10n);
        $featureValue
            ->setExtraItemByKey('key1', 'value1')
            ->setExtraItemByKey('key2', 'value2');
        $featureValueData = $featureValue->toArray();

        self::assertSame('testId', $featureValue->getId());
        self::assertSame('value1', $featureValue->getExtraItemByKey('key1'));
        self::assertSame('value2', $featureValue->getExtraItemByKey('key2'));
        self::assertSame('Value (en-GB)', $featureValueL10n[0]->getValue());
        self::assertSame('en-GB', $featureValueL10n[0]->getLocale());
        self::assertInstanceOf(FeatureValueL10n::class, $featureValueL10n[0]);
        self::assertSame('Value (es-ES)', $featureValueL10n[1]->getValue());
        self::assertSame('es-ES', $featureValueL10n[1]->getLocale());
        self::assertInstanceOf(FeatureValueL10n::class, $featureValueL10n[1]);
        self::assertIsArray($featureValueL10n);
        self::assertCount(2, $featureValueL10n);
        self::assertSame('en-GB', $featureValueData['l10n']['en-GB']['locale']);
        self::assertSame('Value (en-GB)', $featureValueData['l10n']['en-GB']['value']);
        self::assertSame('es-ES', $featureValueData['l10n']['es-ES']['locale']);
        self::assertSame('Value (es-ES)', $featureValueData['l10n']['es-ES']['value']);
    }

    public function testCreateFeatureValueWithEmptyIdExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new FeatureValue('', [new FeatureValueL10n('Value (en-GB)', 'en-GB')]);
    }

    public function testCreateFeatureValueWithEmptyL10nExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new FeatureValue('testId', []);
    }
}
