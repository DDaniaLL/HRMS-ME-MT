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
        Schema::create('comlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->string('hours')->nullable();
            $table->foreignId('overtime_id')->nullable();
            $table->string('status')->nullable()->default('Active');
            $table->date('expired_date')->nullable();
            $table->string('autodate')->nullable();
            $table->string('expired_value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comlists');
    }
};
