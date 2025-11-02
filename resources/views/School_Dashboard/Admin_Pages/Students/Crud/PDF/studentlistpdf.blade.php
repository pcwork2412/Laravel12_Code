<table border="1" cellspacing="0" cellpadding="6" width="100%">
    <thead>
        <tr style="background-color:#ddd;">
            <th>Student ID</th>
            <th>Student Name</th>
            <th>Class</th>
            <th>Section</th>
            <th>Father</th>
            <th>Mobile</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $s)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $s->student_name }}</td>
            <td>{{ $s->promoted_class_name }}</td>
            <td>{{ $s->section }}</td>
            <td>{{ $s->father_name }}</td>
            <td>{{ $s->father_mobile }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
