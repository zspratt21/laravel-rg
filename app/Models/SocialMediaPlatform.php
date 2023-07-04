<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SocialMediaPlatform extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
    ];

    public function socialLinks(): HasMany
    {
        return $this->hasMany(SocialMediaLink::class, 'social_media_platform_id');
    }
}
