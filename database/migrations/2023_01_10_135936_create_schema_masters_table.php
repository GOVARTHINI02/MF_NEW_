<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchemaMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scheme_master_data', function (Blueprint $table) {
            $table->id();
            $table->string('unique_no');
            $table->string('scheme_code');
            $table->string('rta_scheme_code');
            $table->string('amc_scheme_code');
            $table->string('isin');
            $table->string('amc_code');
            $table->string('scheme_type');
            $table->string('scheme_plan');
            $table->string('scheme_name');
            $table->string('purchase_allowed');
            $table->string('purchase_transaction_mode');
            $table->string('minimum_purchase_amount');
            $table->string('additional_purchase_amount');
            $table->string('maximum_purchase_amount');
            $table->string('purchase_amount_multiplier');
            $table->string('purchase_cutoff_time');
            $table->string('redemption_allowed');
            $table->string('redemption_transaction_mode');
            $table->string('minimum_redemption_qty');
            $table->string('redemption_qty_multiplier');
            $table->string('maximum_redemption_qty');
            $table->string('redemption_amount_minimum');
            $table->string('redemption_amount_maximum');
            $table->string('redemption_amount_multiple');
            $table->string('redemption_cutoff_time');
            $table->string('rta_agent_code');
            $table->string('amc_active_flag');
            $table->string('dividend_reinvestment_flag');
            $table->string('sip_flag');
            $table->string('stp_flag');
            $table->string('swp_flag');
            $table->string('switch_flag');
            $table->string('settlement_type');
            $table->string('amc_ind');
            $table->string('face_value');
            $table->string('start_date');
            $table->string('end_date');
            $table->string('exit_load_flag');
            $table->string('exit_load');
            $table->string('lock_in_period_flag');
            $table->string('lock_in_period	');
            $table->string('channel_partner_code');
            $table->string('reOpeningDate	');    
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
        Schema::dropIfExists('schema_masters');
    }
}
