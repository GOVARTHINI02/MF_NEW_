<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrentPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('current_prices', function (Blueprint $table) {
            $table->id();
            $table->string('MStarID')->nullable();
            $table->string('ISIN')->nullable();
            $table->string('DayEndNAV')->nullable();
            $table->string('DayEndNAVDate')->nullable();
            $table->string('MonthEndNAV')->nullable();
            $table->string('MonthEndNAVDate')->nullable();
            $table->string('NAV52wkHigh')->nullable();
            $table->string('NAV52wkHighDate')->nullable();
            $table->string('NAV52wkLow')->nullable();
            $table->string('NAV52wkLowDate')->nullable();
            $table->string('PerformanceReturnSource')->nullable();
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
        Schema::dropIfExists('current_prices');
    }
}
