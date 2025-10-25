<table border="1" cellspacing="0" cellpadding="6" width="100%">
    <thead>
        <tr style="background-color:#ddd;">
            <th>Teacher Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Address</th>
            <th>Qualifications</th>
        </tr>
    </thead>
    <tbody>
        @foreach($teachers as $t)
        <tr>
            <td>{{ $t->teacher_name }}</td>
            <td>{{ $t->email }}</td>
            <td>{{ $t->mobile }}</td>
            <td>{{ $t->address }}</td>
            <td>{{ $t->qualification }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
