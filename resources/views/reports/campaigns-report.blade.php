<!doctype html>
<html lang="en">

<head>
  <title>Campaigns Report</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="shortcut icon" type="image/x-icon" href="assets/favicon_p.png">
  <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon_p.png"> <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="assets/plugins/tabler-icons/tabler-icons.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    body {
      font-family: "Inter", sans-serif;
      background: #fff;
      padding: 20px;
    }

    .header-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 15px;
    }

    .header-bar h2 {
      font-size: 18px;
      font-weight: 700;
      font-family: "Inter";
      color: rgb(0, 33, 64);
      margin: 0;
    }

    .actions button {
      padding: 6px 12px;
      margin-left: 5px;
      font-size: 14px;
      border: none;
      background: transparent;
      cursor: pointer;
      border-radius: 6px;
      font-family: "roboto";
      font-weight: 700;
    }

    .actions button i {
      font-size: 16px;
      margin-right: 2px;
      color: rgb(0, 33, 64);
      position: relative;
      top: 2px;
    }

    .filters {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 15px;
      margin-bottom: 15px;
    }

    .filter-section {
      flex: 1;
      min-width: 300px;
      padding: 12px;
      border-radius: 6px;
    }

    .filter-row {
      display: flex;
      margin-bottom: 6px;
      align-items: center;
    }

    .filter-row label {
      width: 40%;
      font-size: 14px;
      font-weight: 600;
      color: #000;
      margin: 0;
    }

    .blue-label {
      color: rgb(0, 33, 64) !important;
      text-decoration: underline;
      font-weight: 600;
    }

    .report-info {
      font-size: 14px;
      margin-bottom: 10px;
      font-weight: 800;
      font-family: "roboto";
      color: #002140;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 13px;
    }

    table th,
    table td {
      border: 1px solid #ddd;
      padding: 6px;
      text-align: start;
    }

    table th {
      font-weight: 500;
      font-size: 14px !important;
      color: #fff;
      border-color: #fff;
      background-color: rgb(0, 33, 64);
    }
    
    /* Add cursor pointer for clickable cells */
    .clickable {
      cursor: pointer;
      text-decoration: underline;
      color: #0d6efd;
    }
    
    .clickable:hover {
      background-color: #f8f9fa;
    }
  </style>
</head>

