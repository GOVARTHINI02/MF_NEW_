<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmcBasicInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amc_basic_infos', function (Blueprint $table) {
            $table->id();
            $table->string('MStarID')->nullable();
            $table->string('Admin_CompanyID')->nullable();
            $table->text('Admin_CompanyName')->nullable();
            $table->string('Admin_CompanyCity')->nullable();
            $table->string('Admin_CompanyProvince')->nullable();
            $table->string('Admin_CompanyCountry')->nullable();
            $table->string('Admin_CompanyPostalCode')->nullable();
            $table->longText('Admin_CompanyAddress')->nullable();
            $table->string('Advisor_CompanyID')->nullable();
            $table->text('Advisor_CompanyName')->nullable();
            $table->string('Advisor_CompanyCity')->nullable();
            $table->string('Advisor_CompanyProvince')->nullable();
            $table->string('Advisor_CompanyCountry')->nullable();
            $table->string('Advisor_CompanyPostalCode')->nullable();
            $table->longText('Advisor_CompanyAddress')->nullable();
            $table->string('Auditor_CompanyID')->nullable();
            $table->text('Auditor_CompanyName')->nullable();
            $table->string('Auditor_CompanyCity')->nullable();
            $table->string('Auditor_CompanyProvince')->nullable();
            $table->string('Auditor_CompanyCountry')->nullable();
            $table->string('Auditor_CompanyPostalCode')->nullable();
            $table->longText('Auditor_CompanyAddress')->nullable();
            $table->string('Custodian_CompanyID')->nullable();
            $table->text('Custodian_CompanyName')->nullable();
            $table->string('Custodian_CompanyCity')->nullable();
            $table->string('Custodian_CompanyProvince')->nullable();
            $table->string('Custodian_CompanyCountry')->nullable();
            $table->string('Custodian_CompanyPostalCode')->nullable();
            $table->longText('Custodian_CompanyAddress')->nullable();
            $table->string('Distributor_CompanyID')->nullable();
            $table->text('Distributor_CompanyName')->nullable();
            $table->string('Distributor_CompanyCity')->nullable();
            $table->string('Distributor_CompanyProvince')->nullable();
            $table->string('Distributor_CompanyCountry')->nullable();
            $table->string('Distributor_CompanyPostalCode')->nullable();
            $table->longText('Distributor_CompanyAddress')->nullable();
            $table->string('Provider_CompanyID')->nullable();
            $table->text('Provider_CompanyName')->nullable();
            $table->string('Provider_CompanyCity')->nullable();
            $table->string('Provider_CompanyProvince')->nullable();
            $table->string('Provider_CompanyCountry')->nullable();
            $table->string('Provider_CompanyPostalCode')->nullable();
            $table->longText('Provider_CompanyAddress')->nullable();
            $table->longText('Registration_AddressLine1')->nullable();
            $table->longText('Registration_AddressLine2')->nullable();
            $table->string('Registration_City')->nullable();
            $table->string('Registration_CompanyId')->nullable();
            $table->text('Registration_CompanyName')->nullable();
            $table->string('Registration_CountryId')->nullable();
            $table->string('Registration_Fax')->nullable();
            $table->string('Registration_Phone')->nullable();
            $table->string('Registration_Homepage')->nullable();
            $table->string('Registration_PostalCode')->nullable();
            $table->string('Registration_Province')->nullable();
            $table->string('Transfer_CompanyID')->nullable();
            $table->text('Transfer_CompanyName')->nullable();
            $table->string('Transfer_CompanyCity')->nullable();
            $table->string('Transfer_CompanyProvince')->nullable();
            $table->string('Transfer_CompanyCountry')->nullable();
            $table->string('Transfer_CompanyPostalCode')->nullable();
            $table->longText('Transfer_CompanyAddress')->nullable();
           
           
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
        Schema::dropIfExists('amc_basic_infos');
    }
}
