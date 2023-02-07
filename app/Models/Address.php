<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'street',
        'external_number',
        'internal_number',
        'suburb',
        'zipcode',
        'volunteer_id'
    ];

    public function volunteer() {
        // return $this->hasOne(Volunteer::class);
        return $this->belongsTo(Volunteer::class);
    }
}
