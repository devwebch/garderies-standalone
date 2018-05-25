<nav class="nav-lateral">
    <ul>
        <li>
            <a href="{{route('users.index')}}"><i class="fas fa-users icon"></i> Employees</a>
        </li>
        <li class="d-none">
            <a href="{{route('users.create')}}"><i class="fas fa-plus icon"></i> Add</a>
        </li>
        <li>
            <a href="{{route('users.bookings', 1)}}"><i class="fas fa-address-book icon"></i> Bookings</a>
        </li>
    </ul>
</nav>
