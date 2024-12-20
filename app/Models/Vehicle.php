<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = ['vehicle_model', 'year', 'license_plate', 'driver_id','vehicle_owner','status','vendor_id'];

  public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'id');
    }

    public function Make()
    {
        return $this->belongsTo(Make::class, 'make', 'id');
    }
 
    public function ModelVehicle()
    {
        return $this->belongsTo(ModelVehicle::class, 'model', 'id');
    }

}
