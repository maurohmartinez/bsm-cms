<?php

namespace App\Exports;

use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TranscriptionExport implements FromCollection, WithMapping, WithHeadings
{
    public function __construct(private readonly Student $student)
    {
    }

    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return $this->student->subjects()->with('teacher')->get();
    }

    public function map($row): array
    {
        $totalAttendanceCount = $this->student
            ->attendance()
            ->whereHas('lesson', fn (Builder $query) => $query->where('subject_id', $row->id))
            ->count();
        $grade = $this->student
            ->grades()
            ->where('subject_id', $row->id)
            ->first();
        $attendanceGrade = \App\Services\SubjectService::calculateAttendanceGrade($totalAttendanceCount, $row->hours);
        $finalGrade = $grade?->exam && $grade?->participation
            ? \App\Services\SubjectService::calculateFinalGrade($grade->exam, $grade->participation, $attendanceGrade)
            : 0;

        return [
            $row->name,
            $row->teacher->name,
            $row->hours,
            $finalGrade,
        ];
    }

    public function headings(): array
    {
        return [
            'Subject',
            'Teacher',
            'Hours',
            'Grade',
        ];
    }
}
