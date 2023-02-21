<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public const ORDER_TO_SELECT = [
        'ck'         => 'Central Kitchen',
        'purchasing' => 'Purchasing',
    ];

    public const TYPE_SELECT = [
        'Penambahan' => 'Penambahan Stok',
        'Pengurangan' => 'Pengurangan Stok',
    ];

    public const STATUS_SELECT = [
        0  => 'Permohonan ke CK',
        1  => 'Pengiriman',
        2  => 'Selesai',
        9 => 'Dibatalkan',
    ];

    public $table = 'orders';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'order_to',
        'type',
        'ok_id',
        'user_id',
        'keterangan',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function ok()
    {
        return $this->belongsTo(OutletKitchen::class, 'ok_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rms()
    {
        return $this->belongsToMany(Rawmaterial::class)->withPivot('qty','keterangan')->withTimestamps();;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}