<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'alias',
        'product_group_id',
        'product_sub_group_id',
    ];

    public function productGroup(): BelongsTo
    {
        return $this->belongsTo(ProductGroup::class);
    }

    public function productSubGroup(): BelongsTo
    {
        return $this->belongsTo(ProductSubGroup::class);
    }

    public function pricelists(): HasMany
    {
        return $this->hasMany(ProductPricelist::class);
    }
}
