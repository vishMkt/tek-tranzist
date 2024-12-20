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

    protected $guard = "web";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [ 'firstname', 'email', 'lastname','country_code', 'mobile', 'otp', 'otp_expiry', 'country', 'age', 'city', 'user_code', 'vehical_no', 'email_verified_at', 'password','latitude','longitude','image_id','fcm_token','customer_id','company_id'];

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

    public function image()
    {
        return $this->belongsTo(Image::class,'image_id');
    }

    public function countryName()
    {
        return $this->belongsTo(Country::class,'country');
    }
    public function cityName()
    {
        return $this->belongsTo(City::class,'city');
    }
}
