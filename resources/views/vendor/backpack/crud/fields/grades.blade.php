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
                        <tr>
                            <td>{{ $subject->name }}</td>
                            <td>{{ $subject->teacher->name }}</td>
                            <td>{{ $entry->attendance()
                                ->whereHas('lesson', function (\Illuminate\Database\Eloquent\Builder $query) use ($subject) {
                                    $query->where('subject_id', $subject->id);
                                })->count() }}<small class="text-muted">/{{ $subject->hours }}</small> <small class="text-muted">|</small> {{ round(($entry->attendance()
                                ->whereHas('lesson', function (\Illuminate\Database\Eloquent\Builder $query) use ($subject) {
                                    $query->where('subject_id', $subject->id);
                                })->count() * 100) / $subject->hours) }}%</td>
                            @php
                                $grade = $entry->grades()->where('subject_id', $subject->id)->first();
                            @endphp
                            <td>{{ $grade?->participation ?? '-' }}<small class="text-muted">/100</small></td>
                            <td>{{ $grade?->exam ?? '-' }}<small class="text-muted">/100</small></td>
                            <td>?<small class="text-muted">/100</small></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('crud::fields.inc.wrapper_end')
