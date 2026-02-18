@extends('layouts.app')



@section('title','Primus AI')



@section('content')

<div class="content content-two p-0 ps-3 pe-3" id="showroom-page">

    <!-- Page Header -->
    <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 ">
        <div style="position: relative; width: 100%; height: 80px;">
            <!-- Title aligned left -->
            <h6 style="position: absolute; left: 0; top: 50%; transform: translateY(-50%); margin: 0;">
               Primus AI
            </h6>

            <!-- Image centered -->
            <img class="logo-img" src="assets/light_logo.png" alt="Showroom"
                style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); max-width: 80px;">
        </div>


    </div>
    <!-- End Page Header -->

    <div class="chat-wrapper">
      <!-- Start Chat -->
      <div class="chat chat-messages show" id="middle">
          <div>
              <div class="chat-header">
                  <div class="user-details">
                      <div class="d-xl-none">
                          <a class="text-muted chat-close me-2" href="#">
                              <i class="fas fa-arrow-left"></i>
                          </a>
                      </div>
                      <div class="avatar avatar-lg online flex-shrink-0">
                          <img src="assets/light_logo.png" class="border border-1 rounded-circle" alt="image">
                      </div>
                      <div class="ms-2 overflow-hidden">
                          <h6 class="mb-0">Ask Coach Primus!</h6>
                          <span class="last-seen">Available</span>
                      </div>
                  </div>
                  <div class="chat-options">
                      <ul class="list-unstyled">
                          <li>
                              <a href="javascript:void(0)" class="btn chat-search-btn"
                                  data-bs-toggle="tooltip" data-bs-placement="bottom" title="Search">
                                  <i class="ri-search-line"></i>
                              </a>
                          </li>
                          <li>
                              <a class="btn no-bg" href="#" data-bs-toggle="dropdown">
                                  <i class="ri-more-2-fill"></i>
                              </a>
                              <ul class="dropdown-menu dropdown-menu-end p-3">
                                  <li><a href="#" class="dropdown-item"><i
                                              class="ri-volume-mute-line me-2"></i>Mute Notification</a></li>
                                  <li><a href="#" class="dropdown-item"><i
                                              class="ri-time-line me-2"></i>Disappearing Message</a>
                                  </li>
                                  <li><a href="#" class="dropdown-item"><i
                                              class="ri-delete-bin-line me-2"></i>Clear Message</a></li>
                                  <li><a href="#" class="dropdown-item"><i
                                              class="ri-delete-bin-6-line me-2"></i>Delete Chat</a></li>
                                  <li><a href="#" class="dropdown-item"><i
                                              class="ri-forbid-line me-2"></i>Block</a></li>
                              </ul>
                          </li>
                      </ul>
                  </div>
                  <!-- Chat Search -->
                  <div class="chat-search search-wrap contact-search">
                      <form>
                          <div class="input-group">
                              <input type="text" class="form-control" placeholder="Search Contacts">
                              <span class="input-group-text"><i
                                      class="ri-search-line"></i></span>
                          </div>
                      </form>
                  </div>
                  <!-- /Chat Search -->
              </div>
              <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: 100%; height: 442px;">
                  <div class="chat-body overflow-auto chat-page-group slimscroll">
                      <div class="messages">
                      
                         
                              <div id="help-container" >
                                  <img src="assets/sending_img.png"
                                      class=" dreams_chat " alt="image">
                              </div>
                            
                       
                         
                      </div>
                  </div>
              </div>
         
          </div>
          <div class="chat-footer">
              <form class="footer-form">
                  <div class="ai-suggestion-parent">
                      <div class="suggestion-option" data-type="followup">
                          <p>Recommend follow-up time</p>
                      </div>
                      <div class="suggestion-option" data-type="history">
                          <p>Summarize customer deal history</p>
                      </div>
                      <div class="template-option" data-bs-toggle="modal" data-bs-target="#templateModal" data-type="email">
                          <p>Generate Email Template</p>
                      </div>
                      <div class="template-option" data-bs-toggle="modal" data-bs-target="#templateModal" data-type="sms">
                          <p>Generate Text Template</p>
                      </div>
                  </div>
                  
                  <div class="chat-footer-wrap">
                      <div class="form-item">
                          <a href="#" class="action-circle"><i class="ti ti-bolt"></i></a>
                      </div>
                      <div class="form-wrap">
                          <input type="text" class="form-control" placeholder="Ask your question or use">
                      </div>
                   
                      <div class="form-btn">
                          <button class="btn btn-primary" type="submit">
                              <i class="ti ti-send"></i>
                          </button>
                      </div>
                  </div>
              </form>
          </div>
      </div>
      <!-- End Chat -->
  </div>
