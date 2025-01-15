<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;
    protected $table = 'shipping_address';

    protected $fillable = ['name','user_id', 'mobile_number', 'address_line_1', 'address_line_2', 'state', 'city', 'land_mark', 'postal_code'];
}
