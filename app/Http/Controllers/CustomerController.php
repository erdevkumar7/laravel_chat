<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Size;
use App\Models\Color;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
        //  dd(session('guest_cart'));
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
        // dd(Session::all());
        // dd(session('guest_cart'));
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

    public function productAddToCart(Request $request)
    {
        $productId = $request->product_id;
        $quantity = $request->quantity ?? 1;

        // Check if the product exists
        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        if (Auth::guard('web')->check()) {
            // Logged-in user
            $cart = Cart::where('user_id', Auth::guard('web')->user()->id)
                ->where('product_id', $productId)
                ->first();

            if ($cart) {
                return response()->json(['message' => 'Product already in cart'], 200);
            } else {
                $cart = new Cart();
                $cart->user_id = Auth::guard('web')->user()->id;
                $cart->product_id = $productId;
                $cart->quantity = $quantity;
            }
            $cart->save();
        } else {
            // Guest user
            $sessionId = session()->getId();
            $cart = Cart::where('session_id', $sessionId)
                ->where('product_id', $productId)
                ->first();

            if ($cart) {
                return response()->json(['message' => 'Product already in cart'], 200);
            } else {
                $cart = new Cart();
                $cart->session_id = $sessionId;
                $cart->product_id = $productId;
                $cart->quantity = $quantity;
            }
            $cart->save();
        }

        return response()->json(['message' => 'Product added to cart successfully'], 201);
    }

    public function viewCart()
    {
        // Guest user: Fetch cart from the session
        $sessionCart = session()->get('guest_cart', []);
        // Optionally, add product details for guest cart
        $cartItems = [];
        foreach ($sessionCart as $productId => $item) {
            $product = Product::find($productId); // Assuming you have a Product model
            if ($product) {
                $cartItems[] = [
                    'product_id' => $productId,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $item['quantity'],
                    'total' => $product->price * $item['quantity'],
                ];
            }
        }

        // dd($cartItems);
        return view('front.customer.viewCart', compact('cartItems'));
    }
}
