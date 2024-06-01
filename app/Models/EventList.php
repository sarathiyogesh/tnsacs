<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventList extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category', 'country', 'city', 'language', 'location', 'address', 'status',  'start_date',  'end_date',    'price',   'description', 'banner_image',    'feature_image',   'header_tag',  'meta_title',  'meta_description',    'meta_keywords',   'meta_image','slug','api_code'  ];
}
