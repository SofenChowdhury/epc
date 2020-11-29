<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpDepreciationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_depreciations', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('product_id')->nullable();
			$table->integer('coa_reference_no')->nullable();
			$table->date('purchase_date')->nullable();
			$table->integer('cost_price')->nullable();
			$table->decimal('depreciation_rate', 10, 0)->nullable();
			$table->decimal('accumulated_depreciation', 10, 0)->nullable();
			$table->integer('current_value')->nullable();
			$table->decimal('current_year_dep', 10, 0)->nullable();
			$table->integer('active_status')->default(1);
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
		Schema::drop('erp_depreciations');
	}

}
