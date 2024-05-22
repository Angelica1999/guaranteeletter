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
        Schema::table('utilization', function (Blueprint $table) {
            //
            $table->text('budget_bbalance')->nullable();
            $table->text('budget_utilize')->nullable();
            $table->string('obligated')->nullable();
            $table->string('obligated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('utilization', function (Blueprint $table) {
            //
        });
    }
};
