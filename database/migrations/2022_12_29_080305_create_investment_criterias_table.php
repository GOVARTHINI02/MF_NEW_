<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentCriteriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investment_criterias', function (Blueprint $table) {
            $table->id();
            $table->string('MStarID')->nullable();
            $table->string('ISIN')->nullable();
            $table->text('InvestmentPhilosophy')->nullable();
            $table->longText('InvestmentStrategy')->nullable();          
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
        Schema::dropIfExists('investment_criterias');
    }
}
