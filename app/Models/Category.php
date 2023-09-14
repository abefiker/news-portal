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

    public function posts(){
        return $this->hasMany('\App\Models\Post');
    }

    public function user(){
        return $this->belongsTo('\App\Model\User');
    }
    public function video()
    {
        return $this->hasMany(video::class);
    }
}
