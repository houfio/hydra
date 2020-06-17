<?php

use App\Dish;
use App\Order;
use App\Services\CsvReader;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    public function run()
    {
        $reader = new CsvReader();
        $reader->setFile('/database/seeds/exports/sales.csv');
        $sales = $reader->getContent();

        $reader->setFile('/database/seeds/exports/menu.csv');
        $dishes = $reader->getContent();

        foreach ($sales as $sale) {
            $dish = $this->searchByValue($dishes, $sale['itemId']);
            $order = Order::where('created_at', '=', $sale['saleDate'])->first();

            if (!$order) {
                $order = new Order();
                $order->created_at = $sale['saleDate'];
                $order->save();
            }

            $order->dishes()->save(Dish::where('name', '=', $dish['naam'])->first(), [
                'price' => $dish['price'],
                'tax' => 9,
                'quantity' => 1,
                'note' => null
            ]);
        }
    }

    private function searchByValue(array $array, string $needle, string $column = 'id'): ?array
    {
        foreach ($array as $key => $value) {
            if ($value[$column] === $needle) {
                return $value;
            }
        }

        return null;
    }
}
