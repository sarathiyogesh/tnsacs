<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $table = 'countries';

    protected $fillable = ['country_name', 'country_code', 'phone_code', 'status', 'country_image', 'country_description'];

    public static function getName($id){
        $record = Country::find($id);
        if($record){
            return $record->country_name;
        }
        return '';
    }
}
