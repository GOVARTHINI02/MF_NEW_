<?php

use Facade\FlareClient\View;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyNavPerformancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_nav_performances', function (Blueprint $table) {
            $table->id();
            $table->string('MStarID')->nullable();
            $table->string('ISIN')->nullable();
            $table->string('CategoryCode')->nullable();
            $table->string('CategoryName')->nullable();
            $table->string('CumulativeReturn3Yr')->nullable();
            $table->string('CumulativeReturn5Yr')->nullable();
            $table->string('CumulativeReturn10Yr')->nullable();
            $table->string('CumulativeReturnSinceInception')->nullable();
            $table->string('DayEndDate')->nullable();
            $table->string('DayEndNAV')->nullable();
            $table->string('Dividend')->nullable();
            $table->string('DividendDate')->nullable();
            $table->string('FundName')->nullable();
            $table->string('NAVChange')->nullable();
            $table->string('NAVChangePercentage')->nullable();
            $table->string('RecordDate')->nullable();
            $table->string('Return1Day')->nullable();
            $table->string('Return1Mth')->nullable();
            $table->string('Return1Week')->nullable();
            $table->string('Return1Yr')->nullable();
            $table->string('Return2Mth')->nullable();
            $table->string('Return2Yr')->nullable();
            $table->string('Return3Mth')->nullable();
            $table->string('Return3Yr')->nullable();
            $table->string('Return4Yr')->nullable();
            $table->string('Return5Yr')->nullable();
            $table->string('Return6Mth')->nullable();
            $table->string('ReturnSinceInception')->nullable();            
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
        Schema::dropIfExists('daily_nav_performances');
    }
}