<!-- Template Modal -->
<div class="modal fade" id="templateModal" tabindex="-1" aria-labelledby="templateModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
      <h5 class="modal-title" id="templateModalLabel">Generate Template</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  <div class="modal-body">
      <form id="templateForm">
          <input type="hidden" id="selectedType" value="">
          <div class="mb-3">
              <label for="toneSelect" class="form-label">Tone</label>
              <select class="form-select" id="toneSelect">
                  <option value="professional">Professional</option>
                  <option value="friendly">Friendly</option>
                  <option value="formal">Formal</option>
                  <option value="casual">Casual</option>
              </select>
          </div>
          <div class="mb-3">
              <label for="purposeSelect" class="form-label">Purpose</label>
              <select class="form-select" id="purposeSelect">
                  <option value="reminder">Reminder</option>
                  <option value="followup">Follow-up</option>
                  <option value="promotion">Promotion</option>
                  <option value="notification">Notification</option>
              </select>
          </div>
          <div class="mb-3">
              <label for="customDetails" class="form-label">Additional Details (Optional)</label>
              <textarea class="form-control" id="customDetails" rows="2" placeholder="Any specific information to include..."></textarea>
          </div>
      </form>
  </div>
  <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      <button type="button" class="btn btn-primary" id="generateTemplateBtn">Generate</button>
  </div>
</div>
</div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
const templateModal = document.getElementById('templateModal');
const templateForm = document.getElementById('templateForm');
const selectedTypeInput = document.getElementById('selectedType');
const generateTemplateBtn = document.getElementById('generateTemplateBtn');
const messagesContainer = document.querySelector('.messages');

// Store the modal instance
const modal = new bootstrap.Modal(templateModal);

// When a template option is clicked
document.querySelectorAll('.template-option').forEach(option => {
option.addEventListener('click', function() {
    const type = this.getAttribute('data-type');
    selectedTypeInput.value = type;
    
    // Update modal title based on type
    const modalTitle = document.getElementById('templateModalLabel');
    if (type === 'email') {
        modalTitle.textContent = 'Generate Email Template';
    } else if (type === 'sms') {
        modalTitle.textContent = 'Generate Text Template';
    }
});
});

// Handle generate button click
generateTemplateBtn.addEventListener('click', function() {
const type = selectedTypeInput.value;
const tone = document.getElementById('toneSelect').value;
const purpose = document.getElementById('purposeSelect').value;
const customDetails = document.getElementById('customDetails').value;

// Generate the template based on selections
const aiResponse = generateTemplate(type, tone, purpose, customDetails);

// Add the template to the chat
addTemplateToChat(aiResponse, type);

// Close the modal
modal.hide();

// Reset form
templateForm.reset();
});

