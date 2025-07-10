<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductGroupClusterItem extends Model
{
    use SoftDeletes;

    // add fillable
    protected $fillable = [
        'product_group_cluster_id',
        'product_group_id',
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function cluster(): BelongsTo
    {
        return $this->belongsTo(ProductGroupCluster::class, 'product_group_cluster_id');
    }

    public function productGroup(): BelongsTo
    {
        return $this->belongsTo(ProductGroup::class);
    }
}
