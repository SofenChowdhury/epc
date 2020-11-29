<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpProjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erp_projects', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('project_name', 200);
			$table->string('project_code', 100)->nullable()->comment('1st part of ref no.');
			$table->integer('project_phase')->nullable()->comment('2nd part of ref no');
			$table->string('project_full_name', 200)->nullable();
			$table->integer('contract_type')->nullable()->comment('1=jv, 2=subconsultant, 3=lead');
			$table->string('rfp_no', 100)->nullable();
			$table->string('contract_no', 100)->nullable();
			$table->string('project_component', 100)->nullable();
			$table->integer('epc_share_percentage')->nullable();
			$table->integer('jv_party')->default(0);
			$table->integer('epc_lead')->nullable();
			$table->date('project_start_date')->nullable();
			$table->date('project_due_date')->nullable();
			$table->integer('project_director')->nullable();
			$table->integer('project_lead')->nullable();
			$table->integer('client_id')->nullable();
			$table->integer('project_amount')->nullable();
			$table->decimal('amount_after_tax', 11)->nullable();
			$table->string('tax_by', 20)->nullable();
			$table->decimal('tax_amount', 11)->nullable();
			$table->string('project_type', 100)->nullable();
			$table->string('project_status', 20)->nullable();
			$table->string('project_source', 100)->nullable();
			$table->string('contact_person', 100)->nullable();
			$table->string('designation', 50)->nullable();
			$table->string('contact_person_email', 50)->nullable();
			$table->string('contact_person_phone', 100)->nullable();
			$table->text('contact_person_address', 65535)->nullable();
			$table->string('funded_by', 100)->nullable();
			$table->date('previous_deadline')->nullable();
			$table->string('execution_authority', 100)->nullable();
			$table->string('procuring_entity', 100)->nullable();
			$table->string('procuring_entity_district', 50)->nullable();
			$table->string('eoi_selection', 100)->nullable();
			$table->string('eoi_reference', 100)->nullable();
			$table->string('selection_method', 100)->nullable();
			$table->string('procurement_method', 100)->nullable();
			$table->string('study_time', 100)->nullable();
			$table->text('association', 65535)->nullable();
			$table->text('description', 65535)->nullable();
			$table->text('description_2', 65535)->nullable();
			$table->date('completed_on')->nullable();
			$table->boolean('active_status')->default(1);
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
		Schema::drop('erp_projects');
	}

}
