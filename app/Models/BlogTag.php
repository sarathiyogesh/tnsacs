<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogTag extends Model
{
    use HasFactory;
    protected $table = 'blog_tag';
    protected $primaryKey = 'tag_id';

    protected $fillable = ['tag_name','tag_name_slug'];

    public static function getAll(){
        $tags = BlogTag::orderBy('tag_name')->select('tag_name as text', 'tag_id')->get();
        return $tags;
    }
}
