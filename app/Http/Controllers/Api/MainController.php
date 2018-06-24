<?php

namespace App\Http\Controllers\Api;

use App\Filters\MediatorFilters;
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
     * Display a listing of the resource.
     *
     * @param MediatorFilters $filters
     * @return \Illuminate\Http\Response
     */
    public function getEmployeesCollectionList(MediatorFilters $filters)
    {
        return $filters->apply($this->dbDecoratedQuery());
    }

    protected function dbDecoratedQuery()
    {
        $query = DB::table('mediators')
            ->join('employees','mediators.employee_id','=','employees.id')
            ->join('departments','mediators.department_id','=','departments.id')
            ->join('positions','mediators.position_id','=','positions.id')
            ->leftJoin(DB::raw('employees as head_employees'),'departments.head_employee_id','=','head_employees.id')
            ->select(
                DB::raw('employees.id as id'),
                DB::raw('employees.phone as phone'),
                DB::raw('employees.email as email'),
                DB::raw('mediators.is_archive as is_archive'),
                DB::raw('mediators.wage as wage'),
                DB::raw('concat(employees.last_name," ", employees.name, " ", employees.patronymic) as employee_full_name'),
                DB::raw('mediators.created_at as recruitment_date'),
                DB::raw('departments.name as department_name'),
                DB::raw('positions.name as position_name'),
                DB::raw('head_employees.id as head_employee_id'),
                DB::raw('concat(head_employees.last_name, " ", head_employees.name," ", head_employees.patronymic) as head_employee_full_name')
            )->toSQL();

        return DB::table('mediators')
            ->select('*')
            ->from(
                DB::raw("($query) as collection")
            );
    }

    /**
     * Display a listing of the resource.
     *
     * @param MediatorFilters $filters
     * @return \Illuminate\Http\Response
     */
    public function getUnformedEmployeesCollectionList(MediatorFilters $filters)
    {
        return $filters->apply($this->dbUnformedQuery());
    }

    protected function dbUnformedQuery()
    {
        $exception = DB::table('mediators')
            ->select(
                'employee_id'
            );

        $query = DB::table('employees')
            ->select(
                '*',
                DB::raw("NULL as wage"),
                DB::raw("NULL as is_archive"),
                DB::raw('concat(employees.name," ", employees.last_name, " ", employees.patronymic) as employee_full_name'),
                DB::raw("NULL as department_name"),
                DB::raw("NULL as position_name"),
                DB::raw("NULL as head_employee_id"),
                DB::raw("NULL as head_employee_full_name")
            )
            ->whereNotIn('id', $exception)
            ->toSQL();

        return DB::table('mediators')
            ->select('*')
            ->from(
                DB::raw("($query) as collection")
            );
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
