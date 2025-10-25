    // FUll CRUD Operations with All Features AJAX, Bootstrap Modal, and SweetAlert2 
            let lastPaginationUrl = "{{ route('students.index') }}"; // Default: page 1
            $(document).ready(function() {

                // Initialize DataTable
                let studentModal = new bootstrap.Modal(document.getElementById('studentModal'), {
                    backdrop: 'static',
                    keyboard: false
                });
                // Set Per Page Data Logic
                $(document).on("change", "#perPage", function() {
                    const perPage = $(this).val();
                    $("#hiddenPerPage").val(perPage); // update hidden input
                    fetchData("{{ route('students.index') }}"); // fetch fresh data
                });

                // Handle Add Student Button Reset Form 
                $('#addStudentBtn').click(function() {
                    $('#studentForm')[0].reset();
                    $('#student_id').val('');
                    $('#previewImg').attr('src', '');
                    $('#studentModalLabel').text('Add Student');
                    studentModal.show();
                });
                // Handle Profile Image Preview
                $('#profile_image').change(function() {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        $('#previewImg').attr('src', e.target.result);
                    }
                    if (this.files[0]) reader.readAsDataURL(this.files[0]);
                    else $('#previewImg').attr('src', '');
                });

                // Handle Form Submission
                // ✅ Handle Form Submission for Insert + Update using POST
                $('#studentForm').on('submit', function(e) {
                    e.preventDefault();

                    let formData = new FormData(this);
                    let id = $('#student_id').val();
                    let submitBtn = $('#submitBtn');
                    let originalText = submitBtn.text();

                    submitBtn.prop('disabled', true).text(id ? 'Updating...' : 'Saving...');

                    $.ajax({
                        url: "{{ route('students.store') }}", // 👈 You are using updateOrCreate in this
                        method: 'POST', // 👈 Always POST (no need for PUT)
                        data: formData,
                        contentType: false,
                        processData: false,

                        success: function(res) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: res
                                    .message, // ✅ message already contains student name
                                showConfirmButton: false,
                                timer: 2500,
                                timerProgressBar: true,
                                background: '#e6ffed',
                                color: '#1a7f37',
                                iconColor: '#1a7f37',
                                showClass: {
                                    popup: 'animate__animated animate__fadeInRight'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOutRight'
                                },
                                customClass: {
                                    popup: 'border-0 shadow-lg rounded-4 px-4 py-3'
                                },
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal
                                        .stopTimer);
                                    toast.addEventListener('mouseleave', Swal
                                        .resumeTimer);
                                }
                            });

                            $('#studentForm')[0].reset();
                            $('#student_id').val('');
                            $('#previewImg').attr('src', '');
                            submitBtn.prop('disabled', false).text('Save');
                            studentModal.hide();

                            // const currentUrl = "{{ route('students.index') }}";
                            // const filters = $('#filterForm').serialize();
                            // fetchData(currentUrl, filters);
                            if (id) {
                                fetchData(lastPaginationUrl); // ✅ Use saved pagination URL
                            } else {
                                fetchData();
                            }
                        },

                        error: function(xhr) {
                            let msg = 'Something went wrong!';
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                msg = Object.values(xhr.responseJSON.errors).join('<br>');
                            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                                msg = xhr.responseJSON.message;
                            }

                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: 'Error',
                                html: msg,
                                showConfirmButton: false,
                                timer: 3500,
                                timerProgressBar: true,
                                background: '#fff0f0',
                                color: '#d90429',
                                iconColor: '#d90429',
                                showClass: {
                                    popup: 'animate__animated animate__fadeInRight'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOutRight'
                                },
                                customClass: {
                                    popup: 'border-0 shadow-lg rounded-4 px-4 py-3'
                                },
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal
                                        .resumeTimer)
                                }
                            });
                            fetchData(lastPaginationUrl); // ✅ Use saved pagination URL
                            submitBtn.prop('disabled', false).text(originalText);
                        }
                    });
                });


                // Handle Edit Button Click
                $(document).on('click', '.editBtn', function() {
                    const id = $(this).data('id');
                    $.get(`/students/${id}/edit`, function(student) {
                        if (!student) {
                            Swal.fire("Not Found", "Student not found", "error");
                            return;
                        }

                        $('#student_id').val(student.id);
                        $('#name').val(student.name);
                        $('#father_name').val(student.father_name);
                        $('#mother_name').val(student.mother_name);
                        $('#email').val(student.email);
                        $('#mobile').val(student.mobile);
                        $('#dob').val(student.dob);
                        $('#address').val(student.address);
                        $("input[name='gender'][value='" + student.gender + "']").prop('checked', true);
                        $('#classes').val(student.classes);
                        $('#previewImg').attr('src', student.image ?
                            `/storage/${student.image}` : '');

                        $('#studentModalLabel').text('Edit Student');
                        $('#submitBtn').text('Update');
                        studentModal.show();
                    });
                });


                // Handle Delete Button Click
                $(document).on('click', '.deleteBtn', function() {
                    // data-id ka value fetch karo (id,name format me)
                    const data = $(this).data('id'); // "12,Krishna"

                    // String ko split karke array banao
                    const parts = data.split(',');

                    const id = parts[0]; // student id
                    const name = parts[1]; // student name
                    Swal.fire({
                        title: `Delete ${name}?`, // <-- dynamic name in title
                        text: `Are you sure you want to delete ${name}? This action cannot be undone.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: `/students/${id}`,
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(res) {
                                    if (res.status) {
                                        Swal.fire({
                                            toast: true,
                                            position: 'top-end',
                                            icon: 'success',
                                            title: `${name} has been deleted successfully!`,
                                            showConfirmButton: false,
                                            timer: 2500
                                        });
                                        fetchData(lastPaginationUrl);
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error!',
                                            text: res.message ||
                                                `Failed to delete ${name}`
                                        });
                                    }
                                },
                                error: function(xhr) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: xhr.responseJSON?.message ||
                                            'Something went wrong!'
                                    });
                                }

                            });
                        }
                    });

                });



            });
            // End of Document Ready Function

            // Search Functionality  
            document.addEventListener("DOMContentLoaded", function() {
                const $studentList = $("#studentList");
                const $paginationLinks = $("#paginationLinks");
                const $filterForm = $("#filterForm");

                // 👉 Debounce Function
                // Debounce function
                function debounce(func, delay) {
                    let timer;
                    return function(...args) {
                        clearTimeout(timer);
                        timer = setTimeout(() => {
                            func.apply(this, args);
                        }, delay);
                    };
                }

                // Filter change/input
                $(document).on("change input", "#filterForm input, #filterForm select", debounce(function() {
                    fetchData("{{ route('students.index') }}");
                }, 500));
                // 🔁 AJAX Pagination Only
                $(document).on("click", "#paginationLinks .pagination a", function(e) {
                    e.preventDefault();
                    const url = $(this).attr("href");
                    lastPaginationUrl = url; // 🔴 Save the current pagination URL
                    fetchData(url);
                });

                // 👇 Initial Page Load
                // const currentUrl = window.location.href;
                // fetchData(currentUrl);
            });

            // 📦 Fetch Data Function for Pagination and Filter
            let debounceTimer = null;
            let isFetching = false;

            function fetchData(url = "{{ route('students.index') }}", formData = null) {
                const $studentList = $("#studentList");
                if (!formData) {
                    formData = $('#filterForm, #globalSearchForm').serialize();
                }

                // 🚫 Don't show spinner again if already loading
                if (!isFetching) {
                    $studentList.html(`
                         <div class="text-center py-4">
                              <div class="spinner-border text-primary" role="status">
                                   <span class="visually-hidden">Loading...</span>
                              </div>
                          </div>
                        `);
                }

                isFetching = true;

                $.ajax({
                    url: url,
                    type: "GET",
                    data: formData,
                    dataType: "html",
                    success: function(data) {
                        const $data = $(data);
                        const newContent = $data.find("#studentsData").html();
                        $studentList.html(newContent);
                    },
                    error: function() {
                        $studentList.html('<div class="alert alert-danger text-center">Failed to Load Data</div>');
                    },
                    complete: function() {
                        isFetching = false;
                    }
                });
            }


            // Initial Data Fetch on Page Load
            $('body').addClass('loading');
            fetchData("{{ route('students.index') }}");
            setTimeout(() => $('body').removeClass('loading'), 1000); // remove after delay
            // Global Search Input Debounce
            $(document).on("input", "#globalSearchInput", function() {
                $("body").addClass("loading");
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    fetchData("{{ route('students.index') }}");
                    setTimeout(() => {
                        $("body").removeClass("loading");
                    }, 800);
                }, 400);
            });

            // Reset Filter Button Functionality
            $(document).on("click", "#resetFilter", function() {
                $("#filterForm")[0].reset();
                $("#globalSearchForm")[0].reset();
                fetchData("{{ route('students.index') }}");
            });


            // Refresh DataTable
            // function fetchStudents() {
            //     $.get(window.location.href, function(data) {
            //         $("#studentList").html($(data).find("#studentList").html());
            //         // $("#studentsTable").DataTable();
            //     });
            //     // Optionally, handle edit/delete buttons here if needed
            // }