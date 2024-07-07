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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('user_name')->unique();
            $table->string('password');
            $table->string('name');  
            $table->enum('role',['Đầu bếp', 'Quản lý', 'Thu ngân', 'Phục vụ', 'Chủ nhà hàng']);
            $table->timestamps();
        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
        
    }
};
