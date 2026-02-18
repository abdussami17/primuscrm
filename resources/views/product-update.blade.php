@extends('layouts.app')


@section('title','Product Updates')


@section('content')

<div class="content content-two pt-0">
    <!-- Page Header -->
    <div class="position-relative d-flex align-items-center justify-content-between flex-wrap gap-3 mb-2"
      style="min-height: 80px;">
      <!-- Left: Title -->
      <div>
        <h6 class="mb-0">Product Updates</h6>
      </div>

      <!-- Center: Logo -->
      <img src="assets/light_logo.png" alt="Logo" class="mobile-logo-no logo-img"
        style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); max-width: 80px; height: auto;">

    
    </div>

    <!-- Header Section -->
 

    <!-- Filter Buttons -->
    <div class="filter-buttons mt-4">
        <button class="filter-btn active" onclick="filterUpdates('all')">All Updates</button>
        <button class="filter-btn" onclick="filterUpdates('completed')">Completed</button>
        <button class="filter-btn" onclick="filterUpdates('upcoming')">Upcoming</button>
    </div>

    <!-- Table Container -->
    <div class="table-container">
        <div class="table-responsive">
            <table class="table updates-table">
                <thead>
                    <tr>
                        <th style="width: 50px;"></th>
                        <th style="width: 40%;">Update</th>
                        <th style="width: 20%;">Date</th>
                        <th style="width: 150px; text-align: center;">Status</th>
                    </tr>
                </thead>
                <tbody id="updatesTableBody">
                    <!-- Completed Update 1 -->
                    <tr data-category="completed">
                        <td class="icon-cell"><i class="fas fa-filter"></i></td>
                        <td>
                            <div class="update-title">New Deal Type Filter Added</div>
                            <div class="update-description">Enhanced filtering capabilities now allow users to quickly sort and view deals by type. This feature improves navigation and helps teams find relevant deals faster.</div>
                        </td>
                        <td class="date-cell">
                            <i class="far fa-calendar-check"></i>
                            November 2025
                        </td>
                        <td style="text-align: center;">
                            <span class="status-badge badge-completed">Completed</span>
                        </td>
                    </tr>

                    <!-- Upcoming Update 1 -->
                    <tr data-category="upcoming">
                        <td class="icon-cell"><i class="fas fa-moon"></i></td>
                        <td>
                            <div class="update-title">Dark Mode Improvements</div>
                            <div class="update-description">Enhanced dark mode with improved contrast ratios and eye-comfort features. The update includes refined color palettes optimized for extended use.</div>
                        </td>
                        <td class="date-cell">
                            <i class="far fa-calendar"></i>
                            December 2025
                        </td>
                        <td style="text-align: center;">
                            <span class="status-badge badge-upcoming">Coming Soon</span>
                        </td>
                    </tr>

                    <!-- Completed Update 2 -->
                    <tr data-category="completed">
                        <td class="icon-cell"><i class="fas fa-chart-line"></i></td>
                        <td>
                            <div class="update-title">Advanced Analytics Dashboard</div>
                            <div class="update-description">New comprehensive analytics dashboard provides real-time insights into business performance. Features include customizable widgets and interactive charts.</div>
                        </td>
                        <td class="date-cell">
                            <i class="far fa-calendar-check"></i>
                            October 2025
                        </td>
                        <td style="text-align: center;">
                            <span class="status-badge badge-completed">Completed</span>
                        </td>
                    </tr>

                    <!-- Upcoming Update 2 -->
                    <tr data-category="upcoming">
                        <td class="icon-cell"><i class="fas fa-mobile-alt"></i></td>
                        <td>
                            <div class="update-title">Mobile App Launch</div>
                            <div class="update-description">Native mobile applications for iOS and Android platforms. Access all core features on-the-go with optimized mobile interface and push notifications.</div>
                        </td>
                        <td class="date-cell">
                            <i class="far fa-calendar"></i>
                            January 2026
                        </td>
                        <td style="text-align: center;">
                            <span class="status-badge badge-upcoming">Coming Soon</span>
                        </td>
                    </tr>

                    <!-- Completed Update 3 -->
                    <tr data-category="completed">
                        <td class="icon-cell"><i class="fas fa-lock"></i></td>
                        <td>
                            <div class="update-title">Two-Factor Authentication</div>
                            <div class="update-description">Enhanced security with two-factor authentication support. Users can now enable additional security layers including SMS verification and authenticator apps.</div>
                        </td>
                        <td class="date-cell">
                            <i class="far fa-calendar-check"></i>
                            September 2025
                        </td>
                        <td style="text-align: center;">
                            <span class="status-badge badge-completed">Completed</span>
                        </td>
                    </tr>

                    <!-- Upcoming Update 3 -->
                    <tr data-category="upcoming">
                        <td class="icon-cell"><i class="fas fa-robot"></i></td>
                        <td>
                            <div class="update-title">AI-Powered Recommendations</div>
                            <div class="update-description">Intelligent recommendation engine powered by machine learning. The system will analyze patterns and suggest optimal actions for informed decisions.</div>
                        </td>
                        <td class="date-cell">
                            <i class="far fa-calendar"></i>
                            February 2026
                        </td>
                        <td style="text-align: center;">
                            <span class="status-badge badge-upcoming">Coming Soon</span>
                        </td>
                    </tr>

                    <!-- Completed Update 4 -->
                    <tr data-category="completed">
                        <td class="icon-cell"><i class="fas fa-users"></i></td>
                        <td>
                            <div class="update-title">Team Collaboration Tools</div>
                            <div class="update-description">New collaboration features including real-time commenting, task assignments, and team activity feeds. Keep everyone aligned on project progress.</div>
                        </td>
                        <td class="date-cell">
                            <i class="far fa-calendar-check"></i>
                            August 2025
                        </td>
                        <td style="text-align: center;">
                            <span class="status-badge badge-completed">Completed</span>
                        </td>
                    </tr>

                    <!-- Upcoming Update 4 -->
                    <tr data-category="upcoming">
                        <td class="icon-cell"><i class="fas fa-globe"></i></td>
                        <td>
                            <div class="update-title">Multi-Language Support</div>
                            <div class="update-description">Expanding global reach with support for multiple languages including Spanish, French, German, and Mandarin. Fully localized content and documentation.</div>
                        </td>
                        <td class="date-cell">
                            <i class="far fa-calendar"></i>
                            March 2026
                        </td>
                        <td style="text-align: center;">
                            <span class="status-badge badge-upcoming">Coming Soon</span>
                        </td>
                    </tr>

                    <!-- Completed Update 5 -->
                    <tr data-category="completed">
                        <td class="icon-cell"><i class="fas fa-file-export"></i></td>
                        <td>
                            <div class="update-title">Advanced Export Options</div>
                            <div class="update-description">Export data in multiple formats including CSV, Excel, and PDF. Customize export templates and schedule automated reports for your team.</div>
                        </td>
                        <td class="date-cell">
                            <i class="far fa-calendar-check"></i>
                            July 2025
                        </td>
                        <td style="text-align: center;">
                            <span class="status-badge badge-completed">Completed</span>
                        </td>
                    </tr>

                    <!-- Upcoming Update 5 -->
                    <tr data-category="upcoming">
                        <td class="icon-cell"><i class="fas fa-bell"></i></td>
                        <td>
                            <div class="update-title">Smart Notifications System</div>
                            <div class="update-description">Intelligent notification system with customizable alerts, priority levels, and digest modes. Stay updated without being overwhelmed.</div>
                        </td>
                        <td class="date-cell">
                            <i class="far fa-calendar"></i>
                            April 2026
                        </td>
                        <td style="text-align: center;">
                            <span class="status-badge badge-upcoming">Coming Soon</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function filterUpdates(category) {
            const rows = document.querySelectorAll('#updatesTableBody tr');
            const buttons = document.querySelectorAll('.filter-btn');
            
            // Update active button
            buttons.forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            // Filter rows
            rows.forEach(row => {
                if (category === 'all') {
                    row.style.display = '';
                } else {
                    if (row.dataset.category === category) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        }

        // Add smooth animation on page load
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('#updatesTableBody tr');
            rows.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateX(-20px)';
                setTimeout(() => {
                    row.style.transition = 'all 0.5s ease';
                    row.style.opacity = '1';
                    row.style.transform = 'translateX(0)';
                }, index * 100);
            });
        });
    </script>
  </div>
