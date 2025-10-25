@extends('School_Dashboard.Admin_Layouts.app')
@section('content')
    <style>
        .dashboard-container {
            padding: 25px 30px;
            font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
            background-color: #f8fafc;
            min-height: 100vh;
            color: #1e293b;
        }

        .dashboard-header {
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .dashboard-title h1 {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .dashboard-title p {
            color: #64748b;
            font-size: 16px;
            margin: 0;
        }

        .header-actions {
            display: flex;
            gap: 12px;
        }

        .header-action-btn {
            padding: 10px 16px;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 500;
            color: #475569;
            cursor: pointer;
            transition: all 0.2s;
        }

        .header-action-btn:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
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
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #64748b;
            font-size: 14px;
            font-weight: 500;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .chart-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .chart-header h3 {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }

        .chart-filter {
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            background: white;
            font-size: 14px;
            color: #475569;
            cursor: pointer;
        }

        .chart-content {
            height: 300px;
            background: linear-gradient(45deg, #f8fafc, #f1f5f9);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            font-size: 16px;
            position: relative;
            overflow: hidden;
        }

        .chart-content::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(#cbd5e1 1px, transparent 1px),
                radial-gradient(#cbd5e1 1px, transparent 1px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
            opacity: 0.3;
        }

        .recent-activities {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }

        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .activity-item {
            display: flex;
            align-items: flex-start;
            padding: 16px;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .activity-item:hover {
            background: #f8fafc;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 16px;
            flex-shrink: 0;
        }

        .activity-icon.primary {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .activity-icon.success {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .activity-icon.warning {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
        }

        .activity-icon.purple {
            background: rgba(139, 92, 246, 0.1);
            color: #8b5cf6;
        }

        .activity-content {
            flex: 1;
        }

        .activity-content h4 {
            font-size: 15px;
            font-weight: 500;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .activity-content p {
            font-size: 14px;
            color: #64748b;
            margin: 0;
            line-height: 1.5;
        }

        .activity-time {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 4px;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-top: 30px;
        }

        .action-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .action-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .action-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 12px;
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .action-card:nth-child(2) .action-icon {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .action-card:nth-child(3) .action-icon {
            background: rgba(139, 92, 246, 0.1);
            color: #8b5cf6;
        }

        .action-card:nth-child(4) .action-icon {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
        }

        .action-title {
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .action-desc {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 16px;
        }

        .action-btn {
            padding: 8px 16px;
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
        }

        .action-btn:hover {
            background: #2563eb;
        }

        @media (max-width: 1024px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .dashboard-container {
                padding: 20px 15px;
            }

            .stats-container {
                grid-template-columns: 1fr;
            }

            .header-actions {
                width: 100%;
            }

            .header-action-btn {
                flex: 1;
                justify-content: center;
            }
        }

        /* Animation for elements */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-card,
        .chart-card,
        .recent-activities,
        .action-card {
            animation: fadeInUp 0.5s ease-out forwards;
            opacity: 0;
        }

        .stat-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .stat-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .stat-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .stat-card:nth-child(4) {
            animation-delay: 0.4s;
        }

        .chart-card {
            animation-delay: 0.5s;
        }

        .recent-activities {
            animation-delay: 0.6s;
        }

        .action-card:nth-child(1) {
            animation-delay: 0.7s;
        }

        .action-card:nth-child(2) {
            animation-delay: 0.8s;
        }

        .action-card:nth-child(3) {
            animation-delay: 0.9s;
        }

        .action-card:nth-child(4) {
            animation-delay: 1.0s;
        }
    </style>

    <div class="dashboard-container">
        <div class="dashboard-header">
            <div class="dashboard-title">
                <h1>Admin Dashboard</h1>

                <div class="py-12">
                    <div class="mx-auto ">
                        <div class="fs-5 p-2">
                            <div class="p-6 ">
                                <span class="text-info">{{ session('user_name') }}</span> You're Logged In!
                            </div>
                        </div>
                    </div>
                </div>
                <p>Welcome to your education management dashboard</p>
            </div>
            <div class="header-actions">
                <button class="header-action-btn">
                    <i class="fas fa-download"></i>
                    <span>Export Report</span>
                </button>
                <button class="header-action-btn">
                    <i class="fas fa-calendar"></i>
                    <span>Select Date</span>
                </button>
            </div>
        </div>

        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="stat-trend">
                        <i class="fas fa-arrow-up"></i>
                        <span>12%</span>
                    </div>
                </div>
                <div class="stat-value">1,254</div>
                <div class="stat-label">Total Students</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="fas fa-chalkboard"></i>
                    </div>
                    <div class="stat-trend">
                        <i class="fas fa-arrow-up"></i>
                        <span>5%</span>
                    </div>
                </div>
                <div class="stat-value">48</div>
                <div class="stat-label">Total Classes</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="stat-trend">
                        <i class="fas fa-arrow-up"></i>
                        <span>3%</span>
                    </div>
                </div>
                <div class="stat-value">32</div>
                <div class="stat-label">Subjects</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="stat-trend down">
                        <i class="fas fa-arrow-down"></i>
                        <span>2%</span>
                    </div>
                </div>
                <div class="stat-value">24</div>
                <div class="stat-label">Teachers</div>
            </div>
        </div>

        <div class="dashboard-grid">
            <div class="chart-card">
                <div class="chart-header">
                    <h3>Student Performance Overview</h3>
                    <select class="chart-filter">
                        <option>Last 7 Days</option>
                        <option>Last 30 Days</option>
                        <option>Last 90 Days</option>
                    </select>
                </div>
                <div class="chart-content">
                    Student Performance Chart
                </div>
            </div>

            <div class="chart-card">
                <div class="chart-header">
                    <h3>Class Distribution</h3>
                </div>
                <div class="chart-content">
                    Class Distribution Chart
                </div>
            </div>
        </div>

        <div class="recent-activities">
            <div class="chart-header">
                <h3>Recent Activities</h3>
                <a href="#" style="color: #3b82f6; text-decoration: none; font-size: 14px; font-weight: 500;">View
                    All</a>
            </div>

            <div class="activity-list">
                <div class="activity-item">
                    <div class="activity-icon primary">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="activity-content">
                        <h4>New Student Registered</h4>
                        <p>Rahul Sharma has been added to Class 10-A</p>
                        <div class="activity-time">2 hours ago</div>
                    </div>
                </div>

                <div class="activity-item">
                    <div class="activity-icon success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="activity-content">
                        <h4>Marks Updated</h4>
                        <p>Science marks have been updated for Class 9-B</p>
                        <div class="activity-time">5 hours ago</div>
                    </div>
                </div>

                <div class="activity-item">
                    <div class="activity-icon warning">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <div class="activity-content">
                        <h4>ID Cards Generated</h4>
                        <p>ID cards have been generated for Class 12-A</p>
                        <div class="activity-time">Yesterday</div>
                    </div>
                </div>

                <div class="activity-item">
                    <div class="activity-icon purple">
                        <i class="fas fa-file-import"></i>
                    </div>
                    <div class="activity-content">
                        <h4>Data Imported</h4>
                        <p>Student data has been imported from Excel file</p>
                        <div class="activity-time">2 days ago</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="quick-actions">
            <div class="action-card">
                <div class="action-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="action-title">Add Student</div>
                <div class="action-desc">Register a new student to the system</div>
                <button class="action-btn">Add Now</button>
            </div>

            <div class="action-card">
                <div class="action-icon">
                    <i class="fas fa-id-card"></i>
                </div>
                <div class="action-title">Generate ID</div>
                <div class="action-desc">Create ID cards for students</div>
                <button class="action-btn">Generate</button>
            </div>

            <div class="action-card">
                <div class="action-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="action-title">Add Marks</div>
                <div class="action-desc">Enter examination marks</div>
                <button class="action-btn">Enter Marks</button>
            </div>

            <div class="action-card">
                <div class="action-icon">
                    <i class="fas fa-print"></i>
                </div>
                <div class="action-title">Print Reports</div>
                <div class="action-desc">Generate and print reports</div>
                <button class="action-btn">Print</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add any interactive functionality here if needed
            const actionButtons = document.querySelectorAll('.action-btn');

            actionButtons.forEach(button => {
                button.addEventListener('click', function() {
                    this.textContent = 'Processing...';
                    setTimeout(() => {
                        this.textContent = this.textContent.includes('Add') ? 'Added!' :
                            this.textContent.includes('Generate') ? 'Generated!' :
                            this.textContent.includes('Enter') ? 'Entered!' : 'Printed!';
                        setTimeout(() => {
                            this.textContent = this.textContent.includes('Add') ?
                                'Add Now' :
                                this.textContent.includes('Generate') ? 'Generate' :
                                this.textContent.includes('Enter') ? 'Enter Marks' :
                                'Print';
                        }, 1500);
                    }, 1000);
                });
            });
        });
    </script>
@endsection
