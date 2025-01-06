<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;

class VendorController extends Controller
{
    public function dashboard()
    {
        return view('front.vendor.dashboard');
    }


}
