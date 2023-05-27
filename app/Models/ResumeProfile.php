<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResumeProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'mobile',
        'cover_photo',
        'introduction',
    ];
}
