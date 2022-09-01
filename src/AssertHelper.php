<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK;

/**
 * Helper class with assertions that can be used with Nette/Schema library.
 */
class AssertHelper
{
    /**
     * Assertion method to check that provided string is not empty.
     *
     * @return callable
     */
    public static function notEmptyString(): callable
    {
        return static function (mixed $value) {
            return \is_string($value) && $value !== '';
        };
    }

    /**
     * Assertion method to check that provided string is not empty after trimming.
     *
     * @return callable
     */
    public static function notEmptyTrimmedString(): callable
    {
        return static function (mixed $value) {
            return \is_string($value) && \trim($value) !== '';
        };
    }
}
