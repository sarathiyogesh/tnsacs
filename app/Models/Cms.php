<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cms extends Model
{
    use HasFactory;
    protected $table = 'cms';
    protected $fillable = ['field_key', 'field_value'];

    public static function getvalue($field){
        $record = Cms::where('field_key', $field)->first();
        if($record){
            return $record->field_value;
        }
        return '';
    }
}
