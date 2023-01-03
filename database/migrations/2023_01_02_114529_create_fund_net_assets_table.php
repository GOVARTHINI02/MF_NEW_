<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundNetAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_net_assets', function (Blueprint $table) {
            $table->id();
            $table->string('MStarID')->nullable();
            $table->string('ISIN')->nullable();
            $table->string('AsOfOriginalReported')->nullable();
            $table->string('AsOfOriginalReportedDate')->nullable();
            $table->string('FundNetAssets')->nullable();
            $table->string('NetAssetsDate')->nullable();            
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
        Schema::dropIfExists('fund_net_assets');
    }
}
