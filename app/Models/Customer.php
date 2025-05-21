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
        'customer_specialist_id',
        'customer_title_id',
        'is_kpdm'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function specialist()
    {
        return $this->belongsTo(Specialist::class, 'customer_specialist_id');
    }

    public function title()
    {
        return $this->belongsTo(Title::class, 'customer_title_id');
    }
}
