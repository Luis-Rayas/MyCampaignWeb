<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuxVolunteer extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'image_path_ine','image_path_firm'];
    protected $fillable = [
        'image_path_ine',
        'image_path_firm',
        'birthdate',
        'notes',
        'sector',
        'type_volunteer_id',
        'elector_key',
        'local_voting_booth',
        'volunteer_id'
    ];

    public function typeVolunteer()
    {
        return $this->belongsTo(TypeVolunteer::class);
    }
    public function volunteer() {
        return $this->belongsTo(Volunteer::class);
    }
}
