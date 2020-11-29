<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToErpCoaHeadersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('erp_coa_headers', function(Blueprint $table)
		{
			$table->foreign('category_id', 'category_id')->references('category_reference_no')->on('erp_accounts_categories')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('erp_coa_headers', function(Blueprint $table)
		{
			$table->dropForeign('category_id');
		});
	}

}
