<?php

namespace App\ModelFilters\Concerns;

use Illuminate\Support\Str;

trait FilterByWhereInString
{
    public function setup()
    {
        $this->setupFilterByWhereInString();
    }

    /**
     * Setup Where In Trait
     */
    protected function setupFilterByWhereInString()
    {
        foreach ($this->input() as $k => $i) {
            if (in_array($k, $this->getWhereInStringColumnFilters())) {
                $this->columnWhereInStringFilter($k, $i);
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
    private function columnWhereInStringFilter($column, $data)
    {
        $filters = Str::of($data)->explode(',')->toArray();

        if (! $data || ($filters == 0)) {
            return $this->query;
        }

        return $this->query->where(function ($query) use ($column, $filters) {
            foreach ($filters as $key => $search) {
                $query->orWhere($column, trim($search));
            }
        });
    }

    /**
     * Field to Filter
     */
    abstract public function getWhereInStringColumnFilters(): array;
}
