<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Volunteer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'fathers_lastname',
        'mothers_lastname',
        'email',
        'phone',
        'section_id',
        'sympathizer_id',
        'campaign_id',
    ];

    public function address() {
        return $this->hasOne(Address::class);
    }

    public function auxVolunteer() {
        return $this->hasOne(AuxVolunteer::class);
    }

    public function section() {
        return $this->belongsTo(Section::class);
    }

    public function sympathizer() {
        return $this->belongsTo(Sympathizer::class);
    }

    public function campaign() {
        return $this->belongsTo(Campaign::class);
    }
}
