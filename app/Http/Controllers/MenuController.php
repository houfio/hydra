<?php

namespace App\Http\Controllers;

use App\DishType;
use Laravel\Lumen\Routing\Controller;

class MenuController extends Controller
{
    public function list()
    {
        $types = DishType::with('dishes')->get()
            ->makeHidden(['created_at', 'updated_at']);

        foreach ($types as $type) {
            $type->dishes->makeHidden(['type_id', 'created_at', 'updated_at']);
        }

        return response()->json([
            'data' => [
                'types' => $types
            ]
        ]);
    }
}
