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
        Schema::create('addfacilityinfo', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('facility_id')->nullable();
            $table->string('facility_email')->nullable();
            $table->string('social_worker')->nullable();
            $table->string('social_worker_email')->nullable();
            $table->string('social_worker_contact')->nullable();
            $table->string('finance_officer')->nullable();
            $table->string('finance_officer_email')->nullable();
            $table->string('finance_officer_contact')->nullable();
            $table->decimal('vat', 20, 2)->nullable();
            $table->decimal('Ewt', 20, 2)->nullable();
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
        Schema::dropIfExists('addfacilityinfo');
    }
};
