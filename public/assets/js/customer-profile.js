
const documents = [
  { id: 1, name: "Bill of Sale.pdf" },
  { id: 2, name: "Finance Agreement.pdf" },
  { id: 3, name: "Lease Agreement.pdf" },
  { id: 4, name: "Warranty Form.pdf" },
  { id: 5, name: "Insurance Form.pdf" }
];

let savedDocs = [];
let customerDeals = [];
let currentDealFilter = 'all'; // Track current filter state

// Fetch customer deals from database
function fetchCustomerDeals(customerId) {
  fetch(`/customers/${customerId}/deals`, {
    method: 'GET',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      customerDeals = data.deals || [];
      renderDeals(customerDeals);
    } else {
      console.error('Failed to fetch deals:', data.message);
    }
  })
  .catch(error => {
    console.error('Error fetching deals:', error);
  });
}

// Render deals
function renderDeals(deals) {
  const container = document.getElementById('dealsContainer');
  if (!container) return;
  
  container.innerHTML = '';
  
  if (deals.length === 0) {
    container.innerHTML = '<p class="text-muted text-center py-3">No deals found for this customer.</p>';
    return;
  }
  
  deals.forEach((deal, index) => {
    const dealBox = document.createElement('div');
    dealBox.className = 'deal-box mb-3 p-2 border rounded bg-white shadow-sm';
    dealBox.setAttribute('data-deal-id', deal.id);
    
    // Normalize status for filtering
    let normalizedStatus = (deal.status || 'active').toLowerCase();
    if (normalizedStatus === 'delivered') {
      normalizedStatus = 'sold';
    }
    dealBox.setAttribute('data-status', normalizedStatus);
    
    const createdDate = deal.created_at ? new Date(deal.created_at).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) : 'N/A';
    const vehicleName = deal.vehicle_description || 'Vehicle';
    const statusBadge = getStatusBadge(deal.status);
    
    dealBox.innerHTML = `
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <div class="d-flex justify-content-normal align-items-center">
            <p class="deal-vehicle-name fw-semibold mb-0">${vehicleName}</p>
            <i class="toggle-deal-details-icon ti ti-caret-down-filled" data-deal-id="${deal.id}"></i>
          </div>
          <p class="text-muted deal-date">Created Date: ${createdDate}</p>
        </div>
        <div class="text-end">
          <div class="d-flex justify-content-normal align-items-center gap-1">
            <i class="ti ti-trash text-red" onclick="deleteDeal(${deal.id})"></i>
            ${statusBadge}
          </div>
        </div>
      </div>
      <div class="row deals-detail-area d-none g-2" data-deal-id="${deal.id}">
        ${renderDealFields(deal)}
      </div>
    `;
    
    container.appendChild(dealBox);
  });
  
  // Re-attach toggle event listeners
  attachDealToggleListeners();
  
  // Re-apply current filter after rendering
  applyDealFilter(currentDealFilter);
}

// Apply deal filter
function applyDealFilter(filter) {
  currentDealFilter = filter;
  document.querySelectorAll(".deal-box").forEach(box => {
    if (filter === "all" || box.dataset.status === filter) {
      box.style.display = "block";
    } else {
      box.style.display = "none";
    }
  });
}

// Get status badge HTML
function getStatusBadge(status) {
  const statusLower = (status || 'active').toLowerCase();
  
  if (statusLower === 'sold' || statusLower === 'delivered') {
    return '<span class="text-success fw-bold">Sold / Delivered</span>';
  } else if (statusLower === 'active') {
    return '<span class="text-primary fw-bold d-block">Active</span>';
  } else if (statusLower === 'lost') {
    return '<span class="text-danger fw-bold d-block">Lost</span>';
  } else {
    return `<span class="text-secondary fw-bold d-block">${status || 'Active'}</span>`;
  }
}

