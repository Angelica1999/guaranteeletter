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
            if (!Schema::hasColumn('patient_logs', 'pat_rem')) {
                $table->text('pat_rem')->nullable()->after('group_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_logs', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('patient_logs', 'pat_rem')) {
                $table->text('pat_rem')->nullable()->after('group_id');
            }
        });
    }
};
