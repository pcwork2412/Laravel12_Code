//! CRUD Section
$(document).ready(function () {
    // Get Modal Element
    let modal = new bootstrap.Modal(document.getElementById("schoolModal"), {
        backdrop: "static",
        keyboard: false,
    });
    // Set DataTable Show Table Data
    let table = $("#schoolTable").DataTable({
        ajax: "/school_name",
        columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false }, // 👈 serial no.

            // { data: "id", name: "id" },
            {
                data: "school_logo",
                name: "school_logo",
                orderable: false,
                searchable: false,
            },
            {
                data: "school_principal_sign",
                name: "school_principal_sign",
                orderable: false,
                searchable: false,
            },
            { data: "school_name", name: "school_name" },
            { data: "school_tagline", name: "school_tagline" },
            { data: "school_address", name: "school_address" },
            { data: "school_session", name: "school_session" },
            {
                data: "actions",
                name: "actions",
                orderable: false,
                searchable: false,
            },
        ],
    });
    //Reset Form and Open Modal  to Add More Data
    $("#schoolCreateBtn").click(function () {
        $("#schoolForm")[0].reset();
        $("#school_id").val("");
        // $(".school-modal-title").text("Add School Details");
        $("#logoPreviewBox").hide();
        $("#signPreviewBox").hide();
        $("#schoolSaveBtn").text("Add school Details").prop("disabled", false);
        modal.show();
    });
    // Preview School Logo Images Before Upload
    $("#school_logo").on("change", function () {
        let file = this.files[0]; // चुनी गई फाइल को लो
        if (file) {
            let reader = new FileReader();
            reader.onload = function (e) {
                $("#logoPreviewImg").attr("src", e.target.result);
                $("#logoPreviewBox").show();
            };
            reader.readAsDataURL(file);
        } else {
            $("#logoPreviewBox").hide();
        }
    });
    $("#school_principal_sign").on("change", function () {
        let file = this.files[0]; // चुनी गई फाइल को लो
        if (file) {
            let reader = new FileReader();
            reader.onload = function (e) {
                $("#signPreviewImg").attr("src", e.target.result);
                $("#signPreviewBox").show();
            };
            reader.readAsDataURL(file);
        } else {
            $("#signPreviewBox").hide();
        }
    });
    // Submit Form (Create or Update)
    $("#schoolForm").on("submit", function (e) {
        e.preventDefault();
        let id = $("#school_id").val();
        const formData = new FormData(this);

        if (id) {
            formData.append("_method", "PUT");
        }
        if (!id) {
            $("#schoolSaveBtn").text("Saving...").prop("disabled", true);
        } else {
            $("#schoolSaveBtn").text("Updating...").prop("disabled", true);
        }

        $.ajax({
            url: "/school_name" + (id ? `/${id}` : ""),
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                Swal.fire({
                    toast: true,
                    position: "top-end", // ✅ right top
                    icon: "success",
                    title: response.schoolName || "Success",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener("mouseenter", Swal.stopTimer);
                        toast.addEventListener("mouseleave", Swal.resumeTimer);
                    },
                });
                table.ajax.reload(null, false);
                $("#schoolForm")[0].reset();
                $("#previewSchoolImage").addClass("d-none");
                $("#schoolSaveBtn").text("Add school").prop("disabled", false);

                modal.hide();
                $(".modal-backdrop").remove(); // यह जरूरी है
                // fetchschool();
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors || {};
                    let errorMsg =
                        xhr.responseJSON.status ||
                        "Validation Error. Kripya fields check karein.";

                    // agar multiple validation errors aaye
                    $.each(errors, function (_, value) {
                        errorMsg += "\n" + value;
                    });

                    Swal.fire({
                        toast: true,
                        position: "top-end", // ✅ right top
                        icon: "error",
                        title: errorMsg || "error",
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
                    if (!id) {
                        $("#schoolSaveBtn")
                            .text("Add School Details")
                            .prop("disabled", false);
                    } else {
                        $("#schoolSaveBtn")
                            .text("Update School Details")
                            .prop("disabled", false);
                    }
                } else if (xhr.status === 500) {
                    Swal.fire(
                        "Server Error",
                        "Update process me dikkat aayi. Kripya dobara koshish karein.",
                        "error"
                    );
                    if (!id) {
                        $("#schoolSaveBtn")
                            .text("Add School Details")
                            .prop("disabled", false);
                    } else {
                        $("#schoolSaveBtn")
                            .text("Update School Details")
                            .prop("disabled", false);
                    }
                } else {
                    Swal.fire(
                        "Error",
                        xhr.responseJSON.status || "Kuch galat ho gaya!",
                        "error"
                    );
                    if (!id) {
                        $("#schoolSaveBtn")
                            .text("Add School Details")
                            .prop("disabled", false);
                    } else {
                        $("#schoolSaveBtn")
                            .text("Update School Details")
                            .prop("disabled", false);
                    }
                }
            },
        });
    });

    // Edit school Section
    $(document).on("click", ".schoolEditBtn", function () {
        let id = $(this).data("id");
        if (id) {
            $.get(`/school_name/${id}/edit`, function (res) {
                if (res && res.id) {
                    $("#school_id").val(res.id);
                    $("#school_name").val(res.school_name);
                    $("#school_session").val(res.school_session);
                    $("#school_address").val(res.school_address);
                    $("#school_tagline").val(res.school_tagline);
                    if (res.school_logo) {
                        $("#logoPreviewImg").attr(
                            "src",
                            "/storage/" + res.school_logo
                        );

                        $("#logoPreviewBox").show(); // ✅ Box ko dikhana hoga
                    } else {
                        $("#logoPreviewBox").hide(); // ✅ Box ko hide karna hoga
                    }
                    if (res.school_principal_sign) {
                        $("#signPreviewImg").attr(
                            "src",
                            "/storage/" + res.school_principal_sign
                        );

                        $("#signPreviewBox").show(); // ✅ Box ko dikhana hoga
                    } else {
                        $("#signPreviewBox").hide(); // ✅ Box ko hide karna hoga
                    }

                    modal.show();
                    $("#schoolSaveBtn")
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
    $(document).on("click", ".schoolDeleteBtn", function () {
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
                        table.ajax.reload();
                        Swal.fire({
                            toast: true,
                            position: "top-end", // ✅ right top corner
                            icon: "success",
                            title: `${
                                res.schoolName || "The School"
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
                    error: function () {
                        // Error case
                        Swal.fire({
                            toast: true,
                            position: "top-end",
                            icon: "error",
                            title: "Something went wrong!",
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
    $("#schoolcancelBtn").on("click", function () {
        if (modal) {
            modal.hide();
            $(".modal-backdrop").remove(); // यह जरूरी है
        }
    });
});
