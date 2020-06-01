<?php

namespace App\Http\Controllers;

use App\Dish;
use App\Order;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $data = $this->validate($request, [
            'dishes' => 'required|array|min:1',
            'dishes.*.id' => 'required|numeric|min:1|exists:dishes,id',
            'dishes.*.quantity' => 'required|numeric|min:1'
        ]);

        $order = new Order();
        $order->save();

        foreach ($data['dishes'] as $dish) {
            $savedDish = Dish::find($dish['id']);
            $order->dishes()->save($savedDish, [
                'quantity' => $dish['quantity'],
                'price' => $savedDish->price,
                'tax' => 9
            ]);
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function detail(Order $order)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'order' => $order->load('dishes')
            ]
        ]);
    }
}
