$(document).ready(function () {
    // Bootstrap Modal Initialization
    let modal = new bootstrap.Modal(document.getElementById("galleryModal"));
    let table = $("#galleryTable").DataTable({
        processing: true,
        serverSide: true,
        ajax: "/gallery",
        order: [[0, "desc"]],
        columns: [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                title: "S.No",
                orderable: false,
                searchable: false,
            },

            { data: "title", name: "title" },
            { data: "description", name: "description" },
            {
                data: "images",
                name: "images",
                orderable: false,
                searchable: false,
            },
            {
                data: "actions",
                name: "actions",
                orderable: false,
                searchable: false,
            },
        ],
    });
    let selectedFiles = []; // 🔹 Temporary array to store selected files

    // ✅ Show Modal on Add Image Button Click
    $("#addImgBtn").click(function () {
        $("#galleryForm")[0].reset();
        $("#galleryId").val("");
        $("#previewGalleryContainer").html("");
        selectedFiles = []; // Clear previous selections
        modal.show();
    });

    // // ✅ Handle Image Selection & Preview with Remove Button
    // $("#editGalleryImage").on("change", function (e) {
    //     const newFiles = Array.from(e.target.files);

    //     newFiles.forEach((file) => {
    //         selectedFiles.push(file); // Add file to our array

    //         const reader = new FileReader();
    //         reader.onload = function (ev) {
    //             const previewHTML = `
    //             <div class="preview-box position-relative d-inline-block me-2 mb-2" style="width:100px; height:100px;">
    //                 <img src="${ev.target.result}" class="img-thumbnail"
    //                     style="width:100%; height:100%; object-fit:cover; border-radius:6px;">
    //                 <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-preview-btn"
    //                     data-name="${file.name}"
    //                     style="border-radius:50%; width:22px; height:22px; line-height:16px; padding:0;">
    //                     <i class="fa fa-times" style="font-size:12px;"></i>
    //                 </button>
    //             </div>
    //         `;
    //             $("#previewGalleryContainer").append(previewHTML);
    //         };
    //         reader.readAsDataURL(file);
    //     });

    //     // reset input so same file can be reselected
    //     $("#editGalleryImage").val("");
    // });
// ✅ Global arrays to track files
let removedImages = [];

// ✅ Image Preview with Remove Button
$("#editGalleryImage").on("change", function () {
    const files = Array.from(this.files);

    files.forEach((file) => {
        selectedFiles.push(file); // Add to our array

        const reader = new FileReader();
        reader.onload = function (e) {
            const previewHTML = `
                <div class="preview-box position-relative d-inline-block me-2 mb-2" style="width:100px; height:100px;">
                    <img src="${e.target.result}" class="img-thumbnail" 
                         style="width:100%; height:100%; object-fit:cover; border-radius:6px;">
                    <button type="button" 
                            class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-preview-btn"
                            style="border-radius:50%; width:22px; height:22px; line-height:16px; padding:0;">
                        <i class="fa fa-times" style="font-size:12px;"></i>
                    </button>
                </div>
            `;
            $("#previewGalleryContainer").append(previewHTML);
        };
        reader.readAsDataURL(file);
    });

    // reset the file input (so same file can be re-selected)
    $(this).val("");
});

// ✅ Remove preview before upload (frontend-only)
$(document).on("click", ".remove-preview-btn", function () {
    const index = $(this).closest(".preview-box").index();
    selectedFiles.splice(index, 1); // remove file from selectedFiles
    $(this).closest(".preview-box").remove();
});

// ✅ Remove EXISTING image (already saved in DB)
$(document).on("click", ".remove-existing-img", function () {
    const imgId = $(this).data("id");
    removedImages.push(imgId); // store in array
    $(this).closest(".preview-box").remove();
});

// ✅ AJAX Form Submission for Image Upload / Update
$("#galleryForm").on("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const id = $("#galleryId").val();

    // 🟢 If editing, send PUT method
    if (id) formData.append("_method", "PUT");

    // 🟢 Append selected new files
    formData.delete("images[]");
    selectedFiles.forEach((file) => {
        formData.append("images[]", file);
    });

    // 🟢 Append removed images (IDs)
    formData.append("removed_images", JSON.stringify(removedImages));

    // 🟢 Disable button during upload
    $("#uploadGalleryBtn").prop("disabled", true).text("Uploading...");

    $.ajax({
        url: id ? `/gallery/${id}` : "/gallery",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (res) {
            $("#uploadGalleryBtn")
                .prop("disabled", false)
                .html('<i class="bi bi-upload"></i> Upload');

            const myModalEl = document.getElementById("galleryModal");
            const modal = bootstrap.Modal.getInstance(myModalEl);
            modal.hide();

            $("#galleryTable").DataTable().ajax.reload();

            // Reset everything
            $("#galleryForm")[0].reset();
            $("#previewGalleryContainer").html("");
            selectedFiles = [];
            removedImages = [];

            Swal.fire("Success", res.status || "Gallery Saved Successfully!", "success");
        },
        error: function (xhr) {
            $("#uploadGalleryBtn")
                .prop("disabled", false)
                .html('<i class="bi bi-upload"></i> Upload');

            let errorMsg =
                xhr.responseJSON && xhr.responseJSON.message
                    ? xhr.responseJSON.message
                    : "An error occurred";
            Swal.fire("Error", errorMsg, "error");
        },
    });
});

  // ✏️ Edit record (open modal)
