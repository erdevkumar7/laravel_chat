<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Size;
use App\Models\Color;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

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

        if (Auth::check()) {
            // Logged-in user: Store cart in the database
            $userId = Auth::id();

            // Check if the product is already in the cart
            $cart = Cart::where('user_id', $userId)
                ->where('product_id', $productId)
                ->first();

            if ($cart) {
                return response()->json(['message' => 'Product already in cart'], 200);
            }

            // Add product to the cart in the database
            Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);

            return response()->json(['message' => 'Product added to cart successfully'], 201);
        } else {
            // Guest user: Use session for cart
            $cart = session()->get('guest_cart', []);

            // Check if product already exists in the session cart
            if (isset($cart[$productId])) {
                return response()->json(['message' => 'Product already in cart'], 200);
            }

            // Add product to the session cart
            $cart[$productId] = [
                'product_id' => $productId,
                'quantity' => $quantity,
            ];

            // Save the updated cart back to the session
            session(['guest_cart' => $cart]);

            return response()->json(['message' => 'Product added to cart successfully'], 201);
        }
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
