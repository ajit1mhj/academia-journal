<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EditorialBoard extends Model
{
    protected $fillable = [
        'journal_id',
        'name',
        'designation',
        'institution',
        'country',
        'photo',
        'biography',
        'category',
        'order'
    ];

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }
}
