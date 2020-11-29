<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpEmployeeSalaryPrintsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_employee_salary_prints', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->date('salary_month')->nullable();
			$table->integer('project_id')->nullable();
			$table->integer('approval_level')->nullable()->comment('1=sohel, 2=goni, 3=datta, 4=bhuiya, 5=pinku');
			$table->integer('next_user_id')->default(18);
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
		Schema::drop('erp_employee_salary_prints');
	}

}
