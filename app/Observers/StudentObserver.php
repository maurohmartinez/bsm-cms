<?php

namespace App\Observers;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class StudentObserver
{
    public function created(Student $student): void
    {
        $this->createStudentGrade($student);
    }

    public function updated(Student $student): void
    {
        $this->createStudentGrade($student);
    }

    public function deleting(Student $student): void
    {
        $student->transactions()->delete();
        $student->attendance()->delete();

        Cache::flush();
    }

    private function createStudentGrade(Student $student): void
    {
        $student->subjects()
            ->whereDoesntHave(
                'studentGrades',
                fn (Builder $query) => $query->where('student_grades.student_id', $student->id))
            ->get()
            ->map(fn (Subject $subject) => $student->grades()->create(['subject_id' => $subject->id]));
    }
}
