<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $guarded = ['id'];

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function items() {
        return $this->hasMany(Item::class, 'product_id');
    }

    public function inputFields() {
        return $this->hasMany(ProductInputField::class, 'product_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
