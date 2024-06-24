<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserWebsiteHistory extends Model
{
    use HasFactory;

    protected $table = 'user_website_histories';

    protected $fillable = ['content', 'user_website_id'];

    public function userWebsite(): BelongsTo
    {
        return $this->belongsTo(UserWebsite::class);
    }
}
