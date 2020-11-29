<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpStatusesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_statuses', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name', 100)->nullable();
			$table->integer('phases')->nullable()->comment('0=for all phases');
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
		Schema::drop('erp_statuses');
	}

}
