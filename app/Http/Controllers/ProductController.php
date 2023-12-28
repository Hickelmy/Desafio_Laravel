<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;


class ProductController extends Controller
{


    // public function getData(Request $request)
    // {
    //     $perPage = $request->input('per_page', 25);
    //     $items = Product::paginate($perPage);

    //     // $items = Product::all();


    //     return response()->json($items);
    // }
    public function getData(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 25);
            
            $query = Product::query();
    
    
            $query->when($request->filled('name'), function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->input('name') . '%');
            });
    
            $query->when($request->filled('description'), function ($q) use ($request) {
                $q->where('description', 'LIKE', '%' . $request->input('description') . '%');
            });
    
            $query->when($request->filled('price'), function ($q) use ($request) {
                $q->where('price', '=', $request->input('price'));
            });
    
            $query->when($request->filled('expiration_date'), function ($q) use ($request) {
                $q->whereDate('expiration_date', '=', $request->input('expiration_date'));
            });
    
            $query->when($request->filled('category_id'), function ($q) use ($request) {
                $q->where('category_id', '=', $request->input('category_id'));
            });
    
            $items = $query->paginate($perPage);
    
            return response()->json($items);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    

    public function getById($id)
    {
        $items = Product::findOrFail($id);
        // $items = Product::with('category')->findOrFail($id);
        return response()->json($items);
    }


    public function create(Request $request)
    {
        try {
            $product = new Product();
            $product->name = $request->name;
            $product->description = $request->description;

            $price = str_replace(',', '.', str_replace('.', '', $request->price));
            $product->price = $price;

            $product->expiration_date = $request->expiration_date;
            $product->category_id = $request->category_id;



            $category = Category::where('name', $request->category_id)->first();

            // if ($category) {
            //     echo $category->name . ' ' . $category->description;
            // } else {
            //     echo 'Categoria não encontrada.' . $category ;
            //     echo $category->name . ' ' . $category->description;

            // }

            if ($category) {
                $product->category_id = $category->id;
            } else {
                // echo 'Categoria : ' . $category ;

                return response()->json(['error' => 'Categoria não encontrada.' . $category], 404);
            }



            if ($request->hasFile('image')) {
                $image = $request->file('image');

                $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();

                $path = 'D:/LARAVEL/laravel_backend/public/img/';

                $image->move($path, $imageName);

                $product->image = url($path . $imageName);

            }

            $product->save();

            return response()->json($product);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }






    public function update(Request $request)
    {
        try {
            $items = Product::findOrFail($request->id);

            $updateData = [];

            if ($request->has('name')) {
                $updateData['name'] = $request->name;
            }

            if ($request->has('description')) {
                $updateData['description'] = $request->description;
            }

            if ($request->has('price')) {
                $updateData['price'] = $request->price;
            }

            if ($request->has('expiration_date')) {
                $updateData['expiration_date'] = $request->expiration_date;
            }

            if ($request->has('image')) {
                $updateData['image'] = $request->image;
            }

            if ($request->has('category_id')) {
                $updateData['category_id'] = $request->category;
            }

            $items->update($updateData);

            return response()->json($items);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete(Request $request)
    {
        $items = Product::findOrFail($request->id);
        $items->delete();

        return response()->json('Deletado com sucesso');
    }
}
