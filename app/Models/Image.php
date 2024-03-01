<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_id',
        'user_id',
        'taken_date',
        'username',
        'real_name',
        'title',
        'format',
        'image_secret',
        'url',
        'page_type',
        'server_id',
    ];
}
