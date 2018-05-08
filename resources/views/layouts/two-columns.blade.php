<!doctype html>
<html lang="{{ app()->getLocale() }}">
    @include('common.head')
    <body>
        @include('common.header')
        <div class="main">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        @yield('content')
                    </div>
                    <div class="col-md-4">
                        @yield('sidebar')
                    </div>
                </div>
            </div>
        </div>
        @include('common.footer')
        @include('common.scripts')
    </body>
</html>