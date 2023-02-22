<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RawMaterial;

class RawMaterialsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $rms = [
            [
                'name'          => 'Esbete',
                'category_id'   => 1,
                
            ],
            [
                'name'          => 'Ayam Suwir Sambal Matah',
                'category_id'   => 1,
                
            ],
            [
                'name'          => 'Ayam Suwir Sambal Bawang',
                'category_id'   => 1,
                
            ],
            [
                'name'          => 'Kemasan Box',
                'category_id'   => 4,
                
            ],
        ];

        RawMaterial::insert($rms);
    }
}
