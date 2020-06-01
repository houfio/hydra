<?php

namespace App\Http\Controllers;

use App\Offer;
use App\Dish;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class OfferController extends Controller
{
    public function list()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'offers' => Offer::all()
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

        $offer = new Offer();

        $offer->name = $data['name'];
        $offer->valid_until = isset($data['valid_until']) ? $data['valid_until'] : null;

        $offer->save();

        foreach ($data['dishes'] as $dish) {
            $savedDish = Dish::find($dish['id']);
            $offer->dishes()->save($savedDish, [
                'price' => $savedDish->price,
                'tax' => 9
            ]);
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function detail(Offer $offer)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'deal' => $offer
            ]
        ]);
    }

    public function delete(Offer $offer)
    {
        $offer->delete();

        return response('', 204);
    }
}
