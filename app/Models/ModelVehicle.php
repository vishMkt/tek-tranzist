<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelVehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'make_id',
        'file_id',
        'name',
    ];
 
         
    public function Make()
    {
        return $this->belongsTo(Make::class, 'make_id', 'id');
    } 

    public function ImageFront()
    {
        return $this->belongsTo(Image::class, 'file_id', 'id');
    } 
     
}
