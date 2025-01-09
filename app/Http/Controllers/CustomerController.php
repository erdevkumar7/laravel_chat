<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;

class CustomerController extends Controller
{
    public function Home()
    {
        return view('front.home');
    }

    public function dashboard()
    {
        return view('front.customer.dashboard');
    }

    public function getAllProduct()
    {
        $allProduct = Product::where('is_active', '1')
                        ->where('is_available', '1')
                        ->orderBy('created_at', 'desc')
                        ->whereHas('category', function($query){
                            $query->where('is_active', 1)
                                 ->where('is_deleted', 0);
                        })
                        ->with('category')->get();

         $allCategories = Category::where('is_active', 1)
                                ->where('is_deleted', 0)
                                ->get();               
      
        return view('front.customer.allProduct', compact('allProduct', 'allCategories'));
    }
}
