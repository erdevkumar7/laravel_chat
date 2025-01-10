<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Size;
use App\Models\Color;

class MasterController extends Controller
{

    // Admin Size manage
    public function getAllSizeByAdmin()
    {
        $sizes = Size::orderBy('created_at', 'desc')->get();
        return view('admin.size.allSize', compact('sizes'));
    }
    public function adminAddSize(Request $request)
    {
        if ($request->isMethod('post')) {
            $validateData = $request->validate([
                'name' => 'required|max:10|unique:size',
            ], [
                'name.required' => 'size name is required',
            ]);
            Size::create($validateData);
            return redirect()->route('admin.getAllSize');
        }

        return view('admin.size.addSize');
    }

    //Admin Color Manage
    public function getAllColorByAdmin(){
        $colors = Color::orderBy('created_at', 'desc')->get();
        return view('admin.color.allColor', compact('colors'));
    }

    public function adminAddColor(Request $request)
    {
        if($request->isMethod('post')){
            $validateData = $request->validate([
                'name' => 'required|max:10|unique:colors',
                'code' => 'required|max:30',
            ], [
                'name.required' => 'color name is required',
                'name.unique' => 'The color name has already been taken.',
            ]);
            Color::create($validateData);
            return redirect()->route('admin.getAllColor');
        }

        return view('admin.color.addColor');
    }
}
