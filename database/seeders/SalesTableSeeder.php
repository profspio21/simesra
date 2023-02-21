<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sale;

class SalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $sales = [
            [
                'product_id'    => 1,
                'user_id'       => 1,
                'qty'           => 1,
                'ok_id'         => 1,
            ],
            [
                'product_id'    => 1,
                'user_id'       => 1,
                'qty'           => 2,
                'ok_id'         => 1,
            ],
            [
                'product_id'    => 2,
                'user_id'       => 1,
                'qty'           => 1,
                'ok_id'         => 1,
            ],
            [
                'product_id'    => 3,
                'user_id'       => 1,
                'qty'           => 3,
                'ok_id'         => 2,
            ],
            [
                'product_id'    => 1,
                'user_id'       => 1,
                'qty'           => 3,
                'ok_id'         => 2,
            ],
        ];

        Sale::insert($sales);
    }
}
