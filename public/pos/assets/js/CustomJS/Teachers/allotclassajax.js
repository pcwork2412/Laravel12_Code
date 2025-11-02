$(document).ready(function () {
    // Bootstrap modal instance
    const modalEl = document.getElementById("teacherAllotModal");
    const modal = new bootstrap.Modal(modalEl);

    // Initialize DataTable
    let allotTable = $("#teacherAllotTable").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/admin_teachers_allot",
            type: "GET",
            dataType: "json",
        },
        columns: [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false,
            },
            {
                data: "teacher",
                name: "teacher",
            },
            {
                data: "mainClass",
                name: "mainClass",
            },
            {
                data: "mainSection",
                name: "mainSection",
            },
              {
            data: 'view_subclass',
            name: 'view_subclass',
            orderable: false,
            searchable: false
        },
           
            {
                data: "action",
                name: "action",
                orderable: false,
                searchable: false,
            },
        ],
        responsive: true,
        language: {
            search: "Search:",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            zeroRecords: "No matching records found",
            processing: "Loading...",
        },
        order: [[1, "asc"]],
    });

    // ✅ Reset modal when closed
    $("#teacherAllotBtn").on("click", function () {
        $("#teacherAllotForm")[0].reset();
        // $('#teacherAllotForm').attr('action', '{{ route('admin_teachers_allot.store') }}');
        $('#teacherAllotForm input[name="_method"]').remove();
        $("#teacherAllotModalLabel").text("Allot Teacher");
        $("#teacherAllotForm").removeData("id"); // Clear stored ID
        modal.show();
    });

    // When class checkbox is toggled
    $(".class-checkbox").on("change", function () {
        let classId = $(this).data("class-id");
        let isChecked = $(this).is(":checked");

        let sections = $(".section-of-" + classId);
        sections.prop("disabled", !isChecked); // enable/disable sections
        sections.prop("checked", isChecked); // check/uncheck all sections
    });

    // ✅ Add / Update via AJAX
    $("#teacherAllotForm").on("submit", function (e) {
        e.preventDefault();

        let form = $(this);
        let formData = form.serialize();

        // ✅ Get ID from hidden field (or data attribute)
        let id = form.data("id"); // ya aap edit button se set kar rahe ho
        let url = id ? `/admin_teachers_allot/${id}` : "/admin_teachers_allot";
        let method = id ? "POST" : "POST"; // always POST for AJAX, _method=PUT handle karega Laravel

        $.ajax({
            url: url,
            type: method,
            data: formData,
            beforeSend: function () {
                form.find('button[type="submit"]')
                    .prop("disabled", true)
                    .text("Processing...");
            },
            success: function (res) {
                $("#teacherAllotModal").modal("hide");
                form[0].reset();
                form.find('button[type="submit"]')
                    .prop("disabled", false)
                    .html(
                        '<i class="bi bi-check-circle-fill me-1"></i>Allot Teacher'
                    );

                Toastify({
                    text: res.message || "Saved successfully!",
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                    close: true,
                }).showToast();

                allotTable.ajax.reload(null, false);
            },
            error: function (xhr) {
                form.find('button[type="submit"]')
                    .prop("disabled", false)
                    .text("Allot Teacher");
                Toastify({
                    text: xhr.responseJSON?.message || "Something went wrong!",
                    duration: 4000,
                    gravity: "top",
                    position: "right",
                    background: "linear-gradient(to right, #ff5f6d, #ffc371)",
                    close: true,
                }).showToast();
            },
        });
    });

    // ✅ Edit button click → fetch record & open modal
    $(document).on("click", ".editTAllotBtn", function () {
        let id = $(this).data("id");

        // ✅ store the ID in the form data attribute
        $("#teacherAllotForm").data("id", id);

        $.get(`/admin_teachers_allot/${id}/edit`, function (res) {
            if (res) {
                $("#teacherAllotModalLabel").text("Edit Allotment");

                // ✅ Add _method=PUT if not present
                if (!$('#teacherAllotForm input[name="_method"]').length) {
                    $("#teacherAllotForm").append(
                        '<input type="hidden" name="_method" value="PUT">'
                    );
                }

                // Populate single select dropdowns
                $('[name="teacher_id"]').val(res.teacher_id).trigger("change");

                // Set main class and trigger change to load sections
                $('[name="main_class_id"]')
                    .val(res.main_class_id)
                    .trigger("change");

                if (res.main_class_id) {
                    $.get(
                        "/get-global-sections/" + res.main_class_id,
                        function (data) {
                            let options =
                                '<option value="">Select Section</option>';
                            data.forEach((section) => {
                                options += `<option value="${section.id}" class="p-2 rounded-1">${section.section_name}</option>`;
                            });
                            $(".globalSectionSelect").html(options);

                            // ✅ Set selected main section
                            $('[name="main_section_id"]')
                                .val(res.main_section_id)
                                .trigger("change");
                        }
                    );
                }

                // Populate multiple selects
                $('[name="sub_class_ids[]"]')
                    .val(res.sub_class_ids)
                    .trigger("change");
                $('[name="sub_section_ids[]"]')
                    .val(res.sub_section_ids)
                    .trigger("change");

                $("#teacherAllotModal").modal("show");
            }
        }).fail(function () {
            Toastify({
                text: "Failed to fetch record!",
                duration: 4000,
                gravity: "top",
                position: "right",
                background: "linear-gradient(to right, #ff5f6d, #ffc371)",
                close: true,
            }).showToast();
        });
    });

    // 📌 View Allotted Data (Modal Open)
    $(document).on("click", ".allotedDataShowModalBtn", function () {
        let id = $(this).data("id");

        // Loader दिखाओ
        $("#allotedCardsContainer").html(
            `<div class='text-center text-muted py-4'>Loading data...</div>`
        );

        $.ajax({
            url: `/admin_teachers_allot/${id}`,
            type: "GET",
            success: function (data) {
                if (data.error) {
                    alert(data.error);
                    return;
                }

                // Header
                $("#teacherNameText").text(data.teacher_name);
                $("#totalClassesText").text(data.total_classes);
                $("#totalSectionsText").text(data.total_sections);
                $("#totalTeachersText").text(data.total_students);

                // Cards बनाओ
                let html = "";
                if (data.classes.length > 0) {
                    data.classes.forEach((cls) => {
                        let sectionList = "";

                        if (cls.sections && cls.sections.length > 0) {
                            cls.sections.forEach((sec) => {
                                sectionList += `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fa fa-caret-right text-primary me-2"></i> ${sec.section_name}</span>
                        <span class="badge bg-secondary">${sec.students_count} Students</span>
                    </li>`;
                            });
                        } else {
                            sectionList = `<li class="list-group-item text-muted text-center">No sections allotted</li>`;
                        }

                        html += `
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-primary text-white fw-bold">
                        <i class="fa fa-chalkboard me-2"></i> ${cls.class_name}
                    </div>
                    <ul class="list-group list-group-flush">
                        ${sectionList}
                    </ul>
                </div>
            </div>`;
                    });
                } else {
                    html = `<div class='text-center text-muted py-4'>No sub classes allotted.</div>`;
                }

                $("#allotedCardsContainer").html(html);

                $("#allotedDataShowModal").modal("show");
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert("Something went wrong!");
            },
        });
    });

    // 🔹 Set CSRF token globally for all AJAX requests
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    // 🗑️ Delete Function with SweetAlert2
    $(document).on("click", ".deleteTAllotBtn", function () {
        let id = $(this).data("id");

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
            showLoaderOnConfirm: true,
             allowOutsideClick: () => !Swal.isLoading(),
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin_teachers_allot/${id}`,
                    type: "DELETE",
                    success: function (res) {
                        if (res.status === "success") {
                            Swal.fire("Deleted!", res.message, "success");
                            allotTable.ajax.reload(null, false);
                            $("#teacherAllotForm")[0].reset();
                        } else {
                            Swal.fire(
                                "Error!",
                                "Something went wrong!",
                                "error"
                            );
                        }
                    },
                    error: function (err) {
                        Swal.fire("Error!", "Something went wrong!", "error");
                    },
                });
            }
        });
    });
});
