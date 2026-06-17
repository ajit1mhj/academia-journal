<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = [
        'title',
        'issn',
        'eissn',
        'cover_image',
        'pdf_file',
        'contact_email',
        'doi_prefix',
        'description',
        'aim_scope',
        'publication_frequency',
        'subject_areas',
        'language',
        'status',
    ];

    public function volumes()
    {
        return $this->hasMany(Volume::class);
    }

    public function editorialBoard()
    {
        return $this->hasMany(EditorialBoard::class);
    }
}
