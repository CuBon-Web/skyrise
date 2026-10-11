<?php

namespace App\models\website;

use Illuminate\Database\Eloquent\Model;

class AboutBlock extends Model
{
    protected $table = 'about_blocks';
    protected $fillable = ['title', 'intro', 'items', 'image', 'decor', 'sort', 'status'];
    protected $casts = [
        'items' => 'array',
        'decor' => 'integer',
        'status' => 'integer',
    ];
}
