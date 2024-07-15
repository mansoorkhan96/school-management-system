<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    // use \Awobaz\Compoships\Compoships;
    use HasFactory;
    use SoftDeletes;

    public function educationLevel(): BelongsTo
    {
        return $this->belongsTo(EducationLevel::class);
    }

    public function initialEducationLevel(): BelongsTo
    {
        return $this->belongsTo(EducationLevel::class, 'initial_education_level_id');
    }

    public function previousEducationLevel(): BelongsTo
    {
        return $this->belongsTo(EducationLevel::class, 'previous_education_level_id');
    }

    // public function examination()
    // {
    //     return $this->hasMany(
    //         Examination::class,
    //         ['student_id', 'level_id'],
    //         ['id', 'level_id']
    //     )
    //         ->orderBy('subject_id');
    // }

    // public function fees() {
    //     return $this->hasMany('App\Fees');
    // }
}
