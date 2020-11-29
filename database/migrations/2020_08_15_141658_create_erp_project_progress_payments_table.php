<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErpProjectProgressPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_project_progress_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->nullable();
            $table->integer('project_phase')->nullable();
            $table->integer('p_payment_no')->nullable();
            $table->date('p_payment_month')->nullable();
            $table->date('invoice_date')->nullable();
            $table->decimal('invoice_amount', 11)->nullable();
            $table->date('receive_date')->nullable();
            $table->decimal('receive_amount')->nullable();
            $table->text('description', 65535)->nullable();
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
        Schema::dropIfExists('erp_project_progress_payments');
    }
}
