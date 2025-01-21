<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function viewOrder($id = null)
    {
        $userId = Auth::guard('web')->user()->id;
        if ($id) {
            $order = Order::where('id', $id)
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->with('order_items.product')
                ->firstOrFail();

            return view('front.customer.viewOrder', compact('order'));
        } else {
            $orders = Order::where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->with('order_items.product')
                ->get();

            // $orders = DB::table('orders')
            // ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            // ->join('products', 'order_items.product_id', '=', 'products.id')
            // ->where('orders.user_id', $userId)
            // ->select(
            //     'orders.id as order_id',
            //     'orders.total_amount',
            //     'orders.order_status',
            //     'orders.payment_status',
            //     'orders.currency',
            //     'order_items.price as item_price',
            //     'order_items.quantity',
            //     'products.name as product_name',
            //     'products.id as product_id'
            // )
            // ->get();
            // dd($orders);
            return view('front.customer.viewOrder', compact('orders'));
        }
    }

    public function viewOrderItem($order_itemsId)
    {
        // $orderItem = OrderItem::where('id', $order_itemsId)
        //     ->with('product')
        //     ->with('order')
        //     ->get();

        $orderItem = OrderItem::where('id', $order_itemsId)
        ->with([
            'product',        // Eager load the product details
            'order.user'      // Eager load the order and its associated user
        ])
        ->firstOrFail();
        // dd($orderItem);
        return view('front.customer.viewOrderItem', compact('orderItem'));

    }
}
