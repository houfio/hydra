<?php

namespace App\Http\Controllers;

use App\Dish;
use App\Order;
use App\Session;
use Exception;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class OrderController extends Controller
{
    public function list()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'orders' => Order::all()
            ]
        ]);
    }

    public function create(Request $request)
    {
        $data = $this->validate($request, [
            'dishes' => 'required|array|min:1',
            'dishes.*.id' => 'required|numeric|min:1|exists:dishes,id',
            'dishes.*.quantity' => 'required|numeric|min:1',
            'dishes.*.note' => 'nullable|min:1|max:255'
        ]);

        $order = new Order();

        if (isset($request->tablet)) {
            /** @var Session $session */
            $session = Session::find($request->tablet->id);
            $lastOrder = $session->orders()->max('created_at');

            if (strtotime('-10 minutes') < strtotime($lastOrder)) {
                throw new Exception('Order cannot be placed yet.');
            }

            $order->session()->associate($session);
        }

        $order->save();

        foreach ($data['dishes'] as $dish) {
            $savedDish = Dish::find($dish['id']);
            $order->dishes()->save($savedDish, [
                'quantity' => $dish['quantity'],
                'price' => $savedDish->price,
                'tax' => 9,
                'note' => isset($dish['note']) ? $dish['note'] : null
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
