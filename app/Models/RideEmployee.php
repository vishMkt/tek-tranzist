<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RideEmployee extends Model
{
    use HasFactory;
     

    protected $fillable = ['employee_id','booking_type','home_to_ofifce_pick_time','office_to_home_pick_time','days'];
   
    
    public function Employee()
    {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }  
    
    public function Ride()
    {
        return $this->belongsTo(BookRide::class, 'ride_id', 'id');
    }
}
