<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{

    protected $with = ['category'];

    protected $table = 'news';

    use HasFactory;

    public function category() {
        return $this->hasOne(Category::class);
    }
}
