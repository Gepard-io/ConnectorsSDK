<?php
/**
 * @link https://gepard.io
 * @copyright 2022 (c) Bintime
 */

declare(strict_types=1);

namespace GepardIO\ConnectorsSDK\DTO\Taxonomy;

use Assert\Assert;
use Assert\AssertionFailedException;

use function array_map;

/**
 * Locale is a language in which taxonomy data and product content are provided, as well as a language which the
 * system uses to operate (e.g., INT (International), en-GB (English - United Kingdom), de-DE (German)).
 *
 * Language relates to a particular country, therefoe, it is more correct to use the term "locale" instead of
 * "language", because in most cases  data taxonomy and product content are country-oriented. It means that product
 * descriptions in English oriented to the UK (en-GB), US (en-US), and India (en-IN) may be different.
 */
final class Locale extends BaseTaxonomyData
{
    /**
     * @param string       $id A unique identifier.
     * @param string       $code An ISO 639-1, mainly two-character locale code developed to classify a language.
     * @param LocaleL10n[] $l10n Localized information about locale.
     *
     * @throws AssertionFailedException
     */
    public function __construct(string $id, private string $code, array $l10n)
    {
        Assert::lazy()
            ->that($code, 'code')->notEmpty()
            ->that($l10n, 'l10n')->all()->isInstanceOf(LocaleL10n::class)
            ->verifyNow();

        parent::__construct($id, $l10n);
    }

    /**
     * Get the code.
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'l10n' => array_map(static fn(LocaleL10n $l10n) => $l10n->toArray(), $this->l10n),
            'extra' => $this->extra,
        ];
    }
}
