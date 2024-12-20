<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;

    protected $fillable = [
        'policy_number', 
        'provider', 
        'issue_date',
        'expiry_date', 
        'vehicle_id',
        'front_image',
        'back_image'
    ];
  

   
   
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'id');
    }

     
    public function ImageFront()
    {
        return $this->belongsTo(Image::class, 'front_image', 'id');
    }
    
    public function ImageBack()
    {
        return $this->belongsTo(Image::class, 'back_image', 'id');
    }
    

}
