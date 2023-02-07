<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'section',
        'new',
        'state_id',
        'municipality_id',
        'federal_district_id',
        'local_district_id',
    ];

    public function state() {
        return $this->belongsTo(State::class);
    }

    public function federalDistrict() {
        return $this->belongsTo(FederalDistrict::class);
    }

    public function localDistrict() {
        return $this->belongsTo(LocalDistrict::class);
    }

    public function municipality() {
        return $this->belongsTo(Municipality::class);
    }

    public function volunteers() {
        return $this->hasMany(Volunteer::class);
    }
}
