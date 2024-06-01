<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $table = 'user_profile';

    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = ['user_id', 'firstname', 'lastname', 'country_code', 'phone', 'dob_date', 'dob_month',    
                           'dob_year' ];
}
