<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', "role_id", "type", "status", 'designation', 'gender', 'date_birth', 'mobile', 'mobile2', 'department', 'email_otp', 'verify_time', 'code', 'logo', 'contact_person_name', 'contact_person_mobile', 'address', 'state', 'city', 'pincode'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function uploads()
    {
        return $this->hasMany('App\Upload');
    }

    public static function getName($userid){
        $record = User::find($userid);
        if($record){
            return $record->name;
        }
        return '';
    }

    public static function getuserdetails($userid, $key){
        $record = User::find($userid);
        if($record && $record->{$key}){
            return $record->{$key};
        }
        return '';
    }
}
