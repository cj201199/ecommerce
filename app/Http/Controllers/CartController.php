<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\Order;
use DB;
use Log;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = Cart::create([
                'product_id' => $request->product_id,
                'quantity' => 1
            ]);
            DB::commit();
            return response()->json(['status' => 200, 'message' => 'Product added to cart']);
        } catch (\Exception $e) {
            Log::error('add function failed: ' . $e->getMessage());
            return response()->json(['error' => 'add function failed: ' . $e->getMessage()], 500);
        }
    }

    public function index()
    {
        $cart = Cart::with('product')->get();
        return view('pages.cart', compact('cart'));
    }

    public function delete(Request $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $cart = Cart::where('id', $request->product_id)->first();
            if ($cart) {
                $cart->delete();
            }
            DB::commit();
            return response()->json(['status' => 200, 'message' => 'Delete Product From Cart']);
        } catch (\Exception $e) {
            Log::error('delete function failed: ' . $e->getMessage());
            return response()->json(['error' => 'delete function failed: ' . $e->getMessage()], 500);
        }
    }

    public function addOrder(Request $request)
    {
        try {
            Db::beginTransaction();
            $order = Order::create([
                'customer_name' => $request->name,
                'address' => $request->address,
                'mobile' => $request->mobile,
                'total_price' => $request->productid ?? '',
            ]);
            DB::commit();
            return response()->json(['status' => 200, 'message' => 'Order Placed Successfully']);
        } catch (\Exception $e) {
            Log::error('addOrder function failed: ' . $e->getMessage());
            return response()->json(['error' => 'addOrder function failed: ' . $e->getMessage()], 500);
        }
    }
}
