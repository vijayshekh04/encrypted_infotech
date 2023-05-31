<?php

namespace Database\Seeders;

use App\Models\ProductMaster;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=1;$i<=5;$i++)
        {
            $product_insert['name'] = "Product ".$i;
            $product_insert['rate'] = 10;
            $product_insert['unit'] = "unit";


            ProductMaster::create($product_insert);
        }
    }
}
