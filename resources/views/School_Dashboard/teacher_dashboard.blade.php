@extends('school_dashboard.teacher_layouts.app')
@section('content')
    <!-- Popup Modal -->
    {{-- @if ($showPopup ?? "false")
        <div id="popupModal" class="popup-modal">
            <div class="popup-content">
                <span class="close-btn">&times;</span>
                <h1 class="text-danger">Important!</h1>
                <p>Please change your password first</p>
                <a href="{{ route('teachprofile.index') }}" class="popup-btn">Change Now</a>
            </div>
        </div>
        
    @endif --}}
    {{-- Toast Notification --}}
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1080;">
        @if (session('success'))
            <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive"
                aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>

    <div class="container mt-4">

        {{-- Teacher Info Card --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary">
                <h3 class="mb-1 p-1 fw-bold text-white"><i class="fa-solid fa-chalkboard-teacher me-2"></i>Welcome
                    {{ $teacher->teacher_name ?? 'Teacher' }}-({{ $teacher->teacher_id ?? 'ID' }})</h3>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="stats-container">
                        <div class="stat-card">
                            <div class="stat-header">
                                <div class="stat-icon">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <div class="stat-trend">
                                    {{-- <i class="fas fa-arrow-up"></i>
                                    <span>12%</span> --}}
                                    <h3 style="color: #3b82f6;">Students</h3>
                                </div>
                            </div>
                            <div class="stat-value">
                                <h2 class="fw-bold">{{ isset($students) ? $students->count() : 0 }}</h2>

                            </div>
                            <div class="stat-label">Total Students</div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-header">
                                <div class="stat-icon">
                                    <i class="fas fa-chalkboard"></i>
                                </div>
                                <div class="stat-trend">
                                    {{-- <i class="fas fa-arrow-up"></i>
                                    <span>5%</span> --}}
                                    <h3 style=" color: #10b981;">Main Class/Sec</h3>
                                </div>
                            </div>
                            <div class="stat-value">
                                <h4 class="fw-bold">{{ $allotment->mainClass->class_name ?? '-' }} -
                                    {{ $allotment->mainSection->section_name ?? '-' }}</h4>
                            </div>
                            <div class="stat-label">Total Classes</div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-header">
                                <div class="stat-icon">
                                    <i class="fas fa-book"></i>
                                </div>
                                <div class="stat-trend">
                                    {{-- <i class="fas fa-arrow-up"></i>
                                    <span>3%</span> --}}
                                    <h3 style="color: #8b5cf6">Sub-Section</h3>
                                </div>
                            </div>
                            <div class="stat-value">
                                <h5 class="fw-bold">
                                    {{-- @foreach ($allotment->subSections as $subSection)
                                    Sec-{{ $subSection->section_name }}
                                @endforeach --}}
                                    <a href="" class="text-primary"><i class="fa fa-eye"></i> View All</a>
                                </h5>
                            </div>
                            <div class="stat-label">Sub-Sections</div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-header">
                                <div class="stat-icon">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                                <div class="stat-trend down">
                                    {{-- <i class="fas fa-arrow-down"></i>
                                    <span>2%</span> --}}
                                    <h3 style="color: #f59e0b">Sub-Class</h3>

                                </div>
                            </div>
                            <div class="stat-value">
                                <h5 class="fw-bold">
                                    {{-- @foreach ($allotment->subClasses as $subClass)
                                    {{ $subClass->class_name }}
                                @endforeach --}}
                                    <a href="" class="text-primary"><i class="fa fa-eye"></i> View All</a>
                                </h5>
                            </div>
                            <div class="stat-label">Sub-Classes</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    {{-- Custom Styles --}}
    <style>
        .popup-modal {
            display: none;
            /* initially hidden */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        /* Popup box */
        .popup-content {
            position: relative;
            /* important for close button */
            background: #fff;
            padding: 30px 40px;
            border-radius: 15px;
            text-align: center;
            font-size: 1.5rem;
            max-width: 600px;
            animation: popupFade 0.5s ease;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        }

        /* Close button */
        .close-btn {
            position: absolute;
            /* relative to popup-content */
            top: 10px;
            right: 15px;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
            color: #333;
            z-index: 10;
        }

        /* Button style */
        .popup-btn {
            padding: 10px 20px;
            background-color: #ff0000;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 15px;
        }

        /* Fade animation */
        @keyframes popupFade {
            from {
                transform: scale(0.5);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            transition: transform 0.2s, box-shadow 0.2s;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #6366f1);
        }

        .stat-card:nth-child(2)::before {
            background: linear-gradient(90deg, #10b981, #22c55e);
        }

        .stat-card:nth-child(3)::before {
            background: linear-gradient(90deg, #8b5cf6, #a855f7);
        }

        .stat-card:nth-child(4)::before {
            background: linear-gradient(90deg, #f59e0b, #f97316);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .stat-card:nth-child(2) .stat-icon {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .stat-card:nth-child(3) .stat-icon {
            background: rgba(139, 92, 246, 0.1);
            color: #8b5cf6;
        }

        .stat-card:nth-child(4) .stat-icon {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
        }

        .stat-trend {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 14px;
            font-weight: 500;
            color: #10b981;
        }

        .stat-trend.down {
            color: #ef4444;
        }

        .stat-value {
            float: right;
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            padding-top: 30px;
        }

        .stat-label {
            color: #64748b;
            font-size: 14px;
            font-weight: 500;
            padding-top: 30px;
        }
    </style>

@endsection
@push('scripts')
    <script>
        // Wait for page load
        window.addEventListener('load', function() {
            const popup = document.getElementById('popupModal');
            const closeBtn = document.querySelector('.close-btn');

            // Show popup after 1 second
            setTimeout(() => {
                popup.style.display = 'flex';
                closeBtn.style.display = 'flex';
            });

            // Close popup on click
            closeBtn.addEventListener('click', () => {
                popup.style.display = 'none';
            });

            // Close popup if user clicks outside content
            window.addEventListener('click', (e) => {
                if (e.target === popup) {
                    popup.style.display = 'flex';
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            var toastElList = [].slice.call(document.querySelectorAll('.toast'))
            var toastList = toastElList.map(function(toastEl) {
                return new bootstrap.Toast(toastEl, {
                    delay: 4000
                });
            });
            toastList.forEach(toast => toast.show());
        });
    </script>
@endpush
