<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpInventoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_inventories', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('category')->nullable()->comment('1=inventory, 2=equipment, 3=vehicles, 4=furniture');
			$table->integer('product_id')->nullable()->comment('from product table');
			$table->string('product_name', 100)->nullable();
			$table->string('serial_no', 100)->nullable();
			$table->string('brand_name', 100)->nullable();
			$table->integer('type')->nullable()->default(0)->comment('0=short-time, 1=long-time');
			$table->integer('employee_id')->nullable();
			$table->integer('project_id')->nullable();
			$table->integer('coa_id')->nullable();
			$table->integer('location')->nullable();
			$table->integer('room_no')->nullable();
			$table->integer('coa_reference_no')->nullable()->comment('for long-term');
			$table->decimal('depreciation_rate', 10, 0)->nullable()->comment('for long-term');
			$table->integer('quantity')->nullable();
			$table->string('unit', 100)->nullable();
			$table->decimal('price', 10, 0)->nullable();
			$table->date('purchase_date')->nullable();
			$table->integer('min_amount')->nullable();
			$table->string('chasis_no', 100)->nullable();
			$table->string('cc', 20)->nullable();
			$table->integer('payment_method')->nullable();
			$table->integer('vendor_id')->nullable();
			$table->string('vendor_contact', 100)->nullable();
			$table->string('upload_document', 100)->nullable();
			$table->text('description', 65535)->nullable();
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
		Schema::drop('erp_inventories');
	}

}
