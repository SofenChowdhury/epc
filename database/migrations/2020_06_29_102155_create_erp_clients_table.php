<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpClientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_clients', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('client_name', 100);
			$table->string('abbreviation', 100)->nullable();
			$table->string('client_fax', 20)->nullable();
			$table->string('ministry', 100)->nullable();
			$table->string('website', 100)->nullable();
			$table->string('division', 100)->nullable();
			$table->string('agency', 100)->nullable();
			$table->text('client_image', 65535)->nullable();
			$table->text('company_address', 65535)->nullable();
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
		Schema::drop('erp_clients');
	}

}
