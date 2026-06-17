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
    Schema::create('reviews', function (Blueprint $table) {
        $table->id();
        $table->foreignId('article_id')->constrained()->onDelete('cascade');
        $table->foreignId('reviewer_id')->constrained('users')->onDelete('cascade');
        $table->text('strengths')->nullable();
        $table->text('weaknesses')->nullable();
        $table->text('comments_author')->nullable();
        $table->text('comments_editor')->nullable();
        $table->enum('recommendation', [
            'accept', 'minor_revision', 'major_revision', 'reject'
        ])->nullable();
        $table->string('review_file')->nullable();
        $table->date('deadline')->nullable();
        $table->timestamp('submitted_at')->nullable();
        $table->enum('status', ['pending', 'accepted', 'submitted', 'declined'])
              ->default('pending');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
