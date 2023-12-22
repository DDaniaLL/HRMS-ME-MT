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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('birth_date')->nullable();
            $table->string('employee_number')->unique()->nullable();
            $table->string('contract')->nullable();
            $table->string('position')->nullable();
            $table->string('office')->nullable();
            $table->string('department')->nullable();
            $table->string('linemanager')->nullable();
            $table->string('hradmin')->nullable();
            $table->string('isprob')->nullable();
            $table->string('grade')->nullable();
            $table->string('superadmin')->nullable();
            $table->date('joined_date')->nullable();
            $table->date('resigned_date')->nullable();
            $table->string('status')->nullable()->default('active');
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->text('token')->nullable();
            $table->foreignId('usertype_id')->nullable();
            $table->foreignId('office_id')->nullable();
            $table->string('preflang')->nullable()->default('en');
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
