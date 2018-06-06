<table class="table table-borderless table-striped table-responsive-md">
    <thead>
        <tr>
            <th>Nom et prénom</th>
            <th>Etablissement</th>
            <th class="text-right">Remplacements</th>
        </tr>
    </thead>
    <tbody>
        @foreach($topUsers as $top)
            <tr>
                <td>{{$top->name}}</td>
                <td></td>
                <td class="text-right">{{$top->bookings_count}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

