<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subjects';
    protected $fillable = ['name','status'];

    public static function getname($id){
        $result = Subject::find($id);
        if($result){
            return $result->name;
        }
        return "";
    }

    public function scopeActive($query){
        return $query->where('status', 'active');
    }
    
}
