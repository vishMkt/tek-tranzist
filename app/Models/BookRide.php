<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookRide extends Model
{
    use HasFactory;

    protected $fillable = [
        'pickup_location', 
        'pickup_latitude', 
        'pickup_longitude',
        'dropoff_location', 
        'dropoff_latitude', 
        'dropoff_longitude',
        'is_employee_add', 
        'client_id',  
        'is_accept',  
    ];
  


    public function assignRide()
    {
        return $this->hasOne(AssignRide::class, 'ride_id'); 
    }
           
    public function RideEmployee()
    {
        return $this->hasOne(RideEmployee::class, 'ride_id'); 
    }
         
    public function RideEmployeeVehicle()
    {
        return $this->hasOne(RideEmployeeVehicle::class, 'ride_id'); 
    }
    

}
