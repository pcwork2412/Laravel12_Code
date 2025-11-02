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
    var table = $("#studentTable").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: $("#studentTable").data("url"), // URL from data attribute
            data: function (d) {
                d.class_id = $("#classFilter").val(); // pass selected class to server
            },
        },
        columns: [
            {
                data: "checkbox",
                name: "checkbox",
                orderable: false,
                searchable: false,
            },

            {
                data: "image",
                name: "image",
                orderable: false,
                searchable: false,
            },
            // { data: "student_uid", name: "student_uid" },
            { data: "student_name", name: "student_name",searchable: true },
            { data: "promoted_class_name", name: "promoted_class_name" ,searchable: true},
            { data: "section", name: "section" ,searchable: true},
            { data: "father_name", name: "father_name" },
            { data: "father_mobile", name: "father_mobile" },
            {
                data: "actions",
                name: "actions",
                orderable: false,
                searchable: false,
            },
        ],
        order: [[1, "desc"]],
        responsive: true,
        error: function (xhr) {
            console.error("DataTable Ajax Error:", xhr.responseText);
        },
    });
    

    // Reload table when class changes
    $("#classFilter").on("change", function () {
        table.ajax.reload();
    });
    // ✅ Select All functionality
    $("#select_all").on("click", function () {
        var checked = this.checked;
        $(".student_checkbox").each(function () {
            this.checked = checked;
        });
    });

    // ✅ Uncheck master if any checkbox is unchecked
    $(document).on("click", ".student_checkbox", function () {
        if (
            $(".student_checkbox:checked").length ==
            $(".student_checkbox").length
        ) {
            $("#select_all").prop("checked", true);
        } else {
            $("#select_all").prop("checked", false);
        }
    });

    // ✅ Delete Selected functionality
    $("#deleteSelected").on("click", function () {
        var selected = [];
        $(".student_checkbox:checked").each(function () {
            selected.push($(this).val());
        });

        if (selected.length === 0) {
            Swal.fire({
                icon: "warning",
                title: "No Students Selected",
                text: "Please select at least one student to delete.",
                confirmButtonColor: "#3085d6",
            });
            return;
        }

        Swal.fire({
            title: "Are you sure?",
            text:
                "You are about to delete " +
                selected.length +
                " students. This action cannot be undone!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete them!",
            cancelButtonText: "Cancel",
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !Swal.isLoading(),
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/students/bulkdelete",
                    type: "POST",
                    data: {
                        ids: selected,
                        _token: $('meta[name="csrf-token"]').attr("content"), // ✅ ensure CSRF token
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: "success",
                                title: "Deleted!",
                                text: response.message,
                                confirmButtonColor: "#3085d6",
                            });
                            table.ajax.reload(null, false); // ✅ reload DataTable
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error!",
                                text:
                                    response.message || "Something went wrong.",
                                confirmButtonColor: "#3085d6",
                            });
                        }
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: "error",
                            title: "Server Error!",
                            text: "Something went wrong on the server. Please check logs or contact admin.",
                            confirmButtonColor: "#3085d6",
                        });
                    },
                });
            }
        });
    });

    // Add button
    $("#addStudentBtn").on("click", function () {
        $("#studentForm")[0].reset();
        $(".modal-title").html(
            '<i class="bi bi-person-plus-fill me-2"></i>Add New Student'
        );
        $("#saveBtn").html('<i class="bi bi-save me-1"></i> Save Student');
        $("#student_uid").prop("readonly", false);
        $("#student_id").val("");
        $("#previewImg").attr("src", "").hide();
        $("#previewBox").hide();
        $("#saveBtn").val();
        modal.show();
    });

    $(".classSelect").on("change", function () {
        let classId = $(this).val();
        $(".sectionSelect").html("<option>Loading...</option>");
        $("#studentSelect").html("<option>Select Student</option>");
        if (classId) {
            $.get("/get-sections/" + classId, function (data) {
                let options = '<option value="">Select Section</option>';
                data.forEach((section) => {
                    options += `<option value="${section.id}">${section.section_name}</option>`;
                });
                $(".sectionSelect").html(options);
            });
        }
    });

    // Image Preview
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

    // Submit (create/update)
    $("#studentForm").on("submit", function (e) {
        e.preventDefault();

        let id = $("#student_id").val();
        let formData = new FormData(this);
        if (id) formData.append("_method", "PUT");
        if (id) {
            $("#saveBtn")
                .prop("disabled", true)
                .html('<i class="bi bi-save"></i> Updating...');
        } else {
            $("#saveBtn")
                .prop("disabled", true)
                .html('<i class="bi bi-save"></i> Saving...');
        }

        $.ajax({
            url: id ? `/students/${id}` : "/students",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (student) {
                $("#saveBtn")
                    .prop("disabled", false)
                    .html('<i class="bi bi-save"></i> Save');
                modal.hide();
                table.ajax.reload(null, false); // ✅ DataTable refresh
                Swal.fire("Success", student.message, "success");
            },
            error: function (xhr) {
                $("#saveBtn")
                    .prop("disabled", false)
                    .html('<i class="bi bi-save"></i> Save');
                let msg = "Something went wrong";
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
    // Edit button click handler (ajax) and modal show handler
    $(document).on("click", ".editStudentBtn", function () {
        let id = $(this).data("id");
        if (!id) {
            Swal.fire("Error", "Invalid student ID", "error");
            return;
        }

        $.get(`/students/${id}/edit`, function (data) {
            // Hidden id
            $("#student_id").val(data.id);

            // UID readonly
            $("#student_uid").val(data.student_uid).prop("readonly", true);

            // Class select (value should be class id)
            if (
                $(
                    '#promoted_class_name option[value="' +
                        data.promoted_class_name +
                        '"]'
                ).length === 0
            ) {
                // agar option exist nahi karti to temporary add kar do (safe fallback)
                $("#promoted_class_name").append(
                    new Option(
                        data.class_name || "Unknown",
                        data.promoted_class_name,
                        true,
                        true
                    )
                );
            } else {
                $("#promoted_class_name").val(data.promoted_class_name);
            }

            // Sections: replace options with returned sections for that class
            $(".section_name").empty();
            if (Array.isArray(data.sections) && data.sections.length) {
                $.each(data.sections, function (i, s) {
                    $(".section_name").append(new Option(s.section_name, s.id));
                });
            } else {
                // fallback agar sections empty hain (optionally keep previous)
                $(".section_name").append(
                    new Option(
                        data.section || "No sections",
                        data.section_id || ""
                    )
                );
            }

            // Set selected section id
            $(".section_name").val(data.section_id).trigger("change");

            // Other fields
            $("#student_name").val(data.student_name || " ");
            $("#dob").val(data.dob || " ");
            $("#gender").val(data.gender || " ");
            $("#father_name").val(data.father_name || " ");
            $("#mother_name").val(data.mother_name || " ");
            $("#father_mobile").val(data.father_mobile || " ");
            $("#mother_mobile").val(data.mother_mobile || " ");
            $("#email_id").val(data.email_id || " ");
            $("#aadhaar_number").val(data.aadhaar_number || " ");
            $("#guardian_name").val(data.guardian_name || " ");
            $("#father_occupation_income").val(
                data.father_occupation_income || " "
            );
            $("#present_address").val(data.present_address || " ");
            $("#permanent_address").val(data.permanent_address || " ");
            $("#local_guardian").val(data.local_guardian || " ");
            $("#state_belong").val(data.state_belong || " ");
            $("#whatsapp_mobile").val(data.whatsapp_mobile || " ");
            $("#alternate_mobile").val(data.alternate_mobile || " ");
            $("#ration_card_type").val(data.ration_card_type || " ");
            $("#physically_handicapped").val(
                data.physically_handicapped || " "
            );
            $("#blood_group").val(data.blood_group || " ");
            $("#height").val(data.height || " ");
            $("#weight").val(data.weight || " ");
            $("#account_holder_name").val(data.account_holder_name || " ");
            $("#bank_name_branch").val(data.bank_name_branch || " ");
            $("#account_number").val(data.account_number || " ");
            $("#ifsc_code").val(data.ifsc_code || " ");

            modal.show();
            // ✅ Image preview
            if (data.image) {
                let imageUrl = `/storage/${data.image}`; // storage path
                $("#previewImage").attr("src", imageUrl);
                $("#previewBox").show();
            } else {
                $("#previewBox").hide();
                $("#previewImage").attr("src", "");
            }
            // Button text + open modal
            $("#saveBtn").html(
                '<i class="bi bi-save me-1"></i> Update Student'
            );
            $(".modal-title").html(
                ' <i class="bi bi-person-plus-fill me-2"></i>Update Student Details'
            );
        }).fail(function () {
            Swal.fire("Error", "Failed to fetch student details.", "error");
        });
    });

    // Delete
    $(document).on("click", ".deleteStudentBtn", function () {
        let id = $(this).data("id");
        Swal.fire({
            title: "Are you sure?",
            text: "This will permanently delete the student.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/students/${id}`,
                    type: "DELETE",
                    success: function (res) {
                        table.ajax.reload(null, false);
                        Swal.fire("Deleted", res.message, "success");
                    },
                    error: function () {
                        Swal.fire("Error", "Delete failed", "error");
                    },
                });
            }
        });
    });

    // AJAX ke data ko print ke liye copy karna
    // ✅ Print button
    $("#printTable").on("click", function () {
        let tableData = table.rows({ search: "applied" }).data();
        let tbody = "";
        let counter = 1; // Serial number start from 1

        tableData.each(function (row) {
            tbody += `<tr>
                <td>${counter}</td>
                <td>${row.student_uid ?? ""}</td>
                <td>${row.image ?? "N/A"}</td>
                <td>${row.student_name ?? ""}</td>
                <td>${row.promoted_class_name ?? ""}</td>
                <td>${row.section ?? ""}</td>
                <td>${row.father_name ?? ""}</td>
                <td>${row.father_mobile ?? ""}</td>
            </tr>`;

            counter = counter + 1;
        });

        $("#printTableContent tbody").html(tbody);

        let printContents = document.getElementById("printableArea").innerHTML;
        let originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        // location.reload();
    });
});
