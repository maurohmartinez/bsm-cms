<?php

namespace App\Http\Controllers\Operations;

use App\Models\Subject;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;

trait Grades
{
    protected function setupGradesRoutes(string $segment, string $routeName, string $controller): void
    {
        Route::get($segment . '/{id}/grades/', [
            'as' => $routeName . '.grades',
            'uses' => $controller . '@grades',
            'operation' => 'grades',
        ]);
    }

    protected function setupGradesDefaults(): void
    {
        // Access
        $this->crud->allowAccess('grades');

        // Config
        $this->crud->operation('grades', function () {
            $this->crud->loadDefaultOperationSettingsFromConfig();
            $this->crud->enableInlineErrors();
            $this->crud->enableGroupedErrors();
        });

        $this->crud->operation('list', function () {
            $this->crud->addButtonFromView('line', 'grades', 'grades');
        });
    }

    public function grades(int $id): View
    {
        $this->crud->hasAccessOrFail('grades');

        $id = $this->crud->getCurrentEntryId() ?? $id;

        // register any Model Events defined on fields
        $this->crud->registerFieldEvents();

        $this->data['entry'] = $this->crud->getEntryWithLocale($id);
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = null;
        $this->data['title'] = $this->crud->getTitle() ?? trans('backpack::crud.edit').' '.$this->crud->entity_name;
        $this->data['id'] = $id;
        $this->data['subjects'] = Subject::query()
            ->with('teacher')
            ->where('year_id', $this->data['entry']->year_id)
            ->get();

        return view($this->crud->getEditView(), $this->data);
    }
}