// Render deal detail fields
function renderDealFields(deal) {
  return `
    <div class="col-md-4">
      <label class="form-label form-label-sm mb-1">Assigned To</label>
      <input type="text" class="form-control form-control-sm" value="${deal.sales_person?.name || ''}" readonly>
    </div>
    <div class="col-md-4">
      <label class="form-label form-label-sm mb-1">Sales Manager</label>
      <input type="text" class="form-control form-control-sm" value="${deal.sales_manager?.name || ''}" readonly>
    </div>
    <div class="col-md-4">
      <label class="form-label form-label-sm mb-1">Finance Manager</label>
      <input type="text" class="form-control form-control-sm" value="${deal.finance_manager?.name || ''}" readonly>
    </div>
    <div class="col-md-3">
      <label class="form-label form-label-sm mb-1">Lead Type</label>
      <input type="text" class="form-control form-control-sm" value="${deal.lead_type || ''}" readonly>
    </div>
    <div class="col-md-3">
      <label class="form-label form-label-sm mb-1">Status</label>
      <input type="text" class="form-control form-control-sm" value="${deal.status || ''}" readonly>
    </div>
    <div class="col-md-3">
      <label class="form-label form-label-sm mb-1">Inventory Type</label>
      <input type="text" class="form-control form-control-sm" value="${deal.inventory_type || ''}" readonly>
    </div>
    <div class="col-md-3">
      <label class="form-label form-label-sm mb-1">Deal Number</label>
      <input type="text" class="form-control form-control-sm" value="${deal.deal_number || ''}" readonly>
    </div>
    <div class="col-md-4">
      <label class="form-label form-label-sm mb-1">Price</label>
      <input type="text" class="form-control form-control-sm" value="${deal.price ? '$' + parseFloat(deal.price).toLocaleString() : ''}" readonly>
    </div>
    <div class="col-md-4">
      <label class="form-label form-label-sm mb-1">Down Payment</label>
      <input type="text" class="form-control form-control-sm" value="${deal.down_payment ? '$' + parseFloat(deal.down_payment).toLocaleString() : ''}" readonly>
    </div>
    <div class="col-md-4">
      <label class="form-label form-label-sm mb-1">Trade-In Value</label>
      <input type="text" class="form-control form-control-sm" value="${deal.trade_in_value ? '$' + parseFloat(deal.trade_in_value).toLocaleString() : ''}" readonly>
    </div>
  `;
}

// Attach toggle listeners to deal icons
function attachDealToggleListeners() {
  document.querySelectorAll('.toggle-deal-details-icon').forEach(icon => {
    icon.addEventListener('click', function(e) {
      e.stopPropagation();
      const dealId = this.getAttribute('data-deal-id');
      const detailsArea = document.querySelector(`.deals-detail-area[data-deal-id="${dealId}"]`);
      
      if (!detailsArea) return;
      
      // Close all other deals
      document.querySelectorAll('.deals-detail-area').forEach(area => {
        if (area !== detailsArea) {
          area.classList.add('d-none');
        }
      });
      
      // Toggle current deal
      const isCurrentlyOpen = !detailsArea.classList.contains('d-none');
      detailsArea.classList.toggle('d-none');
      
      // Update icons
      document.querySelectorAll('.toggle-deal-details-icon').forEach(i => {
        i.classList.remove('ti-caret-up-filled', 'text-primary');
        i.classList.add('ti-caret-down-filled');
      });
      
      if (!detailsArea.classList.contains('d-none')) {
        this.classList.remove('ti-caret-down-filled');
        this.classList.add('ti-caret-up-filled', 'text-primary');
      }
      
      // Show/hide related sections
      const vehiclesInterest = document.getElementById('vehiclesInterest');
      const notesHistory = document.getElementById('notesHistory');
      const taskSection = document.getElementById('taskandappointmentSection');
      const activitySection = document.getElementById('activityTimelineSection');
      
      const shouldShow = !detailsArea.classList.contains('d-none');
      
      if (vehiclesInterest) vehiclesInterest.style.display = shouldShow ? 'block' : 'none';
      if (notesHistory) notesHistory.style.display = shouldShow ? 'block' : 'none';
      if (taskSection) taskSection.style.display = shouldShow ? 'block' : 'none';
      if (activitySection) activitySection.style.display = shouldShow ? 'block' : 'none';
      
      // Update button states if function exists
      if (typeof updateButtonStates === 'function') {
        updateButtonStates();
      }
    });
  });
}

