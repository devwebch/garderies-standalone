<!doctype html>
<html lang="{{ app()->getLocale() }}">
    @include('common.head')
    <body>
        @include('common.header')
        <div class="main" id="app">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 d-print-none">
                        @yield('nav-lateral')
                    </div>
                    <div class="col-md-9">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        @include('common.footer')
        @include('common.scripts')
    </body>
</html>