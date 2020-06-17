<?php

namespace App\Http\Controllers;

use App\OrderDish;
use App\OrderOffer;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class ReportController extends Controller
{
    public function create(Request $request)
    {
        $data = $this->validate($request, [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $dishes = OrderDish::whereHas('order', function ($query) use ($data) {
            $query->whereBetween('created_at', [$data['start_date'], $data['end_date']]);
        })->with(['dish' => function ($query) {
            $query->select('id', 'name');
        }, 'order' => function ($query) {
            $query->select('id', 'created_at');
        }]);

        $offers = OrderOffer::whereHas('order', function ($query) use ($data) {
            $query->whereBetween('created_at', [$data['start_date'], $data['end_date']]);
        })->with(['dish' => function ($query) {
            $query->select('id', 'name');
        }, 'order' => function ($query) {
            $query->select('id', 'created_at');
        }]);

        $dishes = $dishes->union($offers);

        $vat = 0;
        $revenue = 0;

        foreach ($dishes->get() as $dish) {
            $revenue += (float)$dish->price * $dish->quantity;
            $vat += ((float)$dish->price * $dish->quantity / (100 + $dish->tax)) * $dish->tax;
        }

        return response()->json([
            'success' => true,
            'data' => [
                'revenue' => (float)number_format($revenue, 2, '.', ''),
                'vat' => (float)number_format($vat, 2, '.', ''),
                'dishes' => $dishes->paginate(30)->appends($data)
            ]
        ]);
    }
}
