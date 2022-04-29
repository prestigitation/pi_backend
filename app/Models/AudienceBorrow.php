<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AudienceBorrow extends Model
{
    use HasFactory;

    protected $fillable = ['reason'];

    protected $with = ['audience', 'pairNumber'];

    public function audience() {
        return $this->belongsTo(Audience::class);
    }

    public function pairNumber() {
        return $this->belongsTo(PairNumber::class);
    }
}
