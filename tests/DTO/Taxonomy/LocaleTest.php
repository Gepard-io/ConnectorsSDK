<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\DTO\Taxonomy;

use GepardIO\ConnectorsSDK\DTO\Taxonomy\Locale;
use GepardIO\ConnectorsSDK\DTO\Taxonomy\LocaleL10n;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;

final class LocaleTest extends TestCase
{
    public function testCreateLanguageExpectSuccess(): void
    {
        $localeL10n = [
            new LocaleL10n('English', 'en-GB'),
            new LocaleL10n('Spanish', 'es-ES'),
        ];
        $locale = new Locale('testId', 'testCode', $localeL10n);
        $locale
            ->setExtraItemByKey('key1', 'value1')
            ->setExtraItemByKey('key2', 'value2');
        $localeData = $locale->toArray();

        self::assertSame('testId', $locale->getId());
        self::assertSame('testCode', $locale->getCode());
        self::assertSame('value1', $locale->getExtraItemByKey('key1'));
        self::assertSame('value2', $locale->getExtraItemByKey('key2'));
        self::assertIsArray($locale->getL10n());
        self::assertCount(2, $localeL10n);
        self::assertContainsOnlyInstancesOf(LocaleL10n::class, $locale->getL10n());
        self::assertSame('English', $localeL10n[0]->getName());
        self::assertSame('en-GB', $localeL10n[0]->getLocale());
        self::assertInstanceOf(LocaleL10n::class, $localeL10n[0]);
        self::assertSame('Spanish', $localeL10n[1]->getName());
        self::assertSame('es-ES', $localeL10n[1]->getLocale());
        self::assertInstanceOf(LocaleL10n::class, $localeL10n[1]);
        self::assertSame('en-GB', $localeData['l10n']['en-GB']['locale']);
        self::assertSame('English', $localeData['l10n']['en-GB']['name']);
        self::assertSame('es-ES', $localeData['l10n']['es-ES']['locale']);
        self::assertSame('Spanish', $localeData['l10n']['es-ES']['name']);
    }

    public function testCreateLocaleWithEmptyIdExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Locale('', 'testCode', [new LocaleL10n('English', 'en-GB')]);
    }

    public function testCreateLocaleWithEmptyCodeExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Locale('testId', '', [new LocaleL10n('English', 'en-GB')]);
    }

    public function testCreateLocaleWithEmptyL10nExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Locale('testId', 'testCode', []);
    }

    public function testCreateLocaleWithWrongL10nExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Locale('testId', 'testCode', [new stdClass()]);
    }
}
