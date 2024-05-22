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
        Schema::table('mail_history', function (Blueprint $table) {
            //
            Schema::create('mail_history', function (Blueprint $table) {
                $table->id();
                $table->integer('patient_id');
                $table->string('modified_by', 255);
                $table->string('sent_by', 255);
                $table->timestamps();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mail_history', function (Blueprint $table) {
            //
            Schema::dropIfExists('mail_history');
        });
    }
};
