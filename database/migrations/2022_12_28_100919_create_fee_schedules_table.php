<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeeSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('MStarID')->nullable();
            $table->string('ISIN')->nullable();
            $table->string('DeferLoads_HighBreakpoint')->nullable();
            $table->string('DeferLoads_LowBreakpoint')->nullable();
            $table->string('DeferLoads_BreakpointUnit')->nullable();
            $table->string('DeferLoads_Unit')->nullable();
            $table->string('DeferLoads_Value')->nullable();
            $table->string('DeferLoadDate')->nullable();         
            $table->string('FrontLoads_LowBreakpoint')->nullable();
            $table->string('FrontLoads_BreakpointUnit')->nullable();
            $table->string('FrontLoads_Unit')->nullable();
            $table->string('FrontLoads_Value')->nullable();
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
        Schema::dropIfExists('fee_schedules');
    }
}
