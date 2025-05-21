<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerAffiliation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'customer_affiliations';

    protected $fillable = [
        'customer_id',
        'branch_id',
        'outlet_id'
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }
}
