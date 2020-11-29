<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpEmployeeAdvancesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_employee_advances', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('employee_id')->nullable();
			$table->integer('amount')->nullable();
			$table->integer('repay_duration')->nullable()->comment('no. of months');
			$table->decimal('monthly_repay', 10, 0)->nullable()->comment('=amount/repay_duration');
			$table->date('from_month')->nullable();
			$table->date('to_month')->nullable()->comment('=from_month+repay_duration');
			$table->text('description', 65535)->nullable();
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
		Schema::drop('erp_employee_advances');
	}

}
