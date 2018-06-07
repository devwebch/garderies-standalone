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
                <td><a href="{{route('users.show', $top->id)}}">{{$top->name}}</a></td>
                <td><a href="{{route('nurseries.show', $top->nursery->id)}}">{{$top->nursery->name}}</a></td>
                <td class="text-right">{{$top->bookings->count()}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

