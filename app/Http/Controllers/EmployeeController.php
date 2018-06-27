<?php

namespace App\Http\Controllers;

use App\Event;
use App\Employee;
use App\Mediator;
use Illuminate\Http\Request;
use App\Filters\MediatorFilters;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param MediatorFilters $filters
     * @param Request $request
     * @param $formatting
     * @return \Illuminate\Http\Response
     */
    public function index(MediatorFilters $filters, Request $request)
    {
        $collection = $filters->apply($this->dbDecoratedQuery());

        $fields = [
            'id' => 'ID',
            'employee_full_name' => 'ФИО',
            'recruitment_date' => 'Дата оформления',
            'phone' => 'Телефон',
            'email' => 'Email',
            'department_name' => 'Подразделение',
            'position_name' => 'Должность',
            'head_employee_full_name' => 'Руководитель',
            'wage' => 'Заработная плата',
        ];

        $filtered = array_intersect(array_keys($fields), array_keys($request->all()));
        $search = ['key' => null, 'value' => null];

        foreach ($filtered as $key => $value) {
            if ($request[$value] !== '_query') {
                $search['key'] = $value;
                $search['value'] = $request[$value];
            }
        }
        $filtered['direction'] = $request['direction'];

        return view('employees.index', compact('collection', 'fields', 'filtered', 'search'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'last_name' => 'required',
            'patronymic' => 'required',
            'avatar' => 'image|mimes:jpg,png,jpeg'
        ]);

        $employee = Employee::create($request->all());
        $employee->uploadImage($request->avatar);

        return redirect()->route('employees.show', ['id' => $employee->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::find($id);

        return view('employees.show', ['employee' => $employee]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::find($id);

        return view('employees.edit', ['employee' => $employee]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'last_name' => 'required',
            'patronymic' => 'required',
            'avatar' => 'image|mimes:jpg,png,jpeg'
        ]);
        $employee = Employee::findOrFail($id);
        $employee->update($request->all());
        $employee->uploadImage($request->avatar);

        return redirect()->route('employees.show', ['id' => $employee->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);

        if ($employee->mediator) {
            $employee->mediator->translateSubMediators();
        }

        $employee->mediator()->delete();
        $employee->events()->delete();
        $employee->delete();

        return response()->json([intval($id)], 201);
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

}
