<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Users Report - Primus CRM</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            line-height: 1.4;
            padding: 15px;
            color: #333;
        }
        
        .print-header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #4a5568;
        }
        
        h1 {
            color: #002140;
            font-size: 24px;
            margin-bottom: 8px;
        }
        
        .report-info {
            color: #666;
            font-size: 10px;
            margin-top: 5px;
        }
        
        .stats {
            width: 100%;
            margin-bottom: 15px;
            background: #f8f9fa;
            padding: 10px;
        }
        
        .stats table {
            width: 100%;
            border: none;
        }
        
        .stats td {
            text-align: center;
            padding: 8px;
            border: none;
        }
        
        .stat-label {
            font-size: 9px;
            color: #666;
            text-transform: uppercase;
            display: block;
        }
        
        .stat-value {
            font-size: 20px;
            font-weight: bold;
            color: #002140;
            display: block;
            margin-top: 3px;
        }
        
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 9px;
        }
        
        table.data-table th {
            background-color: #002140;
            color: white;
            padding: 8px 5px;
            text-align: left;
            font-weight: 600;
            font-size: 9px;
            text-transform: uppercase;
        }
        
        table.data-table td {
            padding: 6px 5px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        table.data-table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        .status-active {
            display: inline-block;
            padding: 2px 6px;
            background: #d1fae5;
            color: #065f46;
            border-radius: 3px;
            font-weight: 600;
            font-size: 8px;
        }
        
        .status-inactive {
            display: inline-block;
            padding: 2px 6px;
            background: #fee2e2;
            color: #991b1b;
            border-radius: 3px;
            font-weight: 600;
            font-size: 8px;
        }
        
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
            padding: 15px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            font-size: 9px;
            color: #6b7280;
            background: white;
            z-index: 999;
        }
        
        .content-wrapper {
            padding-bottom: 80px;
        }
        
        @page {
            margin-bottom: 70px;
        }
    </style>
</head>
<body>
    <div class="content-wrapper">
    <div class="print-header">
        <h1>Primus CRM - Users Report</h1>
        <p class="report-info">Generated on {{ date('F d, Y \a\t h:i A') }}</p>
    </div>
    
    <div class="stats">
        <table>
            <tr>
                <td>
                    <span class="stat-label">Total Users</span>
                    <span class="stat-value">{{ $users->count() }}</span>
                </td>
                <td>
                    <span class="stat-label">Active Users</span>
                    <span class="stat-value" style="color: #10b981;">{{ $users->where('is_active', true)->count() }}</span>
                </td>
                <td>
                    <span class="stat-label">Inactive Users</span>
                    <span class="stat-value" style="color: #ef4444;">{{ $users->where('is_active', false)->count() }}</span>
                </td>
            </tr>
        </table>
    </div>
    
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%;">#</th>
                <th style="width: 7%;">Emp #</th>
                <th style="width: 12%;">First Name</th>
                <th style="width: 12%;">Last Name</th>
                <th style="width: 16%;">Email</th>
                <th style="width: 10%;">Phone</th>
                <th style="width: 11%;">Role</th>
                <th style="width: 7%;">Status</th>
                <th style="width: 11%;">Last Login</th>
                <th style="width: 10%;">Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
            @php
                $nameParts = array_filter(explode(' ', trim($user->name)));
                $firstName = $nameParts[0] ?? '';
                $lastName = end($nameParts) !== $firstName ? end($nameParts) : '';
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><strong>{{ $user->employee_number ?? 'N/A' }}</strong></td>
                <td>{{ $firstName }}</td>
                <td>{{ $lastName }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->work_phone ?? $user->cell_phone ?? 'N/A' }}</td>
                <td>{{ $user->roles->pluck('name')->join(', ') ?: 'No Role' }}</td>
                <td>
                    <span class="{{ $user->is_active ? 'status-active' : 'status-inactive' }}">
                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>{{ $user->last_login_at ? $user->last_login_at->format('M d, Y') : 'Never' }}</td>
                <td>{{ $user->created_at->format('M d, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    
    <div class="footer">
        <p><strong>Primus CRM</strong> - User Management System</p>
        <p>© {{ date('Y') }} Primus CRM. All rights reserved.</p>
    </div>
</body>
</html>
