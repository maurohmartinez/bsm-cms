{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('lesson') }}/calendar">
        <i class="la la-calendar nav-icon"></i> Calendar
    </a>
</li>
@includeWhen(class_exists(\Backpack\DevTools\DevToolsServiceProvider::class), 'backpack.devtools::buttons.sidebar_item')

@if(\App\Services\UserService::hasAccessTo('lessons'))
<x-backpack::menu-item title="Lessons" icon="la la-list" :link="route('lesson.index')"/>
@endif

@if(\App\Services\UserService::hasAccessTo('admins'))
<x-backpack::menu-item title="Admins" icon="la la-user" :link="route('admin.index')"/>
@endif

@if(\App\Services\UserService::hasAccessTo('years'))
<x-backpack::menu-item title="Years" icon="la la-calendar" :link="route('year.index')"/>
@endif

@if(\App\Services\UserService::hasAccessTo('students'))
<x-backpack::menu-item title="Students" icon="la la-school" :link="route('student.index')"/>
@endif

@if(\App\Services\UserService::hasAccessTo('teachers'))
<x-backpack::menu-item title="Teachers" icon="la la-users" :link="route('teacher.index')"/>
@endif

@if(\App\Services\UserService::hasAccessTo('subjects'))
<x-backpack::menu-item title="Subjects" icon="la la-chalkboard-teacher" :link="route('subject.index')"/>
<x-backpack::menu-item title="Subject categories" icon="la la-list" :link="route('subject-category.index')"/>
@endif

@if(\App\Services\UserService::hasAccessTo('bookkeeping'))
<x-backpack::menu-dropdown title="Bookkeeping" icon="la la-wallet">
    <x-backpack::menu-dropdown-item title="Transactions" icon="la la-euro-sign" :link="route('transaction.index')" />
    <x-backpack::menu-dropdown-item title="Categories" icon="la la-list" :link="route('transaction-category.index')" />
    <x-backpack::menu-dropdown-item title="Customers" icon="la la-user-friends" :link="route('customer.index')" />
    <x-backpack::menu-dropdown-item title="Vendors" icon="la la-dolly-flatbed" :link="route('vendor.index')" />
    <x-backpack::menu-dropdown-item title="Reports" icon="la la-chart-pie" :link="route('reports.index')" />
</x-backpack::menu-dropdown>
@endif

@if(\App\Services\UserService::hasAccessTo('logs'))
<x-backpack::menu-item title='Logs' icon='la la-terminal' :link="backpack_url('log')"/>
@endif

