<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['nsp', 'email', 'question', 'answer'];

    public function scopeAnswered(Builder $query) {
        $query->whereNotNull('answer');
    }
}
