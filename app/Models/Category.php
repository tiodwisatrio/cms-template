<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'slug', 
        'description',
        'color',
        'icon',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Auto-generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // Relationships
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function scopeForPosts($query)
    {
        return $query->where('type', 'post');
    }

    public function scopeForProducts($query)
    {
        return $query->where('type', 'product');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Helper methods for type checking
    public function isPostCategory(): bool
    {
        return $this->type === 'post';
    }

    public function isProductCategory(): bool
    {
        return $this->type === 'product';
    }

    // Accessor
    public function getPostsCountAttribute()
    {
        return $this->posts()->count();
    }
}