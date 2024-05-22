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
        Schema::create('utilization', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('fundsource_id')->nullable();
            $table->smallInteger('proponentinfo_id')->nullable();
            $table->smallInteger('div_id');
            $table->text('beginning_balance', 20, 2)->nullable();
            $table->text('discount', 5, 2)->nullable();
            $table->text('utilize_amount', 20, 2)->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilization');
    }
};
