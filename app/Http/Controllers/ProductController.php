<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $productcount = Cart::count();
        $minPrice = Product::min('price');
        $maxPrice = Product::max('price');

        $maxRating = Product::max('rating');
        $minRating = Product::min('rating');
        return view('pages.home', compact('products', 'productcount', 'minPrice', 'maxPrice', 'maxRating', 'minRating'));
    }

    public function search(Request $request)
    {
        // dd($request->all());
        $data = $request->query('query');
        $products = Product::where('name', 'LIKE', "%{$data}%")->get();

        return response()->json(['products' => $products]);
    }

    public function price(Request $request)
    {
        $price = $request->input('price');
        $products = Product::where('price', '<=', $price)->get();

        return response()->json(['products' => $products]);
    }

    public function rating(Request $request)
    {
        $rating = $request->input('rating');
        $products = Product::where('rating', '>=', $rating)->get();

        return response()->json(['products' => $products]);
    }
}
