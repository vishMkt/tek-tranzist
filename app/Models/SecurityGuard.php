<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecurityGuard extends Model
{
    use HasFactory;
     

    protected $fillable = [
        'firstname',  
        'lastname', 
        'email',
        'address',
        'country_code',
        'mobile',  
        'date_of_birth',  
        'assigned_location',  
        'shift_timing',  
        'date_of_Joining',  
        'image_id',  
        'emergency_contact_information',  
        'notes',  
    ];
  

    public function Image()
    {
        return $this->belongsTo(Image::class, 'image_id', 'id');
    }
    public function ImageAttachment()
    {
        return $this->belongsTo(Image::class, 'add_attachment', 'id');
    }

}
