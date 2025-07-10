<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamAffiliation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'team_id',
        'product_group_cluster_id',
        'target_dfr',
        'target_profiling',
        'target_master_call_list',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function productGroupCluster(): BelongsTo
    {
        return $this->belongsTo(ProductGroupCluster::class);
    }

    // Helper method to get all product groups in this cluster
    public function getProductGroupsAttribute()
    {
        return $this->productGroupCluster?->productGroups ?? collect();
    }
}
