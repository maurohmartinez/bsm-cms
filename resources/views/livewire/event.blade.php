@extends('livewire.modal', ['key' => $key, 'class' => 'modal-dialog-scrollable'])

@section('modal-content-' . $key)
    <div class="modal-body">
        @if($lesson)
            <div class="mb-3">
                <h5 class="modal-title">{{ \App\Enums\LessonStatusEnum::translatedOption($lesson->status) }}</h5>
                <p><strong>Time:</strong> From {{ $lesson->starts_at->isoFormat('LL') }} to {{ $lesson->ends_at->isoFormat('LL') }}</p>
                <p><strong>Period:</strong> {{ \App\Enums\PeriodEnum::translatedOption($lesson->period) }} semester</p>
                <p><strong>Subject:</strong> none</p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        @endif
    </div>
@endsection
