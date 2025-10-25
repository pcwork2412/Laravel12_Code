$(document).ready(function () {
    $("#classSelect").on("change", function () {
        let classId = $(this).val();
        // Reset dropdowns
        $("#sectionSelect").html("<option>Loading...</option>");
        $("#studentSelect").html("<option>Select Student</option>");
        $("#subjects").html(""); // ✅ fix: correct id

        if (classId) {
            // 🔹 Load Sections
            $.get("/get-sections/" + classId, function (data) {
                let options = '<option value="">Select Section</option>';
                data.forEach((section) => {
                    options += `<option value="${section.id}">${section.section_name}</option>`;
                });
                $("#sectionSelect").html(options);
                // console.log("data Response:", data); // 👈 Debug line
            });

            // 🔹 Load Subjects
            $.get("/get-subjects/" + classId, function (subjects) {
                let html = "";
                if (subjects.length > 0) {
                    subjects.forEach((sub) => {
                        html += `
                            <div class="row g-2 mb-3 align-items-center subject-row">
                                <div class="col-md-4">
                                    <input type="text" name="subject_name[]" class="form-control" value="${sub.subject_name}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <input type="number" name="max_marks[]" class="form-control" value="${sub.max_marks}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <input type="number" name="obtained_marks[]" class="form-control obtained_marks" placeholder="Obtained Marks">
                                </div>
                            </div>
                        `;
                    });
                } else {
                    html = `<p class="text-muted">No subjects available for this class</p>`;
                }
                $("#subjects").html(html); // ✅ fix: correct id
            });
        }
    });

    $("#sectionSelect").on("change", function () {
        let sectionId = $(this).val();
        $("#studentSelect").html("<option>Loading...</option>");
        if (sectionId) {
            $.get("/get-students/" + sectionId, function (data) {
                let options = '<option value="">Select Student</option>';
                data.forEach((student) => {
                    options += `<option value="${student.id}">${student.student_name} (${student.student_uid})</option>`;
                });
                $("#studentSelect").html(options);
            });
        }
    });

   $("#studentSelect").on("change", function () {
    let studentId = $(this).val();

    // ✅ Re-enable fields on every change
    $(".obtained_marks").prop("disabled", false);
    $(".exam_type").prop("disabled", false);
    $(".year").prop("disabled", false);

    if (studentId) {
        let baseUrl = $("#studentSelect").data("check-url");

        $.ajax({
            url: baseUrl + "/" + studentId,
            type: "GET",
            success: function (response) {
                console.log("Ajax Response:", response); // ✅ Debug

                if (response.exists) {
                    Swal.fire({
                        title: "Already Allotted!",
                        html: "<p>इस student के marks पहले से allotted हैं। Select another student.</p>",
                        icon: "warning",
                        showCancelButton: true,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        focusConfirm: false,
                        confirmButtonText: '<i class="fas fa-edit me-1"></i> Edit',
                        cancelButtonText: "Cancel",
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: "btn btn-warning btn-lg fs-5 me-2",
                            cancelButton: "btn btn-secondary btn-lg fs-5",
                        },
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (response.edit_url) {
                                window.location.href = `/marks/${response.edit_url}/edit`;
                            } else {
                                window.location.href = "/marks/create";
                            }
                        } else if (result.isDismissed) {
                            // ❌ Disable fields if cancelled
                            $(".obtained_marks").prop("disabled", true);
                            $(".exam_type").prop("disabled", true);
                            $(".year").prop("disabled", true);

                            Swal.fire({
                                icon: "info",
                                title: "Please select another student.",
                                // timer: 1500,
                                showConfirmButton: true,
                                confirmButtonText: "OK",
                                buttonsStyling: false,
                                customClass: {
                                    confirmButton: "btn btn-secondary btn-lg fs-5",
                                },
                            });
                        }
                    });
                }
            },
        });
    }
});

});
// Save Data Using jQuery AJAX
$(document).on("submit", "#marksForm", function (e) {
    e.preventDefault();

    let id = $("#student_id").val();
    let form = $(this)[0];
    let formData = new FormData(form);
    let saveBtn = $("#saveMarks");
    let originalBtnText = saveBtn.html();

    if (id) {
        formData.append("_method", "PUT"); // update case
        saveBtn
            .prop("disabled", true)
            .html('<i class="bi bi-save"></i> Updating...');
    } else {
        saveBtn
            .prop("disabled", true)
            .html('<i class="bi bi-save"></i> Saving...');
    }

    $.ajax({
        url: id ? `/marks/${id}` : "/marks", // ✅ fix URL
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
            if (data.status === "success") {
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "success",
                    title: data.message,
                    showConfirmButton: false,
                    timer: 2500,
                });

                if (!id) {
                    // ✅ only reset if create mode
                    $(form)[0].reset();
                    $("#subjects").html("");
                }

                saveBtn.prop("disabled", false).html(originalBtnText);
            }
        },
        error: function (xhr) {
            saveBtn.prop("disabled", false).html(originalBtnText); // ✅ re-enable button

            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                let errorList = "";
                $.each(errors, function (key, msgs) {
                    errorList += msgs.join("<br>") + "<br>";
                });

                Swal.fire({
                    icon: "error",
                    title: "Validation Error",
                    html: errorList,
                    confirmButtonColor: "#d33",
                });
            } else {
                // Other errors
                let errorMsg = "Something went wrong. Please try again.";

                // If server sends JSON with message
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                } else if (xhr.responseText) {
                    // fallback: plain text response
                    errorMsg = xhr.responseText;
                }

                Swal.fire({
                    icon: "error",
                    title: "Error",
                    html: errorMsg.replace(/\n/g, "<br>"), // line break handling
                    confirmButtonColor: "#d33",
                });
            }
        },
    });
});

// document.getElementById("addSubject").addEventListener("click", function () {
//     let subjectRow = `
//         <div class="row mb-2">
//             <div class="col"><input type="text" name="subject_name[]" class="form-control" placeholder="Subject"></div>
//             <div class="col"><input type="number" name="max_marks[]" class="form-control" placeholder="Max Marks" value="100"></div>
//             <div class="col"><input type="number" name="obtained_marks[]" class="form-control" placeholder="Obtained Marks"></div>
//         </div>`;
//     document
//         .getElementById("subjects")
//         .insertAdjacentHTML("beforeend", subjectRow);
// });
