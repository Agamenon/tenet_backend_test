<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;
use Brick\Money\Currency;

/**
 * @method static static USD()
 */
final class CurrencyTypeEnum extends Enum
{
    const USD = 'USD';

    public static function USDSMALL() : Currency{
        return new Currency("USDSMALL", 11, "USDSMALL", 5);
    }
}
