<!doctype html>
<html lang="en">

<head>
  <title>Lead Type & Tracking Code Report</title>
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
    
    .clickable {
      cursor: pointer;
      color: #0d6efd;
      text-decoration: underline;
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
      <h2>Lead Type & Tracking Code Report</h2>
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
      
      <!-- Inventory Type -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Inventory Type</label>
        <select class="form-select">
          <option>--ALL--</option>
          <option>New</option>
          <option>Used</option>
          <option>CPO</option>
          <option>Demo</option>
        </select>
      </div>

      <!-- Team -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Team</label>
        <select class="form-select">
          <option>--ALL--</option>
          <option>Team A</option>
          <option>Team B</option>
          <option>Team C</option>
        </select>
      </div>

      <!-- Dealership Franchise -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Dealership Franchise</label>
        <select class="form-select">
          <option>--ALL--</option>
          <option>North Branch</option>
          <option>West Branch</option>
          <option>East Branch</option>
          <option>South Branch</option>
        </select>
      </div>

      <!-- Lead Type -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Lead Type</label>
        <select class="form-select">
          <option>--ALL--</option>
          <option>Online</option>
          <option>Phone</option>
          <option>Walk-in</option>
          <option>Referral</option>
          <option>Website Chat</option>
        </select>
      </div>
      
      <!-- Assigned To -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Assigned To</label>
        <select class="form-select">
          <option>--ALL--</option>
          <option>John Smith</option>
          <option>Sarah Lee</option>
          <option>Robert King</option>
          <option>Mike Johnson</option>
        </select>
      </div>
      
      <!-- Tracking Code -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Tracking Code</label>
        <select class="form-select">
          <option>--ALL--</option>
          <option>WEB123</option>
          <option>CALL456</option>
          <option>WALK789</option>
          <option>REF001</option>
          <option>CHAT002</option>
        </select>
      </div>
    </form>

    <!-- Report Info -->
    <div class="report-info mt-3">08 Records Returned</div>

    <div style="overflow-x: auto; width: 100%;">
      <table style="white-space: nowrap; border-collapse: collapse; width: 100%;">
        <thead>
          <tr>
            <th>Lead Type</th>
            <th>Assigned To</th>
            <th>New Leads</th>
            <th>Number Appts</th>
            <th>Number Appts Sold</th>
            <th>Appt Show / Sold</th>
            <th>Appt Open / Appt Show</th>
            <th>Tracking Code</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Online</td>
            <td>John Smith</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#detailModal" data-info="John Doe - 2023 Toyota Camry, Maria Gonzalez - 2022 Honda Accord, Ahmed Khan - 2024 Nissan Altima, Emily Davis - 2021 Ford Explorer">12</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#detailModal" data-info="John Doe - 2023 Toyota Camry, Maria Gonzalez - 2022 Honda Accord, Ahmed Khan - 2024 Nissan Altima">8</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#detailModal" data-info="John Doe - 2023 Toyota Camry, Maria Gonzalez - 2022 Honda Accord">5</td>
            <td>5 / 8</td>
            <td>3 / 5</td>
            <td>WEB123</td>
          </tr>
          <tr>
            <td>Phone</td>
            <td>Sarah Lee</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#detailModal" data-info="Michael Brown - 2023 Chevrolet Malibu, Olivia Johnson - 2022 Hyundai Sonata, Daniel Martinez - 2023 BMW 330i">9</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#detailModal" data-info="Michael Brown - 2023 Chevrolet Malibu, Olivia Johnson - 2022 Hyundai Sonata">6</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#detailModal" data-info="Michael Brown - 2023 Chevrolet Malibu">4</td>
            <td>4 / 6</td>
            <td>2 / 4</td>
            <td>CALL456</td>
          </tr>
          <tr>
            <td>Walk-in</td>
            <td>Robert King</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#detailModal" data-info="Sophia Taylor - 2021 Kia Sportage, Liam Anderson - 2024 Mercedes C300, Hannah White - 2023 Audi Q5">7</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#detailModal" data-info="Sophia Taylor - 2021 Kia Sportage, Liam Anderson - 2024 Mercedes C300">5</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#detailModal" data-info="Sophia Taylor - 2021 Kia Sportage">2</td>
            <td>2 / 5</td>
            <td>1 / 2</td>
            <td>WALK789</td>
          </tr>
          <tr>
            <td>Referral</td>
            <td>Mike Johnson</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#detailModal" data-info="James Wilson - 2022 Ford F-150, Emma Thompson - 2023 Subaru Outback, Noah Garcia - 2024 Jeep Grand Cherokee">6</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#detailModal" data-info="James Wilson - 2022 Ford F-150, Emma Thompson - 2023 Subaru Outback">4</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#detailModal" data-info="James Wilson - 2022 Ford F-150">3</td>
            <td>3 / 4</td>
            <td>2 / 3</td>
            <td>REF001</td>
          </tr>
          <tr>
            <td>Website Chat</td>
            <td>Emily Davis</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#detailModal" data-info="Ava Rodriguez - 2021 Toyota RAV4, William Lee - 2023 Lexus RX 350, Lisa Anderson - 2022 Toyota Highlander">8</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#detailModal" data-info="Ava Rodriguez - 2021 Toyota RAV4, William Lee - 2023 Lexus RX 350">5</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#detailModal" data-info="Ava Rodriguez - 2021 Toyota RAV4">3</td>
            <td>3 / 5</td>
            <td>2 / 3</td>
            <td>CHAT002</td>
          </tr>
          <tr>
            <td>Online</td>
            <td>David Wilson</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#detailModal" data-info="Mark Thompson - 2023 Honda CR-V, Jennifer Brown - 2024 Ford Bronco, Carlos Martinez - 2021 Chevrolet Silverado">10</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#detailModal" data-info="Mark Thompson - 2023 Honda CR-V, Jennifer Brown - 2024 Ford Bronco">7</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#detailModal" data-info="Mark Thompson - 2023 Honda CR-V">4</td>
            <td>4 / 7</td>
            <td>3 / 4</td>
            <td>WEB456</td>
          </tr>
          <tr>
            <td>Phone</td>
            <td>Amanda Clark</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#detailModal" data-info="Kevin Taylor - 2022 Mazda CX-5, Rachel Garcia - 2023 Volkswagen Tiguan, Brian Wilson - 2021 Hyundai Elantra">5</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#detailModal" data-info="Kevin Taylor - 2022 Mazda CX-5, Rachel Garcia - 2023 Volkswagen Tiguan">3</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#detailModal" data-info="Kevin Taylor - 2022 Mazda CX-5">2</td>
            <td>2 / 3</td>
            <td>1 / 2</td>
            <td>CALL789</td>
          </tr>
          <tr>
            <td>Walk-in</td>
            <td>Chris Evans</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#detailModal" data-info="Michelle Rodriguez - 2024 Honda Civic, Steven Harris - 2022 Toyota Tacoma, Nicole Parker - 2023 Kia Sorento">4</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#detailModal" data-info="Michelle Rodriguez - 2024 Honda Civic, Steven Harris - 2022 Toyota Tacoma">2</td>
            <td class="clickable" data-bs-toggle="modal" data-bs-target="#detailModal" data-info="Michelle Rodriguez - 2024 Honda Civic">1</td>
            <td>1 / 2</td>
            <td>1 / 1</td>
            <td>WALK123</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Detail Modal -->
  <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Lead Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" id="modalContent">
          <p><strong>Customer & Vehicle Details:</strong></p>
          <div id="customerList"></div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // From date fixed 2000-01-01
      document.querySelector("#fromDate").value = "2000-01-01";

      // To date = auto
      document.querySelector("#toDate").value = new Date().toISOString().split('T')[0];
      
      // Handle modal content update
      const detailModal = document.getElementById('detailModal');
      if (detailModal) {
        detailModal.addEventListener('show.bs.modal', function (event) {
          const button = event.relatedTarget;
          const customerInfo = button.getAttribute('data-info');
          const customerList = document.getElementById('customerList');
          
          if (customerInfo && customerList) {
            const customers = customerInfo.split(', ');
            let html = '';
            customers.forEach(customer => {
              html += `<div class="mb-2 p-2 border rounded">
                <strong>${customer}</strong><br>
                <small class="text-muted">Created: Oct 7, 2025 10:15 AM</small><br>
                <a href="customers.html" class="text-dark text-decoration-underline me-2">View Customer</a>
                <a href="inventory.html" class="text-dark text-decoration-underline">View Vehicle</a>
              </div>`;
            });
            customerList.innerHTML = html;
          }
        });
      }
    });
  </script>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <script src="assets/js/custom-calendar.js"></script>
</body>

</html>