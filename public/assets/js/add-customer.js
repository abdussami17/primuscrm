
// JavaScript to handle conditional requirements
document.addEventListener('DOMContentLoaded', function () {
  const businessNameField = document.getElementById('businessName');
  const firstNameField = document.getElementById('firstName');
  const lastNameField = document.getElementById('lastName');

  // Check if backend setting requires cell phone to be mandatory
  const cellPhoneRequired = true; // This should come from backend setting
  const cellPhoneField = document.getElementById('cellPhone');

  if (cellPhoneRequired) {
    cellPhoneField.setAttribute('required', 'required');
  }

  // Toggle name field requirements based on business name
  businessNameField.addEventListener('input', function () {
    if (this.value.trim() !== '') {
      firstNameField.removeAttribute('required');
      lastNameField.removeAttribute('required');
    } else {
      firstNameField.setAttribute('required', 'required');
      lastNameField.setAttribute('required', 'required');
    }
  });

  // Auto-fill sales manager based on assigned salesperson's profile
  const assignedToField = document.getElementById('assignedTo');
  const salesManagerField = document.getElementById('salesManager');

  // This would typically come from your backend/data
  const salespersonManagers = {
    'John Smith': 'Manager A',
    'Lisa Parker': 'Manager B',
    'Michael Brown': 'Manager C'
  };

  assignedToField.addEventListener('change', function () {
    const selectedSalesperson = this.value;
    if (salespersonManagers[selectedSalesperson]) {
      salesManagerField.value = salespersonManagers[selectedSalesperson];
    }
  });
});

