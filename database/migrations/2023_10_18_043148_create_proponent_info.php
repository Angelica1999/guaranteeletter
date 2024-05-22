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
        Schema::create('proponent_info', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('fundsource_id')->nullable();
            $table->smallInteger('proponent_id')->nullable();
            $table->smallInteger('facility_id')->nullable();
            $table->decimal('alocated_funds', 20, 2)->nullable();
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
        Schema::dropIfExists('proponent_info');
    }
};
