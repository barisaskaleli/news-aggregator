<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory, HasTimestamps;

    protected $fillable = [
        'title',
        'content',
        'source_url',
        'source_id',
        'category_id',
        'author_id',
        'published_at',
        'image_url'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'source_id',
        'category_id',
        'author_id',
    ];

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * @param $query
     * @param $title
     * @return void
     */
    public function scopeFilterByTitle($query, $title): void
    {
        if ($title !== null) {
            $query->where('title', 'like', '%' . $title . '%');
        }
    }

    /**
     * @param $query
     * @param $date
     * @return void
     */
    public function scopeFilterByDate($query, $date): void
    {
        if ($date !== null) {
            $query->whereDate('published_at', $date);
        }
    }

    /**
     * @param $query
     * @param $categories
     * @return void
     */
    public function scopeFilterByCategories($query, $categories): void
    {
        if ($categories !== null) {
            $query->whereIn('category_id', $categories);
        }
    }

    /**
     * @param $query
     * @param $sources
     * @return void
     */
    public function scopeFilterBySources($query, $sources): void
    {
        if ($sources !== null) {
            $query->whereIn('source_id', $sources);
        }
    }

    /**
     * @param $query
     * @param $authors
     * @return void
     */
    public function scopeFilterByAuthors($query, $authors): void
    {
        if ($authors !== null) {
            $query->whereIn('author_id', $authors);
        }
    }

    /**
     * @param $query
     * @param $authorName
     * @return void
     */
    public function scopeFilterByAuthorName($query, $authorName): void
    {
        if ($authorName !== null) {
            $query->whereHas('author', function ($q) use ($authorName) {
                $q->where('name', 'like', '%' . $authorName . '%');
            });
        }
    }
}