// Delete deal function
function deleteDeal(dealId) {
  Swal.fire({
    title: 'Delete Deal?',
    text: 'Are you sure you want to delete this deal? This action cannot be undone.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'Cancel'
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(`/deals/${dealId}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          Swal.fire({
            icon: 'success',
            title: 'Deleted!',
            text: 'Deal has been deleted successfully.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
          });
          // Refresh deals
          const customerId = document.getElementById('editVisitCanvas').getAttribute('data-customer-id');
          if (customerId) {
            fetchCustomerDeals(customerId);
          }
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to delete deal: ' + (data.message || 'Unknown error'),
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true
          });
        }
      })
      .catch(error => {
        console.error('Error deleting deal:', error);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Failed to delete deal. Please try again.',
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 4000,
          timerProgressBar: true
        });
      });
    }
  });
}

function renderDocs() {
  const list = document.getElementById("docList");
  if (!list) return;
  list.innerHTML = "";

  documents.forEach(doc => {
    const isSaved = savedDocs.includes(doc.id);

    const item = document.createElement("div");
    item.className = "list-group-item d-flex justify-content-between align-items-center";

    item.innerHTML = `
    <span><i class="ti ti-file-text me-2"></i>${doc.name}</span>
    <div>
      ${isSaved
        ? '<span class="badge bg-success me-2">✔ Saved</span>'
        : `<button class="btn btn-sm btn-primary me-2 open-doc-btn">Open PDF</button>`}
    </div>
  `;

    if (!isSaved) {
      item.querySelector(".open-doc-btn").addEventListener("click", () => openPdfModal(doc));
    }

    list.appendChild(item);
  });
}

function openPdfModal(doc) {
  const pdfModal = new bootstrap.Modal(document.getElementById("pdfModal"));
  document.getElementById("pdfTitle").textContent = doc.name;
  document.getElementById("pdfImage").src = "https://worksheets.clipart-library.com/images2/free-printable-bill-of-sale-templates/free-printable-bill-of-sale-templates-6.png";

  // Save button logic
  const saveBtn = document.getElementById("savePdfBtn");
  saveBtn.onclick = () => {
    if (!savedDocs.includes(doc.id)) savedDocs.push(doc.id);
    alert(`"${doc.name}" has been saved to Notes & History.`);
    renderDocs();
    pdfModal.hide();
  };

  pdfModal.show();
}

document.addEventListener("DOMContentLoaded", renderDocs);







// ---------- Helpers ----------
function pad2(n) { return String(n).padStart(2, '0'); }

function formatDuration(seconds) {
  seconds = Math.max(0, Math.floor(Number(seconds) || 0));
  const h = Math.floor(seconds / 3600);
  const m = Math.floor((seconds % 3600) / 60);
  const s = seconds % 60;
  if (h > 0) {
    return `${h} hour${h !== 1 ? 's' : ''} ${m} minute${m !== 1 ? 's' : ''}${s ? (' ' + s + ' second' + (s !== 1 ? 's' : '')) : ''}`;
  }
  if (m > 0 && s > 0) return `${m} minute${m !== 1 ? 's' : ''} ${s} second${s !== 1 ? 's' : ''}`;
  if (m > 0) return `${m} minute${m !== 1 ? 's' : ''}`;
  return `${s} second${s !== 1 ? 's' : ''}`;
}

function parseHMS(str) {
  if (!str) return 0;
  const parts = str.trim().split(':').map(x => Number(x || 0));
  if (parts.length === 3) return parts[0] * 3600 + parts[1] * 60 + parts[2];
  if (parts.length === 2) return parts[0] * 60 + parts[1];
  return parts[0] || 0;
}

function secondsToHMS(seconds) {
  seconds = Math.max(0, Math.floor(Number(seconds) || 0));
  const h = Math.floor(seconds / 3600);
  const m = Math.floor((seconds % 3600) / 60);
  const s = seconds % 60;
  return `${pad2(h)}:${pad2(m)}:${pad2(s)}`;
}

function dateToDatetimeLocalString(date) {
  if (!date) return '';
  return `${date.getFullYear()}-${pad2(date.getMonth() + 1)}-${pad2(date.getDate())}T${pad2(date.getHours())}:${pad2(date.getMinutes())}`;
}

function datetimeLocalStringToDate(str) {
  if (!str) return null;
  const [d, t] = str.split('T');
  if (!d || !t) return null;
  const [y, mo, da] = d.split('-').map(Number);
  const [hh, mm] = t.split(':').map(Number);
  return new Date(y, mo - 1, da, hh || 0, mm || 0);
}

// ---------- State ----------
let visitStartTime = null;
let visitEndTime = null;
let durationInterval = null;

// ---------- Elements ----------
const startBtn = document.getElementById('startVisitBtn');
const stopBtn = document.getElementById('stopVisitBtn');
const visitStartDisplay = document.getElementById('visitStartTime');
const visitEndDisplay = document.getElementById('visitEndTimeDisplay');
const visitDurationDisplay = document.getElementById('visitDurationDisplay');
const visitNotesDisplay = document.getElementById('visitNotes');
const visitStatusIndicator = document.getElementById('visitStatusIndicator');
const visitByName = document.getElementById('visitByName');

const editModalEl = document.getElementById('editVisitsModal');
const notesInput = document.getElementById('visitNotesnput');
const durationTimeInput = document.getElementById('visitDurationInput');
const visitTimeInput = document.getElementById('visitTime');
const visitEndTimeInput = document.getElementById('visitEndTime');
const saveBtn = document.getElementById('saveVisitChanges');

// Notes Section (for automatic visit notes)
const recentHistory = document.getElementById('recentHistory');

// ---------- UI init ----------
stopBtn.disabled = true;
visitStartDisplay.textContent = '--';
visitEndDisplay.textContent = '--';
visitDurationDisplay.textContent = '0 seconds';
visitStatusIndicator.textContent = 'Visit not started';
if (startBtn && stopBtn) {

    stopBtn.disabled = true;
  
// ---------- Start visit ----------
startBtn.addEventListener('click', () => {
    visitStartTime = new Date();
    visitEndTime = null;
  
    visitStartDisplay.textContent = visitStartTime.toLocaleString();
    visitEndDisplay.textContent = '--';
    visitDurationDisplay.textContent = '0 seconds';
    visitStatusIndicator.textContent = 'Visit in progress...';
    visitStatusIndicator.classList.remove('text-success');
    visitStatusIndicator.classList.add('text-danger');
  
    startBtn.disabled = true;
    stopBtn.disabled = false;
  
    if (durationInterval) clearInterval(durationInterval);
    durationInterval = setInterval(() => {
      const now = new Date();
      const elapsed = Math.floor((now - visitStartTime) / 1000);
      visitDurationDisplay.textContent = formatDuration(elapsed);
    }, 1000);
  
    document.getElementById('alert-box-container').innerHTML = `
      <div class="alert alert-success alert-dismissible" role="alert">
        <strong>Visit Started!</strong> ${visitStartTime.toLocaleString()}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>`;
  });
  
  // ---------- Stop visit ----------
  stopBtn.addEventListener('click', () => {
    if (!visitStartTime) return;
    if (durationInterval) clearInterval(durationInterval);
  
    visitEndTime = new Date();
    const totalSeconds = Math.floor((visitEndTime - visitStartTime) / 1000);
  
    visitEndDisplay.textContent = visitEndTime.toLocaleString();
    visitDurationDisplay.textContent = formatDuration(totalSeconds);
    visitStatusIndicator.textContent = 'Visit Completed!';
    visitStatusIndicator.classList.remove('text-danger');
    visitStatusIndicator.classList.add('text-success');
  
    startBtn.disabled = false;
    stopBtn.disabled = true;
  
    visitEndTimeInput.value = dateToDatetimeLocalString(visitEndTime);
  
    document.getElementById('alert-box-container').innerHTML = `
      <div class="alert alert-success alert-dismissible" role="alert">
        <strong>Visit Ended!</strong> Duration: ${formatDuration(totalSeconds)}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>`;
  
    // ---- Auto add Visit Info to Notes ----
    if (recentHistory) {
      const noteText = `
        Visit ended at ${visitEndTime.toLocaleString()}.
        Duration: ${formatDuration(totalSeconds)}.
      `;
      const newNote = document.createElement('div');
      newNote.className = 'history-item border-bottom pb-3';
      newNote.innerHTML = `
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <span class="fw-bold">You</span>
            <span class="text-muted ms-2">Just now</span>
          </div>
          <span class="badge bg-light text-dark">Visit</span>
        </div>
        <p class="mb-1 mt-1">${noteText}</p>
      `;
      recentHistory.insertBefore(newNote, recentHistory.firstChild);
    }
  });
  
  
  }

// ---------- Edit Modal Show ----------
if(editModalEl){
    editModalEl.addEventListener('show.bs.modal', function () {
        notesInput.value = visitNotesDisplay.textContent === '--' ? '' : visitNotesDisplay.textContent;
      
        let secondsForDuration = 0;
        if (visitStartTime && !visitEndTime) {
          secondsForDuration = Math.floor((new Date() - visitStartTime) / 1000);
        } else if (visitStartTime && visitEndTime) {
          secondsForDuration = Math.floor((visitEndTime - visitStartTime) / 1000);
        } else {
          const disp = visitDurationDisplay.textContent || '';
          if (disp.includes(':')) secondsForDuration = parseHMS(disp);
          else secondsForDuration = parseHMS(secondsToHMS(parseDurationStringToSecondsFromText(disp) || 0));
        }
      
        durationTimeInput.value = secondsToHMS(secondsForDuration);
        visitTimeInput.value = visitStartTime ? dateToDatetimeLocalString(visitStartTime) : '';
        visitEndTimeInput.value = visitEndTime ? dateToDatetimeLocalString(visitEndTime) : '';
      });
}

function parseDurationStringToSecondsFromText(text) {
  if (!text) return 0;
  text = text.toLowerCase();
  let total = 0;
  const h = text.match(/(\d+)\s*hour/);
  const m = text.match(/(\d+)\s*minute/);
  const s = text.match(/(\d+)\s*second/);
  if (h) total += parseInt(h[1], 10) * 3600;
  if (m) total += parseInt(m[1], 10) * 60;
  if (s) total += parseInt(s[1], 10);
  return total;
}

// ---------- Save changes ----------
if(saveBtn){
    saveBtn.addEventListener('click', () => {
        const newNotes = notesInput.value.trim();
        visitNotesDisplay.textContent = newNotes || '--';
      
        const durStr = durationTimeInput.value.trim();
        const durSeconds = parseHMS(durStr);
      
        const startDT = datetimeLocalStringToDate(visitTimeInput.value);
        if (startDT) visitStartTime = startDT;
      
        if (visitEndTimeInput.value) {
          const et = datetimeLocalStringToDate(visitEndTimeInput.value);
          if (et) visitEndTime = et;
        } else if (visitStartTime && durSeconds > 0) {
          visitEndTime = new Date(visitStartTime.getTime() + durSeconds * 1000);
        }
      
        visitStartDisplay.textContent = visitStartTime ? visitStartTime.toLocaleString() : '--';
        visitEndDisplay.textContent = visitEndTime ? visitEndTime.toLocaleString() : '--';
        visitDurationDisplay.textContent = formatDuration(durSeconds);
      
        if (visitEndTime) {
          visitStatusIndicator.textContent = 'Visit Completed!';
          visitStatusIndicator.classList.remove('text-danger');
          visitStatusIndicator.classList.add('text-success');
          startBtn.disabled = false;
          stopBtn.disabled = true;
          if (durationInterval) { clearInterval(durationInterval); durationInterval = null; }
        } else if (visitStartTime) {
          visitStatusIndicator.textContent = 'Visit in progress...';
          visitStatusIndicator.classList.remove('text-success');
          visitStatusIndicator.classList.add('text-danger');
          startBtn.disabled = true;
          stopBtn.disabled = false;
          if (durationInterval) clearInterval(durationInterval);
          durationInterval = setInterval(() => {
            const now = new Date();
            const elapsed = Math.floor((now - visitStartTime) / 1000);
            visitDurationDisplay.textContent = formatDuration(elapsed);
          }, 1000);
        } else {
          visitStatusIndicator.textContent = 'Visit not started';
          visitStatusIndicator.classList.remove('text-success', 'text-danger');
          startBtn.disabled = false;
          stopBtn.disabled = true;
        }
      
        const bsModal = bootstrap.Modal.getInstance(editModalEl);
        if (bsModal) bsModal.hide();
      
        document.getElementById('alert-box-container').innerHTML = `
          <div class="alert alert-success alert-dismissible" role="alert">
            <strong>Visit updated successfully!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>`;
      
        // ---- Auto add edit visit info to Notes ----
        var noteTexts = document.getElementById('visitNotesnput').value;
        if (recentHistory) {
          // const noteText = `
          //   Visit updated. ${noteTexts} Start: ${visitStartTime ? visitStartTime.toLocaleString() : '--'},
          //   End: ${visitEndTime ? visitEndTime.toLocaleString() : '--'},
          //   Duration: ${formatDuration(durSeconds)}.
          // `;
          const noteText = `${noteTexts}`;
          const newNote = document.createElement('div');
          newNote.className = 'history-item border-bottom pb-3';
          newNote.innerHTML = `
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <span class="fw-bold">You</span>
                <span class="text-muted ms-2">Just now</span>
              </div>
              <span class="badge bg-light text-dark">Visit Edit</span>
            </div>
            <p class="mb-1 mt-1">${noteText}</p>
          `;
          recentHistory.insertBefore(newNote, recentHistory.firstChild);
        }
      });
}

