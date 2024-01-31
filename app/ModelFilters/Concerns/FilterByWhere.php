<?php

namespace App\ModelFilters\Concerns;

trait FilterByWhere
{
    public function setup()
    {
        $this->setupFilterByWhere();
    }

    /**
     * Setup Where In Trait
     */
    protected function setupFilterByWhere()
    {
        foreach ($this->input() as $k => $i) {
            if (in_array($k, $this->getWhereColumnFilters())) {
                $this->columnWhereFilter($k, $i);
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
    private function columnWhereFilter($column, $data)
    {
        return $this->where($column, trim($data));
    }

    /**
     * Field to Filter
     */
    abstract public function getWhereColumnFilters(): array;
}
