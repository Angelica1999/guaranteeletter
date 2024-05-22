<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->string('mname')->nullable();
            $table->date('dob')->nullable();
            $table->string('region')->nullabe();
            $table->smallInteger('fundsource_id')->nullable();
            $table->smallInteger('facility_id')->nullable();
            $table->string('other_facility')->nullable();
            $table->smallInteger('province_id')->nullable();
            $table->string('other_province')->nullable();
            $table->smallInteger('muncity_id')->nullable();
            $table->string('other_muncity')->nullable();
            $table->smallInteger('barangay_id')->nullable();
            $table->string('other_barangay')->nullable();
            $table->date('date_guarantee_letter')->nullable();
            $table->smallInteger('proponent_id')->nullable();
            $table->string('patient_code')->nullable();
            // $table->decimal('amount', 20, 2)->nullable();
            $table->decimal('guaranteed_amount', 20, 2)->nullable();
            $table->decimal('actual_amount', 20, 2)->nullable();
            $table->decimal('remaining_balance', 20, 2)->nullable();
            $table->smallInteger('created_by')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
