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
        // Fetch products that are active, available, and belong to active categories
        $allProduct = Product::with('category')
            ->where('is_active', 1)
            ->where('is_available', 1)
            ->whereHas('category', function ($query) {
                $query->where('is_active', 1)->where('is_deleted', 0);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Fetch all active categories
        $allCategories = Category::where('is_active', 1)
            ->where('is_deleted', 0)
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
                $query->where('is_active', 1)
                    ->where('is_deleted', 0);
            })
            ->firstOrFail();

        return view('front.customer.productDetail', compact('product'));
    }
}
