<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpProjectReportingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_project_reportings', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('project_id')->nullable();
			$table->integer('project_phase')->nullable();
			$table->string('report_name', 150)->nullable();
			$table->date('due_date')->nullable();
			$table->text('description', 65535)->nullable();
			$table->integer('no_of_copies')->nullable();
			$table->date('submitted_on')->nullable();
			$table->integer('submitted_by')->nullable()->comment('employee id');
			$table->integer('active_status')->default(1);
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
		Schema::drop('erp_project_reportings');
	}

}
