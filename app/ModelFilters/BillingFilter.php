<?php

namespace App\ModelFilters;

use App\ModelFilters\Concerns\FilterByWhere;
use App\ModelFilters\Concerns\FilterByWhereDateBetween;
use App\ModelFilters\Concerns\FilterByWhereIn;
use EloquentFilter\ModelFilter;

class BillingFilter extends ModelFilter
{
    use FilterByWhereIn, FilterByWhere, FilterByWhereDateBetween;
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function setup()
    {
        $this->setupFilterByWhereIn()
            ->setupFilterByWhere()
            ->setupFilterByWhereDateBetween();
    }

    public function getWhereColumnFilters(): array
    {
        return [
            "quantity"
        ];
    }

    public function getWhereInColumnFilters(): array
    {
        return [
            "service_id",
            "customer_id",
        ];
    }

    public function getWhereDateBetweenColumnFilters(): array
    {
        return [
            "date"
        ];
    }
}
