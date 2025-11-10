<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageText extends Model
{
    protected $table = 'page_texts';

    protected $fillable = [
        'page_base_url',
        'text_key',
        'content',
    ];

    public $timestamps = false;
}
