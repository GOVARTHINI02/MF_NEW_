<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMorningstarRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('morningstar_ratings', function (Blueprint $table) {
            $table->id();
            $table->string('MStarID')->nullable();
            $table->string('ISIN')->nullable();
            $table->string('NumberOfFunds10Year')->nullable();
            $table->string('NumberOfFunds3Year')->nullable();
            $table->string('NumberOfFunds5Year')->nullable();
            $table->string('NumberOfFundsOverall')->nullable();
            $table->string('PerformanceScore3Yr')->nullable();
            $table->string('PerformanceScoreOverall')->nullable();
            $table->string('Rating3Year')->nullable();
            $table->string('Rating5Year')->nullable();
            $table->string('RatingDate')->nullable();
            $table->string('RatingOverall')->nullable();
            $table->string('Return3Year')->nullable();
            $table->string('Return5Year')->nullable();
            $table->string('ReturnOverall')->nullable();
            $table->string('Risk3Year')->nullable();
            $table->string('Risk5Year')->nullable();
            $table->string('RiskOverall')->nullable();
            $table->string('RiskScore3Yr')->nullable();
            $table->string('RiskScore5Yr')->nullable();
            $table->string('RiskScoreOverall')->nullable();           
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
        Schema::dropIfExists('morningstar_ratings');
    }
}
