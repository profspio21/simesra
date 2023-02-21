<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $products = [
            [
                'id'        => 1,
                'name'      => 'Esbete',
            ],
            [
                'id'        => 2,
                'name'      => 'Ayam Suwir Sambal Matah',
            ],
            [
                'id'        => 3,
                'name'      => 'Ayam Suwir Sambal Bawang',
            ],
        ];

        Product::insert($products);
    }
}
