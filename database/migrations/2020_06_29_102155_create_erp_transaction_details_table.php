<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpTransactionDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_transaction_details', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('transaction_id')->nullable();
			$table->integer('coa_id')->nullable();
			$table->decimal('debit_amount', 11)->nullable();
			$table->decimal('credit_amount', 11)->nullable();
			$table->string('type', 191)->nullable()->comment('D for debit and C for credit');
			$table->boolean('active_status')->default(1);
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
		Schema::drop('erp_transaction_details');
	}

}
