<?php
namespace App\Models; // Update the namespace for models

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category_id',
        'user_id',
        'short_desc',
        'image',
        'long_desc',
        'special',
        'breaking',
        'views',
    ];

    public function tags()
    {
        return $this->hasMany('App\Models\Tag'); // Update the namespace for the Tag model
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User'); // Update the namespace for the User model
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category'); // Update the namespace for the Category model
    }
}
