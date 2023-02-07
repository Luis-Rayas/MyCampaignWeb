<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'party',
        'description',
        'start_date',
        'end_date'
    ];

    public function administrators() {
        return $this->belongsToMany(Administrator::class);
    }

    public function sympathizers() {
        return $this->belongsToMany(Sympathizer::class);
    }

    public function volunteers() {
        return $this->hasMany(Volunteer::class);
    }

}
