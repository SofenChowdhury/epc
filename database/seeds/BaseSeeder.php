<?php

use Illuminate\Database\Seeder;
use App\ErpBaseGroup;
use App\ErpBaseSetup;

class BaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ErpBaseGroup::create([
            'name' => 'gender',
        ]);
        ErpBaseGroup::create([
            'name' => 'blood group',
        ]);

        ErpBaseSetup::create([
            'base_group_id' => 1,
            'base_setup_name' => 'Male',
        ]);
        ErpBaseSetup::create([
            'base_group_id' => 1,
            'base_setup_name' => 'Female',
        ]);
        ErpBaseSetup::create([
            'base_group_id' => 2,
            'base_setup_name' => 'A+',
        ]);
        ErpBaseSetup::create([
            'base_group_id' => 2,
            'base_setup_name' => 'A-',
        ]);
        ErpBaseSetup::create([
            'base_group_id' => 2,
            'base_setup_name' => 'B+',
        ]);
        ErpBaseSetup::create([
            'base_group_id' => 2,
            'base_setup_name' => 'B-',
        ]);
        ErpBaseSetup::create([
            'base_group_id' => 2,
            'base_setup_name' => 'AB+',
        ]);
        ErpBaseSetup::create([
            'base_group_id' => 2,
            'base_setup_name' => 'AB-',
        ]);
        ErpBaseSetup::create([
            'base_group_id' => 2,
            'base_setup_name' => 'O+',
        ]);
        ErpBaseSetup::create([
            'base_group_id' => 2,
            'base_setup_name' => 'O-',
        ]);
    }
}
