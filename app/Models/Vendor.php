<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Vendor extends Authenticatable
{
    use HasApiTokens,HasFactory,Notifiable,HasRoles;

    // protected $guard = "vendor";
     

    protected $fillable = ['firstname', 'email', 'email_verified_at', 'password', 'lastname', 'country_code', 'mobile', 'otp', 'otp_expiry', 'address', 'latitude', 'longitude', 'image_id', 'status', 'remember_token', 'created_at', 'updated_at', 'fcm_token'];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    
        
    public function Image()
    {
        return $this->belongsTo(Image::class, 'image_id', 'id');
    }
  
    
 

}
