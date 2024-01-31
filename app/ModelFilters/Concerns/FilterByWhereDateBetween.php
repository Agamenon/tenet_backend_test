<?php

namespace App\ModelFilters\Concerns;

use Carbon\Carbon;

trait FilterByWhereDateBetween
{
    public function setup()
    {
        $this->setupFilterByWhereDateBetween();
    }

    /**
     * Setup Where In Trait
     */
    protected function setupFilterByWhereDateBetween()
    {
        foreach ($this->input() as $k => $i) {
            if (in_array($k, $this->getWhereDateBetweenColumnFilters())) {
                $this->columnWhereDateBetweenFilter($k, $i);
            }
        }

        return $this;
    }

    /**
     * Filter with Like by column
     *
     *
     * @param  string  $column
     * @param  string  $data
     * @return QueryBuilder
     */
    private function columnWhereDateBetweenFilter($column, $data)
    {
        $start = Carbon::make($data)->startOfDay();
        $end = Carbon::make($data)->endOfDay();

        return $this->whereBetween($column, [$start, $end]);
    }

    /**
     * Field to Filter
     */
    abstract public function getWhereDateBetweenColumnFilters(): array;
}
