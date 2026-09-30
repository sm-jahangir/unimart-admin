<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttributeOption extends Model
{
    protected $guarded = ['id'];

    public function attribute()
    {
        return $this->belongsTo(ProductAttribute::class, 'product_attribute_id');
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
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
