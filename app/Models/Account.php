<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends BaseModel
{
    use HasFactory;
    protected $table = "accounts";

    protected $fillable = [
        'user_name',
        'password',
        'name',
        'role',
    ];

    public function bills() {
        return $this->hasMany(Bill::class);
    }
}
