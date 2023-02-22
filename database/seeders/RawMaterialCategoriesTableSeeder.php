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
                'type'  => 'ck',
            ],
            [
                'id'    => 2,
                'name'  => 'Nasi',
                'type'  => 'ck',
            ],
            [
                'id'    => 3,
                'name'  => 'Sendok',
                'type'  => 'ck',
            ],
            [
                'id'    => 4,
                'name'  => 'Kemasan',
                'type'  => 'ck',
            ],
            [
                'id'    => 5,
                'name'  => 'Bahan Segar',
                'type'  => 'purchasing',
            ],
            [
                'id'    => 99,
                'name'  => 'Others',
                'type'  => 'purchasing',
            ],
        ];

        RmCategory::insert($rms_cat);
    }
}
