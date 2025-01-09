<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function adminAddCategory(Request $request, $id = null)
    {
        if ($request->isMethod('post')) {
            $validateData = $request->validate([
                'name' => 'required|min:2|max:55',
                'category_slug' => 'required|unique:categories|min:2|max:55',
            ], [
                'name.required' => 'category name is required',
            ]);

            $category = Category::where('name', $validateData['name'])
                ->where('is_deleted', '0')
                ->first();
            if ($category) {
                return back()->withErrors([
                    'name' => 'category name already exits',
                ])->withInput();
            }

            Category::create($validateData);
            return redirect()->route('admin.dashboard');
        }
        return view('admin.category.addCategory');
    }

    public function vendorAddProduct(Request $request, $id = null)
    {
        $categories = Category::all();

        if ($request->isMethod('post')) {
            $validateData = $request->validate([
                'name' => 'required|min:3|max:55',
                'category_id' => 'required',
                'description' => 'required|min:10|max:100',
                'price' => 'required|numeric',
                'product_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($request->hasFile('product_image')) { 
                $image = $request->file('product_image');
                $originalImageName = $image->getClientOriginalName();
                $imageName = time() . '_' . $originalImageName;
                $image->move(public_path('/front_asset/img/product_img'), $imageName);
            } else {
                $imageName = null;
            }
            $validateData['product_image'] = $imageName;
            $validateData['vendor_id'] = auth('vendor')->id();
           
            // dd($validateData);
            Product::create($validateData);
            return redirect()->route('vendor.dashboard');
        }

        return view('front.vendor.addProduct', compact('categories'));
    }
}
