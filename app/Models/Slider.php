<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
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

    public function scopeActive($query)
    {
        return $query->where('status', Status::ACTIVE);
    }
}
