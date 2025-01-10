<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function getAdminAllCategory(){
        $categories = Category::orderBy('created_at', 'desc')->get();       
        return view('admin.category.allCategory', compact('categories'));
    }

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
                ->first();
            if ($category) {
                return back()->withErrors([
                    'name' => 'category name already exits',
                ])->withInput();
            }

            Category::create($validateData);
            return redirect()->route('admin.getAllCategory');
        }
        return view('admin.category.addCategory');
    }
}
