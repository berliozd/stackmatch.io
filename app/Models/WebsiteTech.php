<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class WebsiteTech extends Model
{
    use HasFactory;

    protected $table = 'websites_techs';
    protected $fillable = [
        'website_id',
        'tech_id',
    ];

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }

    public function tech(): HasOne
    {
        return $this->hasOne(Tech::class, 'id', 'tech_id');
    }
}
