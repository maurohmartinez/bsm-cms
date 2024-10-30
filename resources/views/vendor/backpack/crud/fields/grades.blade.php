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
                        <th>Grade</th>
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
                                })->count() }}/{{ $subject->hours }} <span class="text-muted">|</span> {{ round(($entry->attendance()
                                ->whereHas('lesson', function (\Illuminate\Database\Eloquent\Builder $query) use ($subject) {
                                    $query->where('subject_id', $subject->id);
                                })->count() * 100) / $subject->hours) }}%</td>
                            <td>-</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('crud::fields.inc.wrapper_end')
