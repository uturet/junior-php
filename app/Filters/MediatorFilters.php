<?php

namespace App\Filters;


class MediatorFilters extends Filters
{
    protected $filters = [
        'id', 'employee_full_name', 'phone', 'email', 'department_name', 'position_name', 'head_employee_full_name', 'wage'
    ];

    public function id($value)
    {
        return $this->filter($value, 'id');
    }

    public function recruitment_date($value)
    {
        return $this->filter($value, 'recruitment_date');
    }

    public function wage($value)
    {
        return $this->filter($value, 'wage');
    }

    public function employee_full_name($value)
    {
        return $this->filter($value, 'employee_full_name');
    }

    public function phone($value)
    {
        return $this->filter($value, 'phone');
    }

    public function email($value)
    {
        return $this->filter($value, 'email');
    }

    public function department_name($value)
    {
        return $this->filter($value, 'department_name');
    }

    public function position_name($value)
    {
        return $this->filter($value, 'position_name');
    }

    public function head_employee_full_name($value)
    {
        return $this->filter($value, 'head_employee_full_name');
    }

    public function name($value)
    {
        return $this->filter($value, 'name');
    }

    public function description($value)
    {
        return $this->filter($value, 'description');
    }



    /**
     * @param $value
     * @param $where
     * @return mixed
     */
    protected function filter($value, $where)
    {
        if ($value != '_query') {
            return $this->builder->where($where, $value)->orderBy($where, $this->request->direction);
        }
        return $this->builder->orderBy($where, $this->request->direction);
    }

}