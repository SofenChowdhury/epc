<?php

use Illuminate\Database\Seeder;
use App\ErpDepartment;
use App\ErpDesignation;
use App\ErpEmployeeType;
use App\ErpEmployeeCategory;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ErpDepartment::create([
            'department_name' => 'IT',
            'active_status' => 1,
        ]);
        ErpDepartment::create([
            'department_name' => 'Accounts',
            'active_status' => 1,
        ]);

        ErpDesignation::create([
            'designation_name' => 'Project Manager',
            'active_status' => 1,
        ]);
        ErpDesignation::create([
            'designation_name' => 'Chartered Accountant',
            'active_status' => 1,
        ]);
        ErpDesignation::create([
            'designation_name' => 'Sr. Developer',
            'active_status' => 1,
        ]);

        ErpEmployeeType::create([
            'type_name' => 'Full time'
        ]);
        ErpEmployeeType::create([
            'type_name' => 'Part time'
        ]);
        ErpEmployeeType::create([
            'type_name' => 'Project based'
        ]);
        ErpEmployeeType::create([
            'type_name' => 'Temporary'
        ]);

        ErpEmployeeCategory::create([
            'given_id' => 'H1001',
            'category_name' => 'Higher class',
        ]);

        factory(ErpEmployee::class)->create([
            'unique_id' => 'H1001-1019-01',
        ]);
        factory(ErpEmployee::class)->create([
            'unique_id' => 'H1001-1019-02',
        ]);
        factory(ErpEmployee::class)->create([
            'unique_id' => 'H1001-1019-03',
        ]);

        factory(ErpEmployeeBank::class)->create([
            'employee_id' => 1,
        ]);
        factory(ErpEmployeeFamily::class)->create([
            'employee_id' => 1,
        ]);
        factory(ErpEmployeeSalary::class)->create([
            'employee_id' => 1,
        ]);

        factory(ErpEmployeeBank::class)->create([
            'employee_id' => 2,
        ]);
        factory(ErpEmployeeFamily::class)->create([
            'employee_id' => 2,
        ]);
        factory(ErpEmployeeSalary::class)->create([
            'employee_id' => 2,
        ]);

        factory(ErpEmployeeBank::class)->create([
            'employee_id' => 3,
        ]);
        factory(ErpEmployeeFamily::class)->create([
            'employee_id' => 3,
        ]);
        factory(ErpEmployeeSalary::class)->create([
            'employee_id' => 3,
        ]);
    }
}
