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

    public function getAllVendorForChat()
    {
        $vendors = Vendor::all();
        return view('front.vendor.all_chat_vendor', compact('vendors'));
    }
}
