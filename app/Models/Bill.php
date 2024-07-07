<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bill extends BaseModel
{
    use HasFactory;
    protected $table = "bills";

    protected $fillable = [
        'account_id',
        'table_id',
    ];
    public function account() {
        return $this->BelongsTo(Account::class);
    }
    public function table()
    {
        return $this->BelongsTo(Table::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