// Function to generate template based on parameters
function generateTemplate(type, tone, purpose, customDetails = '') {
let template = '';

if (type === 'email') {
    template = `📧 <strong>Email Template (${tone} ${purpose})</strong>\n\n`;
    
    if (purpose === 'reminder') {
        template += `Subject: Service Reminder\n\nDear <span class="template-placeholder">[Customer Name]</span>,\n\nThis is a friendly reminder about your upcoming service appointment on <span class="template-placeholder">[Date]</span>. `;
        
        if (customDetails) {
            template += `${customDetails}\n\n`;
        } else {
            template += `Please confirm your availability at your earliest convenience.\n\n`;
        }
        
        template += `Best regards,\n<span class="template-placeholder">[Your Name]</span>\nPrimus Team`;
    } 
    else if (purpose === 'followup') {
        template += `Subject: Following Up On Our Conversation\n\nHello <span class="template-placeholder">[Customer Name]</span>,\n\nI hope this message finds you well. I wanted to follow up on our recent discussion about <span class="template-placeholder">[Topic]</span>. `;
        
        if (customDetails) {
            template += `${customDetails}\n\n`;
        } else {
            template += `Please let me know if you have any questions or need further information.\n\n`;
        }
        
        template += `Best regards,\n<span class="template-placeholder">[Your Name]</span>\nPrimus Team`;
    }
} 
else if (type === 'sms') {
    template = `📱 <strong>Text Template (${tone} ${purpose})</strong>\n\n`;
    
    if (purpose === 'reminder') {
        template += `Hi <span class="template-placeholder">[Customer Name]</span>, this is a reminder about your appointment on <span class="template-placeholder">[Date]</span> at <span class="template-placeholder">[Time]</span>. `;
        
        if (customDetails) {
            template += `${customDetails} `;
        } else {
            template += `Reply YES to confirm or NO to reschedule.`;
        }
    } 
    else if (purpose === 'followup') {
        template += `Hi <span class="template-placeholder">[Customer Name]</span>, just following up on our recent conversation. `;
        
        if (customDetails) {
            template += `${customDetails}`;
        } else {
            template += `Let me know if you have any questions!`;
        }
    }
}

return template;
}

// Function to add template to chat
function addTemplateToChat(template, type) {
const time = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});

const chatElement = document.createElement('div');
chatElement.classList.add('chats');

                           
chatElement.innerHTML = `
<div class="chat-avatar">
                                <img src="assets/light_logo.png" class="border border-1 rounded-circle" alt="image">
                            </div>
                            <div class="chat-content">
                                <div class="chat-info">
                                    <div class="message-content">
<p>${template}</p>
                                    
                                    </div>
                                   
                                </div>
                                <div class="chat-profile-name">
                                    <h6>Primus AI<i class="ti ti-circle-filled fs-7 mx-2"></i><span class="chat-time">${time}</span></h6>
                                </div>
                            </div>
                       
`;

messagesContainer.appendChild(chatElement);

// Auto-scroll to the bottom
messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

// Handle other suggestion options
document.querySelectorAll('.suggestion-option').forEach(option => {
option.addEventListener('click', function() {
    const type = this.getAttribute('data-type');
    let response = '';
    
    if (type === 'followup') {
        response = "Based on your customer's history, I recommend following up in <strong>3-5 business days</strong>. This timeframe typically yields the best response rate for your industry.";
    } else if (type === 'history') {
        response = "<strong>Customer Deal History Summary:</strong>\n\n• Last contact: 2 days ago\n• Deal stage: Proposal sent\n• Value: $2,500\n• Previous interactions: 3 calls, 2 emails\n• Next step: Follow-up on proposal";
    }
    
    // Add to chat
    const time = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
    
    const chatElement = document.createElement('div');
    chatElement.classList.add('chats');
    
    chatElement.innerHTML = `
        <div class="chat-avatar">
            <img src="assets/light_logo.png" class="rounded-circle" alt="AI">
        </div>
        <div class="chat-content">
            <div class="chat-profile-name">
                <h6>Primus AI <span class="chat-time">${time}</span></h6>
            </div>
            <div class="message-content">
                <pre>${response}</pre>
            </div>
        </div>
    `;
    
    messagesContainer.appendChild(chatElement);
    
    // Auto-scroll to the bottom
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
});
});
});
</script>

</div>
@endsection