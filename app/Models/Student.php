<?php

namespace App\Models;

use App\Enums\BloodGroup;
use App\Enums\Gender;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Student extends Model
{
    // use \Awobaz\Compoships\Compoships;
    use HasFactory;

    protected static function booted()
    {
        static::saving(function ($student) {
            if (blank($student->profile_photo_path) && $student->isDirty('profile_photo_path')) {
                if (Storage::disk('public')->exists($student->getOriginal('profile_photo_path'))) {
                    Storage::disk('public')->delete($student->getOriginal('profile_photo_path'));
                }
            }
        });

        static::deleting(function ($student) {
            if ($student->profile_photo_path && Storage::disk('public')->exists($student->profile_photo_path)) {
                Storage::disk('public')->delete($student->profile_photo_path);
            }
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'gender' => Gender::class,
            'blood_group' => BloodGroup::class,
            'admission_date' => 'date',
            'date_of_birth' => 'date',
            'school_leaving_date' => 'date',
            'has_disability' => 'boolean',
            'has_doctor_consultancy' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

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

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
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

    public function name(): Attribute
    {
        return Attribute::get(fn () => $this->first_name . ' ' . $this->last_name)
            ->shouldCache();
    }
}