$(document).on("click", ".editGalleryBtn", function () {
    let id = $(this).data("id");

    $.ajax({
        url: `/gallery/${id}/edit`,
        type: "GET",
        success: function (data) {
            $("#galleryId").val(data.id);
            $("#editGalleryTitle").val(data.title);
            $("#editGalleryDescription").val(data.description);

            $("#previewGalleryContainer").html("");
            selectedFiles = [];
            removedImages = [];

            if (data.images && data.images.length > 0) {
                data.images.forEach((img) => {
                    $("#previewGalleryContainer").append(`
                        <div class="preview-box position-relative d-inline-block me-2 mb-2" style="width:100px; height:100px;">
                            <img src="/storage/${img.image_path}" data-id="${img.id}"
                                 class="img-thumbnail" style="width:100%; height:100%; object-fit:cover; border-radius:6px;">
                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-existing-img"
                                    data-id="${img.id}"
                                    style="border-radius:50%; width:22px; height:22px; line-height:16px; padding:0;">
                                <i class="fa fa-times" style="font-size:12px;"></i>
                            </button>
                        </div>
                    `);
                });
            }

            $("#editGalleryImage").val("");
            modal.show();
        },
    });
});

    $("#editGalleryImage").on("change", function () {
        $("#previewGalleryContainer").find('[data-existing="0"]').remove(); // remove old new previews

        let files = this.files;
        if (files.length > 0) {
            Array.from(files).forEach((file, index) => {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $("#previewGalleryContainer").append(`
                    <div class="img-preview" data-existing="0" data-index="${index}" 
                        style="
                            position:relative;
                            width:100px;
                            height:100px;
                            border:1px solid #ccc;
                            border-radius:8px;
                            overflow:hidden;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            background:#f9f9f9;
                            margin-right:8px;
                            margin-bottom:8px;
                        ">
                        <img src="${e.target.result}" 
                             style="
                                width:100%;
                                height:100%;
                                object-fit:contain;
                                border-radius:6px;
                             ">
                        <button type="button" class="remove-img-btn" 
                            style="
                                position:absolute;
                                top:2px;
                                right:2px;
                                background:rgba(255,0,0,0.8);
                                color:white;
                                border:none;
                                border-radius:50%;
                                width:22px;
                                height:22px;
                                font-size:12px;
                                cursor:pointer;
                            ">×</button>
                    </div>
                `);
                };
                reader.readAsDataURL(file);
            });
        }
    });
    // ✅ Remove Image Preview (old or new)
    $(document).on("click", ".remove-img-btn", function () {
        let container = $(this).closest(".img-preview");

        // existing = 1 → old image from DB
        if (container.data("existing") == 1) {
            let imgId = container.data("id");
            window.removedImageIds.push(imgId);
        }

        // remove from preview
        container.remove();
    });

    // 🗑️ Delete record
    $(document).on("click", ".deleteGalleryBtn", function () {
        let id = $(this).data("id");

        Swal.fire({
            title: "Are you sure?",
            text: "This image will be deleted permanently!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/gallery/${id}`,
                    type: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    success: function (res) {
                        table.ajax.reload(null, false);
                        Swal.fire("Deleted!", res.status, "success");
                        $("#galleryForm")[0].reset();
                    },
                    error: function (xhr) {
                        Swal.fire("Error", "Failed to delete record", "error");
                    },
                });
            }
        });
    });

    // 👁️ View record
    $(document).on("click", ".viewGalleryBtn", function () {
        let galleryId = $(this).data("id");

        $("#viewGalleryContent").html(`
        <div class="text-center text-muted py-3">
            <i class="fa fa-spinner fa-spin fa-2x"></i>
            <p class="mt-2">Loading gallery data...</p>
        </div>
    `);

        $.ajax({
            url: "/gallery/" + galleryId, // route('gallery.show', id)
            type: "GET",
            success: function (response) {
                $("#viewGalleryContent").html(response.html);
            },
            error: function () {
                $("#viewGalleryContent").html(`
                <div class="alert alert-danger text-center">
                    Failed to load gallery data. Please try again.
                </div>
            `);
            },
        });
    });
});
