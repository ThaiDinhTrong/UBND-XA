<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); 
            $table->string('code')->unique(); 
            
            $table->boolean('can_manage_configuration')->default(false);
            $table->boolean('can_manage_content')->default(false);
            $table->boolean('can_manage_users')->default(false);
            
            $table->json('permissions')->nullable(); // Để lưu các quyền động
            
            $table->text('description')->nullable(); 
            $table->timestamps();
        });

        // Bảng liên kết nhiều-nhiều giữa users và roles
        Schema::create('role_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('role_id');
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            
            $table->unique(['user_id', 'role_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('roles');
    }
};