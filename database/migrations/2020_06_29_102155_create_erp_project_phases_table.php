<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpProjectPhasesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_project_phases', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('defined_id')->nullable();
			$table->string('name', 100)->nullable();
			$table->integer('required')->nullable()->comment('1=yes, 0=no');
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
		Schema::drop('erp_project_phases');
	}

}
