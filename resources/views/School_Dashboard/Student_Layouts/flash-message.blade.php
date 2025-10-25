@if(session('success')) 
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="10000" data-bs-autohide="false">
        <div class="toast-header">
            <strong class="me-auto">Success</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body text-white bg-success">
            {{ session('success') }}
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var toastEl = document.querySelector('.toast');
        var toast = new bootstrap.Toast(toastEl, { delay: 3000, "progressBar": true,}); // Auto close in 3 seconds
        toast.show();
    });
</script>
@endif


