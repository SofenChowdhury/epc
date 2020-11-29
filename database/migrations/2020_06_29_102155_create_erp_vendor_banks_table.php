<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpVendorBanksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_vendor_banks', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('vendor_id')->nullable();
			$table->string('bank_name', 100)->nullable();
			$table->string('account_number', 100)->nullable();
			$table->string('bank_branch', 100)->nullable();
			$table->text('bank_address', 65535)->nullable();
			$table->string('routing_number', 100)->nullable();
			$table->string('swift_code', 100)->nullable();
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
		Schema::drop('erp_vendor_banks');
	}

}
