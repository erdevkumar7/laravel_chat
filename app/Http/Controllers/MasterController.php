<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Size;

class MasterController extends Controller
{
    public function getAllSizeByAdmin(){
        $sizes = Size::orderBy('created_at', 'desc')->get();
        return view('admin.size.allSize', compact('sizes'));
    }
    public function adminAddSize(Request $request)
    {
        if ($request->isMethod('post')) {
            $validateData = $request->validate([
                'name' => 'required|max:10',
            ], [
                'name.required' => 'Size name is required',
            ]);
            Size::create($validateData);
            return redirect()->route('admin.getAllSize');
        }

        return view('admin.size.addSize');
    }
}
