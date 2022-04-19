<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audience extends Model
{
    use HasFactory;

    //protected $with = ['regularity'];

    protected $fillable = [
        'capacity',
        'name'
    ];

    public function regularity() {
        return $this->hasOne(Regularity::class);
    }
}
