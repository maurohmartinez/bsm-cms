@extends(backpack_view('layouts.horizontal_overlap'))

@section('content')
    <h3>{{ \Illuminate\Support\Facades\Auth::guard(\App\Models\Student::GUARD)->user()->name }}</h3>
    <div class="page-body animated fadeIn">
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
                                    $totalAttendanceCount = \Illuminate\Support\Facades\Auth::guard(\App\Models\Student::GUARD)->user()->attendance()
                                        ->whereHas('lesson', function (\Illuminate\Database\Eloquent\Builder $query) use ($subject) {
                                            $query->where('subject_id', $subject->id);
                                        })->count();
                                    $grade = \Illuminate\Support\Facades\Auth::guard(\App\Models\Student::GUARD)->user()->grades()->where('subject_id', $subject->id)->first();
                                    $attendanceGrade = \App\Services\SubjectService::calculateAttendanceGrade($totalAttendanceCount, $subject->hours);
                                    $finalGrade = $grade?->exam && $grade?->participation
                                        ? \App\Services\SubjectService::calculateFinalGrade($grade->exam, $grade->participation, $attendanceGrade)
                                        : null;
                                    $gradeClassText = $finalGrade
                                        ? ($finalGrade >= 60 ? 'success' : 'danger')
                                        : 'muted';
                                @endphp
                                <tr>
                                    <td>{{ $subject->name }}</td>
                                    <td>{{ $subject->teacher->name }}</td>
                                    <td>{{ $totalAttendanceCount }}/{{ $subject->hours }} <small class="text-muted">|</small> {{ $attendanceGrade }}%</td>
                                    <td>
                                        @if($subject->is_pass_fail)
                                            {{ $grade?->participation === 100 ? 'Passed' : 'Failed' }}
                                        @else
                                            {{ $grade?->participation ?? '-' }}<small class="text-muted">/100</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($subject->is_pass_fail)
                                            {{ $grade?->exam === 100 ? 'Passed' : 'Failed' }}
                                        @else
                                            {{ $grade?->exam ?? '-' }}<small class="text-muted">/100</small>
                                        @endif
                                    </td>
                                    <td class="fw-bold text-{{ $gradeClassText }}">{{ $grade?->exam && $grade?->participation ? $finalGrade : '-' }}<small class="text-muted">/100</small></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
