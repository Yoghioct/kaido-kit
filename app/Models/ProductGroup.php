<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductGroup extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'target_dfr',
        'target_profiling',
        'target_master_call_list',
    ];

    public function teamAffiliations(): HasMany
    {
        return $this->hasMany(TeamAffiliation::class);
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_affiliations');
    }

    public function productSubGroups(): HasMany
    {
        return $this->hasMany(ProductSubGroup::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function indications(): HasMany
    {
        return $this->hasMany(ProductIndication::class);
    }

    public function competitors(): HasMany
    {
        return $this->hasMany(ProductCompetitor::class);
    }

    public function keyMessages(): HasMany
    {
        return $this->hasMany(ProductKeyMessage::class);
    }
}
