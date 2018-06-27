<?php

namespace App\Http\Controllers\Api;

use App\Filters\MediatorFilters;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{

    public function getManagingDepartments($type)
    {
        $managing_department = (DB::table('departments')
            ->select()
            ->where('head_employee_id', '=', null))
            ->pluck('id')->all();

        $collection = (
            $this->dbSubDepartments($type === 'list' ? 'sub_department' : 'departments')
            ->whereIn('mediators.department_id', $managing_department)
        )->get();

        return $this->itemsToArray($collection, ['department']);
    }

    public function getSubCollectionListByDepartment($id)
    {
        $collection = (
            $this->dbSubDepartments('sub_department')
            ->where('mediators.department_id', $id)
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

    /**
     * @param int $archive
     * @return mixed
     */
    protected function dbDecoratedQuery($archive = 0)
    {
        $query = DB::table('mediators')
            ->join('employees','mediators.employee_id','=','employees.id')
            ->join('departments','mediators.department_id','=','departments.id')
            ->join('positions','mediators.position_id','=','positions.id')
            ->leftJoin(DB::raw('employees as head_employees'),'departments.head_employee_id','=','head_employees.id')
            ->select(
                DB::raw('employees.id as id'),
                DB::raw('employees.photo_url as photo_url'),
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
            )->where('is_archive', $archive);
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

    /**
     * Display a listing of the resource.
     *
     * @param MediatorFilters $filters
     * @return \Illuminate\Http\Response
     */
    public function getArchivedEmployeesCollectionList(MediatorFilters $filters)
    {
        return $filters->apply($this->dbDecoratedQuery(1));
    }

    public function getUnformedEmployees()
    {
        $employees_id = DB::table('mediators')
            ->select('employee_id');

        $unformed_employees = (DB::table('employees')
            ->select(
                DB::raw("concat(employees.id, ',', concat(employees.last_name, \" \", employees.name,\" \", employees.patronymic)) as employee")
            )
            ->whereNotIn( 'id', $employees_id ))->get();

        return $this->itemsToArray($unformed_employees);
    }

    public function getFreePositions()
    {
        $positions_id = DB::table('mediators')
            ->select('employee_id');

        $free_positions = (DB::table('positions')
            ->select(
                DB::raw("concat(positions.id, ',', positions.name) as position")
            )
            ->whereNotIn( 'id', $positions_id ))->get();

        return $this->itemsToArray($free_positions);
    }

    public function getSubCollectionByEmployee($id)
    {
        $department_id = $this->getSubDepartmentByHeadEmployee($id);
        $collection = ($this->subCollectionQuery()
            ->where('mediators.department_id', '=', $department_id))
            ->get();
        return $this->itemsToArray($collection);
    }

    public function getSubCollectionByDepartment($id)
    {
        $collection = ($this->subCollectionQuery()
            ->where('mediators.department_id', '=', $id))
            ->get();

        return $this->itemsToArray($collection);
    }

    /**
     * Display a listing of the resource.
     *
     * @param MediatorFilters $filters
     * @return \Illuminate\Http\Response
     */
    public function getDepartmentsCollectionList(MediatorFilters $filters)
    {
        return $filters->apply(DB::table('departments'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param MediatorFilters $filters
     * @return \Illuminate\Http\Response
     */
    public function getPositionsCollectionList(MediatorFilters $filters)
    {
        return $filters->apply(DB::table('positions'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param MediatorFilters $filters
     * @return \Illuminate\Http\Response
     */
    public function getEventsCollectionList(MediatorFilters $filters)
    {
        return $filters->apply(DB::table('events'));
    }

    protected function getSubDepartmentByHeadEmployee($employee)
    {
        return (DB::table('departments')
            ->select()
            ->where('head_employee_id', '=', $employee))->pluck('id')->all();
    }

    protected function getArchivedEmployees()
    {
        $archived_mediators = DB::table('mediators')
            ->select()->where('is_archive', 1)->pluck('employee_id')->all();
        return $this->itemsToArray((DB::table('employees')
            ->select(
                DB::raw("concat(employees.id, ',', concat(employees.last_name, \" \", employees.name,\" \", employees.patronymic)) as employee")
            )
            ->whereIn('id', $archived_mediators))->get());
    }

    protected function subCollectionQuery()
    {
        return DB::table('mediators')
            ->leftJoin(DB::raw('departments as sub_department'),'mediators.employee_id','=','sub_department.head_employee_id')
            ->join('positions','mediators.position_id','=','positions.id')
            ->join('employees','mediators.employee_id','=','employees.id')
            ->select(
                DB::raw("concat(positions.id, ',', positions.name) as position"),
                DB::raw("concat(employees.id, ',', concat(employees.last_name, \" \", employees.name,\" \", employees.patronymic)) as employee"),
                DB::raw("concat(sub_department.id, ',', sub_department.name) as department")
            )
            ->where('is_archive', 0);
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

    /**
     * @param string $department
     * @return mixed
     */
    protected function dbSubDepartments($department)
    {
        return DB::table('mediators')
            ->leftJoin(DB::raw('departments as sub_department'), 'mediators.employee_id', '=', 'sub_department.head_employee_id')
            ->join('departments', 'mediators.department_id', '=', 'departments.id')
            ->leftJoin(DB::raw('employees as head_employees'), 'departments.head_employee_id', '=', 'head_employees.id')
            ->join('positions', 'mediators.position_id', '=', 'positions.id')
            ->join('employees', 'mediators.employee_id', '=', 'employees.id')
            ->select(
                DB::raw("concat($department.id, ',', $department.name) as department"),
                'mediators.wage',
                'mediators.created_at',
                'employees.photo_url',
                DB::raw('positions.name as position_name'),
                DB::raw('departments.name as department_name'),
                DB::raw('employees.id as employee_id'),
                DB::raw('concat(employees.last_name," ", employees.name, " ", employees.patronymic) as employee_full_name'),
                DB::raw('concat(head_employees.last_name, " ", head_employees.name," ", head_employees.patronymic) as head_employee_full_name')
            );
    }
}
