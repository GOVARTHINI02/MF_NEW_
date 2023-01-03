<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnualReportFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('annual_report_fees', function (Blueprint $table) {
            $table->id();
            $table->string('MStarID')->nullable();
            $table->string('ISIN')->nullable();
            $table->string('AnnualReportDate')->nullable();
            $table->string('NetExpenseRatio')->nullable();
            $table->string('InterimNetExpenseRatio')->nullable();
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
        Schema::dropIfExists('annual_report_fees');
    }
}
