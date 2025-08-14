<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'price',
        'currency',
        'description',
        'is_active',
    ];

    // Many-to-Many: categories <-> gift_cards (pivot: category_gift_card)
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_gift_card')
                    ->withTimestamps();
    }
}
