<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends BaseModel
{
    use HasFactory;
    protected $table = "categories";

    protected $fillable = [
        'category_name',
    ];

    public function foods()
    {
        return $this->hasMany(Food::class);
    }
}
