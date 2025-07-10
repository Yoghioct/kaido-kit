<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductGroupCluster extends Model
{
    use SoftDeletes;

    // add fillable
    protected $fillable = [
        'name',
        'description',
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function clusterItems(): HasMany
    {
        return $this->hasMany(ProductGroupClusterItem::class);
    }

    public function productGroups(): BelongsToMany
    {
        return $this->belongsToMany(ProductGroup::class, 'product_group_cluster_items');
    }

    public function teamAffiliations(): HasMany
    {
        return $this->hasMany(TeamAffiliation::class);
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_affiliations');
    }
}
