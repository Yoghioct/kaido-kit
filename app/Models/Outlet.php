<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Outlet extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'outlets';

    protected $fillable = [
        'code',
        'name',
        'address',
        'lat',
        'long',
        'outlet_group_id'
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function outletGroup()
    {
        return $this->belongsTo(OutletGroup::class);
    }

    public function outletAffiliations()
    {
        return $this->hasMany(OutletAffiliation::class);
    }

    public function customerAffiliations()
    {
        return $this->hasMany(CustomerAffiliation::class);
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'outlet_affiliations')
            ->withTimestamps();
    }
}
