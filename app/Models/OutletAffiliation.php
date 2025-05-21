<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OutletAffiliation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'outlet_affiliations';

    protected $fillable = [
        'outlet_id',
        'branch_id'
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
