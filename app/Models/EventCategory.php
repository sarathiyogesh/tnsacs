<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status'];

    public static function getName($id){
        $record = EventCategory::find($id);
        if($record){
            return $record->name; 
        }
        return '';
    }
}
