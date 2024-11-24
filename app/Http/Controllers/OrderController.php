<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use Illuminate\Support\Facades\DB; // Import DB facade

class OrderController extends Controller
{
    /**
     * Store a new order and its items.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_name' => 'required|string|max:255',
            'items' => 'required|array', // Expecting an array of menu items
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Start database transaction
        DB::beginTransaction();  // Use DB without backslash now
        try {
            // Create the order
            $order = Order::create([
                'customer_name' => $validatedData['customer_name'],
                'total_price' => 0, // Temporary, will calculate below
            ]);

            $totalPrice = 0;

            // Add items to the order
            foreach ($validatedData['items'] as $item) {
                $menu = Menu::findOrFail($item['menu_id']);
                $subtotal = $menu->price * $item['quantity'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $menu->id,
                    'quantity' => $item['quantity'],
                    'price' => $menu->price,
                    'subtotal' => $subtotal,
                ]);

                $totalPrice += $subtotal;
            }

            // Update the order's total price
            $order->update(['total_price' => $totalPrice]);

            DB::commit();

            return response()->json(['message' => 'Order placed successfully!', 'order_id' => $order->id], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Order failed!', 'error' => $e->getMessage()], 500);
        }
    }
}