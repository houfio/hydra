<?php

namespace App\Http\Controllers;

use App\Dish;
use App\Offer;
use App\Order;
use Exception;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class OrderController extends Controller
{
    public function list(Request $request)
    {
        $orders = isset($request->tablet) ? $request->tablet->orders()->with('dishes') : Order::with('dishes');
        $orders = $orders->orderBy('created_at', 'desc')->get()->makeHidden(['updated_at']);

        foreach ($orders as $order) {
            $order->dishes->makeHidden(['type_id', 'created_at', 'updated_at']);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'orders' => $orders
            ]
        ]);
    }

    public function create(Request $request)
    {
        $data = $this->validate($request, [
            'dishes' => 'present|array',
            'offers' => 'present|array',
            'dishes.*.id' => 'required|numeric|min:1|exists:dishes,id',
            'offers.*.id' => 'required|numeric|min:1|exists:offers,id',
            '*.*.quantity' => 'required|numeric|min:1',
            '*.*.note' => 'nullable|min:1|max:255'
        ]);

        $order = new Order();

        if (isset($request->tablet)) {
            $lastOrder = $request->tablet->orders()->max('created_at');

            if (strtotime('-10 minutes') < strtotime($lastOrder)) {
                throw new Exception('Order cannot be placed yet.');
            }

            $order->session()->associate($request->tablet);
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

        foreach ($data['offers'] as $offer) {
            $savedOffer = Offer::find($offer['id']);
            $order->offers()->save($savedOffer, [
                'quantity' => $offer['quantity'],
                'price' => $savedOffer->price,
                'tax' => 9,
                'note' => isset($offer['note']) ? $offer['note'] : null
            ]);
        }

        $order->save();

        return response()->json([
            'success' => true,
            'data' => [
                'order' => $order->id
            ]
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
