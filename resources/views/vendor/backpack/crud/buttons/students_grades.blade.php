@if ($crud->hasAccess('studentsGrades'))
    <a href="{{ route('subject.studentsGrades', ['id' => $entry->id]) }}" class="btn btn-link btn-sm"><i class="la la-list-alt"></i> Grades</a>
@endif
