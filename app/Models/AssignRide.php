<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignRide extends Model
{
    use HasFactory;
     

    protected $fillable = ['ride_id', 'vendor_id'];
  

    public function Image()
    {
        return $this->hasMany(Image::class, 'image_id','id');
    }
 
    
    public function Vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id','id');
    }
 

}
