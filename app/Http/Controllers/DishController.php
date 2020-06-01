<?php

namespace App\Http\Controllers;

use App\Dish;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class DishController extends Controller
{
    public function create(Request $request)
    {
        $data = $this->validate($request, [
            'number' => 'required|unique:dishes,number',
            'price' => 'required|integer|min:0',
            'description' => 'nullable',
            'type_id' => 'required|numeric|exists:dish_types,id'
        ]);

        $dish = new Dish();

        $dish->number = $data['number'];
        $dish->price = $data['price'];
        $dish->description = $data['description'];
        $dish->type()->associate(Dish::find((int)$data['type_id']));

        $dish->save();

        return response()->json([
            'success' => true
        ]);
    }

    public function update(Request $request, Dish $dish)
    {
        $data = $this->validate($request, [
            'number' => "required|unique:dishes,number,{$dish->id}",
            'price' => 'required|integer|min:0',
            'description' => 'nullable',
            'type_id' => 'required|numeric|exists:dish_types,id'
        ]);

        $dish->number = $data['number'];
        $dish->price = $data['price'];
        $dish->description = $data['description'];

        if ((int)$data['type_id'] !== $dish->type_id) {
            $dish->type()->associate(Dish::find((int)$data['type_id']));
        }

        $dish->save();

        return response()->json([
            'success' => true
        ]);
    }

    public function detail(Dish $dish)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'dish' => $dish
            ]
        ]);
    }

    public function delete(Dish $dish)
    {
        $dish->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
