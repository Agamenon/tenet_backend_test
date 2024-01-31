<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static BackOffice()
 * @method static static Storage()
 * @method static static Proxy()
 * @method static static Translation()
 */
final class ServiceTypeEnum extends Enum
{
    const BACKOFFICE = "BackOffice";
    const STORAGE = "Storage";
    const PROXY = "Proxy";
    const TRANSLATION = "Translation";
}
