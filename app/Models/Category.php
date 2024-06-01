<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';
    protected $fillable = ['cat_name','slug','status'];

    public static function getname($id){
        $result = Category::find($id);
        if($result){
            return $result->cat_name;
        }
        return "";
    }

    public function scopeActive($query){
        return $query->where('status', 'active');
    }

}
