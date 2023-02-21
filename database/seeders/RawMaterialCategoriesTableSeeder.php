<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RmCategory;

class RawMaterialCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rms_cat = [
            [
                'id'    => 1,
                'name'  => 'WIP',
            ],
            [
                'id'    => 2,
                'name'  => 'Nasi',
            ],
            [
                'id'    => 3,
                'name'  => 'Sendok',
            ],
            [
                'id'    => 4,
                'name'  => 'Kemasan',
            ],
            [
                'id'    => 5,
                'name'  => 'Bahan Segar',
            ],
            [
                'id'    => 99,
                'name'  => 'Others',
            ],
        ];

        RmCategory::insert($rms_cat);
    }
}
