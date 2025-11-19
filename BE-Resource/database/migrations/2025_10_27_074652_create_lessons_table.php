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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('section_id');
            $table->string('type')->comment('dạng bài học: video, text, quiz');
            $table->text('content')->nullable()->comment('For text lessons');
            $table->string('title')->nullable();
            $table->integer('order_index');
            $table->string('video_path')->nullable()->comment('dạng bài video');
            $table->integer('duration_seconds')->nullable();
            $table->boolean('is_free_preview')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
