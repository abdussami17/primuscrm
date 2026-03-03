@extends('layouts.report-layout')

@section('reports-title', 'Email Sent/Recieved Report')



@section('reports-content')
  <div class="report-single">
    <!-- Heading + Buttons -->
    <div class="header-bar">
      <h2>Email Sent / Received Report</h2>
      <div class="actions">
        <button onclick="window.location.reload()">
          <i class="ti ti-reload"></i> Refresh Report
        </button>
        <button onclick="window.print()">
          <i class="ti ti-printer"></i> Print Page
        </button>
        <button>
          <i class="ti ti-file-export"></i> Export
        </button>
        <button>
          <i class="ti ti-player-play-filled"></i> Run Report
        </button>
      </div>
    </div>

    <!-- Filters -->
    <form class="row g-2">

      <!-- Begin Date -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Begin Date</label>
        <input type="text" class="form-control" name="from" 
          id="fromDate" readonly>
      </div>
    
      <!-- End Date -->
      <div class="col-md-3 mb-1">
        <label class="form-label">End Date</label>
        <input type="text" class="form-control" name="to" 
 readonly>
      </div>
    
     
    
      <!-- Email Type -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Email Type:</label>
        <select name="email_type[]">
          <option>--ALL--</option>
          <option value="sent">Sent</option>
          <option value="received">Received</option>

        </select>
      </div>
    
      <!-- Users -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Sent By</label>
    
        <select name="sent_by[]">
            <option value="">-- ALL --</option>
    
            @forelse ($users as $user)
                <option value="{{ $user->id }}">
                    {{ $user->name }}
                </option>
            @empty
                <option disabled>No users found</option>
            @endforelse
        </select>
    </div>
      

    </form>
    
    <!-- Report Info -->
    <div class="report-info mt-3">08 Records Returned</div>

    <!-- Table -->
    <div style="overflow-x: auto; width: 100%;">
      <table style="white-space: nowrap; border-collapse: collapse; width: 100%;">
        <thead>
          <tr>
            <th>Customer Name</th>
            <th>Email Address</th>
            <th>Date/Time</th>
            <th>Email Type</th>
            <th>Sent By</th>
            <th>Team</th>
            <th>Cell Number</th>
            <th>Work Number</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>John Smith</td>
            <td>john.smith@email.com</td>
            <td>Sep 5, 2023 09:15 AM</td>
            <td>Sent</td>
            <td>Alex Johnson</td>
            <td>Sales</td>
            <td>+1 (416) 555-1234</td>
            <td>+1 (416) 555-4321</td>
          </tr>
          <tr>
            <td>Maria Gonzalez</td>
            <td>maria.gonzalez@email.com</td>
            <td>Sep 5, 2023 09:42 AM</td>
            <td>Received</td>
            <td>Sarah Lee</td>
            <td>Service</td>
            <td>+1 (647) 555-7788</td>
            <td>-</td>
          </tr>
          <tr>
            <td>Ahmed Khan</td>
            <td>ahmed.khan@email.com</td>
            <td>Sep 6, 2023 01:05 PM</td>
            <td>Sent</td>
            <td>David Miller</td>
            <td>Parts</td>
            <td>+1 (905) 555-6677</td>
            <td>+1 (905) 555-8899</td>
          </tr>
          <tr>
            <td>Emily Davis</td>
            <td>emily.davis@email.com</td>
            <td>Sep 7, 2023 03:22 PM</td>
            <td>Received</td>
            <td>Robert Wilson</td>
            <td>Sales</td>
            <td>+1 (289) 555-3344</td>
            <td>-</td>
          </tr>
          <tr>
            <td>Michael Brown</td>
            <td>michael.brown@email.com</td>
            <td>Sep 7, 2023 04:10 PM</td>
            <td>Sent</td>
            <td>Alex Johnson</td>
            <td>Sales</td>
            <td>+1 (416) 555-9988</td>
            <td>+1 (416) 555-6677</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

@endsection
