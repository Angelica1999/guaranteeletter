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
        Schema::table('dv2', function (Blueprint $table) {
            //
            $table->dropColumn('facility_id');
            $table->dropColumn('proponent_id');
            $table->string('ref_no')->nullable()->change();
            $table->text('facility');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dv2', function (Blueprint $table) {
            //
        });
    }
};
