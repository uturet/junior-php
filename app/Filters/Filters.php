<?php

namespace App\Filters;

use Illuminate\Http\Request;


abstract class Filters
{
    protected $request, $builder;

    protected $filters = [];

    /**
     * Filters constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder->paginate(30);
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->request->intersect($this->filters);
    }

}