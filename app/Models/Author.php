<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory, HasTimestamps;

    protected $fillable = [
        'name',
        'created_at',
        'updated_at'
    ];

    public function article()
    {
        return $this->hasMany(Article::class);
    }
}