// Scanning SCript
document.addEventListener("DOMContentLoaded", function () {
  let frontStream = null, backStream = null;
  const canvas = document.getElementById("captureCanvas");
  const scanBtn = document.getElementById("scanFillBtn");

  // start camera
  async function startCamera(videoElem, facingMode = "environment") {
    try {
      const stream = await navigator.mediaDevices.getUserMedia({
        video: { facingMode: facingMode }, audio: false
      });
      videoElem.srcObject = stream;
      return stream;
    } catch (err) {
      alert("Camera access denied or unavailable.");
      console.error(err);
      return null;
    }
  }



  // FRONT
  const openFrontCamBtn = document.getElementById("openFrontCamBtn");
  const frontVideoWrap = document.getElementById("frontVideoWrap");
  const cameraStreamFront = document.getElementById("cameraStreamFront");
  const captureFrontBtn = document.getElementById("captureFrontBtn");
  const cancelFrontBtn = document.getElementById("cancelFrontBtn");
  const frontImg = document.getElementById("frontImg");
  const retakeFrontBtn = document.getElementById("retakeFrontBtn");

  openFrontCamBtn.addEventListener("click", async () => {
    frontVideoWrap.style.display = "block";
    document.getElementById("frontPlaceholder").style.display = "none";
    captureFrontBtn.style.display = "inline-block";
    cancelFrontBtn.style.display = "inline-block";
    frontStream = await startCamera(cameraStreamFront, "user");
  });

  cancelFrontBtn.addEventListener("click", () => {
    stopStream(frontStream);
    resetFront();
  });

  captureFrontBtn.addEventListener("click", () => {
    captureImage(cameraStreamFront, frontImg);
    stopStream(frontStream);
    frontVideoWrap.style.display = "none";
    frontImg.style.display = "block";
    retakeFrontBtn.style.display = "inline-block";
    checkBothCaptured();
  });

  retakeFrontBtn.addEventListener("click", () => { resetFront(); });

  function resetFront() {
    frontVideoWrap.style.display = "none";
    frontImg.style.display = "none";
    document.getElementById("frontPlaceholder").style.display = "block";
    retakeFrontBtn.style.display = "none";
    captureFrontBtn.style.display = "none";   // hide again
    cancelFrontBtn.style.display = "none";    // hide again
  }

  // BACK
  const openBackCamBtn = document.getElementById("openBackCamBtn");
  const backVideoWrap = document.getElementById("backVideoWrap");
  const cameraStreamBack = document.getElementById("cameraStreamBack");
  const captureBackBtn = document.getElementById("captureBackBtn");
  const cancelBackBtn = document.getElementById("cancelBackBtn");
  const backImg = document.getElementById("backImg");
  const retakeBackBtn = document.getElementById("retakeBackBtn");

  openBackCamBtn.addEventListener("click", async () => {
    backVideoWrap.style.display = "block";
    document.getElementById("backPlaceholder").style.display = "none";
    captureBackBtn.style.display = "inline-block";
    cancelBackBtn.style.display = "inline-block";
    backStream = await startCamera(cameraStreamBack, "environment");
  });

  cancelBackBtn.addEventListener("click", () => {
    stopStream(backStream);
    resetBack();
  });

  captureBackBtn.addEventListener("click", () => {
    captureImage(cameraStreamBack, backImg);
    stopStream(backStream);
    backVideoWrap.style.display = "none";
    backImg.style.display = "block";
    retakeBackBtn.style.display = "inline-block";
    checkBothCaptured();
  });

  retakeBackBtn.addEventListener("click", () => { resetBack(); });

  function resetBack() {
    backVideoWrap.style.display = "none";
    backImg.style.display = "none";
    document.getElementById("backPlaceholder").style.display = "block";
    retakeBackBtn.style.display = "none";
    captureBackBtn.style.display = "none";    // hide again
    cancelBackBtn.style.display = "none";     // hide again
  }
  // helpers
  function captureImage(videoElem, imgElem) {
    canvas.width = videoElem.videoWidth;
    canvas.height = videoElem.videoHeight;
    canvas.getContext("2d").drawImage(videoElem, 0, 0);
    imgElem.src = canvas.toDataURL("image/png");
  }

  function stopStream(stream) {
    if (stream) stream.getTracks().forEach(track => track.stop());
  }

  function checkBothCaptured() {
    if (frontImg.src && backImg.src) {
      scanBtn.disabled = false;
    }
  }

  // SCAN & FILL
  scanBtn.addEventListener("click", () => {
    scanBtn.disabled = true;
    scanBtn.innerHTML = "Scanning... <i class='fa fa-spinner fa-spin'></i>";

    [frontImg, backImg].forEach(img => {
      if (img.src) {
        const overlay = document.createElement("div");
        overlay.classList.add("scanning-overlay");
        const line = document.createElement("div");
        line.classList.add("scan-line");
        overlay.appendChild(line);
        img.parentElement.appendChild(overlay);
      }
    });

    setTimeout(() => {
      // remove overlay
      document.querySelectorAll(".scanning-overlay").forEach(el => el.remove());
      scanBtn.innerHTML = "Scan & Fill";

      // autofill dummy values
      document.querySelector("input[name='firstName']").value = "John";
      document.querySelector("input[name='lastName']").value = "Doe";
      document.querySelector("input[name='state']").value = "Ontario";
      document.querySelector("input[name='city']").value = "Toronto";
      document.querySelector("input[name='zipCode']").value = "M1B2K3";
      document.querySelector("#streetAddressMain").value = "123 Main Street";

      // close modal
      const modal = bootstrap.Modal.getInstance(document.getElementById("licenseScannerModal"));
      modal.hide();
    }, 3000); // 3s scan duration
  });
});




// Customer Email Scipt 
document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
    if (deleteTarget) {
      deleteTarget.parentElement.remove();
      deleteTarget = null;
    }
    bootstrap.Modal.getInstance(document.getElementById('customConfirmModal')).hide();
  });






  
  let deleteTarget = null;

  function addEmailField() {
    const container = document.getElementById('email-container');
    const field = document.createElement('div');
    field.className = "input-group mb-2";
    field.innerHTML = `
          <input type="email" class="form-control" name="emails[]" placeholder="Email">
          <div class="input-group-text">
              <input type="radio" name="defaultEmail" title="Set as default">
          </div>
          <button class="btn btn-outline-danger" type="button" onclick="showCustomConfirm(this)">
              <i class="fa fa-trash"></i>
          </button>
      `;
    container.appendChild(field);
  }

  function showCustomConfirm(button) {
    deleteTarget = button;
    const modal = new bootstrap.Modal(document.getElementById('customConfirmModal'));
    modal.show();
  }

  document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
    if (deleteTarget) {
      deleteTarget.parentElement.remove();
      deleteTarget = null;
    }
    bootstrap.Modal.getInstance(document.getElementById('customConfirmModal')).hide();
  });

  function toggleCoBuyer() {
    const section = document.getElementById('coBuyerFields');
    section.classList.toggle('d-none');
  }
