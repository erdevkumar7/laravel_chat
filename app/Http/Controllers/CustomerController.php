<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Size;
use App\Models\Color;

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
        // Fetch products that are active, available, and belong to active categories
        $allProduct = Product::with('category')
            ->where('is_active', 1)
            ->where('is_available', 1)
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Fetch all active categories
        $allCategories = Category::where('is_active', 1)
            ->get();

        return view('front.customer.allProduct', compact('allProduct', 'allCategories'));
    }


    public function getProductDetail($id)
    {
        $product = Product::with('category')
            ->where('id', $id)
            ->where('is_active', 1)
            ->where('is_available', 1)
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1);
            })
            ->firstOrFail();

         $sizes = Size::where('is_active', 1)->get();   
          $colors = Color::Where('is_active', 1)->get(); 
        return view('front.customer.productDetail', compact('product', 'sizes', 'colors'));
    }
}
