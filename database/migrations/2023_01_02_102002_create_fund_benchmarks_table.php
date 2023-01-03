<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundBenchmarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_benchmarks', function (Blueprint $table) {
            $table->id();
            $table->string('MStarID')->nullable();
            $table->string('ISIN')->nullable();
            $table->string('PrimaryIndexId')->nullable();
            $table->string('PrimaryIndexName')->nullable();
            $table->string('IndexId')->nullable();
            $table->string('IndexName')->nullable();
            $table->string('Weighting')->nullable();
            $table->string('SecondaryIndexId')->nullable();
            $table->string('SecondaryIndexName')->nullable();
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
        Schema::dropIfExists('fund_benchmarks');
    }
}
