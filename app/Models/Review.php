<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'article_id', 'reviewer_id', 'strengths',
        'weaknesses', 'comments_author', 'comments_editor',
        'recommendation', 'review_file',
        'deadline', 'submitted_at', 'status'
    ];

    protected $casts = [
        'deadline'     => 'date',
        'submitted_at' => 'datetime',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}