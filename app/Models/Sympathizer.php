<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sympathizer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'authorized'
    ];

    public function user() {
        return $this->morphOne(User::class, 'userable');
    }

    public function campaigns() {
        return $this->belongsToMany(Campaign::class);
    }

    public function volunteers() {
        return $this->hasMany(Volunteer::class);
    }
}
