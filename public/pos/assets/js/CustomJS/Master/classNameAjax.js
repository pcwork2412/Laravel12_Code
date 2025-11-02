// Fetch Updated class List
function fetchClass() {
    $.get(window.location.href, function (data) {
        $("#classTable").DataTable().destroy(); // Destroy existing DataTable instance
        $("#classList").html($(data).find("#classList").html());
        $("#classTable").DataTable(); // Re-initialize DataTable
    });
}
// Fetch Updated class List In Subject Form
function fetchSubject() {
    $.get(window.location.href, function (data) {
        $("#classField").html($(data).find("#classField").html());
    });
}
//! CRUD Section
$(document).ready(function () {
    // Get Modal Element
    let modal;
    modal = new bootstrap.Modal(document.getElementById("myModal"), {
        backdrop: "static",
        keyboard: false,
    });
    if (modal) {
        modal.hide();
    }
    $("#classTable").DataTable(); // Add DataTable In table
    // Open Modal to Add
    $("#createBtn").click(function () {
        $("#classForm")[0].reset();
        $("#cl_id").val("");
        $(".modal-title").text("Add Class");
        $("#saveBtn").text("Add Class").prop("disabled", false);
        modal.show();
    });

    // Submit Form (Create or Update)
    $("#classForm").on("submit", function (e) {
        e.preventDefault();

        // 🔹 Get hidden id field
        let id = $("#cl_id").val();

        // 🔹 Set URL & method
        let url = id ? `/class_name/${id}` : `/class_name`;
        let method = "POST"; // always POST, PUT will be spoofed if update

        const formData = new FormData(this);

        // 🔹 Method spoofing for update
        if (id) {
            formData.append("_method", "PUT");
        }

        // 🔹 Button feedback before submit
        let btnText = id ? "Updating..." : "Adding...";
        $("#saveBtn")
            .html(`<i class="fas fa-spinner fa-spin"></i> ${btnText}`)
            .prop("disabled", true);

        // 🔹 AJAX call
        $.ajax({
            url: url,
            type: method,
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "success",
                    title: response.message || "Success",
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true,
                });

                // 🔹 Reset form & close modal
                $("#classForm")[0].reset();
                $("#id").val(""); // clear id for next create
                $("#myModal").modal("hide");

                // 🔹 Refresh table or fetch functions
                fetchClass();
                fetchSubject();

                // 🔹 Reset button
                $("#saveBtn")
                    .html('<i class="fas fa-save"></i> Add Class')
                    .prop("disabled", false);
            },
            error: function (xhr) {
                let msg = "Something went wrong!";
                if (xhr.status === 422 && xhr.responseJSON.errors) {
                    msg = Object.values(xhr.responseJSON.errors)
                        .flat()
                        .join("\n");
                } else if (xhr.responseJSON?.message) {
                    msg = xhr.responseJSON.message;
                }

                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "error",
                    title: msg,
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                });

                // 🔹 Reset button on error
                $("#saveBtn")
                    .html('<i class="fas fa-save"></i> Add Class')
                    .prop("disabled", false);
            },
        });
    });

    // Edit class Section
    // $(document).on("click", ".editClassBtn", function () {
    //     let id = $(this).data("id");

    //     if (id) {
    //         $.get(`/class_name/${id}/edit`, function (response) {
    //             if (response.id) {
    //                 $("#cl_id").val(response.id);
    //                 $("#cl_name").val(response.class_name);
    //                 // sections multiple select handle
    //                 let sections = res.sections.map((sec) => sec.section_name);
    //                 $("#sectionsInput").val(sections).trigger("change");
    //                 $("#saveBtn")
    //                     .text("Update Class Name")
    //                     .prop("disabled", false);
    //                 $(".modal-title").text("Update Class Name");
    //                 modal.show();
    //             } else {
    //                 Swal.fire(
    //                     "Error!",
    //                     "Invalid response from the server.",
    //                     "error"
    //                 );
    //                 $("#saveBtn")
    //                     .text("Update Class Name")
    //                     .prop("disabled", false);
    //             }
    //         }).fail(function () {
    //             Swal.fire("Error!", "Failed to fetch class details.", "error");
    //             $("#saveBtn").text("Update Class Name").prop("disabled", false);
    //         });
    //     }
    // });
    function showSuccess(msg) {
        Swal.fire({
            title: "Success!",
            text: msg,
            icon: "success",
            timer: 2500,
            timerProgressBar: true,
            showConfirmButton: false,
            toast: false, // center popup
        });
    }
 $(document).on('click', '.showAllSectionsBtn', function () {
    let classId = $(this).data('id');

    // Reset UI before loading data
    $('#sectionListBody').html(`
        <tr>
            <td colspan="3" class="text-center text-muted">
                <i class="fa fa-spinner fa-spin me-2"></i> Loading...
            </td>
        </tr>
    `);

    // Reset UI before loading data
    $('#classNameText').text('');
    $('#totalSectionsText').text('');
    $('#totalStudentsText').text('');
    $('#sectionsShowModal').modal('hide');

    // AJAX Request
    $.ajax({
        url: `/class_name/${classId}`, // 👈 show() resource route
        type: "GET",
        success: function (response) {
            if (!response || !response.class_name) {
                $('#sectionListBody').html(`
                    <tr><td colspan="3" class="text-center text-danger">
                        No data found.
                    </td></tr>
                `);
                return;
            }

            // 🧭 Fill Modal Data
            $("#classNameText").text(response.class_name);
            $("#totalSectionsText").text(response.total_sections);
            $("#totalStudentsText").text(response.total_students);

            // 🟢 Show Modal (simple, reliable)
            $('#sectionsShowModal').modal('show');

            // 🧾 Fill Table
            let rows = "";
            response.sections.forEach((sec, index) => {
                rows += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${sec.name}</td>
                        <td>${sec.students_count}</td>
                    </tr>`;
            });

            $("#sectionListBody").html(rows);
        },
        error: function () {
            $("#sectionListBody").html(`
                <tr><td colspan="3" class="text-center text-danger">
                    Failed to load data.
                </td></tr>
            `);
        },
    });
});


    $(document).on("click", ".editClassBtn", function () {
        let id = $(this).data("id");

        if (id) {
            $.get(`/class_name/${id}/edit`, function (response) {
                if (response.id) {
                    $("#cl_id").val(response.id);
                    $("#cl_name").val(response.class_name);

                    // ✅ sections multiple select set
                    let sections = response.sections.map(
                        (sec) => sec.section_name
                    );
                    $("#sectionsInput").val(sections).trigger("change");

                    $("#saveBtn")
                        .text("Update Class Name")
                        .prop("disabled", false);
                    $(".modal-title").text("Update Class Name");
                    modal.show();
                } else {
                    Swal.fire(
                        "Error!",
                        "Invalid response from the server.",
                        "error"
                    );
                }
            }).fail(function () {
                Swal.fire("Error!", "Failed to fetch class details.", "error");
            });
        }
    });

    // Delete class Section
    $(document).on("click", ".deleteBtn", function () {
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
                    url: `/class_name/${id}`,
                    type: "DELETE",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content"),
                    },
                    success: function (res) {
                        fetchClass();
                        fetchSubject();
                        // Success case
                        Swal.fire({
                            toast: true,
                            position: "top-end", // ✅ right top corner
                            icon: "success",
                            title: `${
                                res.message || "The class"
                            } has been deleted.`,
                            showConfirmButton: false,
                            timer: 3000, // auto close after 3s
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                // Hover पर stop होगा
                                toast.addEventListener(
                                    "mouseenter",
                                    Swal.stopTimer
                                );
                                toast.addEventListener(
                                    "mouseleave",
                                    Swal.resumeTimer
                                );
                            },
                        });
                    },
                    error: function (res) {
                        // Error case
                        Swal.fire({
                            toast: true,
                            position: "top-end",
                            icon: "error",
                            title: res.message,
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener(
                                    "mouseenter",
                                    Swal.stopTimer
                                );
                                toast.addEventListener(
                                    "mouseleave",
                                    Swal.resumeTimer
                                );
                            },
                        });
                    },
                });
            }
        });
    });
    // Close Modal on Cancel or Close Button
    $("#cancelBtn, #closeBtn").on("click", function () {
        if (modal) {
            modal.hide();
        }
    });
});

// Initialize Select2 for Sections Input
$(document).ready(function () {
    $("#sectionsInput").select2({
        tags: true,
        tokenSeparators: [",", " "],
        placeholder: "Enter multiple sections",
    });
});
