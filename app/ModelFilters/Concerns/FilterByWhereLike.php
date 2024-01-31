<?php

namespace App\ModelFilters\Concerns;

trait FilterByWhereLike
{
    public function setup()
    {
        $this->setupFilterByWhereLike();
    }

    /**
     * Setup Where In Trait
     */
    protected function setupFilterByWhereLike()
    {
        foreach ($this->input() as $k => $i) {
            if (in_array($k, $this->getWhereLikeColumnFilters())) {
                $this->columnWhereLikeFilter($k, $i);
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
    private function columnWhereLikeFilter($column, $data)
    {
        return $this->whereLike($column, $data);
    }

    /**
     * Field to Filter
     */
    abstract public function getWhereLikeColumnFilters(): array;
}
