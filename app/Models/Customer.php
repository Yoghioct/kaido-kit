<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'customers';

    protected $fillable = [
        'code',
        'prefix_title',
        'full_name',
        'suffix_title',
        'specialist_id',
        'title_id',
        'is_kpdm'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function specialist()
    {
        return $this->belongsTo(Specialist::class);
    }

    public function title()
    {
        return $this->belongsTo(Title::class);
    }
}
