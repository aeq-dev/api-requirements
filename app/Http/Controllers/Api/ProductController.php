<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // This is without using packages or creating a filter class

        $products = Product::with('category');

        if ($request->has('category')) {
            $products->where('category_id', '=', Category::whereName($request->category)->first()?->id);
        }
        if ($request->has('price')) {
            $products->where('price', '=', $request->price);
        }
        return $products->get()->map(function ($item, $key) {
            return [
                'id' => $item->id,
                'sku' => $item->sku,
                'name' => $item->name,
                'category' => $item->category->name,
                'price' => $item->price,
            ];
        });
    }

    public function all()
    {
        return ProductResource::collection(Product::all());
    }
}
