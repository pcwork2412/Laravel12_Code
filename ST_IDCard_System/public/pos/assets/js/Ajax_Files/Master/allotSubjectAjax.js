//! CRUD Section
// Define modal globally so it can be used in all blocks
$(document).ready(function () {
    let modal;
    modal = new bootstrap.Modal(document.getElementById("subjectModal"), {
        backdrop: "static",
        keyboard: false,
    });
    modal.hide();
    // $("#subjectTable").DataTable(); // Add DataTable In table
    // Open Modal to Add
    fetchSubject();

    $("#subjectCreateBtn").click(function () {
        $("#subjectForm")[0].reset();
        $('#subjectForm select').val('').trigger('change');

        $("#subject_id").val("");
        $(".subject-modal-title").text("Add Subjects");
        $("#subjectSaveBtn").text("Add Subject").prop("disabled", false);
        modal.show();
    });
    // Get Modal Element For Add Input Fields
    // Get Modal Element For Add Input Fields
    let subjectCount = 6;

    document
        .getElementById("addMoreBtn")
        .addEventListener("click", function () {
            subjectCount += 2;

            // Function to generate <option> list
            function generateOptions() {
                if (!Array.isArray(allSubjects)) {
                    console.error("allSubjects is not an array", allSubjects);
                    return `<option value="">No Subjects Found</option>`;
                }

                return allSubjects
                    .map(
                        (subject) =>
                            `<option value="${subject.subjects_name}">${subject.subjects_name}</option>`
                    )
                    .join("");
            }

            const field = `
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="subject_name_${
                    subjectCount - 1
                }" class="form-label">Subject Name ${subjectCount - 1}</label>
                <select name="subject_name_${
                    subjectCount - 1
                }" id="subject_name_${subjectCount - 1}" class="form-select">
                    <option value=" ">Select Subject</option>
                    ${generateOptions()}
                </select>
            </div>
            <div class="col-md-6">
                <label for="subject_name_${subjectCount}" class="form-label">Subject Name ${subjectCount}</label>
                <select name="subject_name_${subjectCount}" id="subject_name_${subjectCount}" class="form-select">
                    <option value=" ">Select Subject</option>
                    ${generateOptions()}
                </select>
            </div>
        </div>`;

            document
                .getElementById("subjectFields")
                .insertAdjacentHTML("beforeend", field);
        });

    // Submit Form (Create )
    $("#subjectForm").on("submit", function (e) {
        e.preventDefault();
        let id = $("#subject_id").val();
        let url = id ? `/subject_name/${id}` : `/subject_name`;
        let method = "POST";
        const formData = new FormData(this);

        if (id) {
            formData.append("_method", "PUT");
            $("#subjectSaveBtn").text("updating...").prop("disabled", true);
        } else {
            $("#subjectSaveBtn").text("Adding...").prop("disabled", true);
        }

        $.ajax({
            url: url,
            type: method,
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                Swal.fire(
                    "success",
                    response.message || "Subjects saved",
                    "success"
                );

                // modal.hide();
                $("#subjectForm")[0].reset();
                $("#subjectSaveBtn")
                    .text("Add Subject")
                    .prop("disabled", false);
                $(".modal-backdrop").remove(); // यह जरूरी है
                fetchSubject();
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMsg = "";
                    $.each(errors, function (_, value) {
                        errorMsg += value + "\n";
                    });
                    Swal.fire("Validation Error", errorMsg, "warning");
                } else {
                    Swal.fire(
                        "Error",
                        xhr.responseJSON.message || "Something went wrong!",
                        "error"
                    );
                    $("#subjectSaveBtn")
                        .text("Add Subject")
                        .prop("disabled", false);
                }
            },
        });
    });
    // Edit Subject Section
    $(document).on("click", ".subjectEditBtn", function () {
        
        let id = $(this).data("id");

        $.get(`subject_name/${id}/edit`, function (res) {
            $("#classes_name").val(res.subject.class_name);
            $("#subject_id").val(res.subject.id);
            $(".subject-modal-title").text("Edit Subjects");
            $("#subjectSaveBtn").text("Update Subject").prop("disabled", false);
            $("#subjectFields").empty();

            // ✅ Step 2: Create subject list from res.subject
            let selectedSubjects = [];
            Object.keys(res.subject).forEach(function (key) {
                if (key.startsWith("subject_name_") && res.subject[key]) {
                    selectedSubjects.push(res.subject[key]);
                }
            });
            

            // ✅ Step 3: Get all subjects from AddSubject table
            let allSubjects = res.allSubjects.map((sub) => sub.subjects_name);

            // ✅ Step 4: Loop through each selected subject and create dropdown
            let rowHtml = ""; // पूरी row को जोड़ने के लिए

            selectedSubjects.forEach(function (selectedSub, index) {
                let subjectOptions = '<option value="">Select Subject</option>';
                allSubjects.forEach(function (opt) {
                    let selected = opt === selectedSub ? "selected" : "";
                    subjectOptions += `<option value="${opt}" ${selected}>${opt}</option>`;
                });

                let fieldId = `subject_name_${index + 1}`;
                let fieldName = `subject_name_${index + 1}`;
                let label = `Subject Name (${selectedSub})`;

                let colHtml = `
        <div class="col-md-6">
            <label for="${fieldId}" class="form-label">${label}</label>
            <select name="${fieldName}" id="${fieldId}" class="form-select" >
                ${subjectOptions}
            </select>
        </div>
    `;

                if (index % 2 === 0) {
                    rowHtml += `<div class="row mb-3">`;
                }

                rowHtml += colHtml;

                if (index % 2 === 1 || index === selectedSubjects.length - 1) {
                    rowHtml += `</div>`;
                }
            });

            $("#subjectFields").append(rowHtml);
            modal.show();
            
        });
        modal.hide();
    });

    // Subject Delete Section
    $(document).on("click", ".subjectDeleteBtn", function () {
        let id = $(this).data("id");
        let url = `/subject_name/${id}`;
        let method = "DELETE";
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
                    url: url,
                    type: method,
                    success: function (response) {
                        fetchSubject();
                        Swal.fire(
                            "Deleted!",
                            response.message || "Subjects deleted",
                            "success"
                        );
                    },
                });
            }
        });
    });
    function fetchSubject() {
        $.get(window.location.href, function (data) {
            // Replace entire table section
            let newContent = $(data).find("#subjectCardContainer").html();
            $("#subjectCardContainer").html(newContent);
        });
    }
    // Close Modal on Cancel or Close Button
    $("#subjectCancelBtn").on("click", function () {
        modal.hide();
    });
});

