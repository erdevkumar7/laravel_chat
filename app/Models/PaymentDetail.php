<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    use HasFactory;
    protected $table = 'payments';

    protected $fillable = ['user_id', 'paypal_payment_id', 'status' ,'amount', 'currency'];
}
