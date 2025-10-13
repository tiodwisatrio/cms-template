<?php
// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'sale_price',
        'sku',
        'stock',
        'min_stock',
        'status',
        'featured_image',
        'gallery_images',
        'specifications',
        'weight',
        'dimensions',
        'is_featured',
        'track_stock',
        'meta_description',
        'meta_keywords',
        'category_id',
        'user_id',
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'specifications' => 'array',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'weight' => 'decimal:2',
        'is_featured' => 'boolean',
        'track_stock' => 'boolean',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessors
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getFormattedSalePriceAttribute()
    {
        return $this->sale_price ? 'Rp ' . number_format($this->sale_price, 0, ',', '.') : null;
    }

    public function getIsOnSaleAttribute()
    {
        return $this->sale_price && $this->sale_price < $this->price;
    }

    public function getIsOutOfStockAttribute()
    {
        return $this->track_stock && $this->stock <= 0;
    }

    public function getIsLowStockAttribute()
    {
        return $this->track_stock && $this->stock <= $this->min_stock;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where(function($q) {
            $q->where('track_stock', false)
              ->orWhere('stock', '>', 0);
        });
    }

    // Boot method for auto slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }
}