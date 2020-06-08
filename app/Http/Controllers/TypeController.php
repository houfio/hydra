<?php

namespace App\Http\Controllers;

use App\DishType;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class TypeController extends Controller
{
    public function list()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'types' => DishType::all()->makeHidden(['created_at', 'updated_at'])
            ]
        ]);
    }

    public function create(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|unique:dish_types,name|max:60',
        ]);

        $dishType = new DishType();
        $dishType->name = $data['name'];
        $dishType->save();

        return response()->json([
            'success' => true
        ]);
    }

    public function update(Request $request, DishType $dishType)
    {
        $data = $this->validate($request, [
            'name' => "required|unique:dish_types,name,{$dishType->id}|max:60",
        ]);

        $dishType->name = $data['name'];
        $dishType->save();

        return response()->json([
            'success' => true
        ]);
    }

    public function detail(DishType $dishType)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'dish' => $dishType
            ]
        ]);
    }

    public function delete(DishType $dishType)
    {
        $dishType->delete();

        return response('', 204);
    }
}
