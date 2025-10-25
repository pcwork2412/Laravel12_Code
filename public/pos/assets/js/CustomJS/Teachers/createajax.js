// only for create
$(document).ready(function () {
    // CSRF for AJAX
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    // Image preview
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

    // Form submit
    $("#teacherCreateForm").on("submit", function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        $("#saveBtn")
            .prop("disabled", true)
            .html('<i class="bi bi-save"></i> Saving...');

        $.ajax({
            url: "/teachers",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            success: function (response) {
                $("#saveBtn")
                    .prop("disabled", false)
                    .html(
                        '<i class="bi bi-person-plus-fill"></i> Register Teacher'
                    );

                Swal.fire("Success", response.message, "success");

                // Reset form
                $("#teacherCreateForm")[0].reset();
                $("#previewBox").hide();
                $("#previewImage").attr("src", "");
            },
            error: function (xhr) {
                $("#saveBtn")
                    .prop("disabled", false)
                    .html(
                        '<i class="bi bi-person-plus-fill"></i> Register Teacher'
                    );

                let msg = "Something went wrong!";
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    msg = Object.values(xhr.responseJSON.errors)
                        .flat()
                        .join("<br>");
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }

                Swal.fire("Error", msg, "error");
            },
        });
    });
});
