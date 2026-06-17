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
    Schema::create('journals', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('issn')->nullable();
        $table->string('eissn')->nullable();
        $table->string('publisher')->nullable();
        $table->string('website_url')->nullable();
        $table->text('description')->nullable();
        $table->text('aim_scope')->nullable();
        $table->string('publication_frequency')->nullable();
        $table->enum('status', ['active', 'inactive'])->default('active');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};
