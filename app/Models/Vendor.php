<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Vendor extends Authenticatable
{
    use HasFactory;


    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile_number',
    ];

    // Add this if you're using hashed passwords
    protected $hidden = [
        'password',
    ];
}
