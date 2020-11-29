<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpEmployeeFamiliesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_employee_families', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('employee_id')->unique('employee_id');
			$table->string('father_name', 100)->nullable();
			$table->string('mother_name', 100)->nullable();
			$table->string('marital_status', 20)->nullable();
			$table->string('spouse_name', 100)->nullable();
			$table->string('child_name', 100)->nullable();
			$table->integer('epc_before')->nullable()->comment('0=no, 1=yes');
			$table->date('epc_before_from')->nullable();
			$table->date('epc_before_to')->nullable();
			$table->integer('relative')->nullable()->comment('0=no, 1=yes');
			$table->string('relative_name', 100)->nullable();
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
		Schema::drop('erp_employee_families');
	}

}
