<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends BaseModel
{
    use HasFactory;
    protected $table = "orders";

    protected $fillable = [
        'food_id',
        'bill_id',
        'price',
        'quantity',
        'order_status',
        'note',
    ];
    public function food() {
        return $this->belongsTo(Food::class);
    }
    public function bill() {
        return $this->belongsTo(Bill::class);
    }
}
