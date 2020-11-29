<?php

use Illuminate\Database\Seeder;
use App\ErpProjectPhase;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ErpProjectPhase::create([
            'defined_id' => 1,
            'name' => 'EOI (Expression of Interest)',
            'required' => 1,
        ]);
        ErpProjectPhase::create([
            'defined_id' => 2,
            'name' => 'Proposal',
            'required' => 1,
        ]);
        ErpProjectPhase::create([
            'defined_id' => 3,
            'name' => 'Award',
            'required' => 1,
        ]);
        ErpProjectPhase::create([
            'defined_id' => 4,
            'name' => 'Contract agreement',
            'required' => 1,
        ]);
        ErpProjectPhase::create([
            'defined_id' => 5,
            'name' => 'Feasibility study',
            'required' => 0,
        ]);
        ErpProjectPhase::create([
            'defined_id' => 6,
            'name' => 'Design and Engineering',
            'required' => 1,
        ]);
        ErpProjectPhase::create([
            'defined_id' => 7,
            'name' => 'Construction Monitoring Supervision',
            'required' => 1,
        ]);
        ErpProjectPhase::create([
            'defined_id' => 8,
            'name' => 'Continue Engineering support of operation and maintenance',
            'required' => 0,
        ]);

        factory(ErpClient::class,2)->create();
        factory(ErpProject::class)->create([
            'project_type' => 1,
        ]);
        factory(ErpProject::class,2)->create();
    }
}
