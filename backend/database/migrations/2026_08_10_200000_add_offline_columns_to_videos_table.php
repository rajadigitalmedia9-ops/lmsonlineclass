<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->foreignId('course_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('subject_id')->nullable()->constrained()->nullOnDelete();
            $table->text('description')->nullable();
            $table->string('video_path')->nullable();
            $table->boolean('is_free')->default(false);
            
            // live_class_id should be nullable for offline videos
            $table->unsignedBigInteger('live_class_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
            $table->dropForeign(['subject_id']);
            $table->dropColumn(['course_id', 'subject_id', 'description', 'video_path', 'is_free']);
            
            $table->unsignedBigInteger('live_class_id')->nullable(false)->change();
        });
    }
};
