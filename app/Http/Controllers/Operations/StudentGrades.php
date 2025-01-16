<?php

namespace App\Http\Controllers\Operations;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Prologue\Alerts\Facades\Alert;

trait StudentGrades
{
    protected function setupGradesRoutes(string $segment, string $routeName, string $controller): void
    {
        Route::get($segment . '/{id}/students-grades/', [
            'as' => $routeName . '.studentsGrades',
            'uses' => $controller . '@studentsGrades',
            'operation' => 'studentsGrades',
        ]);
        Route::post($segment . '/{id}/students-grades/', [
            'as' => $routeName . '.studentsGrades',
            'uses' => $controller . '@studentsGradesForm',
            'operation' => 'studentsGrades',
        ]);
    }

    protected function setupGradesDefaults(): void
    {
        $this->crud->allowAccess('studentsGrades');

        $this->crud->operation('studentsGrades', function () {
            $this->crud->loadDefaultOperationSettingsFromConfig();
            $this->crud->setupDefaultSaveActions();
            $this->crud->enableInlineErrors();
            $this->crud->enableGroupedErrors();
        });

        $this->crud->operation('list', function () {
            $this->crud->addButtonFromView('line', 'students_grades', 'students_grades');
        });
    }

    public function studentsGrades(int $id): View
    {
        $this->crud->hasAccessOrFail('studentsGrades');

        $id = $this->crud->getCurrentEntryId() ?? $id;

        $this->crud->registerFieldEvents();

        $this->data['entry'] = $this->crud->getEntryWithLocale($id);

        $this->crud->setOperationSetting('fields', $this->crud->getUpdateFields());

        $this->data['id'] = $id;
        $this->data['operation'] = 'studentsGrades';
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->crud->getSaveAction();
        $this->data['title'] = $this->crud->getTitle() ?? trans('backpack::crud.edit').' '.$this->crud->entity_name;

        return view('crud::inc.form_page', $this->data);
    }

    public function studentsGradesForm(): JsonResponse|RedirectResponse
    {
        $this->crud->hasAccessOrFail('studentsGrades');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        // register any Model Events defined on fields
        $this->crud->registerFieldEvents();

        // update the row in the db
        $item = $this->crud->update(
            $request->get($this->crud->model->getKeyName()),
            $this->crud->getStrippedSaveRequest($request)
        );
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }
}
