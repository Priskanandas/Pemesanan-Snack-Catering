<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = '[
                    {"id":1, "category":"asin","product":"Martabak Telur","image":"product/product-1724164639.jpg","price":"2000","status":"open",
                    "description":"Martabak Telur versi snack .","created_at":"2024-08-20T14:04:12.000000Z","updated_at":"2024-08-20T12:33:04.000000Z"},
                ]';
        $obj = json_decode($data);
        foreach ($obj as $product) {
            Product::create([
                'product'=>$product->product,
                'image'=>$product->image,
                'price'=>$product->price,
                'category'=>$product->category,
                'status'=>$product->status,
                'description'=>$product->description
            ]);
        }
    }
}
