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
        Schema::create('dv2', function (Blueprint $table) {
            $table->id();
            $table->integer('facility_id');
            $table->integer('proponent_id');
            $table->string('route_no', 255);
            $table->text('ref_no');
            $table->text('lname');
            $table->text('fname', 255);
            $table->text('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dv2');
    }
};
