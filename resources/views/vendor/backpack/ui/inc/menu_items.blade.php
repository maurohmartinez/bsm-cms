{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('lesson') }}/calendar">
        <i class="la la-calendar nav-icon"></i> Calendar
    </a>
</li>
@includeWhen(class_exists(\Backpack\DevTools\DevToolsServiceProvider::class), 'backpack.devtools::buttons.sidebar_item')

<x-backpack::menu-item title="Lessons" icon="la la-list" :link="backpack_url('lesson')"/>
<x-backpack::menu-item title="Users" icon="la la-user" :link="backpack_url('user')"/>
<x-backpack::menu-item title="Years" icon="la la-calendar" :link="backpack_url('year')"/>
<x-backpack::menu-item title="Teachers" icon="la la-users" :link="backpack_url('teacher')"/>
<x-backpack::menu-item title="Subjects" icon="la la-chalkboard-teacher" :link="backpack_url('subject')"/>
<x-backpack::menu-item title="Subject categories" icon="la la-list" :link="backpack_url('subject-category')"/>
<x-backpack::menu-item title='Logs' icon='la la-terminal' :link="backpack_url('log')"/>

