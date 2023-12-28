<?php

namespace App\Livewire;

use JetBrains\PhpStorm\NoReturn;
use Livewire\Attributes\On;
use Livewire\Component;

abstract Class WireModal extends Component
{
    public string $key;

    /**
     * To show a clean transition, we set this to true when dispatching an event that will be handled by
     * another livewire component. The other livewire component is responsible for closing this model
     * using the event closeModal.{key}
     */
    public bool $isProcessing = false;

    public abstract function getKey(): string;

    public abstract function setInitialState(?array $params): void;

    public function __construct()
    {
        $this->key = $this->getKey();
    }

    #[NoReturn] #[On('openModal.{key}')]
    public function open(?array $params = []): void
    {
        $this->dispatch(event: 'openModal', modal: $this->getKey());
        $this->setInitialState($params);
    }

    /**
     * This accepts feedback type and message to display a toast message only after the modal is closed,
     * making sure it will be seen by the user and not overshadowed by the modal.
     */
    #[NoReturn] #[On('closeModal.{key}')]
    public function hide(?string $feedbackType = null, ?string $feedbackMessage = null): void
    {
        $this->dispatch(event: 'closeModal', modal: $this->getKey());

        if ($feedbackType && $feedbackMessage) {
            $this->dispatch(event: 'toast', type: $feedbackType, message: $feedbackMessage);
        }
    }

    #[NoReturn] #[On('resetModal.{key}')]
    public function clean(): void
    {
        $this->isProcessing = false;

        $this->reset();
        $this->resetErrorBag();
    }
}
