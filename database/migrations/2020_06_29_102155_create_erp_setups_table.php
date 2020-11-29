<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpSetupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_setups', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('company_name', 191)->nullable();
			$table->string('address', 191)->nullable();
			$table->integer('phone')->nullable();
			$table->string('email', 191)->nullable();
			$table->string('logo', 191)->nullable();
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
		Schema::drop('erp_setups');
	}

}
