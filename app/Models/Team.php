<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function teamAffiliations(): HasMany
    {
        return $this->hasMany(TeamAffiliation::class);
    }

    public function productGroupClusters(): BelongsToMany
    {
        return $this->belongsToMany(ProductGroupCluster::class, 'team_affiliations');
    }

    // Helper method to get all product groups through clusters
    public function getAllProductGroups()
    {
        return $this->teamAffiliations->flatMap(function ($affiliation) {
            return $affiliation->productGroups;
        })->unique('id');
    }
}
