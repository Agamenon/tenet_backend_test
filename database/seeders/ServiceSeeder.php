<?php

namespace Database\Seeders;

use App\Enums\CurrencyTypeEnum;
use App\Enums\ServiceTypeEnum;
use App\Enums\UnitTypeEnum;
use App\Models\Service;
use Brick\Money\Currency;
use Brick\Money\Money;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::firstOrCreate([
            'name' => ServiceTypeEnum::BACKOFFICE,
            'unit' => UnitTypeEnum::MONTH,
            'cost' => Money::of("7.00",CurrencyTypeEnum::USD())->getAmount()
        ]);

        Service::firstOrCreate([
            'name' => ServiceTypeEnum::STORAGE,
            'unit' => UnitTypeEnum::GB,
            'cost' => Money::of("0.03", CurrencyTypeEnum::USD())->getAmount()
        ]);

        Service::firstOrCreate([
            'name' => ServiceTypeEnum::PROXY,
            'unit' => UnitTypeEnum::MINUTE,
            'cost' => Money::of("0.03", CurrencyTypeEnum::USD())->getAmount()
        ]);

        Service::firstOrCreate([
            'name' => ServiceTypeEnum::TRANSLATION,
            'unit' => UnitTypeEnum::LETTER,
            'cost' => Money::of("0.00003", CurrencyTypeEnum::USDSMALL())->getAmount()
        ]);
    }
}
