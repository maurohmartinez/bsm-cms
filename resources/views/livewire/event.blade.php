@extends('livewire.modal', ['key' => $key, 'class' => 'modal-dialog-scrollable'])

@section('modal-content-' . $key)
    <div class="modal-body">
        <form wire:submit="submit">
            @foreach($errors->all() as $error)
                <div class="alert alert-danger"><i class="la la-exclamation-circle me-2"></i>{{ $error }}</div>
            @endforeach
            @if($lesson)
                <div class="mb-3">
                    <h5 class="modal-title">{{ \App\Enums\LessonStatusEnum::translatedOption($lesson->status) }}</h5>
                    <p>
                        <strong>Time:</strong> From {{ $lesson->starts_at->isoFormat('LL') }} to {{ $lesson->ends_at->isoFormat('LL') }}
                    </p>
                    <p><strong>Period:</strong> {{ \App\Enums\PeriodEnum::translatedOption($lesson->period) }} semester
                    </p>

                    @if($isLesson)
                        <label class="fw-bold">Subject</label>
                        <select wire:model="subjectId" class="form-control">
                            <option value="">None...</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }} ({{ $subject->lessons()->year($this->lesson->year_id)->count() }}/{{ $subject->hours }}) » {{ $subject->teacher()->first()->name }}</option>
                            @endforeach
                        </select>

                        <label class="fw-bold">Status</label>
                        <select wire:model="status" class="form-control">
                            <option value="{{ \App\Enums\LessonStatusEnum::AVAILABLE->value }}">Available</option>
                            <option value="{{ \App\Enums\LessonStatusEnum::TO_CONFIRM->value }}">To confirm</option>
                            <option value="{{ \App\Enums\LessonStatusEnum::CONFIRMED->value }}">Confirmed</option>
                            <option value="{{ \App\Enums\LessonStatusEnum::SPECIAL_ACTIVITY->value }}">Special activity</option>
                        </select>

                        <label class="fw-bold mt-3">Interpreter</label>
                        <select wire:model="interpreterId" class="form-control">
                            <option value="">None...</option>
                            @foreach($interpreters as $interpreter)
                                <option value="{{ $interpreter->id }}">{{ $interpreter->name }}</option>
                            @endforeach
                        </select>
                    @else
                        <label class="fw-bold">Type</label>
                        <select wire:model="status" class="form-control">
                            @foreach(\App\Enums\LessonStatusEnum::chapelsStatuses() as $value => $status)
                                <option value="{{ $value }}">{{ $status }}</option>
                            @endforeach
                        </select>
                    @endif

                    <label class="fw-bold my-3 mb-0">Notes</label>
                    <input type="text" wire:model="notes" class="form-control">

                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <button class="btn btn-primary" type="submit">Update</button>
            @endif
        </form>
    </div>
@endsection
