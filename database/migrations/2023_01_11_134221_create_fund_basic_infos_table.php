<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundBasicInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_basic_infos', function (Blueprint $table) {
            $table->id();
            $table->string('MStarID')->nullable();
            $table->string('ISIN')->nullable();
            $table->string('AMFICode')->nullable();
            $table->string('AggregatedCategoryName')->nullable();
            $table->string('BroadCategoryGroup')->nullable();
            $table->string('CategoryName')->nullable();
            $table->string('FundLegalName')->nullable();
            $table->string('FundName')->nullable();
            $table->string('InceptionDate')->nullable();
            $table->string('IndianRiskLevel')->nullable();
            $table->string('ProviderCompanyName')->nullable();
            $table->string('ProviderCompanyPhoneNumber')->nullable();
            $table->string('ProviderCompanyWebsite')->nullable();
            $table->string('RTACode')->nullable();
            $table->string('CustodianCompanyName')->nullable();
            $table->string('DistributorCompanyName')->nullable();
            $table->string('Alice_category')->nullable();
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
        Schema::dropIfExists('fund_basic_infos');
    }
}
