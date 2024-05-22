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
        Schema::table('addfacilityinfo', function (Blueprint $table) {
            //
            $table->string('cc', 255)->nullable()->after('remember_token');
            $table->string('official_mail', 255)->nullable()->after('cc');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addfacilityinfo', function (Blueprint $table) {
            //
        });
    }
};
