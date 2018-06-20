<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeesDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return $this->getManagingDepartments();
        }

        return view('employees_data.index', compact('managing_departments'));
    }

    protected function getManagingDepartments()
    {
        $managing_departments = (DB::table('departments')
            ->select(
                DB::raw("concat(departments.id, ',', departments.name) as department")
            )
            ->where('head_employee_id', '=', null))->get();
        return $this->itemsToArray($managing_departments, ['department']);
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
