<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Raynatourlist extends Model
{
    protected $table = 'rayna_tour_list';
    protected $fillable = ['tour_id','contract_id', 'list_date'];
}
