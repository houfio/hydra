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
        $offers = Offer::with('dishes')
            ->orderBy('created_at', 'desc')
            ->get()
            ->makeHidden(['created_at', 'updated_at']);

        foreach ($offers as $offer) {
            $offer->dishes->makeHidden([
                'type_id',
                'created_at',
                'updated_at',
                'pivot',
                'number',
                'price',
                'description',
                'type_id',
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'offers' => $offers
            ]
        ]);
    }

    public function create(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|unique:deals,name|max:255',
            'valid_until' => 'nullable|date',
            'price' => 'numeric|min:1',
            'dishes' => 'required|array|min:1',
            'dishes.*.id' => 'required|numeric|min:1|exists:dishes,id'
        ]);

        $offer = new Offer();

        $offer->name = $data['name'];
        $offer->valid_until = isset($data['valid_until']) ? $data['valid_until'] : null;
        $offer->price = $data['price'];
        $offer->tax = 9;

        $offer->save();

        foreach ($data['dishes'] as $dish) {
            $savedDish = Dish::find($dish['id']);
            $offer->dishes()->save($savedDish);
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
