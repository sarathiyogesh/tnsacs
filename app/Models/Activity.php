<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    
    protected $table = 'activity';
    protected $primaryKey = 'activity_id';
    protected $fillable = [
        'featured',
        'activity_name',
        'activity_name_slug',
        'activity_city',
        'activity_zone',
        'country_code',
        'activity_address',
        'horizontal_banner',
        'vertical_banner',
        'featured_image',
        'map_coordinates',
        'video_link',
        'activity_description',
        'activity_description1',
        'activity_description2',
        'activity_description3',
        'activity_description4',
        'activity_description5',
        'activity_description6',
        'activity_desc_title1',
        'activity_desc_title2',
        'activity_desc_title3',
        'activity_desc_title4',
        'activity_desc_title5',
        'activity_desc_title6',
        'activity_terms_and_condition',
        'activity_phone',
        'activity_website',
        'activity_email',
        'booking_info',
        'activity_booking_link',
        'activity_opening_hours',
        'activity_review',
        'activity_selfparking',
        'activity_valetparking',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'youtube_url',
        'activity_notification',
        'created_by',
        'regular_price',
        'discount_price',
        'corporate_discount_price',
        'saving_text',
        'starting_days',
        'activity_tag',
        'display',
        'popup_show',
        'popup_msg',
        'coupon_id',
        'coupon_msg',
        'whatsapp_msg',
        'ticket_source',
        'api_tour_id',
        'api_contract_id',
        'api_timeslot',
        'activity_status',
        'header_tags',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_image'
    ];

    public function categoryMap(){
        return $this->hasMany('App\Models\ActivityCategoryMap');
    }

    public function tagMap(){
        return $this->hasMany('App\Models\ActivityTagMap');
    }

    public static function getactivityname($id){
        $record = Activity::where('activity_id', $id)->first();
        if($record){
            return $record->activity_name;
        }
        return '';
    }
}
