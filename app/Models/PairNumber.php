<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PairNumber extends Model
{
    use HasFactory;

    public function schedule() {
        return $this->belongsTo(PairNumber::class);
    }
}
