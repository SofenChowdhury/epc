<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpProjectJointVenturesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_project_joint_ventures', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('project_id')->nullable();
			$table->string('jv_name', 150);
			$table->integer('jv_leading')->nullable()->comment('0=none, 1=local, 2=international');
			$table->integer('share_percentage')->nullable();
			$table->string('contact_person', 100)->nullable();
			$table->string('designation', 100)->nullable();
			$table->string('email', 100)->nullable();
			$table->string('phone_number', 100)->nullable();
			$table->text('address', 65535)->nullable();
			$table->text('remarks', 65535)->nullable();
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
		Schema::drop('erp_project_joint_ventures');
	}

}
