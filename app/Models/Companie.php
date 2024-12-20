<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Companie extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $guard = "companies";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [ 
        'name',
        'email',
        'password',
        'country_code',
        'mobile',
        'image_id',
        'fcm_token',
        'otp', 
        'otp_expiry', 
        'email_verified_at', 
   
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