<body>
  <div class="report-single">
    <!-- Heading + Buttons -->
    <div class="header-bar">
      <h2>Campaigns Report</h2>
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
        <input type="text" class="form-control makatadob-datepicker" 
          data-datepicker-id="fromDate" id="fromDate" readonly>
      </div>
    
      <!-- End Date -->
      <div class="col-md-3 mb-1">
        <label class="form-label">End Date</label>
        <input type="text" class="form-control makatadob-datepicker" 
          data-datepicker-id="toDate" id="toDate" readonly>
      </div>
    
      <!-- Assigned To -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Assigned To</label>
        <select class="form-select">
          <option selected>--ALL--</option>
          <option>James</option>
          <option>Charles</option>
          <option>Rock</option>
        </select>
      </div>
    
      <!-- Assigned By -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Assigned By</label>
        <select class="form-select">
          <option>--ALL--</option>
          <option>Primus CRM</option>
          <option>Dealer</option>
        </select>
      </div>
    
      <!-- Team -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Team</label>
        <select class="form-select">
          <option>--ALL--</option>
          <option>Sales Rep</option>
          <option>BDC Agent</option>
          <option>Sales Manager</option>
          <option>F&amp;I</option>
          <option>BDC Manager</option>
          <option>Finance Director</option>
          <option>GSM</option>
        </select>
      </div>
    
      <!-- Activity Type -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Activity Type</label>
        <select class="form-select">
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
        <select class="form-select">
          <option>--ALL--</option>
          <option>Open</option>
          <option>Completed</option>
        </select>
      </div>
    
      <!-- Source -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Source</label>
        <select class="form-select">
          <option selected>--ALL--</option>
          <option>OEM</option>
          <option>Website</option>
          <option>Walk In</option>
          <option>Referral</option>
          <option>Facebook</option>
          <option>Other</option>
        </select>
      </div>
    
      <!-- Lead Type -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Lead Type</label>
        <select class="form-select">
          <option selected>--ALL--</option>
          <option>Internet</option>
          <option>Walk-in</option>
          <option>Phone Up</option>
          <option>Text Up</option>
          <option>Website Chat</option>
          <option>Import</option>
          <option>Wholesale</option>
        </select>
      </div>
    
      <!-- Appointment Type -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Appointment Type</label>
        <select class="form-select">
          <option>--ALL--</option>
          <option>In Person</option>
          <option>Phone</option>
          <option>Virtual</option>
        </select>
      </div>
    
      <!-- Inventory Type -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Inventory Type</label>
        <select class="form-select">
          <option>--ALL--</option>
          <option>New</option>
          <option>Pre-Owned</option>
          <option>CPO</option>
          <option>Demo</option>
          <option>Wholesale</option>
          <option>Lease Renewal</option>
        </select>
      </div>
    
      <!-- Sales Type -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Sales Type</label>
        <select class="form-select">
          <option>--ALL--</option>
          <option>Sales Inquiry</option>
          <option>Service Inquiry</option>
          <option>Parts Inquiry</option>
        </select>
      </div>
    
      <!-- Sales Status -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Sales Status</label>
        <select class="form-select">
          <option>--ALL--</option>
          <option>Open</option>
          <option>Confirmed</option>
          <option>Missed</option>
          <option>Cancelled</option>
          <option>Walk In</option>
        </select>
      </div>
    
      <!-- Lead Status -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Lead Status</label>
        <select class="form-select">
          <option selected>--ALL--</option>
          <option>Active</option>
          <option>Duplicate</option>
          <option>Invalid</option>
          <option>Lost</option>
          <option>Sold</option>
          <option>Wishlist</option>
        </select>
      </div>
    
      <!-- Deal Type -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Deal Type</label>
        <select class="form-select">
          <option>--ALL--</option>
          <option>Finance</option>
          <option>Cash</option>
          <option>Lease</option>
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
            <th>Assigned To</th>
            <th>Assigned By</th>
            <th>Source</th>
            <th>Lead Type</th>
            <th>Vehicle of Interest</th>
            <th>Trade-In Vehicle</th>
            <th>Campaign Name</th>
            <th>Date Sent</th>
            <th>Sent</th>
            <th>Delivered (#)</th>
            <th>Open Rate %</th>
            <th>Click Rate %</th>
            <th>Response Rate %</th>
            <th>Bounced/Invalid (#)</th>
            <th>Unsubscribes (#)</th>
            <th>Did Not Open (#)</th>
            <th>Appointments Created</th>
            <th>Appointments Completed</th>
            <th>Deals Sold</th>
            <th>ROI</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>John Doe</td>
            <td>Sarah Smith</td>
            <td>Primus CRM</td>
            <td>Facebook</td>
            <td>Internet</td>
            <td>2023 Honda Civic</td>
            <td>2018 Toyota Corolla</td>
            <td>Summer Sales Blast</td>
            <td>Oct 7, 2025 10:55 AM</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">500</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">480</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">60%</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">25%</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">10%</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">20</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">5</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">200</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">30</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">18</td>
            <td>$25,000 / $5,000</td>
            <td>400%</td>
          </tr>
          <tr>
            <td>Jane Smith</td>
            <td>David Johnson</td>
            <td>Primus CRM</td>
            <td>Website</td>
            <td>Internet</td>
            <td>2024 Toyota RAV4</td>
            <td>2020 Honda CR-V</td>
            <td>Fall Promotion</td>
            <td>Oct 6, 2025 02:30 PM</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">750</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">720</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">55%</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">20%</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">8%</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">30</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">8</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">324</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">25</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">15</td>
            <td>$32,000 / $7,500</td>
            <td>327%</td>
          </tr>
          <tr>
            <td>Robert Brown</td>
            <td>Mike Wilson</td>
            <td>Primus CRM</td>
            <td>Google Ads</td>
            <td>Internet</td>
            <td>2022 Ford F-150</td>
            <td>2018 Chevrolet Silverado</td>
            <td>Truck Month</td>
            <td>Oct 5, 2025 09:15 AM</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">300</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">285</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">65%</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">30%</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">12%</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">15</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">3</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">100</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">20</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">12</td>
            <td>$45,000 / $8,000</td>
            <td>463%</td>
          </tr>
          <tr>
            <td>Emily Davis</td>
            <td>Sarah Smith</td>
            <td>Primus CRM</td>
            <td>Instagram</td>
            <td>Internet</td>
            <td>2023 Hyundai Tucson</td>
            <td>2019 Kia Sportage</td>
            <td>SUV Special</td>
            <td>Oct 4, 2025 11:45 AM</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">400</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">380</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">58%</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">22%</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">9%</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">20</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">6</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">160</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">18</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">10</td>
            <td>$28,000 / $6,000</td>
            <td>367%</td>
          </tr>
          <tr>
            <td>Michael Johnson</td>
            <td>David Johnson</td>
            <td>Primus CRM</td>
            <td>Facebook</td>
            <td>Internet</td>
            <td>2024 Subaru Outback</td>
            <td>2021 Mazda CX-5</td>
            <td>Adventure Ready</td>
            <td>Oct 3, 2025 03:20 PM</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">600</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">570</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">52%</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">18%</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">7%</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">30</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">7</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">274</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">22</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">13</td>
            <td>$35,000 / $7,200</td>
            <td>386%</td>
          </tr>
          <tr>
            <td>Sarah Miller</td>
            <td>Mike Wilson</td>
            <td>Primus CRM</td>
            <td>Website</td>
            <td>Internet</td>
            <td>2023 Jeep Wrangler</td>
            <td>2018 Ford Explorer</td>
            <td>Off-Road Special</td>
            <td>Oct 2, 2025 10:10 AM</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">350</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">332</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">62%</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">28%</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">11%</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">18</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">4</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">126</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">16</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">9</td>
            <td>$42,000 / $6,500</td>
            <td>546%</td>
          </tr>
          <tr>
            <td>David Wilson</td>
            <td>Sarah Smith</td>
            <td>Primus CRM</td>
            <td>Google Ads</td>
            <td>Internet</td>
            <td>2024 Ford Bronco</td>
            <td>2019 Jeep Wrangler</td>
            <td>Bronco Launch</td>
            <td>Oct 1, 2025 01:30 PM</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">450</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">427</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">68%</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">32%</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">14%</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">23</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">5</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">137</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">24</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">14</td>
            <td>$48,000 / $8,500</td>
            <td>465%</td>
          </tr>
          <tr>
            <td>Lisa Anderson</td>
            <td>David Johnson</td>
            <td>Primus CRM</td>
            <td>Instagram</td>
            <td>Internet</td>
            <td>2022 Toyota Highlander</td>
            <td>2017 Honda Pilot</td>
            <td>Family First</td>
            <td>Sep 30, 2025 09:45 AM</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">550</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">522</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">54%</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">19%</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">8%</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">28</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">9</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">240</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">20</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#drillModal">11</td>
            <td>$33,000 / $7,800</td>
            <td>323%</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Drill-down Modal -->
  <div class="modal fade" id="drillModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header bg-dark text-white">
          <h5 class="modal-title text-white">Campaign Performance Details</h5>
          <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <table class="table table-sm table-bordered">
            <thead class="table-light">
              <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Status</th>
                <th>Date Contacted</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Mike</td>
                <td>Johnson</td>
                <td>+1 555-123-4567</td>
                <td>mike@example.com</td>
                <td>Opened</td>
                <td>Oct 7, 2025 11:30 AM</td>
              </tr>
              <tr>
                <td>Emily</td>
                <td>Brown</td>
                <td>+1 555-987-6543</td>
                <td>emily@example.com</td>
                <td>Clicked</td>
                <td>Oct 7, 2025 02:15 PM</td>
              </tr>
              <tr>
                <td>David</td>
                <td>Wilson</td>
                <td>+1 555-444-8899</td>
                <td>david@example.com</td>
                <td>Responded</td>
                <td>Oct 8, 2025 09:45 AM</td>
              </tr>
              <tr>
                <td>Sarah</td>
                <td>Davis</td>
                <td>+1 555-777-3322</td>
                <td>sarah@example.com</td>
                <td>Appointment Set</td>
                <td>Oct 8, 2025 03:20 PM</td>
              </tr>
              <tr>
                <td>James</td>
                <td>Miller</td>
                <td>+1 555-222-1155</td>
                <td>james@example.com</td>
                <td>Sold</td>
                <td>Oct 9, 2025 10:00 AM</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // From date fixed 2000-01-01
      document.querySelector("#fromDate").value = "2000-01-01";

      // To date = auto
      document.querySelector("#toDate").value = new Date().toISOString().split('T')[0];
    });
  </script>
  <script src="assets/js/custom-calendar.js"></script>
</body>

</html>