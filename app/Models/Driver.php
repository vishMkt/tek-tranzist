<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Driver extends Authenticatable
{
    use HasApiTokens,HasFactory,Notifiable,HasRoles;

    protected $guard = "driver";
     

    protected $fillable = [
        'firstname', 'email', 'lastname',
        'password',
        'address',
        'country_code',
        'mobile',
        'otp',
        'otp_expiry', 
        'latitude',
        'longitude',
        'walletamount',
        'country',
        'image_id',
        'fcm_token',
        'is_vehicle_added',
        'vendor_id',
        'adhar_card',
        'pan_card',
        'emergency_contact_information',
        'add_attachment',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    public function image()
    {
        return $this->belongsTo(Image::class);
    }
  
    
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
    
    public function ImageAttachment()
    {
        return $this->belongsTo(Image::class, 'add_attachment', 'id');
    }
     
}
