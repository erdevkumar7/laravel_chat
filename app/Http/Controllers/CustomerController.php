<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function Home(){
        return view('front.home');
    }

    public function dashboard(){
        return view('front.customer.dashboard');
     }

   
}
