<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Cart;

class AuthController extends Controller
{
    //*******************************************************************//
    // Admin Auth functionas ******************************************
    public function adminRegister()
    {
        return view('admin.register');
    }

    public function adminRegisterSubmit(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:70',
                'regex:/^[\pL\s]+$/u',
            ],
            'email' => 'required|string|email:rfc,dns|unique:admins',
            'password' => 'required|string|min:8|',
        ], [
            'name.regex' => 'Name field must contain only letters and spaces',
        ]);

        $admin = new Admin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->save();

        return redirect()->route('admin.login')->with('success', 'Registration Successfuly!');
    }

    public function adminLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function adminLoginSubmit(Request $request)
    {
        $credential = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('admin')->attempt($credential)) {
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'invalid_data' => 'The provided credentials do not match our records',
        ])->withInput();
    }

    public function adminLogout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success', 'You have been logged out successfully.');
    }


    //*******************************************************************//
    // Customer Auth functionas ******************************************

    public function customerRegister()
    {
        return view('front.customer.register');
    }

    public function customerRegisterSubmit(Request $request)
    {
        $validatedData = $request->validate([
            'name' =>  [
                'required',
                'string',
                'min:3',
                'max:30',
                'regex:/^[\pL\s]+$/u',
            ],
            'email' =>  [
                'required',
                'string',
                'email:rfc,dns',
                'max:80',
                'unique:users,email',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                function ($attribute, $value, $fail) {
                    $invalidDomains = ['abc.com', 'example.com', 'test.com'];
                    $domain = substr(strrchr($value, "@"), 1);
                    if (in_array($domain, $invalidDomains)) {
                        $fail("The $attribute domain is not allowed.");
                    }
                }
            ],
            'mobile_number' => [
                'required',
                'regex:/^(?!.*(\d)\1{5})[6-9]\d{9}$/',
                'unique:users,mobile_number',
            ],
            'password' => 'required|string|min:6',
        ], [
            'name.regex' => 'Name field must contain only letters and spaces',
            'mobile_number.regex' => 'The Contact number must be a valid number.',
            'mobile_number.unique' => 'The Contact number is already in use.',

            'email.regex' => 'The email address format is invalid.',
            'email.unique' => 'This email address is already registered.',
            'email.email' => 'The email address must be valid.',
            'email.custom' => 'The email domain is not allowed.',
        ]);

        try {
            $validatedData['password'] = Hash::make($validatedData['password']);
            $customer = User::create($validatedData);

            return redirect()->route('login')->with('success', 'Your Registration Successful!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create Vendor: ' . $e->getMessage());
        }
    }

    public function migrateGuestCartToUser()
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $sessionCart = session()->get('guest_cart', []);

            foreach ($sessionCart as $productId => $item) {
                $existingCart = Cart::where('user_id', $userId)
                    ->where('product_id', $productId)
                    ->first();

                if ($existingCart) {
                    // Update quantity if product exists
                    $existingCart->quantity += $item['quantity'];
                    $existingCart->save();
                } else {
                    // Add new product to the database cart
                    Cart::create([
                        'user_id' => $userId,
                        'product_id' => $productId,
                        'quantity' => $item['quantity'],
                    ]);
                }
            }

            // Clear the session cart after merging
            session()->forget('guest_cart');
        }
    }


    public function customerLogin()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('customer.dashboard');
        }
        return view('front.customer.login');
    }

    public function customerLoginSubmit(Request $request)
    {
        $credential = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('web')->attempt($credential)) {

            // Transfer the session cart to the database cart
            $this->migrateGuestCartToUser();
            return redirect()->route('customer.dashboard');
        }

        return back()->withErrors([
            'invalid_data' => 'The provided credentials do not match our records',
        ])->withInput();
    }

    public function customerLogout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }

    //*******************************************************************//
    // Vendor Auth functionas ******************************************

    public function vendorRegister()
    {
        return view('front.vendor.register');
    }

    public function vendorRegisterSubmit(Request $request)
    {
        $validatedData = $request->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                'max: 30',
                'regex:/^[\pL\s]+$/u',
            ],
            'email' => [
                'required',
                'string',
                'max:80',
                'email:rfc,dns',
                'unique:vendors,email',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                function ($attribute, $value, $fail) {
                    $invalidDomains = ['abc.com', 'example.com', 'test.com'];
                    $domain = substr(strrchr($value, "@"), 1);
                    if (in_array($domain, $invalidDomains)) {
                        $fail("The $attribute domain is not allowed.");
                    }
                }
            ],
            'mobile_number' => [
                'required',
                'regex:/^(?!.*(\d)\1{5})[6-9]\d{9}$/',
                'unique:vendors,mobile_number',
            ],
            'password' => 'required|string|min:6',
        ], [
            'name.regex' => 'Name field must contain only letters and spaces',
            'mobile_number.regex' => 'The Contact number must be a valid number.',
            'mobile_number.unique' => 'The Contact number is already in use.',

            'email.regex' => 'The email address format is invalid.',
            'email.unique' => 'This email address is already registered.',
            'email.email' => 'The email address must be valid.',
            'email.custom' => 'The email domain is not allowed.',
        ]);

        try {
            $validatedData['password'] = Hash::make($validatedData['password']);
            $vendor = Vendor::create($validatedData);

            return redirect()->route('vendor.login')->with('success', 'Your Registration Successful!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create Customer: ' . $e->getMessage());
        }
    }

    public function vendorLogin()
    {
        if (Auth::guard('vendor')->check()) {
            return redirect()->route('vendor.dashboard');
        }
        return view('front.vendor.login');
    }

    public function vendorLoginSubmit(Request $request)
    {
        $credential = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('vendor')->attempt($credential)) {
            return redirect()->route('vendor.dashboard');
        }

        return back()->withErrors([
            'invalid_data' => 'The provided credentials do not match our records',
        ])->withInput();
    }

    public function vendorLogout()
    {
        Auth::guard('vendor')->logout();
        return redirect()->route('vendor.login')->with('success', 'You have been logged out successfully.');
    }
}
