<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpProjectDeliverablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_project_deliverables', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('project_id')->nullable();
			$table->integer('project_phase')->nullable();
			$table->integer('report_id')->nullable()->comment('from erp_project_reporting');
			$table->string('report_name', 200)->nullable();
			$table->integer('amount_percentage')->nullable();
			$table->integer('total_amount')->nullable();
			$table->decimal('amount_received', 11)->nullable();
			$table->string('status', 50)->nullable()->default('pending')->comment('pending / received');
			$table->date('receive_date')->nullable();
			$table->date('invoice_date')->nullable();
			$table->integer('turnaround_days')->nullable();
			$table->date('receive_due_date')->nullable();
			$table->decimal('interest_rate', 11)->nullable();
			$table->decimal('revised_amount', 11)->nullable();
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
		Schema::drop('erp_project_deliverables');
	}

}
