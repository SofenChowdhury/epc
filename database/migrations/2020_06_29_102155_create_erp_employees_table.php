<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpEmployeesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_employees', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('unique_id', 20)->nullable()->unique('unique_id');
			$table->string('first_name', 191)->nullable();
			$table->string('last_name', 191)->nullable();
			$table->string('email', 191)->nullable()->unique('email');
			$table->string('mobile', 191)->nullable();
			$table->string('emergency_no', 191)->nullable();
			$table->date('date_of_birth')->nullable();
			$table->text('permanent_address', 65535)->nullable();
			$table->text('current_address', 65535)->nullable();
			$table->string('place_of_birth', 100)->nullable();
			$table->string('nid', 20)->nullable();
			$table->string('tin', 20)->nullable();
			$table->integer('employee_type');
			$table->integer('employee_category_id')->nullable();
			$table->integer('department_id')->nullable();
			$table->integer('designation_id')->nullable();
			$table->integer('supervisor_designation')->nullable()->comment('designation id');
			$table->integer('location')->nullable();
			$table->integer('room_no')->nullable();
			$table->date('joining_date')->nullable();
			$table->date('probation_period')->nullable()->comment('number of months');
			$table->string('employee_photo', 191)->nullable();
			$table->integer('gender_id')->nullable();
			$table->integer('blood_group_id')->nullable();
			$table->string('joining_letter', 100)->nullable();
			$table->text('qualifications', 65535)->nullable();
			$table->text('experiences', 65535)->nullable();
			$table->integer('emp_certificate')->nullable()->default(0);
			$table->boolean('active_status')->default(1);
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
		Schema::drop('erp_employees');
	}

}
