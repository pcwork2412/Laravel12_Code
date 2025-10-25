@extends('School_Dashboard.Admin_Layouts.app')
@section('content')
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --success-color: #2ecc71;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --light-bg: #f8f9fa;
            --dark-bg: #343a40;
            --accent-color: #9b59b6;
        }
        
        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }
        
        .profile-header {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            padding: 2rem 0;
            border-radius: 0 0 20px 20px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid rgba(255,255,255,0.3);
            object-fit: cover;
        }
        
        .profile-card {
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border: none;
            transition: transform 0.3s;
            margin-bottom: 20px;
            overflow: hidden;
        }
        
        .profile-card:hover {
            transform: translateY(-5px);
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid #eaeaea;
            border-radius: 15px 15px 0 0 !important;
            padding: 1.25rem;
            font-weight: 600;
            display: flex;
            align-items: center;
        }
        
        .card-header i {
            margin-right: 10px;
            color: var(--primary-color);
        }
        
        .info-item {
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
        }
        
        .info-item:last-child {
            border-bottom: none;
        }
        
        .info-label {
            min-width: 140px;
            font-weight: 600;
            color: #555;
        }
        
        .stats-card {
            text-align: center;
            padding: 1.5rem;
        }
        
        .stats-number {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0;
            line-height: 1;
        }
        
        .stats-label {
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 5px;
        }
        
        .badge-status {
            padding: 0.5em 1em;
            border-radius: 50px;
            font-weight: 500;
        }
        
        .action-buttons .btn {
            margin-right: 10px;
            margin-bottom: 10px;
            border-radius: 50px;
            padding: 8px 20px;
        }
        
        .tab-content {
            padding: 20px 0;
        }
        
        .activity-item {
            padding: 15px;
            border-left: 3px solid var(--primary-color);
            margin-bottom: 15px;
            background-color: #f8fafc;
            border-radius: 0 8px 8px 0;
        }
        
        .activity-time {
            font-size: 0.85rem;
            color: #6c757d;
        }
        
        .subject-badge {
            padding: 5px 10px;
            border-radius: 20px;
            margin-right: 5px;
            margin-bottom: 5px;
            display: inline-block;
            font-size: 0.85rem;
        }
        
        .attendance-chart {
            height: 200px;
            display: flex;
            align-items: flex-end;
            justify-content: space-around;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .attendance-bar {
            width: 30px;
            background: var(--primary-color);
            border-radius: 3px 3px 0 0;
            position: relative;
        }
        
        .attendance-bar-label {
            position: absolute;
            bottom: -25px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 0.8rem;
        }
        
        .performance-meter {
            height: 10px;
            background: #e9ecef;
            border-radius: 5px;
            overflow: hidden;
            margin: 10px 0;
        }
        
        .performance-fill {
            height: 100%;
            background: var(--success-color);
            border-radius: 5px;
        }
        
        @media (max-width: 768px) {
            .profile-avatar {
                width: 120px;
                height: 120px;
            }
            
            .action-buttons .btn {
                width: 100%;
                margin-right: 0;
            }
            
            .info-item {
                flex-direction: column;
            }
            
            .info-label {
                min-width: auto;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header class="profile-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-2 text-center">
                    <img src="https://picsum.photos/200/200" alt="Profile Avatar" class="profile-avatar">
                </div>
                <div class="col-md-7">
                    <h1 class="h2 mb-1">{{session('user_name')}}</h1>
                    <p class="mb-2">Principal & Administrator</p>
                    <span class="badge badge-status bg-success">Active</span>
                    <span class="badge badge-status bg-info ms-2">10+ Years Experience</span>
                </div>
                <div class="col-md-3 text-md-end">
                    <div class="action-buttons mt-3 mt-md-0">
                        <button class="btn btn-light"><i class="fas fa-edit me-1"></i> Edit Profile</button>
                        <button class="btn btn-outline-light"><i class="fas fa-envelope me-1"></i> Send Message</button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-4">
                <!-- Staff Details Card -->
                <div class="card profile-card">
                    <div class="card-header">
                        <i class="fas fa-id-card"></i> Staff Information
                    </div>
                    <div class="card-body">
                        <div class="info-item">
                            <div class="info-label">Full Name:</div>
                            <div>Dr. Sarah Elizabeth Johnson</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Staff ID:</div>
                            <div>STF-2020-087</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Department:</div>
                            <div>Administration</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Designation:</div>
                            <div>Principal</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Email:</div>
                            <div>s.johnson@prestigeschool.edu</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Phone:</div>
                            <div>+1 (555) 123-4567</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Join Date:</div>
                            <div>August 15, 2015</div>
                        </div>
                    </div>
                </div>

            
            </div>

            <!-- Right Column -->
            <div class="col-lg-8">
                <!-- Tabs Navigation -->
                <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="activity-tab" data-bs-toggle="tab" data-bs-target="#activity" type="button" role="tab">Activity Log</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="classes-tab" data-bs-toggle="tab" data-bs-target="#classes" type="button" role="tab">Class Management</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="performance-tab" data-bs-toggle="tab" data-bs-target="#performance" type="button" role="tab">School Performance</button>
                    </li>
                </ul>

                <!-- Tabs Content -->
                <div class="tab-content" id="profileTabsContent">
                    <!-- Activity Tab -->
                    <div class="tab-pane fade show active" id="activity" role="tabpanel">
                        <h4 class="mb-4">Recent Administrative Activity</h4>
                        
                        <div class="activity-item">
                            <div class="d-flex justify-content-between">
                                <h6>Staff Meeting Conducted</h6>
                                <span class="activity-time">Today, 10:30 AM</span>
                            </div>
                            <p class="mb-0">Monthly staff meeting with all teaching faculty</p>
                        </div>
                        
                        <div class="activity-item">
                            <div class="d-flex justify-content-between">
                                <h6>Parent-Teacher Conference</h6>
                                <span class="activity-time">Yesterday, 2:00 PM</span>
                            </div>
                            <p class="mb-0">Met with parents of Grade 10 students</p>
                        </div>
                        
                        <div class="activity-item">
                            <div class="d-flex justify-content-between">
                                <h6>Curriculum Updated</h6>
                                <span class="activity-time">March 15, 2023</span>
                            </div>
                            <p class="mb-0">Approved new science curriculum for middle school</p>
                        </div>
                        
                        <div class="activity-item">
                            <div class="d-flex justify-content-between">
                                <h6>School Event Organized</h6>
                                <span class="activity-time">March 10, 2023</span>
                            </div>
                            <p class="mb-0">Annual science fair with 150 participants</p>
                        </div>
                        
                        <div class="activity-item">
                            <div class="d-flex justify-content-between">
                                <h6>Budget Review Meeting</h6>
                                <span class="activity-time">March 5, 2023</span>
                            </div>
                            <p class="mb-0">Quarterly budget review with school board</p>
                        </div>
                    </div>

                    <!-- Classes Tab -->
                    <div class="tab-pane fade" id="classes" role="tabpanel">
                        <h4 class="mb-4">Class Management</h4>
                        
                        <div class="card profile-card">
                            <div class="card-header">
                                <i class="fas fa-users"></i> Class Assignments
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Class</th>
                                                <th>Students</th>
                                                <th>Class Teacher</th>
                                                <th>Performance</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Grade 10-A</td>
                                                <td>38</td>
                                                <td>Mr. Robert Brown</td>
                                                <td>
                                                    <div class="performance-meter">
                                                        <div class="performance-fill" style="width: 92%"></div>
                                                    </div>
                                                    <small>92%</small>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">View</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Grade 9-B</td>
                                                <td>42</td>
                                                <td>Ms. Emily Davis</td>
                                                <td>
                                                    <div class="performance-meter">
                                                        <div class="performance-fill" style="width: 88%"></div>
                                                    </div>
                                                    <small>88%</small>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">View</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Grade 8-C</td>
                                                <td>35</td>
                                                <td>Mr. James Wilson</td>
                                                <td>
                                                    <div class="performance-meter">
                                                        <div class="performance-fill" style="width: 85%"></div>
                                                    </div>
                                                    <small>85%</small>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">View</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Grade 7-A</td>
                                                <td>40</td>
                                                <td>Ms. Lisa Anderson</td>
                                                <td>
                                                    <div class="performance-meter">
                                                        <div class="performance-fill" style="width: 90%"></div>
                                                    </div>
                                                    <small>90%</small>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">View</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Performance Tab -->
                    <div class="tab-pane fade" id="performance" role="tabpanel">
                        <h4 class="mb-4">School Performance Overview</h4>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card profile-card">
                                    <div class="card-header">
                                        <i class="fas fa-chart-line"></i> Attendance Trend
                                    </div>
                                    <div class="card-body">
                                        <div class="attendance-chart">
                                            <div class="attendance-bar" style="height: 70%">
                                                <div class="attendance-bar-label">Mon</div>
                                            </div>
                                            <div class="attendance-bar" style="height: 85%">
                                                <div class="attendance-bar-label">Tue</div>
                                            </div>
                                            <div class="attendance-bar" style="height: 90%">
                                                <div class="attendance-bar-label">Wed</div>
                                            </div>
                                            <div class="attendance-bar" style="height: 88%">
                                                <div class="attendance-bar-label">Thu</div>
                                            </div>
                                            <div class="attendance-bar" style="height: 82%">
                                                <div class="attendance-bar-label">Fri</div>
                                            </div>
                                        </div>
                                        <div class="text-center mt-3">
                                            <p class="mb-1">Weekly Average: <strong>85%</strong></p>
                                            <small class="text-muted">+2% from previous week</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card profile-card">
                                    <div class="card-header">
                                        <i class="fas fa-award"></i> Academic Performance
                                    </div>
                                    <div class="card-body">
                                        <div class="info-item">
                                            <div class="info-label">Overall GPA:</div>
                                            <div>3.75 / 4.0</div>
                                        </div>
                                        <div class="info-item">
                                            <div class="info-label">Top Performing Class:</div>
                                            <div>Grade 10-A (92%)</div>
                                        </div>
                                        <div class="info-item">
                                            <div class="info-label">Graduation Rate:</div>
                                            <div>98%</div>
                                        </div>
                                        <div class="info-item">
                                            <div class="info-label">College Acceptance:</div>
                                            <div>94%</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card profile-card">
                            <div class="card-header">
                                <i class="fas fa-tasks"></i> Upcoming Events & Tasks
                            </div>
                            <div class="card-body">
                                <div class="activity-item">
                                    <div class="d-flex justify-content-between">
                                        <h6>Quarterly Examinations</h6>
                                        <span class="activity-time">April 10-15, 2023</span>
                                    </div>
                                    <p class="mb-0">Preparation and scheduling for all classes</p>
                                </div>
                                
                                <div class="activity-item">
                                    <div class="d-flex justify-content-between">
                                        <h6>Annual Sports Day</h6>
                                        <span class="activity-time">April 22, 2023</span>
                                    </div>
                                    <p class="mb-0">Planning committee meeting next week</p>
                                </div>
                                
                                <div class="activity-item">
                                    <div class="d-flex justify-content-between">
                                        <h6>Teacher Training Workshop</h6>
                                        <span class="activity-time">May 5, 2023</span>
                                    </div>
                                    <p class="mb-0">New educational technology tools training</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab functionality
            var firstTab = new bootstrap.Tab(document.getElementById('activity-tab'));
            firstTab.show();
            
            var tabEls = document.querySelectorAll('a[data-bs-toggle="tab"]');
            tabEls.forEach(function(tabEl) {
                tabEl.addEventListener('shown.bs.tab', function (event) {
                    console.log('Tab activated:', event.target.getAttribute('data-bs-target'));
                });
            });
            
            // Simple animation for attendance bars
            setTimeout(function() {
                document.querySelectorAll('.attendance-bar').forEach(function(bar) {
                    bar.style.transition = 'height 1s ease-in-out';
                });
            }, 500);
        });
    </script>
@endsection