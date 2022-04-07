<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleVersion extends Model
{
    use HasFactory;

    protected $fillable = ['schedule_path', 'name'];
}
