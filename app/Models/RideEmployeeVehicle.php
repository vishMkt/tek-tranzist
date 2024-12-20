<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RideEmployeeVehicle extends Model
{
    use HasFactory;
     

    protected $fillable = ['vehicle_id','ride_id','driver_id'];
   
    
    public function Employee()
    {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }  
    
    public function Ride()
    {
        return $this->belongsTo(BookRide::class, 'ride_id', 'id');
    }


    public function EmployeePersonelRide()
{
    return $this->belongsTo(EmployeePersonelRide::class,'ride_id','ride_id');
}

public function Vehicle()
{
    return $this->belongsTo(Vehicle::class,'vehicle_id','id');
}
public function Driver()
{
    return $this->belongsTo(Driver::class,'driver_id','id');
}



}
