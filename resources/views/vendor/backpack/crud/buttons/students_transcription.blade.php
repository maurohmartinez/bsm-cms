@if ($crud->hasAccess('studentTranscription'))
    <a href="{{ route('student.studentTranscription', $entry->getKey()) }}" class="btn btn-sm btn-link" target="_blank">
        <i class="la la-file-excel"></i> <span>Transcription</span>
    </a>
@endif
