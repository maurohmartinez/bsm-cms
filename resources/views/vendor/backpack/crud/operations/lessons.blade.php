@extends(backpack_view('blank'))

@section('content')
    <div class="page-body animated fadeIn">
        <div class="row">
            <livewire:status :year-id="\Illuminate\Support\Facades\Cookie::get('calendar_year', $currentYearId)"/>
            <div class="col-12">
                <div id="lessons" class="card border-0 p-3"></div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <livewire:event/>
@endsection

@section('after_scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendar = new FullCalendar.Calendar(document.getElementById('lessons'), {
                themeSystem: 'bootstrap5',
                headerToolbar: {
                    start: 'today prev,next',
                    end: 'multiMonthYear,dayGridMonth,timeGridWeek,timeGridDay',
                    center: 'title',
                },
                views: {
                    timeGrid: {
                        dayHeaderFormat: { weekday: 'short', month: 'short', day: 'numeric', omitCommas: true },
                    },
                },
                multiMonthMaxColumns: 1,
                businessHours: [
                    {
                        daysOfWeek: [1],
                        startTime: '09:30',
                        endTime: '14:00',
                    },
                    {
                        daysOfWeek: [2, 3, 4],
                        startTime: '08:30',
                        endTime: '14:00',
                    },
                    {
                        daysOfWeek: [5],
                        startTime: '08:30',
                        endTime: '13:00',
                    },
                    {
                        daysOfWeek: [1, 2, 3, 4],
                        startTime: '19:00',
                        endTime: '21:00',
                    },
                ],
                eventMinHeight: 40,
                expandRows: true,
                selectable: false,
                nowIndicator: true,
                editable: false,
                initialView: 'timeGridWeek',
                slotMinTime: '08:30',
                slotMaxTime: '20:00',
                displayEventTime: false,
                eventSources: [
                    {
                        id: "all-lessons",
                        url: "{{ backpack_url($crud->route) }}/calendar",
                        method: 'POST',
                        extraParams: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                        },
                        failure: function () {
                            new Noty({
                                type: "danger",
                                text: 'Failed to get lessons...',
                            }).show();
                        }
                    }
                ],
                eventClick: function (info) {
                    Livewire.dispatch('openModal.event', [{id: info.event.id}]);
                },
                eventClassNames: function (arg) {
                    return ['cursor-pointer'];
                },
                eventMouseEnter: function ({event, el}) {
                    if (event.extendedProps.notes) {
                        $(el).popover({
                            // title: 'Notes',
                            placement: 'auto',
                            html: true,
                            trigger: 'hover',
                            animation: true,
                            content: event.extendedProps.notes,
                            container: $(el),
                        });
                    }
                },
            });
            calendar.render();

            document.addEventListener('livewire:initialized', () => {
                Livewire.on('refresh-calendar', () => {
                    calendar.refetchEvents();
                });
            });
        });
    </script>
@endsection
