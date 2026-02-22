@extends('layouts.report-layout')

@section('reports-title','Activity Report')



@section('reports-content')

<div class="report-single">
  <!-- Heading + Buttons -->
  <div class="header-bar">
    <h2>Activity Report</h2>
    <div class="actions">
      <button onclick="loadActivities()">
        <i class="ti ti-reload"></i> Refresh Report
      </button>
      <button onclick="window.print()">
        <i class="ti ti-printer"></i> Print Page
      </button>
      <button onclick="exportReport()">
        <i class="ti ti-file-export"></i> Export
      </button>
      <button onclick="runReport()">
        <i class="ti ti-player-play-filled"></i> Run Report
      </button>
    </div>
  </div>

  <!-- Filters -->
  <form class="row g-2" id="activityFilters">
    <!-- Begin Date -->
    <div class="col-md-3 mb-1">
      <label class="form-label">Begin Date</label>
      <input type="text" name="from" class="form-control cf-datepicker" 
         readonly>
    </div>
  
    <!-- End Date -->
    <div class="col-md-3 mb-1">
      <label class="form-label">End Date</label>
      <input type="text" name="to" class="form-control cf-datepicker" 
   readonly>
    </div>
  
    <!-- Users / Assigned To -->
    <div class="col-md-3 mb-1">
      <label class="form-label">Assigned To</label>
      <select name="assigned_to[]">
        <option selected>--ALL--</option>
        <option>James</option>
        <option>Charles</option>
        <option>Rock</option>
      </select>
    </div>
  
    <!-- Assigned By -->
    <div class="col-md-3 mb-1">
      <label class="form-label">Assigned By</label>
      <select name="assigned_by[]">
        <option>--ALL--</option>
        <option>Primus CRM</option>
        <option>Dealer</option>
      </select>
    </div>


  
    <!-- Activity Type -->
    <div class="col-md-3 mb-1">
      <label class="form-label">Activity Type</label>
      <select name="activity_type[]">
        <option>--ALL--</option>
        <option>Calls</option>
        <option>Texts</option>
        <option>Emails</option>
        <option>CSI</option>
        <option>Appointment</option>
        <option>Automated</option>
      </select>
    </div>
  
    <!-- Showroom Visit -->
    <div class="col-md-3 mb-1">
      <label class="form-label">Showroom Visit</label>
      <select name="showroom_visit[]">
        <option>--ALL--</option>
        <option>Open</option>
        <option>Completed</option>
      </select>
    </div>
  
    <!-- Lead Type -->
    <div class="col-md-3 mb-1">
      <label class="form-label">Lead Type</label>
      <select name="lead_type[]">
        <option selected>--ALL--</option>
        <option>Internet</option>
        <option>Walk-in</option>
        <option>Phone Up</option>
        <option>Text Up</option>
        <option>Website Chat</option>
        <option>Import</option>
        <option>Wholesale</option>
        <option>Lease Renewal</option>
      </select>
    </div>
  
  
    <!-- Source -->
    <div class="col-md-3 mb-1">
      <label class="form-label">Source</label>
      <select name="source[]">
        <option selected>--ALL--</option>
        <option>OEM</option>
        <option>Website</option>
        <option>Walk In</option>
        <option>Referral</option>
        <option>Facebook</option>
        <option>Other</option>
      </select>
    </div>
  

  
    <!-- Sales Type -->
    <div class="col-md-3 mb-1">
      <label class="form-label">Lead Status</label>
      <select name="lead_status[]">
        <option>--ALL--</option>
        <option>Active</option>
        <option>Pending F&I</option>
        <option>Sold</option>
        <option>Lost</option>
        <option>Duplicate</option>
        <option>Invalid</option>

      </select>
    </div>
  
</form>
  
  <!-- Report Info -->
  <div class="report-info mt-3" id="recordCount">0 Records Returned</div>


  <!-- Table -->
  <div style="overflow-x: auto; width: 100%;">
    <table style="white-space: nowrap; border-collapse: collapse; width: 100%;">
      <thead>
        <tr>
          <!-- Customer Fields -->
          <th>Full Name</th>
          <th>Assigned To</th>
          <th>Assigned By</th>
          <th>Source</th>
          <th>Lead Type</th>
          <th>Vehicle of Interest</th>
          <th>Trade-In Vehicle</th>
          <!-- Activity Fields -->
          <th>Activity Type</th>
          <th>Activity Date & Time</th>
          <th>Status Type</th>
          <th>Notes Preview</th>
          <th>Duration</th>
        </tr>
      </thead>
      <tbody id="activityTableBody">
        <tr>
            <td colspan="12" class="text-center">Loading...</td>
        </tr>
    </tbody>
    </table>
  </div>
</div>
@endsection



{{-- Script Area --}}

  document.addEventListener('DOMContentLoaded', loadActivities);
  
  function loadActivities(filters = {}) {
  
      const tbody = document.getElementById('activityTableBody');
      const recordCount = document.getElementById('recordCount');
  
      tbody.innerHTML =
          `<tr><td colspan="12" class="text-center">Loading...</td></tr>`;
  
      const params = new URLSearchParams(filters);
  
      fetch("{{ route('activity.report.data') }}?" + params)
          .then(res => {
              if (!res.ok) throw new Error('Network error');
              return res.json();
          })
          .then(res => {
  
              if (!res.success) {
                  throw new Error(res.message);
              }
  
              const rows = res.data;
  
              recordCount.textContent =
                  `${res.count} Records Returned`;
  
              if (!rows.length) {
                  tbody.innerHTML =
                      `<tr><td colspan="12" class="text-center">No records found</td></tr>`;
                  return;
              }
  
              tbody.innerHTML = '';
  
              rows.forEach(r => {
  
                  const safe = v => v ?? 'N/A';
  
                  const tr = document.createElement('tr');
  
                  tr.innerHTML = `
                      <td>${safe(r.full_name)}</td>
                      <td>${safe(r.assigned_to)}</td>
                      <td>${safe(r.assigned_by)}</td>
                      <td>${safe(r.source)}</td>
                      <td>${safe(r.lead_type)}</td>
                      <td>${safe(r.vehicle_interest)}</td>
                      <td>${safe(r.trade_in_vehicle)}</td>
                      <td>${safe(r.activity_type)}</td>
                      <td>${safe(r.activity_datetime)}</td>
                      <td>${safe(r.status_type)}</td>
                      <td title="${safe(r.notes_preview)}">${safe(r.notes_preview)}</td>
                      <td>${safe(r.duration)}</td>
                  `;
  
                  tbody.appendChild(tr);
              });
          })
          .catch(err => {
  
              console.error(err);
  
              tbody.innerHTML =
                  `<tr>
                      <td colspan="12" class="text-danger text-center">
                          Failed to load data
                      </td>
                   </tr>`;
          });
  }
  </script>