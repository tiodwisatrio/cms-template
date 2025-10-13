<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'description',
        'category_id',
        'featured_image',
        'document_files',
        'price',
        'status',
        'publish_date',
        'event_date',
        'deadline',
        'view_count',
        'is_featured',
        'user_id'
    ];

    protected $casts = [
        'document_files' => 'array',
        'price' => 'decimal:2',
        'publish_date' => 'date',
        'event_date' => 'datetime',
        'deadline' => 'datetime',
        'is_featured' => 'boolean',
    ];

    // Auto-generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = static::generateSlug($post->title);
                
                // Ensure unique slug
                $originalSlug = $post->slug;
                $count = 1;
                while (static::where('slug', $post->slug)->exists()) {
                    $post->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }
        });

        static::updating(function ($post) {
            if ($post->isDirty('title') && !$post->isDirty('slug')) {
                $post->slug = static::generateSlug($post->title);
            }
        });
    }

    /**
     * Generate slug from title
     */
    public static function generateSlug($title)
    {
        return Str::slug($title, '-', 'id'); // Using Indonesian locale for better handling
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
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

    public function scopePublished($query)
    {
        return $query->whereNotNull('publish_date')
                    ->where('publish_date', '<=', now());
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    // Accessors
    public function getFormattedPriceAttribute()
    {
        return $this->price ? 'Rp ' . number_format((float) $this->price, 0, ',', '.') : null;
    }

    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        return ceil($wordCount / 200); // 200 words per minute
    }

    public function getExcerptAttribute()
    {
        return $this->description ?: Str::limit(strip_tags($this->content), 150);
    }

    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d M Y');
    }

    // Route key name
    public function getRouteKeyName()
    {
        return 'slug';
    }
}