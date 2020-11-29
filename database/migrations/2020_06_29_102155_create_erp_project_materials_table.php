<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpProjectMaterialsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_project_materials', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('project_id')->nullable();
			$table->integer('project_phase')->nullable();
			$table->integer('product_id')->nullable();
			$table->integer('inventory_id')->nullable();
			$table->integer('coa_id')->nullable();
			$table->string('product_name', 100)->nullable();
			$table->decimal('quantity', 11)->nullable();
			$table->decimal('quantity_sanctioned', 11)->nullable();
			$table->decimal('quantity_required', 11)->nullable();
			$table->string('unit', 50)->nullable();
			$table->text('description', 65535)->nullable();
			$table->integer('reassign')->nullable()->comment('0=headOffice, 1=back to client');
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
		Schema::drop('erp_project_materials');
	}

}
