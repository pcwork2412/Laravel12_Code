$(document).ready(function () {
    // CSRF for all AJAX requests
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    // Bootstrap modal instance
    const modalEl = document.getElementById("addStudentModal");
    const modal = new bootstrap.Modal(modalEl);

    // DataTable init (server side)
   $(document).ready(function() {
            $('#marksTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('marks.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'student.student_uid',
                        name: 'student.student_uid',
                        defaultContent: ''
                    },
                    {
                        data: 'student_name',
                        name: 'student_name'
                    },
                    {
                        data: 'class',
                        name: 'class',
                        orderable: false,
                    },
                    {
                        data: 'exam_type',
                        name: 'exam_type'
                    },
                    {
                        data: 'max_marks',
                        name: 'max_marks'
                    },
                    {
                        data: 'obtained_marks',
                        name: 'obtained_marks'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            // Action button example events
            $(document).on('click', '.viewMarksBtn', function() {
                let id = $(this).data('id');
                alert('View marksheet ID: ' + id);
                // yaha modal open karke detail dikha sakte ho
            });

            $(document).on('click', '.editMarksBtn', function() {
                let id = $(this).data('id');
                alert('Edit marksheet ID: ' + id);
            });

            $(document).on('click', '.deleteMarksBtn', function() {
                let id = $(this).data('id');
                if (confirm('Are you sure to delete?')) {
                    $.ajax({
                        url: "/marks/" + id,
                        type: "DELETE",
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            $('#marksTable').DataTable().ajax.reload();
                        }
                    });
                }
            });
        });
});