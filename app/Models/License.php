<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;

    protected $fillable = [
        'license_number', 
        'issue_date', 
        'valide_upto',
        'front_image', 
        'back_image', 
        'driver_id', 
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
