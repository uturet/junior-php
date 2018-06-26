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
        $this->createEmployees(5, 9);

        $this->createUnformedArchivedEmployees(5, 5);

        factory(App\Position::class, 5)->create();
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

    protected function createUnformedArchivedEmployees($unformed, $archived)
    {
        factory(App\Employee::class, $unformed)->create();

        factory(App\Employee::class, $archived)->create()->each(
            function ($employee) {
                $event = factory(App\Event::class)->create([
                    'employee_id' => $employee->id,
                    'is_archive' => 1
                ]);
                factory(App\Mediator::class)->create([
                    'employee_id' => $employee->id,
                    'recruitment_event_id' => $event->id,
                    'department_id' => $event->department_id,
                    'position_id' => $event->position_id,
                    'wage' => $event->wage,
                    'is_archive' => $event->is_archive,
                ]);
            });
    }

    /**
     * @param $h_lvl
     * @param $e_num
     */
    protected function createEmployees($h_lvl, $e_num)
    {
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


}
