<!doctype html>
<html lang="en">

<head>
  <title>Service Appointment Report</title>
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
  <!-- TomSelect CSS -->
  <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
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
    
    .work-notes-cell {
      cursor: pointer;
      color: #000;
      text-decoration: underline;
    }
    
    .work-notes-cell:hover {
      color: #000;
      background-color: #f8f9fa;
    }
  </style>
</head>

<body>
  <div class="report-single">
    <!-- Heading + Buttons -->
    <div class="header-bar">
      <h2>Service Appointment Report</h2>
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

      <!-- Service Advisor -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Service Advisor</label>
        <select class="form-select">
          <option>--ALL--</option>
          <option>John Smith</option>
          <option>Sarah Lee</option>
          <option>Mike Johnson</option>
          <option>Emily Davis</option>
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
    
      <!-- Franchise -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Franchise</label>
        <select class="form-select">
          <option>--ALL--</option>
          <option>North Branch</option>
          <option>West Branch</option>
          <option>East Branch</option>
          <option>South Branch</option>
        </select>
      </div>
    
      <!-- Service Drive -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Service Drive</label>
        <select class="form-select">
          <option>--ALL--</option>
          <option>Drive 1</option>
          <option>Drive 2</option>
          <option>Drive 3</option>
        </select>
      </div>
    
      <!-- Created By -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Created By</label>
        <select class="form-select">
          <option>--ALL--</option>
          <option>Admin</option>
          <option>Manager</option>
          <option>Service Advisor</option>
          <option>Customer</option>
        </select>
      </div>
    
      <!-- Created Team -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Created Team</label>
        <select class="form-select">
          <option>--ALL--</option>
          <option>Sales</option>
          <option>Support</option>
          <option>Service</option>
        </select>
      </div>
    
      <!-- Service Product -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Service Product</label>
        <select class="form-select">
          <option>--ALL--</option>
          <option>Oil Change</option>
          <option>Tire Service</option>
          <option>Brake Service</option>
          <option>Transmission</option>
          <option>Engine Repair</option>
        </select>
      </div>
    
      <!-- Service Type -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Service Type</label>
        <select class="form-select">
          <option>--ALL--</option>
          <option>Customer Pay</option>
          <option>Warranty</option>
          <option>Internal</option>
          <option>Insurance</option>
        </select>
      </div>
    
      <!-- Source -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Source</label>
        <select class="form-select">
          <option>--ALL--</option>
          <option>Online</option>
          <option>Phone</option>
          <option>Walk-in</option>
          <option>Mobile App</option>
        </select>
      </div>
    
      <!-- Status -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Status</label>
        <select class="form-select">
          <option>--ALL--</option>
          <option>Open</option>
          <option>Confirmed</option>
          <option>Completed</option>
          <option>Cancelled</option>
        </select>
      </div>
    </form>
    
    <script>
      window.addEventListener("DOMContentLoaded", () => {
        const today = new Date();
        const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
    
        const formatDate = (d) => d.toISOString().split("T")[0];
    
        document.getElementById("beginDate").value = formatDate(firstDay);
        document.getElementById("endDate").value = formatDate(lastDay);
      });
    </script>
    
    <!-- Report Info -->
    <div class="report-info mt-2">08 Records Returned</div>

    <!-- Table -->
    <div style="overflow-x: auto; width: 100%;">
      <table style="white-space: nowrap; border-collapse: collapse; width: 100%;">
        <thead>
          <tr>
            <th>Work Notes</th>
            <th>App. Date</th>
            <th>App. Time</th>
            <th>Open/Conf./Comp.</th>
            <th>Unconf. Show</th>
            <th>No Show</th>
            <th>Name</th>
            <th>Home Number</th>
            <th>Wk/Cell Number</th>
            <th>Service Drive</th>
            <th>Service Type</th>
            <th>Service Product</th>
            <th>Vehicle</th>
            <th>Current Miles</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="work-notes-cell" data-bs-toggle="modal" data-bs-target="#viewfullnote" data-customer="John Doe" data-vehicle="2022 Toyota Camry">Oil change and tire rotation requested</td>
            <td>Oct 7, 2025</td>
            <td>10:00 AM</td>
            <td>Open</td>
            <td>Yes</td>
            <td>No</td>
            <td>John Doe</td>
            <td>555-1234</td>
            <td>555-5678</td>
            <td>Drive 1</td>
            <td>Customer Pay</td>
            <td>Oil Change</td>
            <td>2022 Toyota Camry</td>
            <td>45,000</td>
          </tr>
          <tr>
            <td class="work-notes-cell" data-bs-toggle="modal" data-bs-target="#viewfullnote" data-customer="Robert King" data-vehicle="2021 Chevrolet Malibu">Warranty claim for transmission issues</td>
            <td>Oct 7, 2025</td>
            <td>03:30 PM</td>
            <td>Confirmed</td>
            <td>Yes</td>
            <td>No</td>
            <td>Robert King</td>
            <td>555-5234</td>
            <td>555-9678</td>
            <td>Drive 2</td>
            <td>Warranty</td>
            <td>Transmission</td>
            <td>2021 Chevrolet Malibu</td>
            <td>55,300</td>
          </tr>
          <tr>
            <td class="work-notes-cell" data-bs-toggle="modal" data-bs-target="#viewfullnote" data-customer="Emma White" data-vehicle="2023 BMW 330i">Body repair from minor accident</td>
            <td>Oct 6, 2025</td>
            <td>01:00 PM</td>
            <td>Completed</td>
            <td>No</td>
            <td>No</td>
            <td>Emma White</td>
            <td>555-6234</td>
            <td>555-0678</td>
            <td>Drive 1</td>
            <td>Insurance</td>
            <td>Body Repair</td>
            <td>2023 BMW 330i</td>
            <td>35,900</td>
          </tr>
          <tr>
            <td class="work-notes-cell" data-bs-toggle="modal" data-bs-target="#viewfullnote" data-customer="Michael Brown" data-vehicle="2020 Honda CR-V">Brake pad replacement and inspection</td>
            <td>Oct 6, 2025</td>
            <td>09:15 AM</td>
            <td>Completed</td>
            <td>No</td>
            <td>No</td>
            <td>Michael Brown</td>
            <td>555-7234</td>
            <td>555-1678</td>
            <td>Drive 3</td>
            <td>Customer Pay</td>
            <td>Brake Service</td>
            <td>2020 Honda CR-V</td>
            <td>68,200</td>
          </tr>
          <tr>
            <td class="work-notes-cell" data-bs-toggle="modal" data-bs-target="#viewfullnote" data-customer="Sarah Johnson" data-vehicle="2019 Ford Escape">Engine diagnostic and tune-up</td>
            <td>Oct 5, 2025</td>
            <td>11:45 AM</td>
            <td>Confirmed</td>
            <td>Yes</td>
            <td>No</td>
            <td>Sarah Johnson</td>
            <td>555-8234</td>
            <td>555-2678</td>
            <td>Drive 2</td>
            <td>Customer Pay</td>
            <td>Engine Repair</td>
            <td>2019 Ford Escape</td>
            <td>72,500</td>
          </tr>
          <tr>
            <td class="work-notes-cell" data-bs-toggle="modal" data-bs-target="#viewfullnote" data-customer="David Wilson" data-vehicle="2022 Hyundai Tucson">Tire replacement and alignment</td>
            <td>Oct 5, 2025</td>
            <td>02:30 PM</td>
            <td>Open</td>
            <td>No</td>
            <td>No</td>
            <td>David Wilson</td>
            <td>555-9234</td>
            <td>555-3678</td>
            <td>Drive 1</td>
            <td>Customer Pay</td>
            <td>Tire Service</td>
            <td>2022 Hyundai Tucson</td>
            <td>28,400</td>
          </tr>
          <tr>
            <td class="work-notes-cell" data-bs-toggle="modal" data-bs-target="#viewfullnote" data-customer="Lisa Anderson" data-vehicle="2023 Toyota RAV4">Factory recall service</td>
            <td>Oct 4, 2025</td>
            <td>08:30 AM</td>
            <td>Completed</td>
            <td>No</td>
            <td>No</td>
            <td>Lisa Anderson</td>
            <td>555-0334</td>
            <td>555-4678</td>
            <td>Drive 3</td>
            <td>Warranty</td>
            <td>Recall Service</td>
            <td>2023 Toyota RAV4</td>
            <td>15,800</td>
          </tr>
          <tr>
            <td class="work-notes-cell" data-bs-toggle="modal" data-bs-target="#viewfullnote" data-customer="James Miller" data-vehicle="2018 Nissan Altima">Pre-purchase inspection</td>
            <td>Oct 4, 2025</td>
            <td>04:15 PM</td>
            <td>Completed</td>
            <td>Yes</td>
            <td>No</td>
            <td>James Miller</td>
            <td>555-1334</td>
            <td>555-5678</td>
            <td>Drive 2</td>
            <td>Customer Pay</td>
            <td>Inspection</td>
            <td>2018 Nissan Altima</td>
            <td>89,300</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Notes Preview Modal -->
  <div class="modal fade" id="viewfullnote" tabindex="-1" aria-labelledby="viewfullnote" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Service Notes History - <span id="serviceCustomerName">John Doe</span></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="note-history">
            <div class="note-entry mb-4">
              <div class="fw-bold">Oct 7, 2025 10:00 AM <span class="text-muted">by John Smith</span></div>
              <div>Customer arrived for scheduled <strong>oil change and tire rotation</strong>. Vehicle condition appears good.</div>
            </div>
  
            <div class="note-entry mb-4">
              <div class="fw-bold">Oct 7, 2025 10:15 AM <span class="text-muted">by Service Technician</span></div>
              <div>Initial inspection completed. Oil change in progress. Tire rotation scheduled after oil service.</div>
            </div>
  
            <div class="note-entry mb-4">
              <div class="fw-bold">Oct 7, 2025 10:45 AM <span class="text-muted">by John Smith</span></div>
              <div>Customer approved additional air filter replacement. Waiting for parts delivery.</div>
            </div>
  
            <div class="note-entry mb-4">
              <div class="fw-bold">Oct 7, 2025 11:30 AM <span class="text-muted">by Service Manager</span></div>
              <div>All services completed successfully. Vehicle ready for customer pickup.</div>
            </div>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-between">
          <button class="btn btn-light border border-1" data-bs-dismiss="modal">Close</button>
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editnoteModal">Add Note</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Note Modal -->
  <div class="modal fade" id="editnoteModal" tabindex="-1" aria-labelledby="editNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Service Note</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <!-- Note -->
          <div class="mb-3">
            <label class="form-label fw-bold">Note</label>
            <textarea class="form-control" id="noteInput" rows="4" placeholder="Write your service note here..."></textarea>
          </div>

          <!-- Audio/Video Buttons -->
          <div class="mb-3 d-flex gap-2">
            <button type="button" class="btn btn-light border-1 border" id="recordAudioBtn"><i class="ti ti-microphone me-1"></i>Record Audio</button>
            <button type="button" class="btn btn-light border-1 border" id="recordVideoBtn"><i class="ti ti-camera me-1"></i>Record Video</button>
          </div>

          <!-- Audio/Video Preview -->
          <div id="mediaPreview" class="mb-3"></div>

          <!-- Private Note -->
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="privateNote">
            <label class="form-check-label" for="privateNote">Private Note (only visible to you)</label>
          </div>

          <!-- Tag Users -->
          <div class="mb-3">
            <label class="form-label fw-bold">Tag Users</label>
            <select id="tagUsers" multiple>
              <option value="1">John Smith</option>
              <option value="2">Sarah Lee</option>
              <option value="3">Mike Johnson</option>
              <option value="4">Emily Davis</option>
              <option value="5">Service Manager</option>
            </select>
          </div>

          <!-- Tagged Users Initials Example -->
          <div class="mt-3" id="taggedUsersInitials"></div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-light border border-1" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="saveNoteBtn">Save Note</button>
        </div>
      </div>
    </div>
  </div>

  <!-- TomSelect JS -->
  <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
  
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // From date fixed 2000-01-01
      document.querySelector("#fromDate").value = "2000-01-01";

      // To date = auto
      document.querySelector("#toDate").value = new Date().toISOString().split('T')[0];
      
      // Initialize TomSelect
      new TomSelect("#tagUsers", {
        plugins: ['remove_button'],
        create: false,
        onChange: function(values) {
          renderUserInitials(values);
        }
      });

      function renderUserInitials(userIds) {
        let users = {
          "1": "John Smith",
          "2": "Sarah Lee",
          "3": "Mike Johnson",
          "4": "Emily Davis",
          "5": "Service Manager"
        };
        let container = document.getElementById("taggedUsersInitials");
        container.innerHTML = "";
        userIds.forEach(id => {
          let name = users[id];
          let initials = name.split(" ").map(n => n[0]).join("");
          let badge = `<span class="badge bg-secondary rounded-circle p-2 me-1" data-bs-toggle="tooltip" title="${name}">${initials}</span>`;
          container.innerHTML += badge;
        });
        new bootstrap.Tooltip(document.body, { selector: '[data-bs-toggle="tooltip"]' });
      }

      // Recording Logic
      let mediaRecorder;
      let recordedChunks = [];
      
      document.getElementById("recordAudioBtn").addEventListener("click", function() {
        navigator.mediaDevices.getUserMedia({ audio: true }).then(stream => {
          startRecording(stream, "audio");
        }).catch(err => alert("Microphone access denied!"));
      });

      document.getElementById("recordVideoBtn").addEventListener("click", function() {
        navigator.mediaDevices.getUserMedia({ audio: true, video: true }).then(stream => {
          startRecording(stream, "video");
        }).catch(err => alert("Camera access denied!"));
      });

      function startRecording(stream, type) {
        recordedChunks = [];
        mediaRecorder = new MediaRecorder(stream);
        mediaRecorder.ondataavailable = e => {
          if (e.data.size > 0) recordedChunks.push(e.data);
        };
        mediaRecorder.onstop = () => {
          let blob = new Blob(recordedChunks, { type: type === "audio" ? "audio/webm" : "video/webm" });
          let url = URL.createObjectURL(blob);
          let preview = type === "audio" 
            ? `<audio controls src="${url}" class="w-100 mt-2"></audio>` 
            : `<video controls src="${url}" class="w-100 mt-2"></video>`;
          document.getElementById("mediaPreview").innerHTML = preview;
        };

        mediaRecorder.start();
        alert("Recording started. Click OK when you want to stop.");
        mediaRecorder.stop();
      }

      // Save Note Button
      document.getElementById("saveNoteBtn").addEventListener("click", function() {
        let modalEl = document.getElementById("editnoteModal");
        let modal = bootstrap.Modal.getInstance(modalEl);
        modal.hide();
      });

      // Update customer name in notes modal when clicking on work notes cell
      document.querySelectorAll('.work-notes-cell').forEach(cell => {
        cell.addEventListener('click', function() {
          const customerName = this.getAttribute('data-customer');
          const vehicle = this.getAttribute('data-vehicle');
          document.getElementById('serviceCustomerName').textContent = `${customerName} - ${vehicle}`;
        });
      });
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/custom-calendar.js"></script>
</body>

</html>