// //! Checkbox Delete
// $(document).ready(function () {
//     // Set CSRF token for all AJAX requests
//     $.ajaxSetup({
//         headers: {
//             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//         },
//     });
//     // Define fetchschool globally so both ready blocks can use it
//     function fetchschool() {
//         $.get(window.location.href, function (data) {
//             // Replace entire table section
//             let newContent = $(data).find("#schoolList").html();
//             $("#schoolList").html(newContent);

//             // Destroy and Re-initialize DataTable
//             if ($.fn.DataTable.isDataTable("#schoolTable")) {
//                 $("#schoolTable").DataTable().destroy();
//             }
//             $("#schoolTable").DataTable();
//         });
//     }

//     // Select/Deselect All Checkbox
//     $(document).on("click", "#schoolSelectAll", function () {
//         let isChecked = $(this).is(":checked");
//         $(".school-checkbox").prop("checked", isChecked);
//     });

//     // Delete Selected
//     $("#deleteSchoolSelectedBtn").on("click", function () {
//         let selectedIds = $(".school-checkbox:checked")
//             .map(function () {
//                 return $(this).val();
//             })
//             .get();

//         if (selectedIds.length === 0) {
//             Swal.fire("Please select at least one school to delete.");
//             return;
//         }

//         let url = $(this).data("url"); // ✅ Correct route

//         Swal.fire({
//             title: "Are you sure?",
//             text: "Selected schooles will be deleted!",
//             icon: "warning",
//             showCancelButton: true,
//             confirmButtonText: "Yes, delete!",
//         }).then((result) => {
//             if (result.isConfirmed) {
//                 $.ajax({
//                     url: url,
//                     method: "POST",
//                     data: {
//                         ids: selectedIds,
//                         _token: $('meta[name="csrf-token"]').attr("content"),
//                     },
//                     success: function (response) {
//                         Swal.fire("Deleted!", response.message, "success");
//                         selectedIds.forEach((id) => {
//                             $("#schoolRow_" + id).remove();
//                         });
//                         fetchschool();
//                     },
//                     error: function () {
//                         Swal.fire("Error!", "Something went wrong.", "error");
//                     },
//                 });
//             }
//         });
//     });
// });
