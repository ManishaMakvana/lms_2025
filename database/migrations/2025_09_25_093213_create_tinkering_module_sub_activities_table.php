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
        Schema::create('tinkering_module_sub_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tinkering_module_id')->constrained('tinkering_modules')->onDelete('cascade');
            $table->string('title');
            $table->string('slug');
            $table->text('objective');
            $table->text('concept_focus');
            $table->json('materials_needed');
            $table->text('instructions');
            $table->string('circuit_diagram')->nullable();
            $table->text('explanation');
            $table->string('video_link')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order');
            $table->timestamps();
            
            $table->index(['tinkering_module_id', 'order']);
            $table->index(['is_active', 'order']);
            $table->unique(['tinkering_module_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tinkering_module_sub_activities');
    }
};
