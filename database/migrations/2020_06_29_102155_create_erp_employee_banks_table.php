<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpEmployeeBanksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_employee_banks', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('employee_id')->unique('employee_id');
			$table->string('bank_name', 100)->nullable();
			$table->string('account_number', 100)->nullable();
			$table->string('bank_address', 100)->nullable();
			$table->string('bank_branch', 100)->nullable();
			$table->integer('routing_no')->nullable();
			$table->string('swift_code', 100)->nullable();
			$table->string('checking_savings', 100)->nullable();
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
		Schema::drop('erp_employee_banks');
	}

}
