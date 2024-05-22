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
        Schema::create('admincost_usage', function (Blueprint $table) {
            $table->id();
            $table->integer('fundsource_id');
            $table->decimal('admin_cost', 30,2);
            $table->decimal('deductions', 30,2);
            $table->text('event');
            $table->decimal('balance', 30,2);
            $table->text('remarks');
            $table->string('created_by', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admincost_usage');
    }
};
