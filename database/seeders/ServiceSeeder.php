<?php

namespace Database\Seeders;

use App\Enums\CurrencyTypeEnum;
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
            'name' => "BackOffice",
            'unit' => UnitTypeEnum::MONTH,
            'cost' => Money::of("7.00",CurrencyTypeEnum::USD())->getAmount()
        ]);

        Service::firstOrCreate([
            'name' => "Storage",
            'unit' => UnitTypeEnum::GB,
            'cost' => Money::of("0.03", CurrencyTypeEnum::USD())->getAmount()
        ]);

        Service::firstOrCreate([
            'name' => "Proxy",
            'unit' => UnitTypeEnum::MINUTE,
            'cost' => Money::of("0.03", CurrencyTypeEnum::USD())->getAmount()
        ]);

        Service::firstOrCreate([
            'name' => "Speech Translation",
            'unit' => UnitTypeEnum::LETTER,
            'cost' => Money::of("0.00003", CurrencyTypeEnum::USDSMALL())->getAmount()
        ]);
    }
}
