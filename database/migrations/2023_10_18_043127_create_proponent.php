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
        Schema::create('proponent', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('fundsource_id')->nullable();
            $table->string('proponent')->nullable();
            $table->string('proponent_code')->nullable();
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
        Schema::dropIfExists('proponent');
    }
};
