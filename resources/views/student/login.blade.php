@extends(backpack_view('layouts.auth'))

@section('content')
    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="text-center mb-4 display-6 auth-logo-container">
                <img src="{{ asset('images/logo.png') }}" alt="">
            </div>
            <div class="card card-md">
                <div class="card-body pt-0">
                    <h2 class="h2 text-center my-4">{{ trans('backpack::base.login') }}</h2>
                    <form method="POST" action="{{ route('students.login') }}" autocomplete="off" novalidate="">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="email">{{ trans('backpack::base.'.strtolower(config('backpack.base.authentication_column_name'))) }}</label>
                            <input autofocus tabindex="1" type="text" name="email" value="{{ old('email') }}" id="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}">
                            @if ($errors->has('email'))
                                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="password">
                                {{ trans('backpack::base.password') }}
                            </label>
                            <input tabindex="2" type="password" name="password" id="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" value="">
                            @if ($errors->has('password'))
                                <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-check mb-0">
                                <input name="remember" tabindex="3" type="checkbox" class="form-check-input">
                                <span class="form-check-label">{{ trans('backpack::base.remember_me') }}</span>
                            </label>
                        </div>
                        <div class="form-footer">
                            <button tabindex="5" type="submit" class="btn btn-primary w-100">{{ trans('backpack::base.login') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
