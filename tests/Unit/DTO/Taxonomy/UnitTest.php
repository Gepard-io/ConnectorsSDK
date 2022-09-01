<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\Unit\DTO\Taxonomy;

use GepardIO\ConnectorsSDK\DTO\Taxonomy\Unit;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\UnitL10n;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class UnitTest extends TestCase
{
    public function testCreateUnitExpectSuccess(): void
    {
        $unitL10n = [
            new UnitL10n('Test name (en-GB)', 'en-GB'),
            new UnitL10n('Test name (es-ES)', 'es-ES'),
        ];
        $unit = new Unit('testId', $unitL10n);
        $unit
            ->setExtraItemByKey('key1', 'value1')
            ->setExtraItemByKey('key2', 'value2');
        $unitData = $unit->toArray();

        self::assertSame('testId', $unit->getId());
        self::assertSame('value1', $unit->getExtraItemByKey('key1'));
        self::assertSame('value2', $unit->getExtraItemByKey('key2'));
        self::assertContainsOnlyInstancesOf(UnitL10n::class, $unit->getL10n());
        self::assertSame('Test name (en-GB)', $unitL10n[0]->getName());
        self::assertSame('en-GB', $unitL10n[0]->getLocale());
        self::assertInstanceOf(UnitL10n::class, $unitL10n[0]);
        self::assertSame('Test name (es-ES)', $unitL10n[1]->getName());
        self::assertSame('es-ES', $unitL10n[1]->getLocale());
        self::assertInstanceOf(UnitL10n::class, $unitL10n[1]);
        self::assertIsArray($unitL10n);
        self::assertCount(2, $unitL10n);
        self::assertSame('testId', $unitData['id']);
        self::assertSame('en-GB', $unitData['l10n']['en-GB']['locale']);
        self::assertSame('Test name (en-GB)', $unitData['l10n']['en-GB']['name']);
        self::assertSame('es-ES', $unitData['l10n']['es-ES']['locale']);
        self::assertSame('Test name (es-ES)', $unitData['l10n']['es-ES']['name']);
    }

    public function testCreateUnitWithEmptyIdExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Unit('', [new UnitL10n('Test name (en-GB)', 'en-GB')]);
    }

    public function testCreateUnitWithEmptyL10nExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Unit('testId', []);
    }
}
