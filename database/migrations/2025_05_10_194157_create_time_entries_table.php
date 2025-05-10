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
        Schema::create('time_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id');
            $table->date('date');
            $table->time('clocked_in')->nullable();
            $table->time('clocked_out')->nullable();
            $table->timestamps();

            $table->foreign('staff_id')->references('id')->on('staff');
            $table->unique(['staff_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_entries');
    }
};
