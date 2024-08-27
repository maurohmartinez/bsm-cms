{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('lesson') }}/calendar">
        <i class="la la-calendar nav-icon"></i> Calendar
    </a>
</li>
@includeWhen(class_exists(\Backpack\DevTools\DevToolsServiceProvider::class), 'backpack.devtools::buttons.sidebar_item')

<x-backpack::menu-item title="Lessons" icon="la la-list" :link="route('lesson.index')"/>
<x-backpack::menu-item title="Users" icon="la la-user" :link="route('user.index')"/>
<x-backpack::menu-item title="Years" icon="la la-calendar" :link="route('year.index')"/>
<x-backpack::menu-item title="Teachers" icon="la la-users" :link="route('teacher.index')"/>
<x-backpack::menu-item title="Subjects" icon="la la-chalkboard-teacher" :link="route('subject.index')"/>
<x-backpack::menu-item title="Subject categories" icon="la la-list" :link="route('subject-category.index')"/>

<x-backpack::menu-dropdown title="Bookkeeping" icon="la la-wallet">
    <x-backpack::menu-dropdown-item title="Movements" icon="la la-euro-sign" :link="route('bookkeeping.index')" />
    <x-backpack::menu-dropdown-item title="Categories" icon="la la-list" :link="route('bookkeeping-category.index')" />
    <x-backpack::menu-dropdown-item title="Customers" icon="la la-user-friends" :link="route('customer.index')" />
    <x-backpack::menu-dropdown-item title="Vendors" icon="la la-dolly-flatbed" :link="route('vendor.index')" />
</x-backpack::menu-dropdown>

<x-backpack::menu-item title='Logs' icon='la la-terminal' :link="backpack_url('log')"/>

