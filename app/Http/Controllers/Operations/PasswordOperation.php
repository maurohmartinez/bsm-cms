<?php

namespace App\Http\Controllers\Operations;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;

trait PasswordOperation
{
    protected function setupPasswordRoutes(string $segment, string $routeName, string $controller): void
    {
        Route::get($segment . '/{id}/password', [
            'as' => $routeName . '.password',
            'uses' => $controller . '@password',
            'operation' => 'password',
        ]);
        Route::put($segment . '/{id}/password', [
            'as' => $routeName . '.passwordPost',
            'uses' => $controller . '@passwordPost',
            'operation' => 'password',
        ]);
    }

    protected function setupPasswordDefaults(): void
    {
        // Access
        $this->crud->allowAccess('password');

        // Config
        $this->crud->operation('password', function () {
            $this->crud->loadDefaultOperationSettingsFromConfig();
            $this->crud->enableInlineErrors();
            $this->crud->enableGroupedErrors();
            $this->crud->setupDefaultSaveActions();
        });

        $this->crud->operation('list', function () {
            $this->crud->addButtonFromView('line', 'password', 'password');
        });

    }

    public function password(int $id): View
    {
        $this->crud->hasAccessOrFail('password');

        // get entry ID from Request (makes sure its last ID for nested resources)
        $id = $this->crud->getCurrentEntryId() ?? $id;

        // register any Model Events defined on fields
        $this->crud->registerFieldEvents();

        // get the info for that entry
        $this->data['entry'] = $this->crud->getEntryWithLocale($id);
        $this->crud->setOperationSetting('urlPost', route($this->crud->getRoute() . '.passwordPost', ['id' => $id]));

        $this->crud->setOperationSetting('fields', $this->crud->getUpdateFields());

        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->crud->getSaveAction();
        $this->data['title'] = $this->crud->getTitle() ?? trans('backpack::crud.edit').' '.$this->crud->entity_name;
        $this->data['id'] = $id;

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view($this->crud->getEditView(), $this->data);
    }

    public function passwordPost(): JsonResponse|RedirectResponse
    {
        $this->crud->hasAccessOrFail('password');

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
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }
}
