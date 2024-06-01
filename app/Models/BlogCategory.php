<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;
    protected $table = 'blog_category';
    protected $primaryKey = 'category_id';

    protected $fillable = ['type','parent','name','slug','status'];

    public static function getAll(){
        $categories = BlogCategory::orderBy('name')->where('parent',0)->get();
        foreach($categories as $category){
            $category->subcategories = BlogCategory::where('parent',$category->category_id)->get();
        }
        return $categories;
    }
}
