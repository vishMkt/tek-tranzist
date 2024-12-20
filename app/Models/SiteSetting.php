<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

  
    protected $fillable = [
        'firstname', 
        'email', 
        'lastname',
        'password',
        'address', 
    ];
 


    public function logoImage()
    {
        return $this->belongsTo(Image::class, 'logo', 'id');
    }
    
    public function favImage()
    {
        return $this->belongsTo(Image::class, 'fav_icon', 'id');
    }
    
     
    

}
