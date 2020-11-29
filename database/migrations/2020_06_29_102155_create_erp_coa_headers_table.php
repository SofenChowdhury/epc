<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpCoaHeadersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_coa_headers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('category_id')->nullable()->index('category_id');
			$table->integer('header_reference_no')->nullable()->index('header_reference_no');
			$table->string('header_name', 191)->nullable();
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
		Schema::drop('erp_coa_headers');
	}

}
