<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Event;
use App\Mediator;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('events.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('events.create');
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
            'employee_id' => 'required',
            'description' => 'required',
        ]);

        $event = (new \App\Event)->create($request->all());

        $mediator = (new \App\Mediator)->firstOrNew(['employee_id' => $request->employee_id]);
        $mediator->fill($request->all());
        if (!$mediator->recruitment_event_id) {
            $event->mediator()->save($mediator);
        } else {
            $event->save();
            $mediator->save();

            if ($request->is_archive) {
                $mediator->translateSubMediators();
            }
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
        $employee = Employee::findOrFail($id);
        $employee->label = $employee->full_name;

        if ($employee->mediator) {
            if ($employee->mediator->is_archive) {
                $employee->marker = 'archive';
            } else {
                $employee->marker = 'collection';
            }

        }else {
            $employee->marker = 'unformed';
        }

        return view('events.show', ['employee' => $employee]);
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
        $event = Event::findOrFail($id);
        $employee = Employee::find($event->employee_id);
        $mediator = Mediator::where('employee_id', $event->employee_id)->first();

        if ($mediator->recruitment_event_id == $id) {

            $mediator->dissociateDepartment();

            $mediator->delete();
            $events = Event::where('employee_id', $event->employee_id);
            $ids = $events->pluck('id');
            $events->delete();

            return response()->json($ids, 201);

        } else {
            $id = $event->id;
            $event->delete();

            $revert = $this->revertData($employee->events(), [
                'position_id',
                'wage',
                'department_id',
                'is_archive'
            ]);

            $mediator->fill($revert)->save();

            return response()->json([$id], 201);
        }

        return response()->json('false', 401);
    }

    protected function revertData($builder, $needle): array
    {
        $revert = [];
        $events = $builder->orderBy('created_at', 'desc')->get();
        foreach ($needle as $prop) {
            foreach ($events as $event) {
                if (!is_null($event->$prop)) {
                    $revert[$prop] = $event->$prop;
                    break;
                }
            }
        }

        return $revert;
    }

}
