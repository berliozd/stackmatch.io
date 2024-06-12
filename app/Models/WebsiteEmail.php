<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteEmail extends Model
{
    use HasFactory;

    protected $table = 'websites_emails';
    protected $fillable = [
        'website_id',
        'email',
    ];

    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}
