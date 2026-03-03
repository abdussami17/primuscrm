 <!-- Do Not Contact Modal -->
 <div class="modal fade" id="doNotContactModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content dnc-modal">
  
        <div class="modal-header border-0 pb-2">
          <h5 class="modal-title fw-semibold">Do Not Contact Preferences</h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>
  
        <div class="modal-body pt-2">
  
          <p class="text-muted small mb-3">
            Select communication channels the customer does not wish to receive.
          </p>
  
          <div class="dnc-option-list">
  
            <div class="dnc-item">
              <input class="form-check-input dnc-option" type="checkbox" id="dncCall" value="call">
              <label for="dncCall">
                <strong>Do Not Call</strong>
                <span>Block all phone calls</span>
              </label>
            </div>
  
            <div class="dnc-item">
              <input class="form-check-input dnc-option" type="checkbox" id="dncText" value="text">
              <label for="dncText">
                <strong>Do Not Text</strong>
                <span>Disable SMS communication</span>
              </label>
            </div>
  
            <div class="dnc-item">
              <input class="form-check-input dnc-option" type="checkbox" id="dncEmail" value="email">
              <label for="dncEmail">
                <strong>Do Not Email</strong>
                <span>Stop all email contact</span>
              </label>
            </div>
  
          </div>
  
        </div>
  
        <div class="modal-footer border-0 pt-0">
          <button class="btn btn-light border border-1" data-bs-dismiss="modal">Cancel</button>
          <button class="btn btn-primary px-4" id="saveDNC" data-bs-dismiss="modal">Save Changes</button>
        </div>
  
      </div>
    </div>
  </div>
  
  
  <style>
    .dnc-modal {
      border-radius: 14px;
      box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }
    
    .dnc-option-list {
      display: flex;
      flex-direction: column;
      gap: 14px;
    }
    
    .dnc-item {
      display: flex;
      align-items: flex-start;
      gap: 12px;
      padding: 12px 14px;
      border:1px solid #ddd;
      border-radius: 10px;
      background: #f8f9fa;
      transition: 0.2s ease;
    }
   

    
    .dnc-item label {
      cursor: pointer;
      line-height: 1.3;
    }
    
    .dnc-item strong {
      display: block;
      font-weight: 600;
    }
    
    .dnc-item span {
      display: block;
      font-size: 12px;
      color: #6c757d;
    }
    </style>
    
<script>
document.addEventListener("DOMContentLoaded", function(){

const dncIcon = document.querySelector(".do-not-contact-icon");
const callIcon = document.querySelector(".call-action-icon");

const modal = new bootstrap.Modal(document.getElementById('doNotContactModal'));
let dncSettings = {
call:false,
text:false,
email:false
};

// Open Modal
dncIcon.addEventListener("click", () => {
modal.show();
});

// Save DNC
document.getElementById("saveDNC").addEventListener("click", () => {

dncSettings.call = document.getElementById("dncCall").checked;
dncSettings.text = document.getElementById("dncText").checked;
dncSettings.email = document.getElementById("dncEmail").checked;

// If Do Not Call selected -> Gray out call icon
if(dncSettings.call){
callIcon.style.color = "#999";
callIcon.style.cursor = "not-allowed";
} else {
callIcon.style.color = "";
callIcon.style.cursor = "pointer";
}

modal.hide();
});

// Call Attempt Logic
callIcon.addEventListener("click", function(){
if(dncSettings.call){
alert("Customer requested Do Not Call");
return;
}

alert("Calling customer...");
});

});
</script>