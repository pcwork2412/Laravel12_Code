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
        $("#id").val("");
        $(".modal-title").text("Add Class");
        $("#saveBtn").text("Add Class").prop("disabled", false);
        modal.show();
    });

    // Submit Form (Create or Update)
$("#classForm").on("submit", function (e) {
    e.preventDefault();
    let id = $("#id").val();   // yaha #id ki jagah #id karo
    let url = id ? `/class_name/${id}` : `/class_name`;
    let method = "POST";

    const formData = new FormData(this);
    if (id) {
        formData.append("_method", "PUT"); // Method spoofing for update
    }

    if (!id) {
        $("#saveBtn").text("Adding....").prop("disabled", true);
    } else{
        $("#saveBtn").text("Updating....").prop("disabled", true);
    }

    $.ajax({
        url: url,
        type: method,
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            Swal.fire("Success", response.message, "success");
            $("#classForm")[0].reset();
            $("#myModal").modal("hide");
            fetchClass();
            fetchSubject();

            $("#saveBtn")
                .html('<i class="fas fa-save"></i> Submit')
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

            Swal.fire("Error", msg, "error");
            $("#saveBtn")
                .html('<i class="fas fa-save"></i> Submit')
                .prop("disabled", false);
        },
    });
});


    // Edit class Section
    $(document).on("click", ".editClassBtn", function () {
        let id = $(this).data("id");
        
        if (id) {
            $.get(`/class_name/${id}/edit`, function (response) {
                if (response.id) {
                    $("#cl_id").val(response.id);
                    $("#cl_name").val(response.class_name);
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
                    $("#saveBtn").text("Update Class Name").prop("disabled", false);
                }
            }).fail(function () {
                Swal.fire("Error!", "Failed to fetch class details.", "error");
                $("#saveBtn").text("Update Class Name").prop("disabled", false);
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
                        Swal.fire(
                            "Deleted!",
                            `${
                                res.class_name || "The class"
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
    $("#cancelBtn, #closeBtn").on("click", function () {
        if (modal) {
            modal.hide();
        }
    });
});

