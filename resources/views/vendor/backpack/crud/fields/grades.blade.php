@include('crud::fields.inc.wrapper_start')
<h3>{{ $entry->name }}</h3>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Teacher</th>
                        <th>Attendance</th>
                        <th>Participation</th>
                        <th>Exam/Homework</th>
                        <th>Final Grade</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($subjects as $subject)
                        @php
                            $totalAttendanceCount = $entry->attendance()
                            ->whereHas('lesson', function (\Illuminate\Database\Eloquent\Builder $query) use ($subject) {
                                $query->where('subject_id', $subject->id);
                            })->count();
                            $grade = $entry->grades()->where('subject_id', $subject->id)->first();
                            $attendanceGrade = \App\Services\SubjectService::calculateAttendanceGrade($totalAttendanceCount, $subject->hours);
                            $finalGrade = $grade?->exam && $grade?->participation
                                ? \App\Services\SubjectService::calculateFinalGrade($grade->exam, $grade->participation, $attendanceGrade)
                                : null;
                            $gradeClassText = $finalGrade
                                ? ($finalGrade >= 60 ? 'success' : 'danger')
                                : 'muted';
                        @endphp
                        <tr>
                            <td>{{ $subject->name }} {{ json_encode($entry->toArray()) }}</td>
                            <td>{{ $subject->teacher->name }}</td>
                            <td>{{ $totalAttendanceCount }}<small class="text-muted">/{{ $subject->hours }}</small> <small class="text-muted">|</small> {{ $attendanceGrade }}%</td>
                            <td>
                                @if($entry->is_pass_fail)
                                    {{ $grade->participation === 100 ? 'Passed' : 'Failed' }}
                                @else
                                    {{ $grade?->participation ?? '-' }}<small class="text-muted">/100</small>
                                @endif
                            </td>
                            <td>
                                @if($entry->is_pass_fail)
                                    {{ $grade->exam === 100 ? 'Passed' : 'Failed' }}
                                @else
                                    {{ $grade?->exam ?? '-' }}<small class="text-muted">/100</small>
                                @endif
                            </td>
                            <td class="fw-bold text-{{ $gradeClassText }}">
                                @if($entry->is_pass_fail)
                                    {{ $finalGrade >= 60 ? 'Passed' : 'Failed' }}
                                @else
                                    {{ $grade?->exam && $grade?->participation ? $finalGrade : '-' }}<small class="text-muted">/100</small>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('crud::fields.inc.wrapper_end')
