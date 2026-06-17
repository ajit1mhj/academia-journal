<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleFile extends Model
{
    protected $fillable = [
        'article_id', 'file_type', 'file_path',
        'original_name', 'version'
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}