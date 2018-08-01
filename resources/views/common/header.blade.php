<header class="header">
    <div class="header__top">
        <div class="container">
            <a class="brand" href="/">
                <img src="{{asset('img/logo_garderies_white.png')}}" alt="{{config('app.name')}}">
            </a>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item d-none">
                        <a class="nav-link" href="/account">Compte garderie</a>
                    </li>
                    <li class="nav-item link-networks {{\App\Http\Controllers\Controller::activeRouteClass('networks.index')}}">
                        <a class="nav-link" href="{{route('networks.index')}}"><i class="fas fa-sitemap"></i> Réseaux</a>
                    </li>
                    <li class="nav-item link-nurseries {{\App\Http\Controllers\Controller::activeRouteClass('nurseries.index')}}">
                        <a class="nav-link" href="{{route('nurseries.index')}}"><i class="fas fa-building"></i> Garderies</a>
                    </li>
                    <li class="nav-item link-users {{\App\Http\Controllers\Controller::activeRouteClass('users.index')}}">
                        <a class="nav-link" href="{{route('users.index')}}"><i class="fas fa-users"></i> Employés</a>
                    </li>
                    <li class="nav-item link-bookings {{\App\Http\Controllers\Controller::activeRouteClass('bookings.index')}}">
                        <a class="nav-link" href="{{route('booking-requests.index')}}"><i class="fas fa-user-clock"></i> Remplacements</a>
                    </li>
                    <li class="nav-item link-availabilities {{\App\Http\Controllers\Controller::activeRouteClass('availabilities.search')}}">
                        <a class="nav-link" href="{{route('availabilities.search')}}"><i class="fas fa-search"></i> Recherche</a>
                    </li>
                </ul>
            </div>

            <notifications></notifications>
        </div>
    </nav>
</header>
