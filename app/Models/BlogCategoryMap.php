<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategoryMap extends Model
{
    use HasFactory;
    protected $table = 'blog_category_map';

    protected $fillable = ['category_id','post_id','type'];

    public $timestamps = false;
}
