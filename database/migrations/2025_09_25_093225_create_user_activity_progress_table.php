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
        Schema::create('user_activity_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('sub_activity_id')->constrained('tinkering_module_sub_activities')->onDelete('cascade');
            $table->json('completed_checklist_items')->nullable();
            $table->decimal('progress_percent', 5, 2)->default(0);
            $table->timestamp('last_viewed_at')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'sub_activity_id']);
            $table->index(['user_id', 'progress_percent']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_activity_progress');
    }
};
