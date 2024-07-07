<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

abstract class BaseModel extends Model
{
    // /**
    //  * The "booting" method of the model.
    //  *
    //  * @return void
    //  */
    // protected static function boot()
    // {
    //     parent::boot();

    //     // Thêm logic chung vào đây, ví dụ:
    //     static::addGlobalScope('created_at_desc', function (Builder $builder) {
    //         $builder->orderBy('created_at', 'desc');
    //     });
    // }

    /**
     * Chuyển đổi ngày tháng và thời gian thành định dạng nhất định
     *
     * @param \DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    // Thêm các phương thức chung khác ở đây...
}
