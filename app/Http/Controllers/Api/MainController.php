<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{

    public function getManagingDepartments()
    {
        $managing_department = (DB::table('departments')
            ->select()
            ->where('head_employee_id', '=', null))
            ->pluck('id')->all();

        return $this->getSubCollectionListByDepartment($managing_department);
    }

    public function getSubCollectionListByDepartment($id)
    {
        $collection = (
        DB::table('mediators')
            ->leftJoin(DB::raw('departments as sub_department'),'mediators.employee_id','=','sub_department.head_employee_id')
            ->join('departments','mediators.department_id','=','departments.id')
            ->leftJoin(DB::raw('employees as head_employees'),'departments.head_employee_id','=','head_employees.id')
            ->join('positions','mediators.position_id','=','positions.id')
            ->join('employees','mediators.employee_id','=','employees.id')
            ->select(
                DB::raw("concat(sub_department.id, ',', sub_department.name) as department"),
                'mediators.wage',
                'mediators.created_at',
                DB::raw('positions.name as position_name'),
                DB::raw('departments.name as department_name'),
                DB::raw('concat(employees.last_name," ", employees.name, " ", employees.patronymic) as employee_full_name'),
                DB::raw('concat(head_employees.last_name, " ", head_employees.name," ", head_employees.patronymic) as head_employee_full_name')
            )
            ->where('mediators.department_id', '=', $id)
        )->get();

        return $this->itemsToArray($collection, ['department']);
    }

    /**
     * @param $collection
     * @param array $relevant_cols
     * @return array
     */
    protected function itemsToArray($collection, $relevant_cols = [])
    {
        $newOne = [];

        foreach ($collection as $key => $item) {

                $newOne[$key] = [];
                foreach ($item as $model => $data) {

                    if ($data && (in_array($model, $relevant_cols) || empty($relevant_cols))) {
                        $data = explode(',', $data);
                        $newOne[$key][$model] = ['id' => $data[0], 'label' => $data[1]];
                    } else {
                        $newOne[$key][$model] = $data;
                    }
                }
        }

        return $newOne;
    }
}
