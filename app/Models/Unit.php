<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'status' => Status::class,
    ];

    public function creator()
    {
        return $this->morphTo();
    }

    public function editor()
    {
        return $this->morphTo();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
