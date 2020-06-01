<?php

namespace App\Http\Controllers;

use App\Deal;
use App\Dish;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class DealController extends Controller
{
    public function list()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'deals' => Deal::all()
            ]
        ]);
    }

    public function create(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|unique:deals,name|max:255',
            'valid_until' => 'nullable|date',
            'dishes' => 'required|array|min:1',
            'dishes.*.id' => 'required|numeric|min:1|exists:dishes,id',
            'dishes.*.price' => 'required|numeric|min:1'
        ]);

        $deal = new Deal();

        $deal->name = $data['name'];
        $deal->valid_until = isset($data['valid_until']) ? $data['valid_until'] : null;

        $deal->save();

        foreach ($data['dishes'] as $dish) {
            $savedDish = Dish::find($dish['id']);
            $deal->dishes()->save($savedDish, [
                'price' => $savedDish->price,
                'tax' => 9
            ]);
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function detail(Deal $deal)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'deal' => $deal
            ]
        ]);
    }

    public function delete(Deal $deal)
    {
        $deal->delete();

        return response('', 204);
    }
}
