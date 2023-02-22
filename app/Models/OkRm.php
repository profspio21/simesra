<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OkRm extends Model
{
    use HasFactory;

    public $table = 'outlet_kitchen_raw_material';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'ok_id',
        'rm_id',
        'qty',
        'created_at',
        'updated_at',
    ];

    public function ok() {
        return $this->belongsTo(OutletKitchen::class, 'ok_id');
    }

    public function rm() {
        return $this->belongsTo(RawMaterial::class, 'rm_id');
    }
}
