<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSeo extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'meta_keyword' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function creator()
    {
        return $this->morphTo();
    }

    public function editor()
    {
        return $this->morphTo();
    }
}
