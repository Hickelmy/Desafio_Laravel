<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    

    public function getData(request $request)
    {
        $items = Category::all();
        return response()->json($items);
    }

    public function getById($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }
    public function create(Request $request)
    {
        // $items = Category::create($request->all());
        $items = new Category();
        $items->name = $request->name;
        $items->save();

        return response()->json($items);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100',
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());

        return response()->json($category);
    }

    public function delete(Request $request)
{
    $items = Category::findOrFail($request->id);
    $items->delete();

    return response()->json($items);
}

  
}
