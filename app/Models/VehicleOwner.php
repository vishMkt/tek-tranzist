<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleOwner extends Model
{
    use HasFactory;
     

    protected $fillable = [
        'firstname', 'email', 'lastname', 
        'address',
        'country_code',
        'mobile',  
        'vendor_id'
    ];
  
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
 

}
