<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnualReportFinancialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('annual_report_financials', function (Blueprint $table) {
            $table->id();
            $table->string('MStarID')->nullable();
            $table->string('ISIN')->nullable();
            $table->string('AnnualReportTurnoverRatio')->nullable();
            $table->string('AnnualReportTurnoverRatioDate')->nullable();
            $table->string('InterimTurnoverRatio')->nullable();
            $table->string('InterimTurnoverRatioDate')->nullable();
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
        Schema::dropIfExists('annual_report_financials');
    }
}
