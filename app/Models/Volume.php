<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Volume extends Model
{
    protected $fillable = [
        'journal_id',
        'volume_no',
        'year',
        'description',
        'status'
    ];

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function issues()
    {
        return $this->hasMany(Issue::class);
    }
}
