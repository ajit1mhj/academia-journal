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
    Schema::create('issues', function (Blueprint $table) {
        $table->id();
        $table->foreignId('volume_id')->constrained()->onDelete('cascade');
        $table->integer('issue_no');
        $table->date('publication_date')->nullable();
        $table->string('cover_image')->nullable();
        $table->enum('status', ['upcoming', 'draft', 'published', 'archived'])
              ->default('draft');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
