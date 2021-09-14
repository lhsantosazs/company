<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_customer', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id')->unsigned();
            /*$table->foreign('company_id')
                  ->references('id')
                  ->on('company')
                  ->onDelete('cascade');*/
            $table->integer('customer_id')->unsigned();
            /*$table->foreign('customer_id')
                  ->references('id')
                  ->on('customer')
                  ->onDelete('cascade');*/
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
        Schema::dropIfExists('company_customer');
    }
}
