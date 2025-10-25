//! CRUD Section
$(document).ready(function () {
    // Get Modal Element
    let modal = new bootstrap.Modal(document.getElementById("schoolModal"), {
        backdrop: "static",
        keyboard: false,
    });
    $("#schoolTable").DataTable(); // Add DataTable In table
    //Reset Form and Open Modal  to Add More Data
    $("#schoolcreateBtn").click(function () {
        $("#schoolForm")[0].reset();
        $("#school_id").val("");
        $(".school-modal-title").text("Add School Details");
        $("#previewSchoolImage").addClass("d-none");
        $("#schoolsaveBtn").text("Add school").prop("disabled", false);
        modal.show();
    });
    // Preview Images Before Upload
    $("#image").on("change", function () {
        let file = this.files[0]; // चुनी गई फाइल को लो
        if (file) {
            let reader = new FileReader();
            reader.onload = function (e) {
                $("#previewSchoolImage")
                    .attr("src", e.target.result)
                    .removeClass("d-none");
            };
            reader.readAsDataURL(file);
        }
    });
    // Define fetchschool globally so both ready blocks can use it
    function fetchschool() {
        $.get(window.location.href, function (data) {
            // Replace entire table section
            let newContent = $(data).find("#schoolList").html();
            $("#schoolList").html(newContent);

            // Destroy and Re-initialize DataTable
            if ($.fn.DataTable.isDataTable("#schoolTable")) {
                $("#schoolTable").DataTable().destroy();
            }
            $("#schoolTable").DataTable();
        });
    }
    // Submit Form (Create or Update)
    $("#schoolForm").on("submit", function (e) {
        e.preventDefault();
        let id = $("#school_id").val();
        let url = id ? `/school_name/${id}` : "/school_name";
        let method = "POST";
        const formData = new FormData(this);

        if (id) {
            formData.append("_method", "PUT");
        }
        if (url === "/school_name") {
            $("#schoolsaveBtn").text("Saving...").prop("disabled", true);
        } else {
            $("#schoolsaveBtn").text("Updating...").prop("disabled", true);
        }

        $.ajax({
            url: url,
            type: method,
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                Swal.fire(
                    "Success",
                    response.message || "School saved",
                    "success"
                );

                $("#schoolForm")[0].reset();
                $("#previewSchoolImage").addClass("d-none");
                $("#schoolsaveBtn").text("Add school").prop("disabled", false);

                modal.hide();       
                $(".modal-backdrop").remove(); // यह जरूरी है
                fetchschool();
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMsg = "";
                    $.each(errors, function (_, value) {
                        errorMsg += value + "\n";
                    });
                    Swal.fire("Validation Error", errorMsg, "warning");
                    $("#schoolsaveBtn")
                        .text("Add school")
                        .prop("disabled", false);
                } else {
                    Swal.fire(
                        "Error",
                        xhr.responseJSON.message || "Something went wrong!",
                        "error"
                    );
                }
            },
        });
    });

    // Edit school Section
    $(document).on("click", ".schooleditBtn", function () { 
        let id = $(this).data("id");
        if (id) {
            $.get(`/school_name/${id}/edit`, function (res) {
                if (res && res.id) {
                    $("#school_id").val(res.id);
                    $("#school_name").val(res.school_name);
                    $("#session").val(res.session);
                    $("#description").val(res.description);
                    $("#address").val(res.address);
                    if (res.image) {
                        $("#previewSchoolImage")
                            .attr("src", "/storage/" + res.image)
                            .removeClass("d-none");
                    } else {
                        $("#previewSchoolImage").addClass("d-none");
                    }
                    modal.show();
                    $("#schoolsaveBtn")
                        .text("Update school Details")
                        .prop("disabled", false);
                    $(".school-modal-title").text("Update school Details");
                } else {
                    Swal.fire(
                        "Error!",
                        "Invalid response from the server.",
                        "error"
                    );
                }
            }).fail(function () {
                Swal.fire("Error!", "Failed to fetch school details.", "error");
            });
        }
    });
    // Delete school Section
    $(document).on("click", ".schooldeleteBtn", function () {
        let id = $(this).data("id");
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/school_name/${id}`,
                    type: "DELETE",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content"),
                    },
                    success: function (res) {
                        fetchschool();
                        Swal.fire(
                            "Deleted!",
                            `${
                                res.school_name || "The school"
                            } has been deleted.`,
                            "success"
                        );
                    },
                    error: function () {
                        Swal.fire("Error!", "Something went wrong!", "error");
                    },
                });
            }
        });
    });

    // Close Modal on Cancel or Close Button
    $("#schoolcancelBtn").on("click", function () {
        if (modal) {
            modal.hide();
            $(".modal-backdrop").remove(); // यह जरूरी है
        }
    });
});
    // Define fetchschool globally so both ready blocks can use it
    function fetchschool() {
        $.get(window.location.href, function (data) {
            // Replace entire table section
            let newContent = $(data).find("#schoolList").html();
            $("#schoolList").html(newContent);

            // Destroy and Re-initialize DataTable
            if ($.fn.DataTable.isDataTable("#schoolTable")) {
                $("#schoolTable").DataTable().destroy();
            }
            $("#schoolTable").DataTable();
        });
    }
//! Checkbox Delete
$(document).ready(function () {
    $("#deleteSelected")
        .html('<i class="fa fa-trash"></i>  Delete All school')
        .prop("disabled", false);
    // Check All Checkbox
    // ✅ Variable to track "Check All Across All Pages"
    let deleteAllAcrossPages = false;

    $(document).on("click", "#selectAllSChool", function () {
        let isChecked = $(this).is(":checked");
        $(".checkSingle").prop("checked", isChecked);

        // ✅ Set global flag for check-all-across-pagination
        deleteAllAcrossPages = isChecked;
    });

    // Single Checkbox
    $(document).on("click", ".checkSingle", function () {
        let allChecked =
            $(".checkSingle:checked").length === $(".checkSingle").length;
        $("#selectAllSChool").prop("checked", allChecked);
    });

    // Delete Multiple school
    $("#deleteSelected").on("click", function (e) {
        e.preventDefault();
        var ids = [];
        $(".school_checkbox:checked").each(function () {
            ids.push($(this).val());
            
        });

        if (ids.length > 0) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#deleteSelected")
                    .html('<i class="fa fa-trash"></i> Deleting.....')
                    .prop("disabled", true);
                    $.ajax({
                        url: "/delete-multiple-schools", // Use your actual route URL here
                        type: "POST",
                        data: {
                            ids: ids,
                            delete_all: deleteAllAcrossPages ? 1 : 0,
                            _token: $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },

                        success: function (response) {
                            // Remove deleted rows from DOM
                            response.ids.forEach(function (id) {
                                $('tr[data-school-id="' + id + '"]').remove();
                            });

                            Swal.fire(
                                "Deleted!",
                                " Selected (" +
                                    response.ids.length +
                                    ") school have been deleted.",
                                "success"
                            );
                            $("#deleteSelected")
                                .html(
                                    '<i class="fa fa-trash"></i>  Delete All school'
                                )
                                .prop("disabled", false);
                            // ✅ Pagination वाला AJAX reload यहां दोबारा चला दो
                            let currentUrl = window.location.href;

    //                         // Show loading spinner
    //                         $("#schoolList").html(`
    //     <div class="text-center py-5">
    //         <div class="spinner-border text-primary" role="status">
    //             <span class="visually-hidden">Loading...</span>
    //         </div>
    //     </div>
    // `);

                            $.ajax({
                                url: currentUrl,
                                type: "GET",
                                dataType: "html",
                                cache: false,
                                success: function (data) {
                                    const $data = $(data);
                                    const newContent = $data
                                        .find("#schoolList")
                                        .html();
                                    // const newPagination = $data
                                    //     .find("#paginationLinks")
                                    //     .html();
                                    // $("#schoolList").children().remove(); // Even safer than .empty()

                                    $("#schoolList").empty(); // पहले खाली करो DOM
                                    $("#schoolList").html(newContent); // फिर नया content भरो

                                    // $("#paginationLinks").html(newPagination);
                                },
                                error: function () {
                                    $("#schoolList").html(
                                        '<div class="alert alert-danger text-center">Failed to reload data.</div>'
                                    );
                                },
                            });
                        },
                        error: function (xhr, status, error) {
                            Swal.fire(
                                "Error!",
                                "Something went wrong. Please try again.",
                                "error"
                            );
                        },
                    });
                }
            });
        } else {
            Swal.fire(
                "No selection!",
                "Please select at least one teacher.",
                "error"
            );
        }
    });
});
