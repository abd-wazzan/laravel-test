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
            $table->string('prefixname', 255)->nullable();
            $table->string('firstname', 255);
            $table->string('middlename', 255)->nullable();
            $table->string('lastname', 255);
            $table->string('suffixname', 255)->nullable();
            $table->string('username', 255)->unique();
            $table->string('email', 255)->unique();
            $table->text('password');
            $table->text('photo')->nullable();
            $table->string('type', 255)->default(\App\Enums\UserTypeEnum::USER->value)->index();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
