<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Raynatouroption extends Model
{
    protected $table = 'rayna_tour_option';
    protected $fillable = ['tour_id','option_id', 'transfer_id', 'transfer_name','contract_id', 'list_date', 'adult_prie', 'child_price'];
}
