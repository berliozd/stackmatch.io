<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WebsitePhone extends Model
{
    use HasFactory;

    protected $table = 'websites_phones';

    protected $fillable = [
        'phone',
        'website_id',
    ];

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }
}
