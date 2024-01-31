<?php

namespace App\ModelFilters\Concerns;

trait FilterByWhereBoolean
{
    public function setup()
    {
        $this->setupFilterByWhereBoolean();
    }

    /**
     * Setup Where By Boolean Trait
     */
    protected function setupFilterByWhereBoolean()
    {
        foreach ($this->input() as $k => $i) {
            if (in_array($k, $this->getWhereBooleanColumnFilters())) {
                $this->columnWhereBooleanFilter($k, $i);
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
    private function columnWhereBooleanFilter($column, $data)
    {
        $data = filter_var($data, FILTER_VALIDATE_BOOLEAN);

        return $this->where($column, $data);
    }

    /**
     * Field to Filter
     */
    abstract public function getWhereBooleanColumnFilters(): array;
}
