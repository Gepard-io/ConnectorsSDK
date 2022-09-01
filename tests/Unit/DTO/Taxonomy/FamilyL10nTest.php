<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\Unit\DTO\Taxonomy;

use GepardIO\ConnectorsSDK\DTO\Taxonomy\FamilyL10n;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\TaxonomyL10nInterface;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class FamilyL10nTest extends TestCase
{
    public function testCreateFamilyL10nExpectSuccess(): void
    {
        $familyL10n = new FamilyL10n('Name', 'en-GB');
        $familyL10nData = $familyL10n->toArray();

        self::assertInstanceOf(TaxonomyL10nInterface::class, $familyL10n);
        self::assertSame('Name', $familyL10n->getName());
        self::assertSame('en-GB', $familyL10n->getLocale());
        self::assertTrue($familyL10n->equals(new FamilyL10n('Name', 'en-GB')));
        self::assertFalse($familyL10n->equals(new FamilyL10n('Another name', 'es-ES')));
        self::assertIsArray($familyL10n->toArray());
        self::assertSame('en-GB', $familyL10nData['locale']);
        self::assertSame('Name', $familyL10nData['name']);
    }

    public function testCreateFamilyL10nWithEmptyNameExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new FamilyL10n('', 'en-GB');
    }

    public function testCreateFamilyL10nWithEmptyLocaleExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new FamilyL10n('Name', '');
    }
}
