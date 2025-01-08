<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class ProductController extends Controller
{
    public function adminAddCategory(Request $request, $id = null)
    {
        if ($request->isMethod('post')) {
            $validateData = $request->validate([
                'name' => 'required|min:3|max:55',
                'description' => 'required|min:3|max:55',
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
        return view('admin.product.add_category');
    }
}
