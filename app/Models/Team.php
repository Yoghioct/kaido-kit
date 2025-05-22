<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function productGroups()
    {
        return $this->belongsToMany(ProductGroup::class, 'team_affiliations');
    }
}
