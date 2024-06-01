<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'status'
    ];

    public static function getdepartment($dept_id){
        $record = Department::find($dept_id);
        if($record){
            return $record->name;
        }
        return '';
    }
}
