$(document).ready(function () {
    // Department Dropdown For Section
    $(".globalClassSelect").on("change", function () {
        let classId = $(this).val();
        $(".globalSectionSelect").html("<option>Loading...</option>");
        $(".globalStudentSelect").html("<option>Select Student</option>");
        if (classId) {
            $.get("/get-global-sections/" + classId, function (data) {
                let options = '<option value="">Select Section</option>';
                data.forEach((section) => {
                    options += `<option value="${section.id}" class="p-2 rounded-1">${section.section_name}</option>`;
                });
                $(".globalSectionSelect").html(options);
            });
        }
        
    $(".globalSectionSelect").on("change", function () {
        let sectionId = $(this).val();
        $(".globalStudentSelect").html("<option>Loading...</option>");
        if (sectionId) {
            $.get("/get-global-students/" + sectionId, function (data) {
                let options = '<option value="">Select Student</option>';
                data.forEach((student) => {
                    options += `<option value="${student.student_uid}">${student.student_name} (${student.student_uid})</option>`;
                });
                $(".globalStudentSelect").html(options);
            });
        }
    });
    });

    // $(".allotClassSelect").on("change", function () {
    //     let classId = $(this).val();
    //     $(".allotSectionSelect").html("<option>Loading...</option>");
    //     $(".allotStudentSelect").html("<option>Select Student</option>");
    //     if (classId) {
    //         $.get("/get-global-sections/" + classId, function (data) {
    //             let options = '<option value="">Select Section</option>';
    //             data.forEach((section) => {
    //                 options += `<option value="${section.id}" class="p-2 rounded-1">${section.section_name}</option>`;
    //             });
    //             $(".allotSectionSelect").html(options);
    //         });
    //     }
    // });
});
