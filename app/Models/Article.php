<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'issue_id',
        'title',
        'authors',
        'keywords',
        'subject_area',
        'language',
        'doi',
        'pages',
        'status',
        'published_at',
        'views',
        'downloads',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }

    public function files()
    {
        return $this->hasMany(ArticleFile::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function manuscript()
    {
        return $this->files()->where('file_type', 'manuscript')->latest()->first();
    }
}