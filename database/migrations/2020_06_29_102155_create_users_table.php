<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 191);
			$table->string('email', 191)->unique();
			$table->integer('employee_id')->unique('employee_id_2');
			$table->dateTime('email_verified_at')->nullable();
			$table->string('password', 191);
			$table->boolean('active_status')->default(1);
			$table->dateTime('last_login_at')->nullable();
			$table->string('last_login_ip', 100)->nullable();
			$table->string('remember_token', 100)->nullable();
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
		Schema::drop('users');
	}

}
