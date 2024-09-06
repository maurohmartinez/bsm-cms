@extends(backpack_view('layouts.horizontal_overlap'))

@section('content')
    <h3>{{ \Illuminate\Support\Facades\Auth::guard('students')->user()->name }}</h3>
    <div class="page-body animated fadeIn">
        <div class="row">
            <div class="col-12">
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
                views: {
                    timeGrid: {
                        dayHeaderFormat: { weekday: 'short'},
                    },
                },
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
                ],
                eventMinHeight: 40,
                expandRows: true,
                selectable: false,
                nowIndicator: true,
                editable: false,
                initialView: 'timeGridWeek',
                slotMinTime: '08:30',
                slotMaxTime: '14:00',
                displayEventTime: false,
                eventSources: [
                    {
                        id: "all-lessons",
                        url: "{{ url('student/get-calendar-events') }}",
                        method: 'POST',
                        extraParams: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                        },
                        failure: function (e) {
                            alert(e.message);
                        }
                    }
                ],
            });
            calendar.render();
        });
    </script>
@endsection
