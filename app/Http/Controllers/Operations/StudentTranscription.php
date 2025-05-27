<?php

namespace App\Http\Controllers\Operations;

use App\Exports\TranscriptionExport;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

trait StudentTranscription
{
    protected function setupStudentTranscriptionRoutes(string $segment, string $routeName, string $controller): void
    {
        Route::get($segment . '/{id}/students-transcription/', [
            'as' => $routeName . '.studentTranscription',
            'uses' => $controller . '@studentTranscription',
            'operation' => 'studentTranscription',
        ]);
    }

    protected function setupStudentTranscriptionDefaults(): void
    {
        $this->crud->allowAccess('studentTranscription');

        $this->crud->operation('studentTranscription', function () {
            $this->crud->loadDefaultOperationSettingsFromConfig();
            $this->crud->setupDefaultSaveActions();
        });

        $this->crud->operation('list', function () {
            $this->crud->addButtonFromView('line', 'students_transcription', 'students_transcription');
        });
    }

    public function studentTranscription(int $id): BinaryFileResponse
    {
        $this->crud->hasAccessOrFail('studentTranscription');

        $id = $this->crud->getCurrentEntryId() ?? $id;

        $this->crud->registerFieldEvents();

        $this->data['entry'] = $this->crud->getEntryWithLocale($id);

        $this->crud->setOperationSetting('fields', $this->crud->getUpdateFields());

        $this->data['id'] = $id;
        $this->data['crud'] = $this->crud;

        return Excel::download(new TranscriptionExport(student: $this->data['entry']), $this->data['entry']->name . '-transcription.xlsx');
    }
}
