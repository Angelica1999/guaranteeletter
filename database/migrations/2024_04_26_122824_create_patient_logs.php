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
        Schema::table('patient_logs', function (Blueprint $table) {
            //
            Schema::create('patient_logs', function (Blueprint $table) {
                $table->id();
                $table->integer('patient_id');
                $table->string('fname')->nullable();
                $table->string('lname')->nullable();
                $table->string('mname')->nullable();
                $table->date('dob')->nullable();
                $table->string('region')->nullable();
                $table->integer('facility_id')->nullable();
                $table->string('other_facility')->nullable();
                $table->integer('province_id')->nullable();
                $table->string('other_province')->nullable();
                $table->integer('muncity_id')->nullable();
                $table->string('other_muncity')->nullable();
                $table->integer('barangay_id')->nullable();
                $table->string('other_barangay')->nullable();
                $table->date('date_guarantee_letter');
                $table->integer('proponent_id')->nullable();
                $table->string('patient_code')->nullable();
                $table->text('guaranteed_amount')->nullable();
                $table->text('actual_amount')->nullable();
                $table->text('remaining_balance')->nullable();
                $table->integer('created_by')->nullable();
                $table->integer('group_id')->nullable();
                $table->rememberToken();
                $table->text('remarks')->nullable();
                $table->timestamps();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_logs', function (Blueprint $table) {
            //
            Schema::dropIfExists('patient_logs');
        });
    }
};
