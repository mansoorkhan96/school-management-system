<?php

namespace App\Models;

use App\Enums\FeesType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fees extends Model
{
    use HasFactory;

    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'date',
        'payment_date' => 'date',
        'fee_month' => 'integer',
        'year' => 'integer',
        'type' => FeesType::class,
    ];

    protected static function booted()
    {
        static::saving(function (Fees $fees) {
            if (empty($fees->education_level_id)) {
                $fees->education_level_id = $fees->student->education_level_id;
            }
        });
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function educationLevel(): BelongsTo
    {
        return $this->belongsTo(EducationLevel::class);
    }

    public function getIsPaidAttribute(): bool
    {
        return ! is_null($this->payment_date);
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->due_date && $this->due_date->isPast() && ! $this->is_paid;
    }

    public function getMonthNameAttribute(): ?string
    {
        if (! $this->fee_month) {
            return null;
        }

        return now()->month($this->fee_month)->format('F');
    }
}
