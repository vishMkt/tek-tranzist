<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePersonelRide extends Model
{
    use HasFactory;

    protected $fillable = ['ride_id','home_to_office_pick_time','office_to_home_pick_time','employee_id','ride_date'];
 

       
    
    public function Employee()
    {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }  
    
    public function Ride()
    {
        return $this->belongsTo(BookRide::class, 'ride_id', 'id');
    }
    
}
