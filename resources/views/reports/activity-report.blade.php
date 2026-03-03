@extends('layouts.report-layout')

@section('reports-title', 'Activity Report')



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
                <input type="text" name="from" class="form-control cf-datepicker" readonly>
            </div>

            <!-- End Date -->
            <div class="col-md-3 mb-1">
                <label class="form-label">End Date</label>
                <input type="text" name="to" class="form-control cf-datepicker" readonly>
            </div>

            <!-- Users / Assigned To -->
            <div class="col-md-3 mb-1">
                <label class="form-label">Assigned To</label>
                <select name="assigned_to[]">
                    <option value="all" selected>--ALL--</option>
                    @foreach ($salesManagers as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Assigned By -->
            <div class="col-md-3 mb-1">
                <label class="form-label">Assigned By</label>
                <select name="assigned_by[]">
                    <option value="all" selected>--ALL--</option>
                    @foreach ($assignedBy as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>



            <!-- Activity Type -->
            <div class="col-md-3 mb-1">
                <label class="form-label">Activity Type</label>
                <select name="activity_type[]">
                    <option value="all" selected>--ALL--</option>
                    @foreach ($activityTypes as $activity_type)
                        <option value="{{ $activity_type }}">
                            {{ $activity_type }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Showroom Visit -->
            <div class="col-md-3 mb-1">
                <label class="form-label">Showroom Visit</label>
                <select name="showroom_visit[]">
                    <option value="all" selected>--ALL--</option>
                    @foreach ($showroomVisit as $value => $label)
                        <option value="{{ $value }}">
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Lead Type -->
            <div class="col-md-3 mb-1">
                <label class="form-label">Lead Type</label>
                <select name="lead_type[]">
                    <option value="all" selected>--ALL--</option>
                    @foreach (['Internet', 'Walk-In', 'Phone Up', 'Text Up', 'Website Chat', 'Import', 'Wholesale', 'Lease Renewal'] as $type)
                        <option value="{{ $type }}">
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
            </div>


            <!-- Source -->
            <div class="col-md-3 mb-1">
                <label class="form-label">Source</label>
                <select name="source[]">
                    <option selected value="all">--ALL--</option>
                    @foreach ([
            'walk_in' => 'Walk-in',
            'phone_up' => 'Phone Up',
            'text' => 'Text',
            'repeat_customer' => 'Repeat Customer',
            'referral' => 'Referral',
            'services' => 'Services',
            'sales' => 'Sales',
            'lease_renewal' => 'Lease Renewal',
            'drive_by' => 'Drive By',
            'dealer_website' => 'Dealer Website',

            'unknown' => 'Unknown',
        ] as $val => $label)
                        <option value="{{ $val }}">
                            {{ $label }}</option>
                    @endforeach
                </select>
            </div>



            <!-- Sales Type -->
            <div class="col-md-3 mb-1">
                <label class="form-label">Status Type</label>
                <select name="lead_status[]">
                    <option selected value="all">--ALL--</option>
                    @foreach (['Active', 'Pending F&I', 'Sold', 'Lost', 'Duplicate', 'Invalid'] as $status)
                        <option value="{{ $status }}">
                            {{ $status }}
                        </option>
                    @endforeach

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
<script>
  document.addEventListener('DOMContentLoaded', () => {
      // Load default data on page load
      loadActivities();
  });
  
  function getFilters() {
      const form = document.getElementById('activityFilters');
      const formData = new FormData(form);
      const filters = {};
  
      formData.forEach((value, key) => {
          // Normalize multi-selects
          if (key.endsWith('[]')) {
              const k = key.replace('[]', '');
              if (!filters[k]) filters[k] = [];
              filters[k].push(value);
          } else {
              filters[key] = value;
          }
      });
  
      // Convert single values to arrays if backend expects arrays
      ['assigned_to', 'assigned_by', 'activity_type', 'showroom_visit', 'lead_type', 'source', 'lead_status'].forEach(field => {
          if (filters[field] !== undefined && !Array.isArray(filters[field])) {
              filters[field] = [filters[field]];
          }
      });
  
      // Remove filters that are 'all' so backend fetches all records
      Object.keys(filters).forEach(key => {
          if (Array.isArray(filters[key])) {
              if (filters[key].includes('all')) delete filters[key];
          }
      });
  
      return filters;
  }
  
  function runReport() {
      loadActivities(getFilters());
  }
  
  function loadActivities(filters = {}) {
      const tbody = document.getElementById('activityTableBody');
      const recordCount = document.getElementById('recordCount');
  
      tbody.innerHTML = `<tr><td colspan="12" class="text-center">Loading...</td></tr>`;
  
      // Prepare URL parameters
      const params = new URLSearchParams();
      Object.keys(filters).forEach(key => {
          if (Array.isArray(filters[key])) {
              filters[key].forEach(val => params.append(key + '[]', val));
          } else {
              params.append(key, filters[key]);
          }
      });
  
      fetch("{{ route('activity.report.data') }}?" + params)
          .then(res => {
              if (!res.ok) throw new Error('Network error');
              return res.json();
          })
          .then(res => {
              if (!res.success) throw new Error(res.message);
  
              recordCount.textContent = `${res.count} Records Returned`;
  
              if (!res.data.length) {
                  tbody.innerHTML = `<tr><td colspan="12" class="text-center">No records found</td></tr>`;
                  return;
              }
  
              tbody.innerHTML = '';
              res.data.forEach(r => {
                  const safe = v => v ?? 'N/A';
                  const fullNote = safe(r.notes_preview);
                const shortNote = fullNote.length > 50
                    ? fullNote.substring(0, 50) + '...'
                    : fullNote;
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
                      <td title="${fullNote}">${shortNote}</td>
                      <td>${safe(r.duration)}</td>
                  `;
                  tbody.appendChild(tr);
              });
          })
          .catch(err => {
              console.error(err);
              tbody.innerHTML = `<tr><td colspan="12" class="text-danger text-center">Failed to load data</td></tr>`;
          });
  }

  function exportReport() {
    const filters = getFilters();

    const params = new URLSearchParams();

    Object.keys(filters).forEach(key => {
        if (Array.isArray(filters[key])) {
            filters[key].forEach(val => params.append(key + '[]', val));
        } else {
            params.append(key, filters[key]);
        }
    });

    window.location = "{{ route('activity.report.export') }}?" + params;
}
  </script>