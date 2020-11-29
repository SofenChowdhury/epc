<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpProjectAdvancesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_project_advances', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('project_id')->nullable();
			$table->integer('project_phase')->nullable();
			$table->decimal('amount', 11)->nullable();
			$table->date('receive_date')->nullable();
			$table->string('bank_name', 100)->nullable();
			$table->decimal('guarantee_amount', 11)->nullable();
			$table->date('effective_through')->nullable();
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
		Schema::drop('erp_project_advances');
	}

}
