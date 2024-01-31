<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static GB()
 * @method static static LETTER()
 * @method static static MONTH()
 */
final class UnitTypeEnum extends Enum
{
    const GB = "GB";
    const LETTER = "LETTER";
    const MONTH = "MONTH";
    const MINUTE = "MINUTE";
}
