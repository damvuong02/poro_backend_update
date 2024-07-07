<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Table extends BaseModel
{
    use HasFactory;
    protected $table = "tables";

    protected $fillable = [
        'table_name',
        'table_status',
    ];

    public function bills()
    {
        return $this->belongsTo(Bill::class);
    }

    public function foods(){
        return $this->belongsTo(Food::class);
    }
}
