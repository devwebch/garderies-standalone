<!doctype html>
<html lang="{{ app()->getLocale() }}">
    @include('common.head')
    <body>
        @include('common.header')
        <div class="main" id="app">
            @yield('hook-vue')
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        @include('common.footer')
        @include('common.scripts')
    </body>
</html>