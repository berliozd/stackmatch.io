<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteAddress extends Model
{
    use HasFactory;

    protected $table = 'websites_addresses';

    protected $fillable = [
        'city',
        'postcode',
        'country',
    ];

    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}
