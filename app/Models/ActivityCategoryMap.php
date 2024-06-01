<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityCategoryMap extends Model
{
    protected $table = 'activity_category_map';
    public $timestamps = false;
    protected $fillable = ['category_id','activity_id'];
}
