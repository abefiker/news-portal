<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'user_id',
        'image',
        'desc'
    ];
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($category) {
            if ($category->posts()->count() > 0) {
                throw new \Exception('Category has associated posts and cannot be deleted.');
            }
        });
    }
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function posts()
    {
        return $this->hasMany('\App\Models\Post');
    }

    public function user()
    {
        return $this->belongsTo('\App\Model\User');
    }
    public function video()
    {
        return $this->hasMany(video::class);
    }
}
