<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Size;
use App\Models\Color;
use App\Models\Cart;
use App\Models\Shipping;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

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
        if (Auth::guard('web')->check()) {
            $cartItems = Cart::where('user_id', Auth::guard('web')->user()->id)->with('product')->get();
        } else {
            $sessionId = session()->getId();
            // dd($sessionId);
            $cartItems = Cart::where('session_id', $sessionId)->with('product')->get();
        }
        //    dd($cartItems);
        return view('front.customer.viewCart', compact('cartItems'));
    }

    public function checkOut()
    {
        $cartItems = Cart::where('user_id', Auth::guard('web')->user()->id)->with('product')->get();
        $jsonPath = public_path('state_city.json');
        $stateCity = json_decode(File::get($jsonPath), true);

        $shipping = Shipping::where('user_id', Auth::guard('web')->user()->id)->latest()->first();
        if (!$shipping) {
            // Create an empty object to avoid null checks in the view
            $shipping = (object) [
                'name' => '',
                'mobile_number' => '',
                'address_line_1' => '',
                'address_line_2' => '',
                'land_mark' => '',
                'state' => '',
                'city' => '',
                'postal_code' => '',
            ];
        }
        $totalAmount = $cartItems->sum(fn($item) => $item->quantity * $item->product->price);
        return view('front.customer.checkOut', compact('cartItems', 'totalAmount', 'shipping', 'stateCity'));
    }

    public function addOrEditAddress(Request $request)
    {
        $userId = Auth::guard('web')->user()->id;
        $validateData = $request->validate([
            'name' => 'required|min:3|max:80',
            'mobile_number' => [
                'required',
                'regex:/^(?!.*(\d)\1{5})[6-9]\d{9}$/',
                Rule::unique('shipping_address', 'mobile_number')->ignore($userId, 'user_id'),
            ],
            'address_line_1' => 'required',
            'address_line_2' => 'required',
            'state' => 'required',
            'city' => 'required|min:2|max:80',
            'land_mark' => 'nullable',
            'postal_code' => 'required|max:10',
        ]);

        $validateData['user_id'] = $userId;
        $shipping = Shipping::where('user_id', $userId)->latest()->first();

        if ($shipping) {
            $shipping->update($validateData);
            $message = 'Address updated successfully.';
        } else {
            Shipping::create($validateData);
            $message = 'Address added successfully.';
        }

        // Redirect back with a success message
        return redirect()->back()->with('success', $message);
    }
}
