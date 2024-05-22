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
        Schema::create('transfer', function (Blueprint $table) {
            $table->id();
            $table->integer('from_proponent');
            $table->integer('from_saa');
            $table->integer('from_facility');
            $table->text('from_amount')->nullable();
            $table->integer('to_proponent');
            $table->integer('to_saa');
            $table->integer('to_facility');
            $table->text('to_amount')->nullable();
            $table->integer('status');
            $table->string('transfer_by', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer');
    }
};
