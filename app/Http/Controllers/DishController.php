<?php

namespace App\Http\Controllers;

use App\Dish;
use App\DishType;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class DishController extends Controller
{
    public function list(Request $request)
    {
        $search = $request->query('q');

        $types = DishType::with(['dishes' => function ($q) use ($search) {
            $q->where('name', 'like', "%$search%")
                ->orWhere('number', 'like', "%$search%")
                ->orWhereHas('type', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%$search%");
                });
        }])->get()->makeHidden(['created_at', 'updated_at']);

        foreach ($types as $type) {
            $type->dishes->makeHidden(['type_id', 'created_at', 'updated_at']);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'types' => $types->filter(fn ($type) => $type->dishes->count() > 0)
            ],
            'search' => $search
        ]);
    }

    public function create(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|unique:dishes,name|max:255',
            'number' => 'required|unique:dishes,number',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable',
            'type_id' => 'required|numeric|exists:dish_types,id'
        ]);

        $dish = new Dish();

        $dish->name = $data['name'];
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
            'name' => "required|unique:dishes,name,{$dish->id}|max:255",
            'number' => "required|unique:dishes,number,{$dish->id}",
            'price' => 'required|numeric|min:0',
            'description' => 'nullable',
            'type_id' => 'required|numeric|exists:dish_types,id'
        ]);

        $dish->name = $data['name'];
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

        return response('', 204);
    }
}
