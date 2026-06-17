<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('journals', function (Blueprint $table) {
            if (!Schema::hasColumn('journals', 'contact_email')) {
                $table->string('contact_email')->nullable()->after('pdf_file');
            }
            if (!Schema::hasColumn('journals', 'doi_prefix')) {
                $table->string('doi_prefix')->nullable()->after('contact_email');
            }
            if (!Schema::hasColumn('journals', 'subject_areas')) {
                $table->string('subject_areas')->nullable()->after('doi_prefix');
            }
            if (!Schema::hasColumn('journals', 'language')) {
                $table->string('language')->nullable()->after('subject_areas');
            }
        });
    }

    public function down(): void
    {
        Schema::table('journals', function (Blueprint $table) {
            $table->dropColumn(['contact_email', 'doi_prefix', 'subject_areas', 'language']);
        });
    }
};