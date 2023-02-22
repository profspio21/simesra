<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawMaterial extends Model
{
    use HasFactory;

    public $table = 'raw_materials';

    public const TYPE_SELECT = [
        'ck' => 'Central Kitchen',
        'purchasing' => 'Purchasing',
    ];

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
        return $this->belongsToMany(OutletKitchen::class, 'outlet_kitchen_raw_material' , 'rm_id', 'ok_id')->withPivot('qty')->withTimestamps();
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_rm', 'rm_id', 'product_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}