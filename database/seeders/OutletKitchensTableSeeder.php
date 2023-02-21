<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OutletKitchen;
use App\Models\User;

class OutletKitchensTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $oks = [
            [
                'id'             => 1,
                'lokasi'       => 'Sentul',
            ],
            [
                'id'             => 2,
                'lokasi'       => 'Kemang',
            ],
        ];

        OutletKitchen::insert($oks);
        User::findOrFail(1)->ok()->sync(OutletKitchen::pluck('id'));
    }
}
