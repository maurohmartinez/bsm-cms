<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentAttendance extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;

    protected $table = 'student_attendance';

    protected $fillable = [
        'student_id',
        'lesson_id',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function scopeStudent(Builder $query, Student $student): Builder
    {
        return $query->where('student_id', $student->id);
    }
}
