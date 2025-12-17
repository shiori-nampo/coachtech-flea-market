<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
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

    public function images()
    {
        return $this->hasMany(ItemImage::class);
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
        'name',
        'brand_name',
        'description',
        'price',
        'condition',
    ];
}
