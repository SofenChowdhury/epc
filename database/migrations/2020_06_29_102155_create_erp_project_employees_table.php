<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpProjectEmployeesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_project_employees', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('project_id')->nullable();
			$table->integer('user_id')->nullable();
			$table->integer('project_phase')->nullable();
			$table->integer('employee_id')->nullable();
			$table->string('title', 100)->nullable();
			$table->integer('man_hour')->nullable();
			$table->integer('staff_month_rate')->nullable();
			$table->integer('staff_month_proposal')->nullable();
			$table->integer('staff_month_agreed')->nullable();
			$table->decimal('total_amount', 11)->nullable();
			$table->integer('active_status')->default(1);
			$table->integer('reassign')->nullable()->comment('0=head office');
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
		Schema::drop('erp_project_employees');
	}

}
