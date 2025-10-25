// alert("Hello, World!");
$(document).ready(function () {
   // Image Preview
    $("#image").on("change", function (e) {
        let file = e.target.files[0];

        if (file) {
            let reader = new FileReader();
            reader.onload = function (event) {
                $("#previewImage").attr("src", event.target.result);
                $("#previewBox").show();
            };
            reader.readAsDataURL(file);
        } else {
            $("#previewBox").hide();
            $("#previewImage").attr("src", "");
        }
    });

    // ✅ Form Submission
    $("#studentForm").on("submit", function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        let submitBtn = $("#saveBtn");
        let originalText = $("#saveBtn").html();

        submitBtn.prop("disabled", true).html('<i class="bi bi-hourglass-split me-1"></i> Saving...');

        $.ajax({
            url: "/students", // store route
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "success",
                    title: res.message || "Student added successfully!",
                    showConfirmButton: false,
                    timer: 2500,
                });

                // Reset form
                $("#studentForm")[0].reset();
                $("#previewImg").attr("src", "").addClass("d-none");
                submitBtn.prop("disabled", false).html(originalText);
            },
            error: function (xhr) {
                let msg = "Something went wrong!";
                if (xhr.responseJSON?.errors) {
                    msg = Object.values(xhr.responseJSON.errors).join("<br>");
                } else if (xhr.responseJSON?.message) {
                    msg = xhr.responseJSON.message;
                }
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    html: msg,
                });
                submitBtn.prop("disabled", false).html(originalText);
            },
        });
    });

  


    $('.classSelect').on('change', function() {
        let classId = $(this).val();
        $('#sectionSelect').html('<option>Loading...</option>');
        $('#studentSelect').html('<option>Select Student</option>');
        if (classId) {
            $.get('/get-sections/' + classId, function(data) {
                let options = '<option value="">Select Section</option>';
                data.forEach(section => {
                    options += `<option value="${section.id}">${section.section_name}</option>`;
                });
                $('#sectionSelect').html(options);
            });
        }
    });
    
});
