<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\RawMaterial;

class ProductRmTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $a = RawMaterial::whereIn('id',[1,4])->get();
        $b = RawMaterial::whereIn('id',[2,4])->get();
        $c = RawMaterial::where('id',3)->get();
        Product::findOrFail(1)->rms()->sync($a->pluck('id'));
        Product::findOrFail(2)->rms()->sync($b->pluck('id'));
        Product::findOrFail(3)->rms()->sync($c->pluck('id'));
        
    }
}
