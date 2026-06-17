<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleAuthor extends Model
{
    protected $fillable = [
        'article_id', 'user_id', 'is_corresponding'
    ];

    protected $casts = [
        'is_corresponding' => 'boolean',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}