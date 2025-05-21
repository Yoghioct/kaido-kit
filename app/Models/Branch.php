<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    //
    protected $table = 'branches';

    protected $fillable = [
        'name',
        'code',
        'region_id'
    ];

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }
}
