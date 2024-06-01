<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;
    protected $table = 'faculty';
    protected $fillable = ['institution', 'course', 'name','email', 'phone', 'photo', 'address', 'state', 'city', 'pincode', 'status', 'created_by'];

    public static function getname($dept_id){
        $record = Faculty::find($dept_id);
        if($record){
            return $record->name;
        }
        return '';
    }
}
