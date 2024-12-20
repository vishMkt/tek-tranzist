<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory,Notifiable,HasRoles;

    protected $guard = "admin";

    protected $fillable = [
        'name',
        'email',
        'password',
        'number',
        'image_id',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function projects() : BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'user_projects');
    }
    

}
