<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpVendorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_vendors', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('unique_id', 100)->nullable();
			$table->string('vendor_name', 100)->nullable();
			$table->integer('coa_id')->nullable();
			$table->string('service_type', 200)->nullable();
			$table->string('service_acc_no', 100)->nullable();
			$table->string('service_meter_no', 100)->nullable();
			$table->text('office_address', 65535)->nullable();
			$table->string('email', 100)->nullable();
			$table->string('phone_number', 100)->nullable();
			$table->string('contact_person_name', 100)->nullable();
			$table->string('designation', 100)->nullable();
			$table->string('contact_person_email', 100)->nullable();
			$table->string('contact_person_phone', 100)->nullable();
			$table->string('trade_licence_no', 100)->nullable();
			$table->integer('active_status')->default(1);
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
		Schema::drop('erp_vendors');
	}

}
