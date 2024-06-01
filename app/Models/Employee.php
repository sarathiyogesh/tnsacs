<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Department;


class Employee extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = ['name', 'designation', 'email', 'mobile', 'dept', 'gender', 'mobile2', 'date_birth'];
    
    protected $hidden = [
        
    ];

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    public static function getdepartment($dept_id){
        $record = Department::find($dept_id);
        if($record){
            return $record->name;
        }
        return '';
    }
}
