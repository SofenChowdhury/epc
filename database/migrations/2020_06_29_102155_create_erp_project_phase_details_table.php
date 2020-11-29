<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpProjectPhaseDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_project_phase_details', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('project_id')->nullable();
			$table->integer('project_phase')->nullable();
			$table->string('phase_status', 20)->nullable();
			$table->date('phase_start_date')->nullable();
			$table->date('phase_end_date')->nullable();
			$table->time('phase_end_time')->nullable();
			$table->text('proposal_meeting_place', 65535)->nullable();
			$table->date('meeting_date')->nullable();
			$table->time('meeting_time')->nullable();
			$table->string('proposal_validity', 100)->nullable();
			$table->string('assign_name_1', 100)->nullable();
			$table->text('assign_desc_1', 65535)->nullable();
			$table->string('assign_name_2', 100)->nullable();
			$table->text('assign_desc_2', 65535)->nullable();
			$table->string('assign_name_3', 100)->nullable();
			$table->text('assign_desc_3', 65535)->nullable();
			$table->text('remark', 65535)->nullable();
			$table->integer('created_by')->nullable();
			$table->integer('updated_by')->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('erp_project_phase_details');
	}

}
