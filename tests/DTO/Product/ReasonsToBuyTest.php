<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\Tests\DTO\Product;

use GepardIO\ConnectorsSDK\DTO\Product\ReasonToBuy;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class ReasonsToBuyTest extends TestCase
{
    public function testCreateReasonToBuyExpectSuccess(): void
    {
        $reasonToBuy = new ReasonToBuy(
            'testId',
            'en-GB',
            'Title',
            'Value',
            1,
            'https://company.test/picture.jpg'
        );
        $reasonToBuy
            ->setExtraItemByKey('key1', 'value1')
            ->setExtraItemByKey('key2', 'value2');

        self::assertSame('testId', $reasonToBuy->getId());
        self::assertSame('en-GB', $reasonToBuy->getLocale());
        self::assertSame('Title', $reasonToBuy->getTitle());
        self::assertSame('Value', $reasonToBuy->getValue());
        self::assertSame(1, $reasonToBuy->getNo());
        self::assertSame('https://company.test/picture.jpg', $reasonToBuy->getPictureUrl());
        self::assertSame('value1', $reasonToBuy->getExtraItemByKey('key1'));
        self::assertSame('value2', $reasonToBuy->getExtraItemByKey('key2'));
    }

    public function testCreateReasonToBuyWithOptionalParamsExpectSuccess(): void
    {
        $reasonToBuy = new ReasonToBuy(
            'testId',
            'en-GB',
            'Title',
            'Value',
            1
        );

        self::assertNull($reasonToBuy->getPictureUrl());
    }

    public function testCreateReasonToBuyWithEmptyIdExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new ReasonToBuy(
            '',
            'en-GB',
            'Title',
            'Value',
            1,
        );
    }

    public function testCreateReasonToBuyWithEmptyLocaleExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new ReasonToBuy(
            'testId',
            '',
            'Title',
            'Value',
            1,
        );
    }

    public function testCreateReasonToBuyWithEmptyTitleExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new ReasonToBuy(
            'testId',
            'en-GB',
            '',
            'Value',
            1,
        );
    }

    public function testCreateReasonToBuyWithEmptyValueExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new ReasonToBuy(
            'testId',
            'en-GB',
            'Title',
            '',
            1,
        );
    }

    public function testCreateReasonToBuyWithWrongNoExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new ReasonToBuy(
            'testId',
            'en-GB',
            'Title',
            'Value',
            0,
        );
    }

    public function testCreateReasonToBuyWithWrongPictureUrlExpectException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new ReasonToBuy(
            'testId',
            'en-GB',
            'Title',
            'Value',
            1,
            'wrong url'
        );
    }
}
