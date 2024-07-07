<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class WaiterNotification extends BaseModel
{
    use HasFactory;

    protected $table = "waiter_notifications";
    protected $fillable = [
        'table_id',
        'food_id',
        'notification_status'
    ];
    public function table()
    {
        return $this->belongsTo(Table::class);
    }
    public function food(){
        return $this->belongsTo(Food::class);
    }
}
