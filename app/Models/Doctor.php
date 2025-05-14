<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    // add fillable
    protected $fillable = [
        'code',
        'name',
        'gender',
        'status',
        'specialist_id',
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function specialist()
    {
        return $this->belongsTo(Specialist::class);
    }
}
