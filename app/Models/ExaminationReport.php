<?php

namespace App\Models;

use App\Enums\ExaminationReportType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExaminationReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'subject_id',
        'education_level_id',
        'type',
        'year',
        'obtained_marks',
    ];

    protected function casts(): array
    {
        return [
            'type' => ExaminationReportType::class,
            'year' => 'integer',
            'obtained_marks' => 'integer',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function educationLevel(): BelongsTo
    {
        return $this->belongsTo(EducationLevel::class);
    }
}
