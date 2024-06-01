<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogTagMap extends Model
{
    use HasFactory;
    protected $table = 'blog_tag_map';

    protected $fillable = ['tag_id','post_id'];

    public $timestamps = false;
}
