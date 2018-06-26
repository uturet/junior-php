<?php

namespace App\Http\Controllers;

use App\Department;
use App\Employee;
use App\Event;
use App\Mediator;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('departments.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('departments.create');
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
            'description' => 'required',
            'type' => 'required',
        ]);

        if ($request->type) {

            $employee = Employee::find($request->head_employee_id);

            $employee->mediator->translateSubMediators();
            $department = Department::create($request->all());
            $department->employee()->associate($employee->id);

        } else {
            Department::create($request->all());
        }

        return response()->json('created', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $department = Department::findOrFail($id);
        if ($department->employees) {
            $department->employee->label = $department->employee->full_name;
        }

        return view('departments.edit', compact('department'));
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
        $department = Department::find($id);

        if ($request->head_employee_id) {
            $employee = Employee::find($request->head_employee_id);

            $employee->mediator->translateSubMediators();
        }

        $department->update($request->all());

        return response()->json('updated', 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $department = Department::find($id);

        if (!empty($department->mediators->all())) {
            if ($department->employee) {
                $department->employee->mediator->translateSubMediators();
            } else {
                return response()->json(null, 204);
            }
        }

        $department->events->each(function ($event) {
            $event->department()->dissociate()->save();
        });

        Department::destroy($id);

        return response()->json([intval($id)], 201);
    }
}
