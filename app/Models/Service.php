<?php

namespace App\Models;

use App\Enums\UnitTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "name",
        "unit",
        "cost"
    ];

    protected $casts = [
        'unit' => UnitTypeEnum::class,
    ];
}
