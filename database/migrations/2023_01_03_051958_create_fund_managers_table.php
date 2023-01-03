<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_managers', function (Blueprint $table) {
            $table->id();
            $table->string('MStarID')->nullable();
            $table->string('ISIN')->nullable();
            $table->string('FundManagerTenureAverage')->nullable();
            $table->string('Display')->nullable();
            $table->string('ManagerId')->nullable();
            $table->string('Name')->nullable(); 
            $table->string('Role')->nullable(); 
            $table->string('StartDate')->nullable();
            $table->string('Tenure')->nullable();               
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
        Schema::dropIfExists('fund_managers');
    }
}
