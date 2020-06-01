<?php

namespace App\Http\Controllers;

use App\DishType;
use App\Offer;
use Barryvdh\DomPDF\Facade as PDF;
use Laravel\Lumen\Routing\Controller;

class MenuController extends Controller
{
    private function generate()
    {
        $types = DishType::with('dishes')->get()
            ->makeHidden(['created_at', 'updated_at']);

        $offers = Offer::with('dishes')->get()
            ->makeHidden(['created_at', 'updated_at']);

        foreach ($types as $type) {
            $type->dishes->makeHidden(['type_id', 'created_at', 'updated_at']);
        }

        foreach ($offers as $offer) {
            $offer->dishes->makeHidden(['type_id', 'created_at', 'updated_at']);
        }

        return [
            'types' => $types,
            'offers' => $offers
        ];
    }

    public function download()
    {
        return PDF::loadView('menu', $this->generate())->download('menu.pdf');
    }

    public function list()
    {
        return response()->json([
            'success' => true,
            'data' => $this->generate()
        ]);
    }
}
