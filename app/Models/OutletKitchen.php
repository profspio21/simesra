<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutletKitchen extends Model
{
    use HasFactory;

    public $table = 'outlet_kitchens';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'lokasi',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function rm()
    {
        return $this->belongsToMany(RawMaterial::class, 'outlet_kitchen_raw_material' , 'ok_id', 'rm_id')->withPivot('qty')->withTimestamps();
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}