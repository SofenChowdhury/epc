<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpVendorDocumentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_vendor_documents', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('vendor_id')->nullable();
			$table->string('document_name', 100)->nullable();
			$table->string('upload_document', 100)->nullable();
			$table->text('description', 65535)->nullable();
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
		Schema::drop('erp_vendor_documents');
	}

}
