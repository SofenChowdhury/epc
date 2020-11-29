<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpEmployeeIndentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_employee_indents', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('employee_id')->nullable();
			$table->string('product_name', 100)->nullable()->comment('from product table');
			$table->integer('quantity')->nullable();
			$table->text('description', 65535)->nullable();
			$table->string('indent_no', 100)->nullable();
			$table->integer('is_assigned')->nullable()->comment('0=not assigned, 1=assigned');
			$table->integer('active_status')->default(1);
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
		Schema::drop('erp_employee_indents');
	}

}
