<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OutletKitchen;
use App\Models\RawMaterial;

class OkRmTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $rm = RawMaterial::all();
        foreach ($rm as $key => $value) {
            OutletKitchen::findOrFail(1)->rm()->attach($value, ['qty' => 100]);
        }
    }
}
