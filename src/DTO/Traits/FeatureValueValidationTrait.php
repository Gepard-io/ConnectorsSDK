<?php

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Traits;

use GepardIO\ConnectorsSDK\DTO\Taxonomy\FeatureValue;
use InvalidArgumentException;

use function is_a;
use function is_string;
use function sprintf;

/**
 * Validate feature values by type of feature
 */
trait FeatureValueValidationTrait
{
    /**
     * Validate the allowed values by feature type.
     *
     * @param array $allowedValues
     */
    private function validateAllowedValues(array $allowedValues): void
    {
        $validationResult = true;
        foreach ($allowedValues as $value) {
            if (!is_a($value, FeatureValue::class)) {
                $validationResult = false;
                break;
            }
        }

        if ($validationResult === false) {
            foreach ($allowedValues as $value) {
                if (!is_string($value) || $value === '') {
                    $validationResult = false;
                    break;
                }
            }
        }

        if ($validationResult === false) {
            throw new InvalidArgumentException(
                sprintf(
                    'Unsupported allowedValues type, expected type should be string or instance of %s',
                    FeatureValue::class
                )
            );
        }
    }
}
