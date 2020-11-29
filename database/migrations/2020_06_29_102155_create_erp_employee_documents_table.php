<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpEmployeeDocumentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_employee_documents', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('employee_id');
			$table->string('document_name', 100)->nullable();
			$table->integer('project_id')->nullable();
			$table->integer('priority')->nullable()->comment('1=high, 2=medium, 3=low');
			$table->text('description', 65535)->nullable();
			$table->string('upload_document', 100)->nullable();
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
		Schema::drop('erp_employee_documents');
	}

}
