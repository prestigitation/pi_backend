<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{

    protected $with = ['category'];

    protected $fillable = ['title', 'description', 'image', 'category_id'];

    //protected $table = 'news';

    use HasFactory;

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
