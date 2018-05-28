<nav class="nav-lateral">
    <ul>
        <li>
            <a href="{{route('users.index')}}"><i class="fas fa-users icon"></i> Employés</a>
        </li>
        <li class="d-none">
            <a href="{{route('users.create')}}"><i class="fas fa-plus icon"></i> Ajouter</a>
        </li>
        <li>
            <a href="{{route('users.bookings', 1)}}"><i class="fas fa-address-book icon"></i> Remplacements</a>
        </li>
    </ul>
</nav>
