<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $fillable = [
        'volume_id', 'issue_no', 'publication_date',
        'cover_image', 'status'
    ];

    protected $casts = [
        'publication_date' => 'date',
    ];

    public function volume()
    {
        return $this->belongsTo(Volume::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}