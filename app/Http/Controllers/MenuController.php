<?php

namespace App\Http\Controllers;

use App\DishType;
use App\Offer;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;
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
            $offer->dishes->makeHidden(['type_id', 'created_at', 'updated_at', 'pivot']);
        }

        return [
            'types' => $types,
            'offers' => $offers
        ];
    }

    public function list()
    {
        return response()->json([
            'success' => true,
            'data' => $this->generate()
        ]);
    }

    public function current()
    {
        $data = $this->generate();
        $hash = md5(serialize($data));
        $path = "public/menu/$hash.pdf";

        if (!Storage::exists($path)) {
            $content = PDF::loadView('menu', $data)->download()->getOriginalContent();

            Storage::put($path, $content);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'url' => env('APP_URL') . '/storage' . substr($path, 6)
            ]
        ]);
    }
}
