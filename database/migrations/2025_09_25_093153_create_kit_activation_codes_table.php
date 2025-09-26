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
        Schema::create('kit_activation_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('used_by')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('status', ['unused', 'used', 'blocked'])->default('unused');
            $table->foreignId('module_id')->nullable()->constrained('tinkering_modules')->onDelete('set null');
            $table->foreignId('generated_by')->constrained('users')->onDelete('cascade');
            $table->timestamp('used_at')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'module_id']);
            $table->index('code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kit_activation_codes');
    }
};
