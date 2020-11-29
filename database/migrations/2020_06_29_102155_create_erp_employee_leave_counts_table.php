<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpEmployeeLeaveCountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_employee_leave_counts', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('leave_type_id')->nullable();
			$table->integer('employee_id')->nullable();
			$table->integer('count')->nullable();
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
		Schema::drop('erp_employee_leave_counts');
	}

}
