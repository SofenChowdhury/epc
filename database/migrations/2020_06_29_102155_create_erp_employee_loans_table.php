<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpEmployeeLoansTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_employee_loans', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('employee_id')->nullable();
			$table->integer('amount')->nullable();
			$table->date('due_date')->nullable();
			$table->integer('repaid_amount')->nullable();
			$table->date('repaid_date')->nullable();
			$table->integer('due_left')->nullable();
			$table->integer('active_status')->nullable()->default(1);
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
		Schema::drop('erp_employee_loans');
	}

}
