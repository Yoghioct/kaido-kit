<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductSubGroup extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'product_group_id',
    ];

    public function productGroup(): BelongsTo
    {
        return $this->belongsTo(ProductGroup::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
