<a href="https://bsmlatvia.lv/" target="_blank"><img src="https://bsmlatvia.lv/wp-content/uploads/2022/11/logo-bsm-1x1-1.png" width="150" alt="Laravel Logo"></a>

## About BSM CMS
This is a **C**ontrol **M**anagment **S**ystem (CMS) built for a school to help organise its main areas, which include: 

- Subjects
  - Years (since it is a one-year programme)
  - Teachers
  - Calendar
- Students (Auth)
  - Attendance
  - Tuition
  - Grades
- Bookkeeping
  - Income
  - Expenses
  - Reports

## Stack
This project uses:
- <a href="https://laravel.com/" target="_blank">Laravel</a>
- <a href="https://backpackforlaravel.com/" target="_blank">Backpack for Laravel</a>
- <a href="https://livewire.laravel.com/" target="_blank">Livewire</a>
- <a href="https://tabler.io/admin-template/preview" target="_blank">Tabler</a>

## How to install
Install all dependencies:

```shell
composer install
```

Run migrations and seeders:

```shell
php artisan migrate --seed
```

And 💣... boom! You have the application ready.

## How to use it

- To enter the Admin Panel use `/login`
- To enter the Students Panel use `/students`
