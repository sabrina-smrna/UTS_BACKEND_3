<?php

// app/Models/News.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    // untuk menentukan kolom yang dapat diisi secara bersamaan
    protected $fillable = [
        'title', 
        'author', 
        'description', 
        'content', 
        'url', 
        'url_image', 
        'published_at', 
        'category'
    ];

    // If 'published_at' is a datetime field, ensure it's treated as a date instance
    protected $dates = [
        'published_at',
    ];
}

