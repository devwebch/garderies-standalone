<!doctype html>
<html lang="{{ app()->getLocale() }}">
    @include('common.head')
    <body>
        @include('common.header')
        <div class="main" id="app">
            @yield('hook-vue')
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-lg-2 d-print-none">
                        @yield('nav-lateral')
                    </div>
                    <div class="col-md-9 col-lg-10">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        @include('common.footer')
        @include('common.scripts')
    </body>
</html>