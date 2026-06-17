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
    Schema::create('articles', function (Blueprint $table) {
        $table->id();
        $table->foreignId('issue_id')->nullable()->constrained()->onDelete('set null');
        $table->string('title');
        $table->string('subtitle')->nullable();
        $table->text('abstract');
        $table->string('keywords');
        $table->string('subject_area')->nullable();
        $table->string('language')->default('English');
        $table->string('doi')->nullable()->unique();
        $table->string('pages')->nullable();
        $table->enum('status', [
            'submitted', 'under_review', 'revision_requested',
            'accepted', 'rejected', 'scheduled', 'published'
        ])->default('submitted');
        $table->timestamp('published_at')->nullable();
        $table->unsignedInteger('views')->default(0);
        $table->unsignedInteger('downloads')->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
