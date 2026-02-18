<!doctype html>
<html lang="en">

<head>
  <title>Text Sent / Received Report</title>
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
      <h2>Text Sent / Received Report</h2>
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
    
      <!-- Franchise -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Franchise</label>
        <select class="form-select">
          <option>--ALL--</option>
          <option>North Branch</option>
          <option>West Branch</option>
          <option>West Branch – Sister Store 1</option>
        </select>
      </div>
    
      <!-- Text Type -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Text Type</label>
        <select class="form-select">
          <option>--ALL--</option>
        </select>
      </div>
    
      <!-- Users -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Users</label>
        <select class="form-select">
          <option>--ALL--</option>
          <option>Aaron Burgess</option>
          <option>Brad Nakuckyj</option>
          <option>Brandon Henderson</option>
          <option>Emily Chan</option>
          <option>Jake Thomson</option>
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
    </form>
    
    <!-- Report Info -->
    <div class="report-info mt-3">08 Records Returned</div>

    <!-- Table -->
    <div style="overflow-x: auto; width: 100%;">
      <table style="white-space: nowrap; border-collapse: collapse; width: 100%;">
        <thead>
          <tr>
            <th>Customer Name</th>
            <th>Date/Time</th>
            <th>Text Type</th>
            <th>Sent By</th>
            <th>Team</th>
            <th>Cell Number</th>
            <th>Work Number</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>John Smith</td>
            <td>Oct 5, 2023 10:32 AM</td>
            <td>Sent</td>
            <td>Alex Johnson</td>
            <td>Sales</td>
            <td>+1 (416) 555-1234</td>
            <td>+1 (416) 555-4321</td>
          </tr>
          <tr>
            <td>Maria Gonzalez</td>
            <td>Oct 5, 2023 02:15 PM</td>
            <td>Received</td>
            <td>Sarah Lee</td>
            <td>Service</td>
            <td>+1 (647) 555-7788</td>
            <td>-</td>
          </tr>
          <tr>
            <td>Ahmed Khan</td>
            <td>Oct 6, 2023 11:45 AM</td>
            <td>Sent</td>
            <td>David Miller</td>
            <td>Parts</td>
            <td>+1 (905) 555-6677</td>
            <td>+1 (905) 555-8899</td>
          </tr>
          <tr>
            <td>Emily Davis</td>
            <td>Oct 7, 2023 03:50 PM</td>
            <td>Received</td>
            <td>Robert Wilson</td>
            <td>Sales</td>
            <td>+1 (289) 555-3344</td>
            <td>-</td>
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