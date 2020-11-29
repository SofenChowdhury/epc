<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToErpChartOfAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('erp_chart_of_accounts', function(Blueprint $table)
		{
			$table->foreign('coa_header_id', 'coa_header_id')->references('header_reference_no')->on('erp_coa_headers')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('coa_parent', 'coa_parent')->references('coa_reference_no')->on('erp_chart_of_accounts')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('erp_chart_of_accounts', function(Blueprint $table)
		{
			$table->dropForeign('coa_header_id');
			$table->dropForeign('coa_parent');
		});
	}

}
