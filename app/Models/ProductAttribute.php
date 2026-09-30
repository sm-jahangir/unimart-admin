<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $guarded = ['id'];

    public function options()
    {
        return $this->hasMany(ProductAttributeOption::class);
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
