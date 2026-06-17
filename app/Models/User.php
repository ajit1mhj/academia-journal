<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'institution',
        'orcid',
        'country',
        'phone',
        'photo',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_authors')
            ->withPivot('is_corresponding')
            ->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    public function ajmsNotifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function isAdmin(): bool
    {
        return $this->role?->name === 'admin';
    }
    public function isEditor(): bool
    {
        return $this->role?->name === 'editor';
    }
    public function isReviewer(): bool
    {
        return $this->role?->name === 'reviewer';
    }
    public function isAuthor(): bool
    {
        return $this->role?->name === 'author';
    }
}
