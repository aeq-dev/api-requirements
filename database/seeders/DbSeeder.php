<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Currency EUR
        $currency = Currency::create(['code' => 'EUR']);

        // Read Products Json file and fill the DB
        $products = json_decode(file_get_contents(storage_path() . "/products.json"), true);
        foreach ($products as $key => $product) {

            $category = Category::firstOrCreate([
                'name' => $product['category']
            ]);
            $product = $category->products()->create([
                'sku' => $product['sku'],
                'name' => $product['name'],
                'price' => $product['price']
            ]);
            if ($category->name === 'insurance')
                $product->price()->create([
                    'original' => $product['price'],
                    'final' => $product['price'] - $product['price'] * 0.3,
                    'discount_percentage' => 30,
                    'currency_id' => $currency->id
                ]);
            elseif ($product['sku'] === "000003")
                $product->price()->create([
                    'original' => $product['price'],
                    'final' => $product['price'] - $product['price'] * 0.15,
                    'discount_percentage' => 15,
                    'currency_id' => $currency->id
                ]);
            else
                $product->price()->create([
                    'original' => $product['price'],
                    'final' => $product['price'],
                    'discount_percentage' => null,
                    'currency_id' => $currency->id
                ]);
        }
    }
}
