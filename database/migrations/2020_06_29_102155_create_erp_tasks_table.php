<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpTasksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_tasks', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('task_id', 20)->nullable();
			$table->integer('parent_id')->nullable()->comment('task id');
			$table->integer('child')->default(0)->comment('0=no, 1=yes');
			$table->string('task_name', 200)->nullable();
			$table->integer('project_id')->nullable();
			$table->integer('project_phase')->nullable();
			$table->integer('assigned_to')->nullable()->comment('It is user id');
			$table->integer('employee_id')->nullable();
			$table->integer('assigned_by')->nullable();
			$table->string('task_status', 20)->nullable()->comment('new, ongoing, completed, reassigned, cancelled');
			$table->integer('priority')->nullable()->comment('0=medium, 1=high, 2=urgent');
			$table->text('description', 65535)->nullable();
			$table->date('due_date')->nullable();
			$table->date('completed_on')->nullable();
			$table->integer('active_status')->default(1);
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
		Schema::drop('erp_tasks');
	}

}
