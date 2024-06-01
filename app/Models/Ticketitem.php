<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticketitem extends Model
{
    use HasFactory;
    protected $table = 'activity_ticket_item';

    public static function getitemname($id){
        $record = Ticketitem::where('id', $id)->first();
        if($record){
            return $record->item_name;
        }
        return '';
    }
}
