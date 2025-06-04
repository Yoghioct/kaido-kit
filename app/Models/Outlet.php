<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cheesegrits\FilamentGoogleMaps\Concerns\InteractsWithMaps;

class Outlet extends Model
{
    use HasFactory, SoftDeletes, InteractsWithMaps;

    protected $table = 'outlets';

    protected $fillable = [
        'code',
        'name',
        'address',
        'lat',
        'long',
        'state',
        'city',
        'district',
        'subdistrict',
        'zip',
        'outlet_group_id'
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $appends = ['location'];

    public function getLocationAttribute(): array
    {
        return [
            'lat' => (float) $this->lat,
            'lng' => (float) $this->long,
        ];
    }

    // Mutator computed 'location'
    public function setLocationAttribute(?array $location): void
    {
        if (is_array($location)) {
            $this->attributes['lat']  = $location['lat'];
            $this->attributes['long'] = $location['lng'];
        }
    }

    // Nama atribut computed untuk Filament Google Maps
    public static function getComputedLocation(): string
    {
        return 'location';
    }

    // Kolom lat & long
    public static function getLatLngAttributes(): array
    {
        return [
            'lat'  => 'lat',
            'long' => 'long',
        ];
    }

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
