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
    Schema::create('editorial_boards', function (Blueprint $table) {
        $table->id();
        $table->foreignId('journal_id')->constrained()->onDelete('cascade');
        $table->string('name');
        $table->string('designation')->nullable();
        $table->string('institution')->nullable();
        $table->string('country')->nullable();
        $table->string('photo')->nullable();
        $table->text('biography')->nullable();
        $table->enum('category', [
            'editor_in_chief', 'managing_editor',
            'editorial_board', 'review_board', 'advisory_board'
        ]);
        $table->integer('order')->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('editorial_boards');
    }
};
