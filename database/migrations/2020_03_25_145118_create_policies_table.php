<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->nullable()->default(NULL);
            $table->bigInteger('admin_id')->nullable()->default(NULL);
            $table->bigInteger('price_id');
            $table->bigInteger('vehicle_id');
            $table->bigInteger('id_estado');
            $table->bigInteger('id_municipio');
            $table->bigInteger('id_parroquia');
            $table->bigInteger('vehicle_class_id');
            $table->string('client_address')->default('No especificado');
            $table->string('client_email');
            $table->string('client_name');
            $table->string('client_lastname');
            $table->string('client_ci');
            $table->string('client_name_contractor');
            $table->string('client_lastname_contractor');
            $table->string('client_ci_contractor');
            $table->string('client_phone')->nullable();
            $table->string('vehicle_brand');
            $table->string('vehicle_model');
            $table->string('vehicle_type');
            $table->string('vehicle_registration');
            $table->string('vehicle_bodywork_serial')->nullable();
            $table->string('vehicle_weight')->nullable();
            $table->string('vehicle_motor_serial')->nullable();
            $table->string('vehicle_certificate_number')->nullable();
            $table->string('vehicle_color');
            $table->bigInteger('vehicle_year');
            $table->string('used_for');
            $table->boolean('status')->default(0);
            $table->date('expiring_date');
            $table->timestamps();
            $table->softDeletes()->nullable()->default(NULL);

            // Fixed prices
            $table->decimal('damage_things', 25, 2)->default('0');
            $table->decimal('premium1', 25, 2)->default('0');
            $table->decimal('damage_people', 25, 2)->default('0');
            $table->decimal('premium2', 25, 2)->default('0');
            $table->decimal('disability', 25, 2)->default('0');
            $table->decimal('premium3', 25, 2)->default('0');
            $table->decimal('legal_assistance', 25, 2)->default('0');
            $table->decimal('premium4', 25, 2)->default('0');
            $table->decimal('death', 25, 2)->default('0');
            $table->decimal('premium5', 25, 2)->default('0');
            $table->decimal('medical_expenses', 25, 2)->default('0');
            $table->decimal('premium6', 25, 2)->default('0');
            $table->decimal('crane', 25, 2)->default('0');
            $table->decimal('total_premium', 30, 2)->default('0');
            $table->decimal('total_all', 30, 2)->default('0');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('price_id')->references('id')->on('prices');
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->foreign('id_estado')->references('id_estado')->on('estados');
            $table->foreign('id_municipio')->references('id_municipio')->on('municipios');
            $table->foreign('id_parroquia')->references('id_parroquia')->on('parroquias');
            $table->foreign('vehicle_class_id')->references('id')->on('vehicle_classes');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('policies');
    }
}
