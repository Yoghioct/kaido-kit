<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductPricelist extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'price',
        'effective_at',
    ];

    protected $casts = [
        'effective_at' => 'datetime',
        'price' => 'decimal:2',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
