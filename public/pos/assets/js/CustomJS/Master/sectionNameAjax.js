// Fetch Updated section List
function fetchSection() {
    $.get(window.location.href, function (data) {
        $("#sectionTable").DataTable().destroy(); // Destroy existing DataTable instance
        $("#sectionList").html($(data).find("#sectionList").html());
        $("#sectionTable").DataTable(); // Re-initialize DataTable
    });
}
// Fetch Updated section List In Subject Form
function fetchSubject() {
    $.get(window.location.href, function (data) {
        $("#sectionField").html($(data).find("#sectionField").html());
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
    $("#sectionTable").DataTable(); // Add DataTable In table
    // Open Modal to Add
    $("#createBtn").click(function () {
        $("#sectionForm")[0].reset();
        $("#section_id").val("");
        $(".modal-title").text("Add Section");
        $("#saveBtn").text("Add Section").prop("disabled", false);
        modal.show();
    });

    // Submit Form (Create or Update)
    $("#sectionForm").on("submit", function (e) {
        e.preventDefault();

        // properly read the id from hidden input
        let id = $("#section_id").val(); // '' or null => create, otherwise update
        let url = id ? `/section_name/${id}` : `/section_name`;
        let method = "POST";

        const formData = new FormData(this);
        if (id) {
            formData.append("_method", "PUT"); // Method spoofing for update
        }

        if (!id) {
            $("#saveBtn").text("Adding....").prop("disabled", true);
        } else {
            $("#saveBtn").text("Updating....").prop("disabled", true);
        }

        $.ajax({
            url: url,
            type: method,
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                Swal.fire({
                    toast: true,
                    position: "top-end", // ✅ right top
                    icon: "success",
                    title: response.message || "Success",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener("mouseenter", Swal.stopTimer);
                        toast.addEventListener("mouseleave", Swal.resumeTimer);
                    },
                });

                $("#sectionForm")[0].reset();
                $("#myModal").modal("hide");
                fetchSection();
                fetchSubject();

                $("#saveBtn")
                    .html('<i section="fas fa-save"></i> Submit')
                    .prop("disabled", false);
            },
            error: function (xhr) {
                let msg = "Something went wrong!";
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    msg = Object.values(errors).join("\n");
                } else if (xhr.responseJSON?.message) {
                    msg = xhr.responseJSON.message;
                }

                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "error",
                    title: msg,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener("mouseenter", Swal.stopTimer);
                        toast.addEventListener("mouseleave", Swal.resumeTimer);
                    },
                });

                $("#saveBtn")
                    .html('<i class="fas fa-save"></i> Submit')
                    .prop("disabled", false);
            },
        });
    });

    // Edit Logic
    $(document).on("click", ".editSectionBtn", function () {
        let sectionId = $(this).data("id");

        $.ajax({
            url: `/section_name/${sectionId}/edit`, // aapke routes ke hisab se adjust karo
            type: "GET",
            success: function (res) {
                // res should contain section_name and class_id (or class_id property name)
                $("#section_name").val(res.section_name);
                $("#class_id").val(res.class_id || res.cl_id); // safety
                $("#section_id").val(res.id); // important: set hidden id
                $("#saveBtn").text("Update");
                $("#myModal").modal("show"); // aapka modal id jo bhi ho
            },
            error: function (xhr) {
                console.error(xhr);
                Swal.fire("Error", "Could not load section data", "error");
            },
        });
    });

    $(document).on("click", ".deleteSectionBtn", function () {
        let id = $(this).data("id"); // section id

        Swal.fire({
            title: "Are you sure?",
            text: "This section will be permanently deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
            showLoaderOnConfirm: true,
             allowOutsideClick: () => !Swal.isLoading(),
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/section_name/${id}`,
                    type: "POST", // Laravel method spoofing ke liye
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content"),
                        _method: "DELETE",
                    },
                    success: function (response) {
                        Swal.fire({
                            toast: true,
                            position: "top-end",
                            icon: "success",
                            title:
                                response.message ||
                                "Section deleted successfully!",
                            showConfirmButton: false,
                            timer: 2500,
                            timerProgressBar: true,
                        });

                        // 🔁 Table reload ya row remove
                        fetchSection(); // agar function hai to refresh karega
                        fetchSubject?.(); // optional, agar use karte ho
                    },
                    error: function (xhr) {
                        let msg = "Something went wrong!";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            toast: true,
                            position: "top-end",
                            icon: "error",
                            title: msg,
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
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
