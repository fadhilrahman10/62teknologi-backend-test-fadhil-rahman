<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Business extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'alias', 'name', 'image_url', 'is_closed', 'url', 'review_count', 'rating',
        'price', 'latitude', 'longitude', 'phone', 'display_phone', 'distance'
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'business_category', 'business_id', 'category_id');
    }

    public function location(): HasOne
    {
        return $this->hasOne(Location::class, 'business_id', 'id');
    }
}
