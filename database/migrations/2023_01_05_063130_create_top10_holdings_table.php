<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTop10HoldingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('top10_holdings', function (Blueprint $table) {
            $table->id();
            $table->string('MstarID')->nullable();
            $table->string('ISIN')->nullable();
            $table->string('HoldingType')->nullable();
            $table->string('Name')->nullable();
            $table->string('Weighting')->nullable();
            $table->string('NumberOfShare')->nullable();
            $table->string('MarketValue')->nullable();
            $table->string('ShareChange')->nullable();
            $table->string('MaturityDate')->nullable();
            $table->string('Coupon')->nullable();
            $table->string('IndianCreditQualityClassification')->nullable();
            $table->string('SectorId')->nullable();
            $table->string('Sector')->nullable();
            $table->string('GlobalSectorId')->nullable();
            $table->string('GlobalSector')->nullable();
            $table->string('Ticker')->nullable();
            $table->string('HoldingYTDReturn')->nullable();
            $table->string('Stylebox')->nullable();
            $table->string('RegionId')->nullable();
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
        Schema::dropIfExists('top10_holdings');
    }
}
