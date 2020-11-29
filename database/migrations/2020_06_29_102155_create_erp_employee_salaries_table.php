<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpEmployeeSalariesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_employee_salaries', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('employee_id')->nullable();
			$table->decimal('basic_percentage', 10, 0)->nullable();
			$table->float('basic', 10, 0)->nullable();
			$table->decimal('hourly_rate', 10, 0)->nullable();
			$table->decimal('house_rent_percentage', 10, 0)->nullable();
			$table->float('house_rent', 10, 0)->nullable();
			$table->float('conveyance', 10, 0)->nullable();
			$table->decimal('medical_percentage', 10, 0)->nullable();
			$table->float('medical', 10, 0)->nullable();
			$table->decimal('provident_fund_percentage', 10, 0)->nullable();
			$table->float('provident_fund', 10, 0)->nullable();
			$table->float('overtime', 10, 0)->nullable();
			$table->decimal('tax_amount', 11, 0)->nullable()->comment('monthly income tax');
			$table->decimal('tax_payable', 10, 0)->nullable()->comment('80% of income tax');
			$table->integer('increment')->nullable();
			$table->integer('total_salary')->nullable();
			$table->date('increment_date')->nullable();
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
		Schema::drop('erp_employee_salaries');
	}

}
