<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawMaterial extends Model
{
    use HasFactory;

    public $table = 'raw_materials';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'category_id',
        'ok_id',
        'qty',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function category()
    {
        return $this->belongsTo(RmCategory::class, 'category_id');
    }

    public function ok()
    {
        return $this->belongsTo(OutletKitchen::class, 'ok_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_rm', 'product_id', 'rm_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}