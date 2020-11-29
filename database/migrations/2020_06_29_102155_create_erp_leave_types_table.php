<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpLeaveTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_leave_types', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('leave_type', 100)->nullable();
			$table->integer('total_leaves')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('erp_leave_types');
	}

}
