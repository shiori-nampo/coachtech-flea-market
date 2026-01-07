<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }


    protected $fillable = [
        'user_id',
        'image',
        'name',
        'brand_name',
        'description',
        'price',
        'condition_id',
        'status',
    ];

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/no-image.png');
        }

        if (str_starts_with($this->image, 'http') || str_starts_with($this->image, 'images/')) {
            return asset($this->image);
        }

        return asset('storage/'. $this->image);
    }
}
