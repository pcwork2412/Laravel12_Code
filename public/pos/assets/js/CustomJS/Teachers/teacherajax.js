$(document).ready(function () {
    // ✅ CSRF for all AJAX requests
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    // Datatable
    let teacherTable = $("#teacherTable").DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#teacherTable").data("url"), // Example: data-url="{{ route('teachers.index') }}"
        columns: [
                    { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
            {
                data: "image",
                name: "image",
                orderable: false,
                searchable: false,
            },
            { data: "teacher_name", name: "teacher_name" },
            // { data: "role", name: "role" },
            { data: "status", name: "status" },
            // { data: "dob", name: "dob" },
            // { data: "gender", name: "gender" },
            // { data: "email", name: "email" },
            { data: "mobile", name: "mobile" },
            { data: "qualification", name: "qualification" },
            { data: "experience", name: "experience" },
            {
                data: "documents",
                name: "documents",
                orderable: false,
                searchable: false,
            },
            {
                data: "actions",
                name: "actions",
                orderable: false,
                searchable: false,
            },
        ],
        order: [[2, "asc"]],
        responsive: true,
    });
  // Select All functionality
$('#select_all').on('click', function () {
    $('.staff_checkbox').prop('checked', this.checked);
});

// Uncheck master if any checkbox unchecked
$(document).on('click', '.staff_checkbox', function () {
    $('#select_all').prop('checked', $('.staff_checkbox:checked').length === $('.staff_checkbox').length);
});

// Bulk action based on dropdown
$('#entries').on('change', function () {
    var action = $(this).val();
    var selected = $('.staff_checkbox:checked').map(function () {
        return $(this).val();
    }).get();

    if (action === 'Delete') {

        if (selected.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Staff Selected',
                text: 'Please select at least one staff member to delete.',
                confirmButtonColor: '#3085d6'
            });
            $(this).val('Select Action'); // Reset dropdown
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to delete ' + selected.length + ' staff members. This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/staff/bulk-delete",
                    type: "POST",
                    data: {
                        ids: selected,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message,
                                confirmButtonColor: '#3085d6'
                            });
                    teacherTable.ajax.reload(null, false);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message || 'Something went wrong.',
                                confirmButtonColor: '#3085d6'
                            });
                        }
                        $('#entries').val('Select Action'); // Reset dropdown
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error!',
                            text: 'Something went wrong on the server. Please try again.',
                            confirmButtonColor: '#3085d6'
                        });
                        $('#entries').val('Select Action'); // Reset dropdown
                    }
                });
            } else {
                $('#entries').val('Select Action'); // Reset dropdown
            }
        });
    }
});


    // ✅ Bootstrap modal instance
    const modalEl = document.getElementById("addTeacherModal");
    const modal = new bootstrap.Modal(modalEl);

    // ✅ Add button click
    $("#addTeacherBtn").on("click", function () {
        $("#teacherForm")[0].reset();
        $(".modal-title").html(
            `<i class="bi bi-person-plus-fill me-2"></i>Add New Teacher`
        );
        $("#teacher_id").val("");
        $("#previewImage").attr("src", "").hide();
        $("#previewBox").hide();
        $("#saveBtn")
            .prop("disabled", false)
            .html('<i class="bi bi-save"></i> Save');
        modal.show();
    });

    // ✅ Image Preview
    $("#image").on("change", function (e) {
        let file = e.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function (event) {
                $("#previewImage").attr("src", event.target.result);
                $("#previewBox").show();
            };
            reader.readAsDataURL(file);
        } else {
            $("#previewBox").hide();
            $("#previewImage").attr("src", "");
        }
    });

    // ✅ Submit (create/update) for Teacher
    $("#teacherForm").on("submit", function (e) {
        e.preventDefault();

        let id = $("#teacher_id").val();
        let formData = new FormData(this);
        if (id) formData.append("_method", "PUT");

        $("#saveBtn")
            .prop("disabled", true)
            .html(id ? "Updating..." : "Saving...");

        $.ajax({
            url: id ? `/teachers/${id}` : "/teachers",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            success: function (response) {
                $("#saveBtn").prop("disabled", false).html("Save");
                Swal.fire("Success", response.message, "success");
                // ✅ index page ke liye
                if (typeof teacherTable !== "undefined") {
                    teacherTable.ajax.reload(null, false);
                }
                
                // ✅ show page ke liye (partial refresh without reload)
                if ($(".teacherProfile").length > 0) {
                    $(".teacherProfile").load(
                        location.href + " .teacherProfile > *"
                    );
                }
                if ($(".tecaherProCard").length > 0) {
                    $(".tecaherProCard").load(
                        location.href + " .tecaherProCard > *"
                    );
                }
                 modal.hide();
                $("#teacherForm")[0].reset();
                $("#previewBox").hide();
                $("#previewImage").attr("src", "").hide();
            },
            error: function (xhr) {
                $("#saveBtn").prop("disabled", false).html("Save");
                let msg = "Something went wrong!";
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    msg = Object.values(xhr.responseJSON.errors)
                        .flat()
                        .join("<br>");
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                } 
                Swal.fire("Error", msg, "error");
            },
        });
    });

    // Edit button click
    $(document).on("click", ".editTeacherBtn", function () {
        let id = $(this).data("id");
        $.get(`/teachers/${id}/edit`, function (teacher) {
            $("#teacher_id").val(teacher.id);
            $("#teacher_name").val(teacher.teacher_name);
            $("#dob").val(teacher.dob);
            $("#gender").val(teacher.gender);
            $("#email").val(teacher.email);
            $("#mobile").val(teacher.mobile);
            $("#qualification").val(teacher.qualification);
            $("#experience").val(teacher.experience);
            $("#address").val(teacher.address);
            $("#city").val(teacher.city);
            $("#state").val(teacher.state);
            $("#pincode").val(teacher.pincode);
            $(".modal-title").html(
                `<i class="bi bi-person-plus-fill me-2"></i>Update Teacher Details`
            );

            modal.show();
            // Image Preview Logic
               // 🔹 अब थोड़ा delay दो ताकि modal DOM में render हो जाए
        setTimeout(() => {
            if (teacher.image) {
                let imageUrl = `/storage/${teacher.image}`;
                $("#previewImage").attr("src", imageUrl).show();
                $("#previewBox").show();
            } else {
                $("#previewImage").attr("src", "").hide();
                $("#previewBox").hide();
            }
        }, 150); // 150ms छोटा delay बस render timing fix करने के लिए

            $("#saveBtn").html('<i class="bi bi-save"></i> Update');
         
        }).fail(function () {
            Swal.fire("Error", "Failed to fetch teacher details.", "error");
        });
    });

    // Delete button click
    $(document).on("click", ".deleteTeacherBtn", function () {
        let id = $(this).data("id");

        Swal.fire({
            title: "Are you sure?",
            text: "This teacher will be permanently deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/teachers/${id}`,
                    type: "DELETE",
                    success: function (response) {
                        Swal.fire("Deleted!", response.message, "success");
                        teacherTable.ajax.reload(null, false);
                    },
                    error: function (xhr) {
                        let msg = "Something went wrong!";
                        if (xhr.responseJSON && xhr.responseJSON.message)
                            msg = xhr.responseJSON.message;
                        Swal.fire("Error", msg, "error");
                    },
                });
            }
        });
    });
});
