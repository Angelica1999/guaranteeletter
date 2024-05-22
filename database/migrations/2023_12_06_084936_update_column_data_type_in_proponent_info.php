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
        Schema::table('proponent_info', function (Blueprint $table) {
            //
            $table->text('alocated_funds', 20, 2)->change();
            $table->text('remaining_balance', 20, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proponent_info', function (Blueprint $table) {
            //
        });
    }
};
