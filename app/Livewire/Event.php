<?php

namespace App\Livewire;

use App\Enums\LessonStatusEnum;
use App\Models\Interpreter;
use App\Models\Lesson;
use App\Models\Subject;
use Exception;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\NoReturn;

class Event extends WireModal
{
    public ?Lesson $lesson = null;

    public ?Collection $subjects;

    public ?Collection $interpreters;

    public ?string $notes = '';

    public ?int $subjectId;

    public ?int $interpreterId = null;

    public ?string $status;

    public ?bool $isLesson;

    public function getKey(): string
    {
        return 'event';
    }

    #[NoReturn] public function submit(): void
    {
        match ($this->isLesson) {
            true => $this->updateRegularLesson(),
            default => $this->updateChapel(),
        };
    }

    #[NoReturn] private function updateRegularLesson(): void
    {
        $this->validate([
            'subjectId' => 'required|exists:subjects,id',
            'interpreterId' => 'sometimes|nullable|exists:interpreters,id',
            'status' => 'required|in:' . implode(',', $this->subjectId
                    ? [
                        LessonStatusEnum::TO_CONFIRM->value,
                        LessonStatusEnum::CONFIRMED->value,
                    ] : [LessonStatusEnum::AVAILABLE->value]),
            'notes' => 'sometimes|nullable|max:1000',
        ]);

        try {
            $this->lesson->update([
                'subject_id' => $this->subjectId,
                'interpreter_id' => $this->interpreterId,
                'status' => $this->status,
                'extras' => ['notes' => $this->notes],
            ]);
        } catch (Exception $e) {
            $this->addError('toast', $e->getMessage());

            return;
        }

        $this->isProcessing = true;

        $this->dispatch('toast', type: 'success', message: 'Done!');
        $this->dispatch('refresh-calendar');
        $this->hide();
    }

    #[NoReturn] private function updateChapel(): void
    {
        $this->validate([
            'status' => 'required|in:' . implode(',', array_keys(LessonStatusEnum::chapelsStatuses())),
            'notes' => 'sometimes|nullable|max:1000',
        ]);

        try {
            $this->lesson->update([
                'status' => $this->status,
                'extras' => ['notes' => $this->notes],
            ]);
        } catch (Exception $e) {
            $this->addError('toast', $e->getMessage());

            return;
        }

        $this->isProcessing = true;

        $this->dispatch('toast', type: 'success', message: 'Done!');
        $this->dispatch('refresh-calendar');
        $this->hide();
    }

    public function setInitialState(?array $params): void
    {
        $this->lesson = Lesson::query()->findOrFail($params['id']);
        $this->isLesson = !in_array($this->lesson->status->value, array_keys(LessonStatusEnum::chapelsStatuses()));
        $this->status = $this->lesson->status->value;
        $this->subjects = Subject::query()
            ->where('year_id', $this->lesson->year_id)
            ->get()
            ->filter(function (Subject $subject) {
                return $subject->selected_hours < $subject->hours;
            });
        $this->interpreters = Interpreter::query()
            ->where('year_id', $this->lesson->year_id)
            ->get();

        $this->subjectId = $this->lesson->subject_id;
        $this->interpreterId = $this->lesson->interpreter_id;
        $this->notes = $this->lesson->extras['notes'] ?? '';
    }
}
