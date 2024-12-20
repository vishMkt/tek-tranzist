<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puc extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_number', 
        'owner_name', 
        'puc_certificate_number',
        'puc_issue_date',
        'puc_expiry_date',
        'driver_id', 
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