@endsection


@push('styles')
<style>

    
         
    .table-container {
   border: 1px solid #ddd;
        overflow-x: auto;
    }

    .updates-table {
        width: 100%;
        margin: 0;
    }

    .updates-table thead {
        background: var(--cf-primary);
        color: #ffffff;
    }

    .updates-table thead th {
        padding: 20px 15px;
        color: #fff;
        font-weight: 600;
        text-align: left;
        border: none;
        font-size: 1rem;
    }

    .updates-table tbody tr {
        border-bottom: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .updates-table tbody tr:hover {
       
        transform: scale(1.01);
    }

    .updates-table tbody tr:last-child {
        border-bottom: none;
    }

    .updates-table tbody td {
        padding: 20px 15px;
        vertical-align: middle;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge-completed {
        background: var(--cf-primary);
        color: #ffffff;
    }

    .badge-upcoming {
        background: #fff;
        color: var(--cf-primary);
        border: 2px solid var(--cf-primary);
    }

    .update-title {
        font-weight: 600;
        color: #1f2937;
        font-size: 1.1rem;
        margin-bottom: 8px;
    }

    .update-description {
        color: #6b7280;
        font-size: 0.95rem;
        line-height: 1.6;
        margin: 0;
    }

    .date-cell {
        color: #6b7280;
        font-weight: 500;
        white-space: nowrap;
    }

    .date-cell i {
        color: var(--cf-primary);
        margin-right: 8px;
    }

    .icon-cell {
        text-align: center;
        font-size: 1.5rem;
        color: var(--cf-primary);
    }

    .filter-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: 10px 25px;
        border: 2px solid var(--cf-primary);
        background: #ffffff;
        color: var(--cf-primary);
        border-radius: 30px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .filter-btn:hover, .filter-btn.active {
        background: var(--cf-primary);
        color: #ffffff;
    }

    @media (max-width: 768px) {
        .header-section h1 {
            font-size: 2rem;
        }

        .table-container {
            padding: 15px;
        }

        .updates-table thead th,
        .updates-table tbody td {
            padding: 12px 10px;
            font-size: 0.9rem;
        }

        .icon-cell {
            display: none;
        }
    }

    .table-responsive {
        border-radius: 10px;
    }
</style>
    
@endpush