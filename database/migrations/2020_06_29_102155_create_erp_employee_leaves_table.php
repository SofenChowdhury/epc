<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpEmployeeLeavesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_employee_leaves', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('employee_id');
			$table->integer('type_of_leave')->nullable()->comment('0=Casual, 1=Annual');
			$table->date('start_date')->nullable();
			$table->integer('start_time')->nullable()->comment('0=Morning, 1=Afternoon');
			$table->date('end_date')->nullable();
			$table->integer('end_time')->nullable()->comment('0=Morning, 1=Afternoon');
			$table->integer('total_days')->nullable();
			$table->integer('approved_by')->nullable()->comment('admin id');
			$table->integer('approval_status')->nullable()->default(0)->comment('0=pending, 1=approved, 2=cancelled');
			$table->text('description', 65535)->nullable();
			$table->string('leave_document', 100)->nullable();
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
		Schema::drop('erp_employee_leaves');
	}

}
