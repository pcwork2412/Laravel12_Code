//! CRUD Section
$(document).ready(function () {
    // Get Modal Element
    let modal = new bootstrap.Modal(document.getElementById("subjectModal"), {
        backdrop: "static",
        keyboard: false,
    });
    // Set DataTable Show Table Data
    let table = $("#subjectTable").DataTable({
        ajax: "/subject_name",
        columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false }, // 👈 serial no.

            { data: "subject_name", name: "subject_name" },
            { data: "class_name", name: "class_name",searchable: true },
            { data: "max_marks", name: "max_marks" },
            {
                data: "actions",
                name: "actions",
                orderable: false,
                searchable: false,
            },
        ],
    });
    //Reset Form and Open Modal  to Add More Data
    $("#subjectCreateBtn").click(function () {
        $("#subjectForm")[0].reset();
        $("#subject_id").val("");
        $(".subject-modal-title").text("Add subject Details");
        $("#subjectSaveBtn")
            .text("Add subject Details")
            .prop("disabled", false);
        modal.show();
    });
   
  // Submit Form (Create or Update)
$("#subjectForm").on("submit", function (e) {
    e.preventDefault();
    let id = $("#subject_id").val();
    const formData = new FormData(this);

    if (id) {
        formData.append("_method", "PUT");
    }
    if (!id) {
        $("#subjectSaveBtn").text("Saving...").prop("disabled", true);
    } else {
        $("#subjectSaveBtn").text("Updating...").prop("disabled", true);
    }

    $.ajax({
        url: "/subject_name" + (id ? `/${id}` : ""),
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "success",
                title: `${response.status || "The School"} Saved Successfully.`,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener("mouseenter", Swal.stopTimer);
                    toast.addEventListener("mouseleave", Swal.resumeTimer);
                },
            });
            $("#subjectForm")[0].reset();
            $("#subject_id").val("");
            $("#subjectSaveBtn")
                .text(id ? "Update School Details" : "Add subject Details")
                .prop("disabled", false);
            if(id){
                modal.hide();
            }
            modal.show();
            table.ajax.reload(null, false);
        },
        error: function (xhr) {
            let defaultBtnText = id ? "Update School Details" : "Add School Details";
            $("#subjectSaveBtn").text(defaultBtnText).prop("disabled", false);

            if (xhr.status === 422) {
                // Validation Error
                let errors = xhr.responseJSON.errors || {};
                let errorMsg = xhr.responseJSON.status || "Validation Error. Kripya fields check karein.";
                $.each(errors, function (_, value) {
                    errorMsg += "\n" + value;
                });
                Swal.fire("Validation Error", errorMsg, "warning");
            } 
            else if (xhr.status === 409) {
                // Duplicate Subject Error
                Swal.fire(
                    "Duplicate Subject",
                    xhr.responseJSON.message || "Ye subject is class me already allot hai!",
                    "warning"
                );
            } 
            else if (xhr.status === 500) {
                Swal.fire(
                    "Server Error",
                    "Update process me dikkat aayi. Kripya dobara koshish karein.",
                    "error"
                );
            } 
            else {
                Swal.fire(
                    "Error",
                    xhr.responseJSON.status || "Kuch galat ho gaya!",
                    "error"
                );
            }
        },
    });
});

    // Edit subject Section
    $(document).on("click", ".subjectEditBtn", function () {
        let id = $(this).data("id");
        if (id) {
            $.get(`/subject_name/${id}/edit`, function (res) {
                if (res && res.id) {
                    $("#subject_id").val(res.id);
                    $("#subject_name").val(res.subject_name);
                    $("#max_marks").val(res.max_marks);
                    $("#class_id").val(res.class_id);

                    modal.show();
                    $("#subjectSaveBtn")
                        .text("Update subject Details")
                        .prop("disabled", false);
                    $(".subject-modal-title").text("Update subject Details");
                } else {
                    Swal.fire(
                        "Error!",
                        "Invalid response from the server.",
                        "error"
                    );
                }
            }).fail(function () {
                Swal.fire(
                    "Error!",
                    "Failed to fetch subject details.",
                    "error"
                );
            });
        }
    });
  // Delete subject Section (fix with preConfirm + showLoaderOnConfirm)
$(document).on("click", ".subjectDeleteBtn", function () {
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
        preConfirm: () => {
            // Return a promise so Swal shows loader until AJAX finishes
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: `/subject_name/${id}`,
                    type: "DELETE",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content")
                    },
                    success: function (res) {
                        resolve(res); // resolved value available as result.value
                    },
                    error: function (xhr, status, err) {
                        // pass error message to showValidationMessage (optional)
                        reject(xhr.responseJSON?.message || "Request failed");
                    }
                });
            }).catch((errMsg) => {
                // show validation message inside the modal (keeps modal open)
                Swal.showValidationMessage(String(errMsg));
            });
        }
    }).then((result) => {
        if (result.isConfirmed && result.value) {
            // AJAX success response is in result.value
            let res = result.value;
            if (typeof table !== "undefined" && table.ajax) table.ajax.reload();

            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "success",
                title: `${res.subjectName || "The School"} has been deleted.`,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener("mouseenter", Swal.stopTimer);
                    toast.addEventListener("mouseleave", Swal.resumeTimer);
                },
            });
        }
    });
});


    // Close Modal on Cancel or Close Button
    $("#subjectcancelBtn").on("click", function () {
        if (modal) {
            modal.hide();
            $(".modal-backdrop").remove(); // यह जरूरी है
        }
    });
});
