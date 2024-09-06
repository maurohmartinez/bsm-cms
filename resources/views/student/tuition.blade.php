@extends(backpack_view('layouts.horizontal_overlap'))

@section('content')
    <h3>{{ \Illuminate\Support\Facades\Auth::guard('students')->user()->name }}</h3>

    <h1>Paid: <span class="fw-light">EUR {{ $paid }} | </span> To pay: <span class="fw-light">EUR {{ $total - $paid }}</span></h1>

    <div class="page-body animated fadeIn">
        @if(count($transactions) > 0)
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Account</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->created_at->format('m.d.Y') }}</td>
                                        <td>{{ $transaction->amount }}</td>
                                        <td>{{ $transaction->account->value }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
