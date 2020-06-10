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
            'name' => 'required|unique:offers,name|max:255',
            'valid_until' => 'nullable|date|after:today',
            'price' => 'numeric|min:1',
            'dishes' => 'required|array|min:1',
            'dishes.*.id' => 'required|numeric|min:1|exists:dishes,id'
        ]);

        $offer = new Offer();

        $offer->name = $data['name'];
        $offer->valid_until = isset($data['valid_until']) && $data['valid_until'] ? $data['valid_until'] : null;
        $offer->price = $data['price'];

        $offer->save();

        foreach ($data['dishes'] as $dish) {
            $savedDish = Dish::find($dish['id']);
            $offer->dishes()->save($savedDish);
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function update(Request $request, Offer $offer)
    {
        $data = $this->validate($request, [
            'name' => "required|unique:offers,name,{$offer->id}|max:255",
            'valid_until' => 'nullable|date|after:today',
            'price' => 'numeric|min:1',
            'dishes' => 'required|array|min:1',
            'dishes.*.id' => 'required|numeric|min:1|exists:dishes,id'
        ]);

        $offer->name = $data['name'];
        $offer->valid_until = isset($data['valid_until']) && $data['valid_until'] ? $data['valid_until'] : null;
        $offer->price = $data['price'];

        $offer->dishes()->detach($offer->dishes()->pluck('dishes.id')->toArray());

        foreach ($data['dishes'] as $dish) {
            $savedDish = Dish::find($dish['id']);
            $offer->dishes()->save($savedDish);
        }

        $offer->save();

        return response()->json([
            'success' => true
        ]);
    }

    public function detail(Offer $offer)
    {
        $offer = $offer->load('dishes')
            ->makeHidden(['created_at', 'updated_at']);

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

        return response()->json([
            'success' => true,
            'data' => [
                'offer' => $offer
            ]
        ]);
    }

    public function delete(Offer $offer)
    {
        $offer->delete();

        return response('', 204);
    }
}
