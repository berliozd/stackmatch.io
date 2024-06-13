<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Website extends Model
{
    use HasFactory;

    protected $table = 'websites';
    protected $fillable = [
        'url',
        'name',
        'city',
        'postcode',
        'country',
        'domain',
    ];

    public function emails(): HasMany
    {
        return $this->hasMany(WebsiteEmail::class);
    }

    public function phones(): HasMany
    {
        return $this->hasMany(WebsitePhone::class);
    }

    public function techs(): HasMany
    {
        return $this->hasMany(WebsiteTech::class);
    }

    public function socials(): HasMany
    {
        return $this->hasMany(WebsiteSocial::class);
    }

    public function address(): HasOne
    {
        return $this->hasOne(WebsiteAddress::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot(UserWebsite::class)->withTimestamps();
    }
}
