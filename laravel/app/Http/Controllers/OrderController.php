<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
{
    $orders = Order::with('items.product')
                   ->where('user_id', $request->user()->id)
                   ->orderBy('created_at', 'desc')
                   ->get();
                   
    return response()->json($orders);
}
    public function checkout(Request $request)
    {
        $user = $request->user();
        
        $cartItems = CartItem::with('product')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'El carret és buit'], 400);
        }

        $order = DB::transaction(function () use ($user, $cartItems) {
            
            $totalAmount = 0;
            foreach ($cartItems as $item) {
                $quantity = $item->quantity ?? 1; 
                $totalAmount += $item->product->price * $quantity;
            }

            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $totalAmount,
                'status' => 'pending'
            ]);

            foreach ($cartItems as $item) {
                $quantity = $item->quantity ?? 1;
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $quantity,
                    'price' => $item->product->price // ¡Congelamos el precio!
                ]);
            }

            CartItem::where('user_id', $user->id)->delete();

            return $order;
        });

        return response()->json(['message' => 'Comanda creada correctament', 'order' => $order], 201);
    }
}