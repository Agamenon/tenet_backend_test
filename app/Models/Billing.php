<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "customer_id",
        "service_id",
        "date",
        "quantity"
    ];

    protected $casts = [
        'date' => "date:Y-m-d",
    ];

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function service(){
        return $this->belongsTo(Service::class);
    }

    /**
     *
     * @param Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLastFifteenDays(Builder $query){

        $start = now()->subDays(15)->startOfDay();
        $end   = now()->endOfDay();

        return $query->whereBetween('date', [$start, $end]);

    }

}
