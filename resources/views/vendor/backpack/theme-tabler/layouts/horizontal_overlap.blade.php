<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}" dir="{{ backpack_theme_config('html_direction') }}">

<head>
    @include(backpack_view('inc.head'))
</head>

<body class="{{ backpack_theme_config('classes.body') }}">

@include(backpack_view('layouts.partials.light_dark_mode_logic'))

<div class="page">
    <div class="page-wrapper">

        @includeWhen(backpack_theme_config('options.doubleTopBarInHorizontalLayouts'), backpack_view('layouts._horizontal_overlap.header_container'))

        <header data-bs-theme={{ $theme ?? 'system' }} class="{{ backpack_theme_config('classes.menuHorizontalContainer') ?? 'navbar-expand-lg top' }}">
            <div class="collapse navbar-collapse" id="navbar-menu">
                <div class="d-print-none {{ backpack_theme_config('classes.menuHorizontalContent') ?? 'navbar navbar-expand-lg navbar-'.($theme ?? 'light').' navbar-'.(($overlap ?? false) ? 'overlap' : '') }}">
                    <div class="{{ backpack_theme_config('options.useFluidContainers') ? 'container-fluid' : 'container-xl' }}">
                        <ul class="navbar-nav">
                            @unless(backpack_theme_config('options.doubleTopBarInHorizontalLayouts'))
                                <li class="nav-brand">
                                    <a class="nav-link" href="{{ url('student') }}">
                                        <img src="{{ asset('images/logo.png') }}" alt="BSM" style="max-width: 90px;">
                                    </a>
                                </li>
                            @endunless
                            @include(backpack_view('inc.student_sidebar_content'))
                        </ul>
                        @unless(backpack_theme_config('options.doubleTopBarInHorizontalLayouts'))
                            <form class="nav-link" action="{{ route('students.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger"><i class="la la-sign-out-alt me-1"></i> Logout</button>
                            </form>
                        @endunless
                    </div>
                </div>
            </div>
        </header>
        {{-- we use this here to display the mobile menu --}}
        <aside data-bs-theme={{ $theme ?? 'system' }} class="navbar navbar-expand-lg navbar-{{ $theme ?? 'light' }} d-block d-lg-none">
            <div class="container-fluid">
                <ul class="nav navbar-nav d-flex flex-row align-items-center justify-content-between w-100">
                    @include(backpack_view('layouts.partials.mobile_toggle_btn'), ['forceWhiteLabelText' => true])
                    <div class="d-flex flex-row align-items-center">
                        @include(backpack_view('inc.topbar_left_content'))
                        <li class="nav-item me-2">
                            @includeWhen(backpack_theme_config('options.showColorModeSwitcher'), backpack_view('layouts.partials.switch_theme'))
                        </li>
                        @include(backpack_view('inc.topbar_right_content'))
                        <div class="nav-item dropdown">
                            <form class="nav-link" action="{{ route('students.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger"><i class="la la-sign-out-alt me-1"></i> Logout</button>
                            </form>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                @if(config('backpack.base.setup_my_account_routes'))
                                    <a href="{{ route('backpack.account.info') }}" class="dropdown-item"><i class="la la-user me-2"></i>{{ trans('backpack::base.my_account') }}
                                    </a>
                                    <div class="dropdown-divider"></div>
                                @endif

                            </div>
                        </div>
                    </div>
                </ul>
                <div class="collapse navbar-collapse" id="mobile-menu">
                    <ul class="navbar-nav pt-lg-3">
                        @include(backpack_view('inc.student_sidebar_content'))
                    </ul>
                </div>
            </div>
        </aside>


        <div class="page-body">
            <main class="{{ backpack_theme_config('options.useFluidContainers') ? 'container-fluid' : 'container-xl' }}">

                @yield('before_breadcrumbs_widgets')
                @includeWhen(isset($breadcrumbs), backpack_view('inc.breadcrumbs'))
                @yield('after_breadcrumbs_widgets')
                @yield('header')

                <div class="container-fluid animated fadeIn">
                    @yield('before_content_widgets')
                    @yield('content')
                    @yield('after_content_widgets')
                </div>
            </main>
        </div>

        @include(backpack_view('inc.footer'))
    </div>
</div>

@yield('before_scripts')
@stack('before_scripts')

@include(backpack_view('inc.scripts'))
@include(backpack_view('inc.theme_scripts'))

@yield('after_scripts')
@stack('after_scripts')
</body>
</html>
