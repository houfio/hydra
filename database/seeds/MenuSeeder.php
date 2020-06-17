<?php

use App\Dish;
use App\DishType;
use App\Services\CsvReader;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run()
    {
        $reader = new CsvReader();
        $reader->setFile('/database/seeds/exports/menu.csv');
        $rows = $reader->getContent();

        foreach ($rows as $row) {
            $dish = new Dish();

            $dish->number = $row['menunummer'] . strtolower($row['menu_toevoeging']);

            if (!$dish->number) {
                $dish->number = rand(1, 80) . chr(rand(97,122));
            }

            $dish->price = $row['price'];
            $dish->name = $row['naam'];
            $dish->description = $row['beschrijving'];

            $type = DishType::where('name', '=', $row['soortgerecht'])->first();

            if (!$type) {
                $type = new DishType();
                $type->name = ucfirst(strtolower($row['soortgerecht']));
                $type->save();
            }

            $dish->type()->associate($type);
            $dish->save();
        }
    }
}
