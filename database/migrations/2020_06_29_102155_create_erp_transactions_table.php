<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_transactions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->date('transaction_date')->nullable();
			$table->string('description', 191)->nullable();
			$table->string('voucher_no', 191)->nullable();
			$table->decimal('total_transaction', 11)->nullable();
			$table->integer('project_id')->nullable();
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
		Schema::drop('erp_transactions');
	}

}
