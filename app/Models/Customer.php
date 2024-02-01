<?php

namespace App\Models;

use App\Models\Traits\HasCustomEventsLogs;
use App\Models\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes, HasCustomEventsLogs, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "name",
    ];

    protected function getHumanModelName(): string
    {
        return 'Customer';
    }

    public function billings(){
        return $this->hasMany(Billing::class);
    }
}
