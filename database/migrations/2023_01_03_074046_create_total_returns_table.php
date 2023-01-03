<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTotalReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('total_returns', function (Blueprint $table) {
            $table->id();
            $table->string('MStarID')->nullable();
            $table->string('ISIN')->nullable();
            $table->string('CumulativeReturn2Yr')->nullable();
            $table->string('CumulativeReturn3Yr')->nullable();
            $table->string('CumulativeReturn4Yr')->nullable();
            $table->string('CumulativeReturnSinceInception')->nullable();
            $table->string('MonthEndDate')->nullable();
            $table->string('Return1Mth')->nullable();
            $table->string('Return1Yr')->nullable();
            $table->string('Return2Mth')->nullable();
            $table->string('Return2Yr')->nullable();
            $table->string('Return3Mth')->nullable();
            $table->string('Return3Yr')->nullable();
            $table->string('Return4Yr')->nullable();
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
        Schema::dropIfExists('total_returns');
    }
}
