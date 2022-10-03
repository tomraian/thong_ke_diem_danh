<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayRequired extends Model
{
    protected $fillable = ['sunday_required', 'not_sunday_required'];
    use HasFactory;
}
