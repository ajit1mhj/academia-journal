<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('journals', function (Blueprint $table) {
            // Add only what's needed
            $table->string('cover_image')->nullable()->after('eissn');
            $table->string('pdf_file')->nullable()->after('cover_image');
            $table->string('contact_email')->nullable()->after('pdf_file');
            $table->string('doi_prefix')->nullable()->after('contact_email');

            // Drop unused fields if they exist
            $table->dropColumn([
                'website_url',
                'publisher',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('journals', function (Blueprint $table) {
            $table->dropColumn(['cover_image', 'pdf_file', 'contact_email', 'doi_prefix']);
            $table->string('website_url')->nullable();
            $table->string('publisher')->nullable();
        });
    }
};