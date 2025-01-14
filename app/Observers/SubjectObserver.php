<?php

namespace App\Observers;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;

class SubjectObserver
{
    public function created(Subject $subject): void
    {
        self::createStudentsGrades($subject);
    }

    public function updated(Subject $subject): void
    {
        self::createStudentsGrades($subject);
    }

    public static function createStudentsGrades(Subject $subject): void
    {
        $subject->students()
            ->whereDoesntHave(
                'grades',
                fn (Builder $query) => $query->where('student_grades.subject_id', $subject->id))
            ->get()
            ->map(fn (Student $student) => $subject->studentGrades()->create(['student_id' => $student->id]));
    }
}
