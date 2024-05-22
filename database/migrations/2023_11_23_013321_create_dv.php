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
        Schema::create('dv', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->string('facility_id');
            $table->string('address');
            $table->dateTime('month_year_from');
            $table->dateTime('month_year_to');
            $table->string('fundsource_id')->nullable();
            $table->text('amount1')->nullable();
            $table->text('amount2')->nullable();
            $table->text('amount3')->nullable();
            $table->text('total_amount', 20, 2)->nullable();
            $table->text('deduction1')->nullable();
            $table->text('deduction2')->nullable();
            $table->text('deduction_amount1', 20, 2)->nullable();
            $table->text('deduction_amount2', 20, 2)->nullable();
            $table->text('total_deduction_amount', 5, 2)->nullable();
            $table->text('overall_total_amount', 20, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dv');
    }
};
