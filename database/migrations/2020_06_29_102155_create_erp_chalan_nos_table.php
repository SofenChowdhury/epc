<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpChalanNosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_chalan_nos', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('chalan_no', 100)->nullable();
			$table->string('bank_name', 100)->nullable();
			$table->date('chalan_date')->nullable();
			$table->date('start_month')->nullable();
			$table->date('end_month')->nullable();
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
		Schema::drop('erp_chalan_nos');
	}

}
