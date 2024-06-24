<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserWebsite extends Pivot
{
    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function histories(): HasMany
    {
        return $this->hasMany(UserWebsiteHistory::class, 'user_website_id', 'id');
    }
}
