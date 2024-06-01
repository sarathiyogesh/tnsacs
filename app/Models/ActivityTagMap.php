<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityTagMap extends Model
{
    use HasFactory;
    
    protected $table = 'activity_tag_map';
    public $timestamps = false;
    protected $fillable = ['tag_id','activity_id'];
}
