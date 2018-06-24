<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Employee::class, 500)->create();

        list($e_num, $h_lvl) = array(9, 5);

        $head_employee = factory(App\Employee::class)->create();
        $head_department = factory(App\Department::class)->create();
        $this->employeeEventMediator($head_department->id, $head_employee->id);
        $departments = $this->subDepartments([$head_employee]);

        for ($i = 0; $i < $h_lvl; $i++) {
            $employees = [];

            foreach ($departments as $department) {

                $callback = function ($employee) use ($department) {
                  $this->employeeEventMediator($department->id, $employee->id);
                };

                array_push($employees,
                    ...(factory(App\Employee::class, $e_num)->create()->each($callback)->all()));
            }

            if ($i < $h_lvl - 1) {
                $departments = $this->subDepartments($employees);
            }

        }
    }

    protected function employeeEventMediator($department_id, $employee_id)
    {
        $event = factory(App\Event::class)->create([
                    'employee_id' => $employee_id,
                    'department_id' => $department_id,
                    'position_id' => (factory(App\Position::class)->create())->id,
                    'wage' => rand(1000, 5000),
                    'is_archive' => 0,
                ]);

        factory(App\Mediator::class)->create([
            'employee_id' => $employee_id,
            'recruitment_event_id' => $event->id,
            'department_id' => $event->department_id,
            'position_id' => $event->position_id,
            'wage' => $event->wage,
            'is_archive' => $event->is_archive,
        ]);
    }

    /**
     * @param $employees
     * @return array
     */
    protected function subDepartments($employees)
    {
        $departments = [];


        foreach ($employees as $employee) {
            $employee->department()->save(factory(App\Department::class)->make());
            $departments[] = $employee->department;
        }
        return $departments;
    }


}
