// $(document).ready(function() {
//     // CSRF Token सेट करो
//     $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });

//     // Generate Barcode Button Submit
//     $("#labelForm").on('submit', function(e) {
//         e.preventDefault();

//         let formData = new FormData(this);

//         $.ajax({
//             url: "{{ route('gen-label') }}",
//             method: "POST",
//             data: formData,
//             contentType: false,
//             processData: false,
//             success: function(res) {
//                 $("#barcodeArea").html(res); // server से मिला HTML show कराओ
//                 Swal.fire('Success', 'Barcode Generated Successfully!', 'success');
//             },
//             error: function(xhr) {
//                 Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
//             }
//         });
//     });

//     // Print Button Click
//     $("#printBtn").click(function() {
//         window.open("{{ route('print-label') }}", "_blank");
//     });
// });