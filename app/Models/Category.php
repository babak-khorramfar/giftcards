<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
    ];

    // رابطه Many-to-Many با گیفت‌کارت‌ها
    public function giftCards()
    {
        return $this->belongsToMany(GiftCard::class, 'category_gift_card')
                    ->withTimestamps();
    }

    // روابط درختی (Self-relation)
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
