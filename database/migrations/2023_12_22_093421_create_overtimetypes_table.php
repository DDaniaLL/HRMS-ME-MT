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
        Schema::create('overtimetypes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('national')->nullable();
            $table->string('international')->nullable();
            $table->string('service')->nullable();
            $table->string('custom')->nullable();
            $table->string('multiplier')->nullable();//1.5 or 1.25 or 2...
            $table->string('typeofdays')->nullable();//holiday or weekday or weekend...
            $table->string('minhour')->nullable();//leaset amount of acceptable hours (half or one)
            $table->string('maxhour')->nullable();//max amount of acceptable hours (10 or 12 or ...)
            $table->string('needsattachment')->nullable();
            $table->string('needscomment')->nullable();
            $table->string('cansubmitbackdate')->nullable();
            $table->string('cangeneratecto')->nullable();
            $table->string('active')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('overtimetypes');
    }
};
