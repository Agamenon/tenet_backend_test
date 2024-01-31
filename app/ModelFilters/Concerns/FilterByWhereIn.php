<?php

namespace App\ModelFilters\Concerns;

use Illuminate\Support\Str;

trait FilterByWhereIn
{
    public function setup()
    {
        $this->setupFilterByWhereIn();
    }

    /**
     * Setup Where In Trait
     */
    protected function setupFilterByWhereIn()
    {
        foreach ($this->input() as $k => $i) {
            if (in_array($k, $this->getWhereInColumnFilters())) {
                $this->columnWhereInFilter($k, $i);
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
    private function columnWhereInFilter($column, $data)
    {
        if (! $data || (Str::of($data)->explode(',')->toArray() == 0)) {
            return $this->query;
        }

        return $this->query->whereIn($column, Str::of($data)->explode(',')->toArray());
    }

    /**
     * Field to Filter
     */
    abstract public function getWhereInColumnFilters(): array;
}
