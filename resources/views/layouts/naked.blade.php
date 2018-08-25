<!doctype html>
<html lang="{{ app()->getLocale() }}">
    @include('common.head')
    <body>
        <div class="wrapper" id="app">
            <div class="main">
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
        </div>
        @include('common.scripts')
    </body>
</html>