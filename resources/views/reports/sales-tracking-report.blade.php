<!doctype html>
<html lang="en">

<head>
  <title>Sales Tracking Report</title>
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
  </style>
</head>

<body>
  <div class="report-single">
    <!-- Heading + Buttons -->
    <div class="header-bar">
      <h2>Sales Tracking Report</h2>
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

      <!-- Assigned To -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Assigned To</label>
        <select class="form-select">
          <option>--ALL--</option>
          <option>James</option>
          <option>Charles</option>
          <option>Rock</option>
          <option>Mike Smith</option>
          <option>Sarah Johnson</option>
          <option>Robert Lee</option>
        </select>
      </div>

      <!-- Assigned By -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Assigned By</label>
        <select class="form-select">
          <option>--ALL--</option>
          <option>Primus CRM</option>
          <option>Dealer</option>
          <option>Alex Brown</option>
          <option>Tom Walker</option>
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
          <option>--ALL--</option>
          <option>OEM</option>
          <option>Website</option>
          <option>Walk In</option>
          <option>Referral</option>
          <option>Facebook</option>
          <option>Google Ads</option>
          <option>Instagram</option>
          <option>Email Campaign</option>
          <option>Other</option>
        </select>
      </div>

      <!-- Lead Type -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Lead Type</label>
        <select class="form-select">
          <option>--ALL--</option>
          <option>Internet</option>
          <option>Walk-in</option>
          <option>Phone Up</option>
          <option>Text Up</option>
          <option>Website Chat</option>
          <option>Import</option>
          <option>Wholesale</option>
          <option>Showroom</option>
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
          <option>--ALL--</option>
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
    <div class="report-info mt-3">12 Records Returned</div>

    <!-- Table -->
    <div style="overflow-x: auto; width: 100%;">
      <table style="white-space: nowrap; border-collapse: collapse; width: 100%;">
        <thead class="">
          <tr>
            <th>Customer Name</th>
            <th>Assigned To</th>
            <th>Assigned By</th>
            <th>Source</th>
            <th>Lead Type</th>
            <th>Vehicle of Interest</th>
            <th>Trade-In Vehicle</th>
            <th>Appointments Created</th>
            <th>Appointments Completed</th>
            <th>Sold Deals</th>
            <th>Conversion %</th>
            <th>Avg. Response Time</th>
            <th>Cost per Lead</th>
            <th>Cost per Sold Unit</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>John Doe</td>
            <td>Mike Smith</td>
            <td>Primus CRM</td>
            <td>Facebook</td>
            <td>Internet</td>
            <td>2023 Honda Civic</td>
            <td>2019 Toyota Corolla</td>
            <td>3</td>
            <td>2</td>
            <td>1</td>
            <td>12%</td>
            <td>45 mins</td>
            <td>$50</td>
            <td>$600</td>
          </tr>
          <tr>
            <td>Maria Lopez</td>
            <td>Sarah Johnson</td>
            <td>Alex Brown</td>
            <td>Google Ads</td>
            <td>Phone</td>
            <td>2024 Toyota Camry</td>
            <td>-</td>
            <td>4</td>
            <td>3</td>
            <td>2</td>
            <td>18%</td>
            <td>30 mins</td>
            <td>$40</td>
            <td>$450</td>
          </tr>
          <tr>
            <td>David Chen</td>
            <td>Robert Lee</td>
            <td>Primus CRM</td>
            <td>Walk-In</td>
            <td>Showroom</td>
            <td>2022 Ford Explorer</td>
            <td>2017 Nissan Rogue</td>
            <td>2</td>
            <td>2</td>
            <td>1</td>
            <td>20%</td>
            <td>15 mins</td>
            <td>$0</td>
            <td>$300</td>
          </tr>
          <tr>
            <td>Emily Davis</td>
            <td>James White</td>
            <td>Primus CRM</td>
            <td>Email Campaign</td>
            <td>Internet</td>
            <td>2023 BMW X5</td>
            <td>-</td>
            <td>5</td>
            <td>4</td>
            <td>2</td>
            <td>25%</td>
            <td>50 mins</td>
            <td>$60</td>
            <td>$700</td>
          </tr>
          <tr>
            <td>Ahmed Khan</td>
            <td>Linda Green</td>
            <td>Tom Walker</td>
            <td>Referral</td>
            <td>Phone</td>
            <td>2024 Hyundai Sonata</td>
            <td>2018 Kia Optima</td>
            <td>3</td>
            <td>2</td>
            <td>1</td>
            <td>16%</td>
            <td>25 mins</td>
            <td>$20</td>
            <td>$350</td>
          </tr>
          <tr>
            <td>Michael Brown</td>
            <td>Chris Evans</td>
            <td>Primus CRM</td>
            <td>Instagram</td>
            <td>Internet</td>
            <td>2023 Audi A4</td>
            <td>-</td>
            <td>6</td>
            <td>5</td>
            <td>3</td>
            <td>28%</td>
            <td>40 mins</td>
            <td>$55</td>
            <td>$500</td>
          </tr>
          <tr>
            <td>Sophia Martinez</td>
            <td>William Harris</td>
            <td>Anna Scott</td>
            <td>Website Lead</td>
            <td>Internet</td>
            <td>2024 Tesla Model 3</td>
            <td>2020 Toyota Prius</td>
            <td>2</td>
            <td>2</td>
            <td>2</td>
            <td>35%</td>
            <td>20 mins</td>
            <td>$70</td>
            <td>$650</td>
          </tr>
          <tr>
            <td>Jason Clark</td>
            <td>Emma Wilson</td>
            <td>Primus CRM</td>
            <td>Walk-In</td>
            <td>Showroom</td>
            <td>2022 Jeep Wrangler</td>
            <td>-</td>
            <td>1</td>
            <td>1</td>
            <td>0</td>
            <td>0%</td>
            <td>10 mins</td>
            <td>$0</td>
            <td>-</td>
          </tr>
          <tr>
            <td>Hannah Lee</td>
            <td>Daniel Thomas</td>
            <td>Michael Young</td>
            <td>Facebook</td>
            <td>Internet</td>
            <td>2023 Kia Sportage</td>
            <td>2015 Ford Escape</td>
            <td>3</td>
            <td>2</td>
            <td>1</td>
            <td>14%</td>
            <td>35 mins</td>
            <td>$45</td>
            <td>$550</td>
          </tr>
          <tr>
            <td>Olivia Johnson</td>
            <td>Jacob Allen</td>
            <td>Primus CRM</td>
            <td>Google Ads</td>
            <td>Internet</td>
            <td>2024 Mercedes C-Class</td>
            <td>-</td>
            <td>4</td>
            <td>3</td>
            <td>1</td>
            <td>22%</td>
            <td>55 mins</td>
            <td>$65</td>
            <td>$800</td>
          </tr>
          <tr>
            <td>Chris Taylor</td>
            <td>Laura Martinez</td>
            <td>Kevin Adams</td>
            <td>Email Campaign</td>
            <td>Phone</td>
            <td>2023 Toyota RAV4</td>
            <td>2017 Honda CR-V</td>
            <td>5</td>
            <td>4</td>
            <td>2</td>
            <td>20%</td>
            <td>28 mins</td>
            <td>$52</td>
            <td>$580</td>
          </tr>
          <tr>
            <td>Aisha Patel</td>
            <td>Brian Cooper</td>
            <td>Primus CRM</td>
            <td>Referral</td>
            <td>Showroom</td>
            <td>2023 Nissan Altima</td>
            <td>-</td>
            <td>2</td>
            <td>2</td>
            <td>1</td>
            <td>18%</td>
            <td>22 mins</td>
            <td>$25</td>
            <td>$400</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

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