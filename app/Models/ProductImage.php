<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'featured_image'
    ];

    // Function: product

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
