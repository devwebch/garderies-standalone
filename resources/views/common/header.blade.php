<header class="header">
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="{{asset('img/logo_garderies_white.png')}}" alt="{{config('app.name')}}" style="height: 50px; width: 168px;">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item d-none">
                        <a class="nav-link" href="/account">Compte garderie</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('networks.index')}}"><i class="fas fa-sitemap"></i> Vos réseaux</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('nurseries.index')}}"><i class="fas fa-building"></i> Etablissements</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('users.index')}}"><i class="fas fa-users"></i> Employés</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('bookings.index')}}"><i class="fas fa-user-clock"></i> Remplaçements</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('users.search')}}"><i class="fas fa-search"></i> Recherche de remplaçant</a>
                    </li>
                </ul>
            </div>
            <div class="float-right text-white d-none d-lg-block">
                <a href="#" class="btn btn-link text-white" data-toggle="popover" data-placement="bottom" data-content="Il n'y a pas de notifications pour le moment." title="Vos notifications">
                    <i class="fas fa-bell"></i>
                </a>
            </div>
        </div>
    </nav>
</header>
