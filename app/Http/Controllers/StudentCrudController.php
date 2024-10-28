<?php

namespace App\Http\Controllers;

use App\Enums\LanguageLevelsEnum;
use App\Enums\LanguagesEnum;
use App\Models\Year;
use App\Services\UserService;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SubjectCrudController
 *
 * @property-read CrudPanel $crud
 */
class StudentCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \App\Http\Controllers\Operations\PasswordOperation;

    public function setup(): void
    {
        CRUD::setModel(\App\Models\Student::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/student');
        CRUD::setEntityNameStrings('student', 'students');

        if (!UserService::hasAccessTo('students')) {
            $this->crud->denyAllAccess();
        }
    }

    protected function setupListOperation(): void
    {
        CRUD::filter('year')
            ->type('dropdown')
            ->values(Year::all()->pluck('name', 'id')->toArray())
            ->whenActive(fn (int $value) => CRUD::addBaseClause('where', 'year_id', $value));

        CRUD::column('name');
        CRUD::column('year');
        CRUD::column('email');
        CRUD::column('tuition')->label('To pay');
        CRUD::column('country_city');
        CRUD::column('birth');
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(\App\Http\Requests\StudentRequest::class);

        CRUD::field('name');
        CRUD::field('year')->size(6);
        CRUD::field('email')->size(6);
        CRUD::field('languages')->type('repeatable')->subfields([
            [
                'name' => LanguagesEnum::LATVIAN->value,
                'label' => 'Latvian',
                'type' => 'select_from_array',
                'options' => [
                    LanguageLevelsEnum::NONE->value => LanguageLevelsEnum::NONE->value,
                    LanguageLevelsEnum::A1->value => LanguageLevelsEnum::A1->value,
                    LanguageLevelsEnum::A2->value => LanguageLevelsEnum::A2->value,
                    LanguageLevelsEnum::B1->value => LanguageLevelsEnum::B1->value,
                    LanguageLevelsEnum::B2->value => LanguageLevelsEnum::B2->value,
                    LanguageLevelsEnum::C1->value => LanguageLevelsEnum::C1->value,
                    LanguageLevelsEnum::C2->value => LanguageLevelsEnum::C2->value,
                ],
                'wrapper' => ['class' => 'col-4']
            ],
            [
                'name' => LanguagesEnum::ENGLISH->value,
                'label' => 'English',
                'type' => 'select_from_array',
                'options' => [
                    LanguageLevelsEnum::NONE->value => LanguageLevelsEnum::NONE->value,
                    LanguageLevelsEnum::A1->value => LanguageLevelsEnum::A1->value,
                    LanguageLevelsEnum::A2->value => LanguageLevelsEnum::A2->value,
                    LanguageLevelsEnum::B1->value => LanguageLevelsEnum::B1->value,
                    LanguageLevelsEnum::B2->value => LanguageLevelsEnum::B2->value,
                    LanguageLevelsEnum::C1->value => LanguageLevelsEnum::C1->value,
                    LanguageLevelsEnum::C2->value => LanguageLevelsEnum::C2->value,
                ],
                'wrapper' => ['class' => 'col-4']
            ],
            [
                'name' => LanguagesEnum::RUSSIAN->value,
                'label' => 'Russian',
                'type' => 'select_from_array',
                'options' => [
                    LanguageLevelsEnum::NONE->value => LanguageLevelsEnum::NONE->value,
                    LanguageLevelsEnum::A1->value => LanguageLevelsEnum::A1->value,
                    LanguageLevelsEnum::A2->value => LanguageLevelsEnum::A2->value,
                    LanguageLevelsEnum::B1->value => LanguageLevelsEnum::B1->value,
                    LanguageLevelsEnum::B2->value => LanguageLevelsEnum::B2->value,
                    LanguageLevelsEnum::C1->value => LanguageLevelsEnum::C1->value,
                    LanguageLevelsEnum::C2->value => LanguageLevelsEnum::C2->value,
                ],
                'wrapper' => ['class' => 'col-4']
            ]
        ])
            ->init_rows(1)
            ->min_rows(1)
            ->max_rows(1);
        CRUD::field('country')->size(4);
        CRUD::field('city')->size(4);
        CRUD::field('birth')->size(4)->type('date_picker');
        CRUD::field('personal_code')->size(6);
        CRUD::field('passport')->size(6);
        CRUD::field('images')->type('upload_multiple')->withFiles(true);
    }

    protected function setupPasswordOperation(): void
    {
        CRUD::setValidation(\App\Http\Requests\PasswordRequest::class);
        CRUD::field('password');
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }
}
