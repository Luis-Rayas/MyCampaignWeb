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

    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'img_path'];

    public function volunteers() {
        return $this->hasMany(Volunteer::class);
    }

}
