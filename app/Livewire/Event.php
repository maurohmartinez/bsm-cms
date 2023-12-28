<?php

namespace App\Livewire;

use App\Models\Lesson;

class Event extends WireModal
{
    public ?Lesson $lesson = null;

    public function getKey(): string
    {
        return 'event';
    }

    public function resetModalState(): void
    {
    }

    public function setInitialState(?array $params): void
    {
        $this->lesson = Lesson::findOrFail($params['id']);
    }
}
