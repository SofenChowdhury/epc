<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpChartOfAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_chart_of_accounts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('coa_reference_no')->nullable()->index('coa_reference_no');
			$table->integer('coa_header_id')->nullable()->index('coa_header_id');
			$table->string('coa_name', 191)->nullable();
			$table->integer('coa_parent')->nullable()->index('coa_parent');
			$table->integer('child')->nullable()->comment('1=has child');
			$table->string('account_type', 20)->nullable();
			$table->integer('project_id')->nullable();
			$table->integer('opening_debit')->nullable();
			$table->integer('opening_credit')->nullable();
			$table->decimal('opening_debit_amount', 11)->nullable();
			$table->decimal('opening_credit_amount', 11)->nullable();
			$table->boolean('active_status')->default(1);
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
		Schema::drop('erp_chart_of_accounts');
	}

}
