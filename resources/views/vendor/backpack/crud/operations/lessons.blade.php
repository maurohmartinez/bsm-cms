@extends(backpack_view('blank'))

@section('content')
    <div class="page-body animated fadeIn">
        <div class="row">
            <div class="container-xl">
                <div id="lessons" class="card border-0 p-3"></div>
            </div>
        </div>
    </div>
@endsection

@section('after_scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendar = new FullCalendar.Calendar(document.getElementById('lessons'), {
            themeSystem: 'bootstrap5',
            headerToolbar: {
                start: 'today prev,next',
                end: 'dayGridMonth,timeGridWeek,timeGridDay',
                center: 'title',
            },
            businessHours: [
                {
                    daysOfWeek: [1, 2, 3, 4, 5],
                    startTime: '08:30',
                    endTime: '14:00',
                },
                {
                    daysOfWeek: [1, 2, 3, 4, 5],
                    startTime: '19:00',
                    endTime: '21:00',
                },
            ],
            eventMinHeight: 40,
            expandRows: true,
            select: function (info) {
                Livewire.dispatch('new-event', { start: info.startStr });
            },
            selectable: true,
            nowIndicator: true,
            editable: false,
            initialView: 'timeGridWeek',
            slotMinTime: '08:30',
            slotMaxTime: '20:00',
            eventSources: [
                {
                    id: "all-lessons",
                    url: "{{ backpack_url($crud->route) }}",
                    method: 'POST',
                    extraParams: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    failure: function() {
                        new Noty({
                            type: "danger",
                            text: 'Failed to get lessons...',
                        }).show();
                    }
                }
            ],
            eventClick: function (info) {
                Livewire.dispatch('show-event', { id: info.event.id });
            },
            eventClassNames: function(arg) {
                if (arg.event.extendedProps.archived_at != null) {
                    return [ 'text-decoration-line-through' ]
                } else {
                    return [ '' ]
                }
            },
        });
        calendar.render();
    });
</script>
@endsection
