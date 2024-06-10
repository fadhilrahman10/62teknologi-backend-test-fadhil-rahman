<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['alias', 'title'];

    public function businesses(): BelongsToMany
    {
        return $this->belongsToMany(Business::class, 'business_category', 'category_id', 'business_id');
    }
}
