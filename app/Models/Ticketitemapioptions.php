<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Activity;

class Ticketitemapioptions extends Model
{
    protected $table = 'activity_ticket_item_api_options';

    public static function gettermsandconditions($tourId, $itemId){
    	$records = Ticketitemapioptions::where('ticket_item_id', '!=', $itemId)->where('api_tour_id', $tourId)->groupBy('ticket_item_id')->get();
    	if(count($records) > 0){
    		foreach($records as $record){
    			$count = Ticketitemapioptions::where('ticket_item_id', $record->ticket_item_id)->count();
    			if($count == 1){
    				$activity = Activity::find($record->activityId);
    				if($activity){
    					return $activity->activity_terms_and_condition;
    				}
    			}
    		}
    	}
    	return '';
    }
}
