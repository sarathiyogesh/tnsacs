<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Raynatouroptiondata extends Model
{
    protected $table = 'rayna_tour_option_data';
    protected $fillable = ['tour_id','option_id', 'option_name','contract_id','country_id','city_id', 'created_at', 'updated_at'];
    public static function optionname($tour_id, $option_id){
    	$record = Raynatouroptiondata::where('tour_id', $tour_id)->where('option_id', $option_id)->first();
    	if($record){
    		return $record->option_name;
    	}
    	return '';
    }
}
