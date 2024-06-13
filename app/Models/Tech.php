<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tech extends Model
{
    use HasFactory;

    protected $table = 'techs';

    protected $fillable = [
        'name',
        'tech_tag_id',
    ];

    public function techTag(): BelongsTo
    {
        return $this->belongsTo(TechTag::class);
    }
}
