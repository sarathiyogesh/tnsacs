<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\BlogCategoryMap;
use App\Models\BlogTagMap;

class BlogPost extends Model
{
    use HasFactory;

    protected $table = 'blog_post';
    protected $primaryKey = 'post_id';

    protected $fillable = ['post_title','post_title_slug','post_description','featured_image','posted_by','featured_post','status'];

    public static function savePost($data){
        DB::transaction(function() use($data, &$postid){
            $post = BlogPost::create($data);
            $postid = $post->post_id;

            if(array_key_exists("categories",$data)){

                foreach($data['categories'] as $cat){
                    BlogCategoryMap::create(['category_id'=>$cat, 'post_id'=>$postid, 'type'=>'parent']);
                }
                if(array_key_exists("subcategories",$data)){
                    foreach($data['subcategories'] as $cat){
                        BlogCategoryMap::create(['category_id'=>$cat, 'post_id'=>$postid, 'type'=>'child']);
                    }
                }
            }

            if(array_key_exists("tags",$data)){
                foreach($data['tags'] as $tag){
                    $tagCheck = BlogTag::find($tag);
                    if($tagCheck){
                        BlogTagMap::create(['tag_id'=>$tag, 'post_id'=>$postid]);
                    }                    
                }
            }
        });

        return $postid;
    }

    public static function updatePost($data){
        DB::transaction(function() use($data){
            $post = BlogPost::find($data['post_id']);
            $postid = $post->post_id;

            if(array_key_exists("categories",$data)){

                BlogCategoryMap::where('post_id',$postid)->delete();
                foreach($data['categories'] as $cat){
                    BlogCategoryMap::create(['category_id'=>$cat, 'post_id'=>$postid, 'type'=>'parent']);
                }
                if(array_key_exists("subcategories",$data)){
                    foreach($data['subcategories'] as $cat){
                        BlogCategoryMap::create(['category_id'=>$cat, 'post_id'=>$postid, 'type'=>'child']);
                    }
                }

            }

            if(array_key_exists("tags",$data)){
                BlogTagMap::where('post_id',$postid)->delete();
                foreach($data['tags'] as $tag){
                    $tagCheck = BlogTag::find($tag);
                    if($tagCheck){
                        BlogTagMap::create(['tag_id'=>$tag, 'post_id'=>$postid]);
                    }                    
                }
            }

            $update = BlogPost::find($postid)->update($data);
        });

        return true;
    }
}
