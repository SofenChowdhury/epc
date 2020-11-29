<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpEmployeeMaterialsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_employee_materials', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('employee_id')->nullable();
			$table->integer('inventory_id')->nullable();
			$table->integer('driver_id')->nullable();
			$table->integer('coa_id')->nullable();
			$table->string('indent_no', 100)->nullable();
			$table->integer('location')->nullable();
			$table->integer('room_no')->nullable();
			$table->string('product_name', 100)->nullable();
			$table->integer('quantity')->nullable();
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
		Schema::drop('erp_employee_materials');
	}

}
