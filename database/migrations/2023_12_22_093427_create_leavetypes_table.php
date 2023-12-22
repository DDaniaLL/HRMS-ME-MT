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
        Schema::create('leavetypes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->float('value')->nullable();
            $table->string('active')->nullable();
            $table->string('accrualtype')->nullable();
            $table->string('national')->nullable();
            $table->string('international')->nullable();
            $table->string('service')->nullable();
            $table->string('custom')->nullable();
            $table->string('order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leavetypes');
    }
};
