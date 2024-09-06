@extends(backpack_view('layouts.horizontal_overlap'))

@section('content')
    <h3>{{ \Illuminate\Support\Facades\Auth::guard('students')->user()->name }}</h3>
    <div class="page-body animated fadeIn">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Teacher</th>
                                <th>Grade</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($subjects as $subject)
                                <tr>
                                    <td>{{ $subject->name }}</td>
                                    <td>{{ $subject->teacher->name }}</td>
                                    <td>-</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
