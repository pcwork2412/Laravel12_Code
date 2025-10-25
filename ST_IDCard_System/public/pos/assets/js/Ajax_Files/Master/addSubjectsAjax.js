//! CRUD Section
$(document).ready(function () {
    // Get Modal Element
    let modal = new bootstrap.Modal(
        document.getElementById("addSubjectsModal"),
        {
            backdrop: "static",
            keyboard: false,
        }
    );
    // modal.show();
    $("#addSubjectsTable").DataTable(); // Add DataTable In table
    //Reset Form and Open Modal  to Add More Data
    $("#addSubjectsBtn").click(function () {
        $("#addSubjectsForm")[0].reset();
        $("#addSubjects_id").val("");
        $("#addSubjectsSaveBtn").text(`Add Subject`).prop("disabled", false);
        modal.show();
    });
    // Submit Form (Create or Update)
    $("#addSubjectsForm").on("submit", function (e) {
        e.preventDefault();
        let id = $("#addSubjects_id").val();
        let url = id ? `/add_subjects/${id}` : "/add_subjects";
        let method = "POST";
        const formData = new FormData(this);

        if (id) {
            formData.append("_method", "PUT");
        }
        if (url === "/add_subjects") {
            $("#addSubjectsSaveBtn").text("Saving...").prop("disabled", true);
        } else {
            $("#addSubjectsSaveBtn").text("Updating...").prop("disabled", true);
        }

        $.ajax({
            url: url,
            type: method,
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                // let audio = new Audio(successSound);
                // audio.play().catch((e) => {
                //     console.warn("Audio play blocked by browser:", e);
                // });
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "success",
                    // title: res.message || "Success!",
                    text: res.message || "Success!",
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    background:
                        "linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%)",
                    color: "#222",
                    customClass: {
                        popup: "border-0 shadow-xl rounded-2xl px-3 py-2",
                        title: "fw-bold fs-4 mb-1",
                        icon: "bg-success text-white rounded-circle shadow",
                        timerProgressBar: "bg-primary",
                    },
                    didOpen: (toast) => {
                        toast.addEventListener("mouseenter", Swal.stopTimer);
                        toast.addEventListener("mouseleave", Swal.resumeTimer);
                    },
                });

                fetchAddSubjects();
                fetchAddedSubject()
                $("#addSubjectsForm")[0].reset();
                $("#addSubjectsSaveBtn")
                    .text("Add Subjects")
                    .prop("disabled", false);
                modal.hide();
                $(".modal-backdrop").remove(); // यह जरूरी है
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.resJSON.errors;
                    let errorMsg = "";
                    $.each(errors, function (_, value) {
                        errorMsg += value + "\n";
                    });
                     Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "error",
                    // title: res.message || "error!",
                    text: "Validation Error", errorMsg,
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    background:
                        "linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%)",
                    color: "#222",
                    customClass: {
                        popup: "border-0 shadow-xl rounded-2xl px-3 py-2",
                        title: "fw-bold fs-4 mb-1",
                        icon: "bg-success text-white rounded-circle shadow",
                        timerProgressBar: "bg-primary",
                    },
                    didOpen: (toast) => {
                        toast.addEventListener("mouseenter", Swal.stopTimer);
                        toast.addEventListener("mouseleave", Swal.resumeTimer);
                    },
                });
                    fetchAddSubjects();
                    fetchAddedSubject()
                    $("#addSubjectsSaveBtn")
                        .text("Add subject")
                        .prop("disabled", false);
                } else {
                     Swal.fire({
                            toast: true,
                            position: "top-end",
                            icon: "error",
                            // title: "Error!",
                            text:  xhr.resJSON.message || "Something went wrong!",
                            showConfirmButton: true,
                            confirmButtonText: "OK",
                            background:
                                "linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%)",
                            color: "#222",
                            customClass: {
                                popup: "border-0 shadow-xl rounded-2xl px-3 py-2",
                                title: "fw-bold fs-4 mb-1",
                                icon: "bg-danger text-white rounded-circle shadow",
                                timerProgressBar: "bg-primary",
                            },
                        });
                }
            },
        });
    });
    // Edit Subject Section
    $(document).on("click", ".addSubjectsEditBtn", function () {
        let id = $(this).data("id");
        $.get(`add_subjects/${id}/edit`, function (res) {
            $("#addSubjects_id").val(res.id);
            $("#subjects_name").val(res.subjects_name);
            $("#addSubjectsSaveBtn")
                .text(`Update Subject`)
                .prop("disabled", false);
            $(".subject-modal-title").text("Update Subjects");
            modal.show();
        });
    });
    // Delete SUbjects Section
    $(document).on("click", ".addSubjectsDeleteBtn", function () {
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
                    url: `/add_subjects/${id}`,
                    type: "DELETE",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content"),
                    },
                    success: function (res) {
                        fetchAddSubjects();
                        fetchAddedSubject()
                        Swal.fire({
                            toast: true,
                            position: "top-end",
                            icon: "success",
                            text: `Deleted! ${(res && res.subject_Name) ? "`"+ res.subject_Name+"`" : "The Subject"} has been deleted.`,
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                            background:
                                "linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%)",
                            color: "#222",
                            customClass: {
                                popup: "border-0 shadow-xl rounded-2xl px-3 py-2",
                                title: "fw-bold fs-4 mb-1",
                                icon: "bg-success text-white rounded-circle shadow",
                                timerProgressBar: "bg-primary",
                            },
                            didOpen: (toast) => {
                                toast.addEventListener("mouseenter", Swal.stopTimer);
                                toast.addEventListener("mouseleave", Swal.resumeTimer);
                            },
                        });
                    },
                    error: function () {
                        Swal.fire({
                            toast: true,
                            position: "top-end",
                            icon: "error",
                            // title: "Error!",
                            text: "Something went wrong!",
                            showConfirmButton: true,
                            confirmButtonText: "OK",
                            background:
                                "linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%)",
                            color: "#222",
                            customClass: {
                                popup: "border-0 shadow-xl rounded-2xl px-3 py-2",
                                title: "fw-bold fs-4 mb-1",
                                icon: "bg-danger text-white rounded-circle shadow",
                                timerProgressBar: "bg-primary",
                            },
                        });
                    },
                });
            }
        });
    });

    // Define fetchAddSubjects globally so both ready blocks can use it
    function fetchAddSubjects() {
        $.get(window.location.href, function (data) {
            $("#addSubjectsTable").DataTable().destroy(); // Destroy existing DataTable instance
            $("#addSubjectsList").html($(data).find("#addSubjectsList").html());
            $("#addSubjectsTable").DataTable(); // Re-initialize DataTable
        });
    }
    
// Fetch Updated class List In Subject Form
function fetchAddedSubject() {
    $.get(window.location.href, function (data) {
        $("#subjectFields").html($(data).find("#subjectFields").html());
    });
}
});
