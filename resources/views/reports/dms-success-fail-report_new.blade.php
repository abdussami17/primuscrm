<!doctype html>
<html lang="en">

<head>
  <title>DMS Success / Fail Report</title>
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
    
    .status-success {
      color: #198754;
      font-weight: 600;
    }
    
    .status-failed {
      color: #dc3545;
      font-weight: 600;
    }
    
    .notes-preview-cell {
      cursor: pointer;
      color: #000;
      text-decoration: underline;
    }
    
    .notes-preview-cell:hover {
      color: #000;
    }
  </style>
</head>

<body>
  <div class="report-single">
    <!-- Heading + Buttons -->
    <div class="header-bar">
      <h2>DMS Success / Fail Report</h2>
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
    
      <!-- Status Filter -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Status</label>
        <select class="form-select">
          <option>--ALL--</option>
          <option>Success</option>
          <option>Failed</option>
        </select>
      </div>
    
      <!-- Salesperson Filter -->
      <div class="col-md-3 mb-1">
        <label class="form-label">Salesperson</label>
        <select class="form-select">
          <option>--ALL--</option>
          <option>Alex Johnson</option>
          <option>Sarah Lee</option>
          <option>David Miller</option>
          <option>Robert Wilson</option>
          <option>Kevin Thompson</option>
        </select>
      </div>
    </form>
    
    <!-- Report Info -->
    <div class="report-info mt-3">15 Records Returned</div>

    <!-- Table -->
    <div style="overflow-x: auto; width: 100%;">
      <table style="white-space: nowrap; border-collapse: collapse; width: 100%;">
        <thead>
          <tr>
            <th>DMS ID</th>
            <th>Customer Name</th>
            <th>Vehicle</th>
            <th>VIN</th>
            <th>Salesperson</th>
            <th>Push Date & Time</th>
            <th>Status</th>
            <th>Notes</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>DMS-001</td>
            <td>John Smith</td>
            <td>2023 Toyota Camry SE</td>
            <td>4T1C11AK3PU123456</td>
            <td>Alex Johnson</td>
            <td>Oct 7, 2025 10:15 AM</td>
            <td class="status-success">Success</td>
            <td class="notes-preview-cell" data-bs-toggle="modal" data-bs-target="#viewfullnote" data-dms-id="DMS-001">Successfully pushed to DMS</td>
          </tr>
          <tr>
            <td>DMS-002</td>
            <td>Maria Gonzalez</td>
            <td>2022 Honda Accord LX</td>
            <td>1HGCV1F14NA345678</td>
            <td>Sarah Lee</td>
            <td>Oct 7, 2025 10:20 AM</td>
            <td class="status-failed">Failed</td>
            <td class="notes-preview-cell" data-bs-toggle="modal" data-bs-target="#viewfullnote" data-dms-id="DMS-002">Missing finance manager approval</td>
          </tr>
          <tr>
            <td>DMS-003</td>
            <td>Ahmed Khan</td>
            <td>2024 Nissan Altima SV</td>
            <td>1N4BL4DV7RN789012</td>
            <td>David Miller</td>
            <td>Oct 7, 2025 10:25 AM</td>
            <td class="status-success">Success</td>
            <td class="notes-preview-cell" data-bs-toggle="modal" data-bs-target="#viewfullnote" data-dms-id="DMS-003">Deal submitted successfully</td>
          </tr>
          <tr>
            <td>DMS-004</td>
            <td>Emily Davis</td>
            <td>2021 Ford Explorer XLT</td>
            <td>1FM5K7D89MGA12345</td>
            <td>Robert Wilson</td>
            <td>Oct 7, 2025 10:28 AM</td>
            <td class="status-failed">Failed</td>
            <td class="notes-preview-cell" data-bs-toggle="modal" data-bs-target="#viewfullnote" data-dms-id="DMS-004">VIN not recognized by DMS</td>
          </tr>
          <tr>
            <td>DMS-005</td>
            <td>Michael Brown</td>
            <td>2023 Chevrolet Malibu LT</td>
            <td>1G1ZD5ST2PF234567</td>
            <td>Kevin Thompson</td>
            <td>Oct 7, 2025 10:32 AM</td>
            <td class="status-success">Success</td>
            <td class="notes-preview-cell" data-bs-toggle="modal" data-bs-target="#viewfullnote" data-dms-id="DMS-005">Customer data synced</td>
          </tr>
          <tr>
            <td>DMS-006</td>
            <td>Olivia Johnson</td>
            <td>2022 Hyundai Sonata SEL</td>
            <td>5NPEJ4J24NH123456</td>
            <td>Alex Johnson</td>
            <td>Oct 7, 2025 10:40 AM</td>
            <td class="status-failed">Failed</td>
            <td class="notes-preview-cell" data-bs-toggle="modal" data-bs-target="#viewfullnote" data-dms-id="DMS-006">Missing trade-in vehicle info</td>
          </tr>
          <tr>
            <td>DMS-007</td>
            <td>Daniel Martinez</td>
            <td>2023 BMW 330i</td>
            <td>3MW5R7J06P8A56789</td>
            <td>Sarah Lee</td>
            <td>Oct 7, 2025 10:45 AM</td>
            <td class="status-success">Success</td>
            <td class="notes-preview-cell" data-bs-toggle="modal" data-bs-target="#viewfullnote" data-dms-id="DMS-007">Approved by finance department</td>
          </tr>
          <tr>
            <td>DMS-008</td>
            <td>Sophia Taylor</td>
            <td>2021 Kia Sportage LX</td>
            <td>KNDPM3AC5M7123456</td>
            <td>David Miller</td>
            <td>Oct 7, 2025 10:50 AM</td>
            <td class="status-failed">Failed</td>
            <td class="notes-preview-cell" data-bs-toggle="modal" data-bs-target="#viewfullnote" data-dms-id="DMS-008">Duplicate deal detected in system</td>
          </tr>
          <tr>
            <td>DMS-009</td>
            <td>Liam Anderson</td>
            <td>2024 Mercedes C300</td>
            <td>WDDWF8DB7RR123456</td>
            <td>Robert Wilson</td>
            <td>Oct 7, 2025 11:00 AM</td>
            <td class="status-success">Success</td>
            <td class="notes-preview-cell" data-bs-toggle="modal" data-bs-target="#viewfullnote" data-dms-id="DMS-009">Deal pushed successfully</td>
          </tr>
          <tr>
            <td>DMS-010</td>
            <td>Hannah White</td>
            <td>2023 Audi Q5 Premium</td>
            <td>WA1AAAFY3P2123456</td>
            <td>Kevin Thompson</td>
            <td>Oct 7, 2025 11:05 AM</td>
            <td class="status-success">Success</td>
            <td class="notes-preview-cell" data-bs-toggle="modal" data-bs-target="#viewfullnote" data-dms-id="DMS-010">Deal finalized and archived</td>
          </tr>
          <tr>
            <td>DMS-011</td>
            <td>James Wilson</td>
            <td>2022 Ford F-150 Lariat</td>
            <td>1FTEW1EP2NFA78901</td>
            <td>Alex Johnson</td>
            <td>Oct 7, 2025 11:15 AM</td>
            <td class="status-success">Success</td>
            <td class="notes-preview-cell" data-bs-toggle="modal" data-bs-target="#viewfullnote" data-dms-id="DMS-011">All documents verified and submitted</td>
          </tr>
          <tr>
            <td>DMS-012</td>
            <td>Emma Thompson</td>
            <td>2023 Subaru Outback Limited</td>
            <td>4S4BT65C0P3212345</td>
            <td>Sarah Lee</td>
            <td>Oct 7, 2025 11:20 AM</td>
            <td class="status-failed">Failed</td>
            <td class="notes-preview-cell" data-bs-toggle="modal" data-bs-target="#viewfullnote" data-dms-id="DMS-012">Customer credit application pending</td>
          </tr>
          <tr>
            <td>DMS-013</td>
            <td>Noah Garcia</td>
            <td>2024 Jeep Grand Cherokee</td>
            <td>1C4RJYDG4RC123456</td>
            <td>David Miller</td>
            <td>Oct 7, 2025 11:25 AM</td>
            <td class="status-success">Success</td>
            <td class="notes-preview-cell" data-bs-toggle="modal" data-bs-target="#viewfullnote" data-dms-id="DMS-013">Lease deal processed successfully</td>
          </tr>
          <tr>
            <td>DMS-014</td>
            <td>Ava Rodriguez</td>
            <td>2021 Toyota RAV4 XLE</td>
            <td>2T3W1RFV3MW123456</td>
            <td>Robert Wilson</td>
            <td>Oct 7, 2025 11:30 AM</td>
            <td class="status-failed">Failed</td>
            <td class="notes-preview-cell" data-bs-toggle="modal" data-bs-target="#viewfullnote" data-dms-id="DMS-014">Insurance documentation incomplete</td>
          </tr>
          <tr>
            <td>DMS-015</td>
            <td>William Lee</td>
            <td>2023 Lexus RX 350</td>
            <td>2T2HZMDA7PC123456</td>
            <td>Kevin Thompson</td>
            <td>Oct 7, 2025 11:35 AM</td>
            <td class="status-success">Success</td>
            <td class="notes-preview-cell" data-bs-toggle="modal" data-bs-target="#viewfullnote" data-dms-id="DMS-015">Premium package deal completed</td>
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
          <h5 class="modal-title">DMS Notes History - <span id="dmsCustomerName">John Smith</span></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="note-history">
            <div class="note-entry mb-4">
              <div class="fw-bold">Oct 7, 2025 10:15 AM <span class="text-muted">by Alex Johnson</span></div>
              <div>DMS push initiated for <strong>2023 Toyota Camry SE</strong>. All required documents verified and ready for submission.</div>
            </div>
  
            <div class="note-entry mb-4">
              <div class="fw-bold">Oct 7, 2025 10:16 AM <span class="text-muted">by System</span></div>
              <div>DMS integration check passed. Vehicle data validated successfully.</div>
            </div>
  
            <div class="note-entry mb-4">
              <div class="fw-bold">Oct 7, 2025 10:17 AM <span class="text-muted">by Alex Johnson</span></div>
              <div>Customer information confirmed. Finance terms approved by lending institution.</div>
            </div>
  
            <div class="note-entry mb-4">
              <div class="fw-bold">Oct 7, 2025 10:18 AM <span class="text-muted">by System</span></div>
              <div>DMS push completed successfully. Deal ID: <strong>DMS-001</strong> created in system.</div>
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
          <h5 class="modal-title">Add DMS Note</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <!-- Note -->
          <div class="mb-3">
            <label class="form-label fw-bold">Note</label>
            <textarea class="form-control" id="noteInput" rows="4" placeholder="Write your DMS note here..."></textarea>
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
              <option value="1">Alex Johnson</option>
              <option value="2">Sarah Lee</option>
              <option value="3">David Miller</option>
              <option value="4">Robert Wilson</option>
              <option value="5">Kevin Thompson</option>
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
          "1": "Alex Johnson",
          "2": "Sarah Lee",
          "3": "David Miller",
          "4": "Robert Wilson",
          "5": "Kevin Thompson"
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

      // Update customer name in notes modal when clicking on notes cell
      document.querySelectorAll('.notes-preview-cell').forEach(cell => {
        cell.addEventListener('click', function() {
          const row = this.closest('tr');
          const customerName = row.cells[1].textContent;
          document.getElementById('dmsCustomerName').textContent = customerName;
        });
      });
    });
  </script>
  	<script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/custom-calendar.js"></script>
</body>

</html>