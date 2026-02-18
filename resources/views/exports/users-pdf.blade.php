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
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            padding: 20px;
            color: #333;
        }
        
        .print-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #4a5568;
        }
        
        h1 {
            color: #002140;
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .report-info {
            color: #666;
            font-size: 11px;
            margin-top: 5px;
        }
        
        .stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
        }
        
        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #002140;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 11px;
        }
        
        th {
            background-color: #002140;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        td {
            padding: 10px 8px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        tr:hover {
            background-color: #f3f4f6;
        }
        
        .status-active {
            display: inline-block;
            padding: 3px 8px;
            background: #d1fae5;
            color: #065f46;
            border-radius: 3px;
            font-weight: 600;
            font-size: 10px;
        }
        
        .status-inactive {
            display: inline-block;
            padding: 3px 8px;
            background: #fee2e2;
            color: #991b1b;
            border-radius: 3px;
            font-weight: 600;
            font-size: 10px;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
        }
        
        .no-print {
            text-align: center;
            margin: 20px 0;
        }
        
        .print-btn {
            background: #002140;
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.3s;
        }
        
        .print-btn:hover {
            background: #003366;
        }
        
        @media print {
            .no-print {
                display: none;
            }
            
            body {
                padding: 0;
            }
            
            tr:hover {
                background-color: inherit;
            }
        }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()" class="print-btn">🖨️ Print / Save as PDF</button>
    </div>
    
    <div class="print-header">
        <h1>Primus CRM - Users Report</h1>
        <p class="report-info">Generated on {{ date('F d, Y \a\t h:i A') }}</p>
    </div>
    
    <div class="stats">
        <div class="stat-item">
            <div class="stat-label">Total Users</div>
            <div class="stat-value">{{ $users->count() }}</div>
        </div>
        <div class="stat-item">
            <div class="stat-label">Active Users</div>
            <div class="stat-value" style="color: #10b981;">{{ $users->where('is_active', true)->count() }}</div>
        </div>
        <div class="stat-item">
            <div class="stat-label">Inactive Users</div>
            <div class="stat-value" style="color: #ef4444;">{{ $users->where('is_active', false)->count() }}</div>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Employee #</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Status</th>
                <th>Last Login</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><strong>{{ $user->employee_number ?? 'N/A' }}</strong></td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->work_phone ?? $user->cell_phone ?? 'N/A' }}</td>
                <td>{{ $user->roles->pluck('name')->join(', ') ?: 'No Role' }}</td>
                <td>
                    <span class="{{ $user->is_active ? 'status-active' : 'status-inactive' }}">
                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>{{ $user->last_login_at ? $user->last_login_at->format('M d, Y h:i A') : 'Never' }}</td>
                <td>{{ $user->created_at->format('M d, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p><strong>Primus CRM</strong> - User Management System</p>
        <p>© {{ date('Y') }} Primus CRM. All rights reserved.</p>
    </div>
    
    <script>
        // Auto-focus print dialog option
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('autoprint') === 'true') {
            window.onload = function() {
                window.print();
            };
        }
    </script>
</body>
</html>
