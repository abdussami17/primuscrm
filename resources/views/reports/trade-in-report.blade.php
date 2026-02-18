<!doctype html>
<html lang="en">

<head>
  <title>Trade-In Report</title>
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
      <h2>Trade-In Report</h2>
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
          <option>--ALL--</option>
          <option>James</option>
          <option>Charles</option>
          <option>Rock</option>
          <option>Mike Smith</option>
          <option>Sarah Johnson</option>
        </select>
      </div>
      
      <!-- Dealership Franchise -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Dealership Franchise</label>
        <select class="form-select">
          <option>--ALL--</option>
          <option>Twins Motors Thompson</option>
          <option>Bannister GM Vernor</option>
          <option>Bannister Nissan</option>
          <option>Bannister Ford</option>
          <option>North Branch</option>
          <option>West Branch</option>
        </select>
      </div>
      
      <!-- Vehicle Make -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Vehicle Make</label>
        <select class="form-select">
          <option>--ALL--</option>
          <option>Toyota</option>
          <option>Honda</option>
          <option>Nissan</option>
          <option>Ford</option>
          <option>Chevrolet</option>
          <option>BMW</option>
          <option>Mercedes</option>
        </select>
      </div>
      
      <!-- Vehicle Year -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Vehicle Year</label>
        <select class="form-select">
          <option>--ALL--</option>
          <option>2024</option>
          <option>2023</option>
          <option>2022</option>
          <option>2021</option>
          <option>2020</option>
          <option>2019</option>
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
            <th>Full Name</th>
            <th>Trade-In Date</th>
            <th>Year</th>
            <th>Make</th>
            <th>Model</th>
            <th>VIN</th>
            <th>KMs</th>
            <th>Condition</th>
            <th>Trade-In Value</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>John Smith</td>
            <td>Oct 7, 2025</td>
            <td>2023</td>
            <td>Toyota</td>
            <td>Camry SE</td>
            <td>1HGCM82633A123456</td>
            <td>45,000</td>
            <td>Excellent</td>
            <td>$18,500</td>
          </tr>
          <tr>
            <td>Maria Gonzalez</td>
            <td>Oct 6, 2025</td>
            <td>2022</td>
            <td>Honda</td>
            <td>Accord LX</td>
            <td>2FTRX18W1XCA12345</td>
            <td>30,500</td>
            <td>Good</td>
            <td>$16,200</td>
          </tr>
          <tr>
            <td>Ahmed Khan</td>
            <td>Oct 5, 2025</td>
            <td>2024</td>
            <td>Nissan</td>
            <td>Altima SV</td>
            <td>3N1AB7AP4FY123456</td>
            <td>18,200</td>
            <td>Like New</td>
            <td>$22,800</td>
          </tr>
          <tr>
            <td>Emily Davis</td>
            <td>Oct 4, 2025</td>
            <td>2021</td>
            <td>Ford</td>
            <td>Explorer XLT</td>
            <td>1FM5K8D80HGA12345</td>
            <td>52,800</td>
            <td>Fair</td>
            <td>$15,600</td>
          </tr>
          <tr>
            <td>Michael Brown</td>
            <td>Oct 3, 2025</td>
            <td>2020</td>
            <td>Chevrolet</td>
            <td>Malibu LT</td>
            <td>1G1ZD5ST7LF123456</td>
            <td>67,300</td>
            <td>Good</td>
            <td>$12,400</td>
          </tr>
          <tr>
            <td>Sarah Johnson</td>
            <td>Oct 2, 2025</td>
            <td>2023</td>
            <td>BMW</td>
            <td>330i</td>
            <td>3MW5R7J08M8A12345</td>
            <td>22,100</td>
            <td>Excellent</td>
            <td>$28,900</td>
          </tr>
          <tr>
            <td>Robert Wilson</td>
            <td>Oct 1, 2025</td>
            <td>2019</td>
            <td>Mercedes</td>
            <td>C300</td>
            <td>WDDWF8DB7RA123456</td>
            <td>58,900</td>
            <td>Good</td>
            <td>$21,300</td>
          </tr>
          <tr>
            <td>Lisa Anderson</td>
            <td>Sep 30, 2025</td>
            <td>2022</td>
            <td>Hyundai</td>
            <td>Tucson Limited</td>
            <td>5NPE34AF0NH123456</td>
            <td>34,700</td>
            <td>Excellent</td>
            <td>$19,800</td>
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