// ---------- Optional: endVisitBtn ----------
const endVisitBtn = document.getElementById('endVisitBtn');
if (endVisitBtn) {
  endVisitBtn.addEventListener('click', () => stopBtn.click());
}




if (typeof TomSelect !== 'undefined') {
    const tagUsers = document.getElementById('tagUsers');
    if (tagUsers) {
      new TomSelect(tagUsers, {
        plugins: ['remove_button'],
        create: false,
        onChange(values) {
          renderUserInitials(values);
        }
      });
    }
  }
  

function renderUserInitials(userIds) {
  let users = {
    "1": "John Smith",
    "2": "Sarah Johnson",
    "3": "David Brown",
    "4": "Emily Davis"
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
let mediaRecorders;
let recordedChunks = [];
const recordAudioBtn = document.getElementById("recordAudioBtn");
if(recordAudioBtn){
    recordAudioBtn.addEventListener("click", function () {
        navigator.mediaDevices.getUserMedia({ audio: true }).then(stream => {
          startRecording(stream, "audio");
        }).catch(err => alert("Microphone access denied!"));
      });
}

const recordVideoBtn = document.getElementById("recordVideoBtn");
if(recordVideoBtn){
    recordAudioBtn.addEventListener("click", function () {
        navigator.mediaDevices.getUserMedia({ audio: true, video: true }).then(stream => {
          startRecording(stream, "video");
        }).catch(err => alert("Camera access denied!"));
      });
}


function startRecording(stream, type) {
  recordedChunks = [];
  mediaRecorders = new MediaRecorder(stream);
  mediaRecorders.ondataavailable = e => {
    if (e.data.size > 0) recordedChunks.push(e.data);
  };
  mediaRecorders.onstop = () => {
    let blob = new Blob(recordedChunks, { type: type === "audio" ? "audio/webm" : "video/webm" });
    let url = URL.createObjectURL(blob);
    let preview = type === "audio"
      ? `<audio controls src="${url}" class="w-100 mt-2"></audio>`
      : `<video controls src="${url}" class="w-100 mt-2"></video>`;
    document.getElementById("mediaPreview").innerHTML = preview;
  };

  mediaRecorders.start();
  alert("Recording started. Click OK when you want to stop.");
  mediaRecorders.stop();
}
const saveNoteBtn = document.getElementById("saveNoteBtn");
// Save Note Button
if(saveNoteBtn){
    saveNoteBtn.addEventListener("click", function () {

        let modalEl = document.getElementById("editnoteModal");
        let modal = bootstrap.Modal.getInstance(modalEl);
        modal.hide();
      });
}

// Add New Deal Form Submission
document.addEventListener('DOMContentLoaded', function() {
  const addDealForm = document.getElementById('addDealForm');
  const addDealModal = document.getElementById('addDealModal');
  
  if (addDealModal) {
    // When modal opens, set the customer ID and generate deal number
    addDealModal.addEventListener('show.bs.modal', function() {
      const customerId = document.getElementById('editVisitCanvas')?.getAttribute('data-customer-id');
      const customerIdField = document.getElementById('dealCustomerId');
      
      if (customerIdField && customerId) {
        customerIdField.value = customerId;
      }
      
      // Auto-generate deal number if empty
      const dealNumberField = document.getElementById('dealNumber');
      if (dealNumberField && !dealNumberField.value) {
        const date = new Date();
        const dateStr = date.getFullYear() + 
                       String(date.getMonth() + 1).padStart(2, '0') + 
                       String(date.getDate()).padStart(2, '0');
        const randomNum = String(Math.floor(Math.random() * 1000)).padStart(3, '0');
        dealNumberField.value = `DEAL-${dateStr}-${randomNum}`;
      }
    });
    
    // Reset form when modal closes
    addDealModal.addEventListener('hidden.bs.modal', function() {
      if (addDealForm) {
        addDealForm.reset();
        
        // Reset vehicle display
        const vehicleDisplay = document.getElementById('selectedVehicleDisplay');
        if (vehicleDisplay) {
          vehicleDisplay.textContent = 'No vehicle selected';
          vehicleDisplay.classList.remove('text-success', 'fw-semibold');
          vehicleDisplay.classList.add('text-muted');
        }
        
        // Clear hidden fields
        document.getElementById('dealInventoryId').value = '';
        document.getElementById('dealCustomerId').value = '';
      }
    });
  }
  
  if (addDealForm) {
    let isSubmittingDeal = false; // Flag to prevent double submission
    
    // Remove any existing listeners to prevent duplicates
    const newForm = addDealForm.cloneNode(true);
    addDealForm.parentNode.replaceChild(newForm, addDealForm);
    
    newForm.addEventListener('submit', function(e) {
      e.preventDefault();
      e.stopPropagation();
      e.stopImmediatePropagation();
      
      console.log('Form submit triggered. isSubmitting:', isSubmittingDeal);
      
      // Prevent double submission
      if (isSubmittingDeal) {
        console.log('Already submitting, ignoring duplicate submission');
        return false;
      }
      
      const formData = new FormData(newForm);
      const data = Object.fromEntries(formData.entries());
      
      // Validate required fields
      if (!data.customer_id) {
        Swal.fire({
          icon: 'error',
          title: 'Missing Information',
          text: 'Customer ID is missing. Please try again.',
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });
        return false;
      }
      
      if (!data.deal_number) {
        Swal.fire({
          icon: 'error',
          title: 'Required Field',
          text: 'Deal number is required.',
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });
        return false;
      }
      
      if (!data.status) {
        Swal.fire({
          icon: 'error',
          title: 'Required Field',
          text: 'Please select a deal status.',
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });
        return false;
      }
      
      // Set submitting flag and disable submit button
      isSubmittingDeal = true;
      const submitBtn = document.getElementById('saveDealBtn');
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Saving...';
      }
      
      console.log('Submitting deal:', data);
      
      // Submit to server
      fetch('/deals', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(data)
      })
      .then(response => response.json())
      .then(result => {
        console.log('Deal submission result:', result);
        
        if (result.success) {
          Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Deal created successfully!',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
          });
          
          // Refresh deals list first
          if (data.customer_id) {
            fetchCustomerDeals(data.customer_id);
          }
          
          // Reset form
          newForm.reset();
          
          // Close modal - try multiple methods
          const modalElement = document.getElementById('addDealModal');
          
          // Method 1: Use getInstance
          let modal = bootstrap.Modal.getInstance(modalElement);
          if (modal) {
            console.log('Closing modal via getInstance');
            modal.hide();
          } else {
            // Method 2: Create new instance and hide
            console.log('Creating new modal instance to close');
            modal = new bootstrap.Modal(modalElement);
            modal.hide();
          }
          
          // Method 3: Force hide after a delay
          setTimeout(() => {
            if (modalElement) {
              modalElement.classList.remove('show');
              modalElement.style.display = 'none';
              modalElement.setAttribute('aria-hidden', 'true');
              modalElement.removeAttribute('aria-modal');
              
              // Remove backdrop
              const backdrops = document.querySelectorAll('.modal-backdrop');
              backdrops.forEach(backdrop => backdrop.remove());
              
              // Reset body
              document.body.classList.remove('modal-open');
              document.body.style.overflow = '';
              document.body.style.paddingRight = '';
            }
            
            console.log('Modal force closed');
          }, 100);
          
        } else {
          // Only re-enable button on error
          isSubmittingDeal = false;
          if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="ti ti-device-floppy me-1"></i>Save Deal';
          }
          
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to create deal: ' + (result.message || 'Unknown error'),
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true
          });
        }
      })
      .catch(error => {
        console.error('Error creating deal:', error);
        
        // Only re-enable button on error
        isSubmittingDeal = false;
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = '<i class="ti ti-device-floppy me-1"></i>Save Deal';
        }
        
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Failed to create deal. Please try again.',
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 4000,
          timerProgressBar: true
        });
      });
      
      return false;
    });
  }
});
