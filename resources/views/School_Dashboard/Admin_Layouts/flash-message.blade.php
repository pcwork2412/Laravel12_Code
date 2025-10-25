{{-- ✅ Include Toastify CDN --}}
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

                {{-- Success and Error Messages --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
@if (session('success'))
<script>
document.addEventListener("DOMContentLoaded", function () {
    Toastify({
        text: "{{ session('success') }}",
        duration: 4000,
        close: true,
        gravity: "top", // top or bottom
        position: "right", // left, center or right
        stopOnFocus: true, // pause on hover
        style: {
            background: "linear-gradient(to right, #00b09b, #96c93d)",
            color: "#fff",
            borderRadius: "8px",
            boxShadow: "0 3px 8px rgba(0,0,0,0.2)",
            fontWeight: "500",
            fontSize: "15px",
        },
        offset: {
            x: 15,
            y: 15
        },
        avatar: "https://cdn-icons-png.flaticon.com/512/845/845646.png", // ✅ success icon
    }).showToast();
});
</script>
@endif

@if (session('error'))
<script>
document.addEventListener("DOMContentLoaded", function () {
    Toastify({
        text: "{{ session('error') }}",
        duration: 5000,
        close: true,
        gravity: "top",
        position: "right",
        stopOnFocus: true,
        style: {
            background: "linear-gradient(to right, #ff5f6d, #ffc371)",
            color: "#fff",
            borderRadius: "8px",
            boxShadow: "0 3px 8px rgba(0,0,0,0.2)",
            fontWeight: "500",
            fontSize: "15px",
        },
        offset: {
            x: 15,
            y: 15
        },
        avatar: "https://cdn-icons-png.flaticon.com/512/463/463612.png", // ⚠️ error icon
    }).showToast();
});
</script>
@endif
