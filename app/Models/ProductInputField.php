<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductInputField extends Model
{
    protected $table = 'product_input_fields';
    protected $guarded = ['id'];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
