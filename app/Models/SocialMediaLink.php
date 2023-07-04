<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialMediaLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'social_media_platform_id',
        'user_id',
    ];

    public function platform(): BelongsTo
    {
        return $this->belongsTo(SocialMediaPlatform::class, 'social_media_platform_id');
    }
}
