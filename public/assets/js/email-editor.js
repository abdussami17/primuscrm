/**
 * Email Editor JavaScript
 * Handles all email/brochure wizard functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    if (!document.getElementById('editor')) return;
    new EmailEditor();
});

class EmailEditor {
    constructor() {
        this.editor = document.getElementById('editor');
        this.preview = document.getElementById('preview');
        this.savedSelection = null;
        this.selectedImage = null;
        // Allow runtime override from server or other scripts
        this.sampleData = window.templateData || window.TEMPLATE_DATA || {
            first_name: 'Michael', last_name: 'Smith', email: 'michael.smith@email.com',
            cell_phone: '(555) 123-4567', city: 'Saskatoon', province: 'Saskatchewan',
            dealer_name: 'Primus Motors', dealer_phone: '222-333-4444',
            year: '2025', make: 'Ferrari', model: 'F80', advisor_name: 'Ben Dover'
        };
        
        this.init();
    }
    
    init() {
        this.setupToolbar();
        this.setupColorPickers();
        this.setupTableGrid();
        this.setupMergeFields();
        this.setupImageControls();
        this.setupVoiceRecognition();
        this.setupEditor();
        this.setupAIAssistant();
        this.setupPreviewToggle();
        this.setupHtmlMode();
        this.setupEmailSuggestions();
        this.renderPreview();
    }
    
    // Toolbar Setup
    setupToolbar() {
        document.querySelectorAll('.toolbar-btn[data-cmd]').forEach(btn => {
            btn.addEventListener('click', () => {
                const cmd = btn.dataset.cmd;
                if (['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'].includes(cmd)) {
                    document.querySelectorAll('[data-cmd^="justify"]').forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                }
                document.execCommand(cmd, false, null);
                this.renderPreview();
            });
        });
        
        document.getElementById('fontFamily')?.addEventListener('change', e => {
            document.execCommand('fontName', false, e.target.value);
            this.renderPreview();
        });
        
        document.getElementById('fontSize')?.addEventListener('change', e => {
            document.execCommand('fontSize', false, '7');
            document.querySelectorAll('font[size="7"]').forEach(el => {
                el.removeAttribute('size');
                el.style.fontSize = e.target.value;
            });
            this.renderPreview();
        });
        
        document.getElementById('btnImage')?.addEventListener('click', () => this.insertImage());
        document.getElementById('btnLink')?.addEventListener('click', () => this.insertLink());
        document.getElementById('btnClearFormat')?.addEventListener('click', () => {
            document.execCommand('removeFormat', false, null);
            this.renderPreview();
        });
    }
    
    insertImage() {
        const input = document.createElement('input');
        input.type = 'file';
        input.accept = 'image/*';
        input.onchange = e => {
            const file = e.target.files[0];
            if (!file?.type.startsWith('image/')) return;
            
            const reader = new FileReader();
            reader.onload = event => {
                const img = `<img src="${event.target.result}" style="max-width:600px;display:block;margin:10px auto;border-radius:8px;">`;
                document.execCommand('insertHTML', false, img);
                this.renderPreview();
            };
            reader.readAsDataURL(file);
        };
        input.click();
    }
    
    insertLink() {
        let url = prompt('Enter URL:');
        if (url) {
            if (!/^https?:\/\//i.test(url)) url = 'https://' + url;
            document.execCommand('createLink', false, url);
            this.renderPreview();
        }
    }
    
    // Color Pickers
    setupColorPickers() {
        const colors = ['#000000','#444444','#666666','#FF0000','#FF9900','#FFFF00','#00FF00','#0000FF','#9900FF'];
        
        ['textColorDropdown', 'highlightColorDropdown'].forEach(id => {
            const dropdown = document.getElementById(id);
            if (!dropdown) return;
            
            const grid = document.createElement('div');
            grid.className = 'color-grid';
            colors.forEach(color => {
                const swatch = document.createElement('div');
                swatch.className = 'color-swatch';
                swatch.style.background = color;
                swatch.addEventListener('click', () => {
                    const cmd = id.includes('text') ? 'foreColor' : 'hiliteColor';
                    this.restoreSelection();
                    document.execCommand(cmd, false, color);
                    dropdown.classList.remove('show');
                    this.renderPreview();
                });
                grid.appendChild(swatch);
            });
            dropdown.appendChild(grid);
        });
        
        document.getElementById('textColorBtn')?.addEventListener('click', e => {
            e.stopPropagation();
            this.saveSelection();
            document.getElementById('textColorDropdown')?.classList.toggle('show');
        });
        
        document.getElementById('highlightColorBtn')?.addEventListener('click', e => {
            e.stopPropagation();
            this.saveSelection();
            document.getElementById('highlightColorDropdown')?.classList.toggle('show');
        });
        
        document.addEventListener('click', () => {
            document.querySelectorAll('.color-dropdown').forEach(d => d.classList.remove('show'));
        });
    }
    
    // Table Grid
    setupTableGrid() {
        const grid = document.getElementById('tableGrid');
        const popup = document.getElementById('tableGridPopup');
        if (!grid || !popup) return;
        
        for (let row = 0; row < 6; row++) {
            for (let col = 0; col < 6; col++) {
                const cell = document.createElement('div');
                cell.className = 'table-cell';
                cell.addEventListener('click', () => {
                    this.insertTable(row + 1, col + 1);
                    popup.classList.remove('show');
                });
                grid.appendChild(cell);
            }
        }
        
        document.getElementById('btnTable')?.addEventListener('click', e => {
            e.stopPropagation();
            popup.classList.toggle('show');
        });
    }
    
    insertTable(rows, cols) {
        let html = '<table style="width:100%;border-collapse:collapse;margin:15px 0;"><thead><tr>';
        for (let c = 0; c < cols; c++) html += '<th style="border:1px solid #ddd;padding:8px;">Header</th>';
        html += '</tr></thead><tbody>';
        for (let r = 0; r < rows - 1; r++) {
            html += '<tr>';
            for (let c = 0; c < cols; c++) html += '<td style="border:1px solid #ddd;padding:8px;">Cell</td>';
            html += '</tr>';
        }
        html += '</tbody></table><p><br></p>';
        document.execCommand('insertHTML', false, html);
        this.renderPreview();
    }
    
    // Merge Fields
    setupMergeFields() {
        document.querySelectorAll('.category-header').forEach(header => {
            header.addEventListener('click', () => {
                const body = header.nextElementSibling;
                const icon = header.querySelector('i:last-child');
                body?.classList.toggle('show');
                icon?.classList.toggle('bi-chevron-down');
                icon?.classList.toggle('bi-chevron-up');
            });
        });
        
        document.querySelectorAll('.field-item').forEach(item => {
            item.addEventListener('click', () => {
                const token = item.dataset.token;
                this.editor.focus();
                const tokenSpan = `<span class="token">@{{${token}}}</span>&nbsp;`;
                document.execCommand('insertHTML', false, tokenSpan);
                this.renderPreview();
            });
        });
    }
    
    // Image Controls
    setupImageControls() {
        const controls = document.getElementById('imageControls');
        if (!controls) return;
        
        document.querySelectorAll('.image-align-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                if (!this.selectedImage) return;
                const align = btn.dataset.align;
                this.selectedImage.style.marginLeft = align === 'center' || align === 'right' ? 'auto' : '0';
                this.selectedImage.style.marginRight = align === 'center' || align === 'left' ? 'auto' : '0';
                this.renderPreview();
            });
        });
        
        document.getElementById('deleteImage')?.addEventListener('click', () => {
            if (this.selectedImage) {
                this.selectedImage.remove();
                controls.classList.remove('show');
                this.selectedImage = null;
                this.renderPreview();
            }
        });
    }
    
    // Voice Recognition
    setupVoiceRecognition() {
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        const btn = document.getElementById('btnVoice');
        if (!SpeechRecognition || !btn) {
            btn?.style.setProperty('display', 'none');
            return;
        }
        
        const recognition = new SpeechRecognition();
        recognition.continuous = true;
        recognition.interimResults = true;
        
        btn.addEventListener('click', () => {
            if (btn.classList.contains('recording')) {
                recognition.stop();
                btn.classList.remove('recording');
            } else {
                recognition.start();
                btn.classList.add('recording');
            }
        });
        
        recognition.onresult = event => {
            for (let i = event.resultIndex; i < event.results.length; i++) {
                if (event.results[i].isFinal) {
                    document.execCommand('insertText', false, event.results[i][0].transcript);
                    this.renderPreview();
                }
            }
        };
        
        recognition.onend = () => btn.classList.remove('recording');
        recognition.onerror = () => btn.classList.remove('recording');
    }
    
    // Editor Setup
    setupEditor() {
        this.editor.addEventListener('input', () => this.renderPreview());
        this.editor.addEventListener('blur', () => this.saveSelection());
        
        this.editor.addEventListener('click', e => {
            if (e.target.tagName === 'IMG') {
                this.selectedImage = e.target;
                document.getElementById('imageControls')?.classList.add('show');
            } else {
                this.selectedImage = null;
                document.getElementById('imageControls')?.classList.remove('show');
            }
        });
    }
    
    // AI Assistant
    setupAIAssistant() {
        const modal = document.getElementById('aiModal');
        if (!modal) return;
        
        document.getElementById('btnAIAssistant')?.addEventListener('click', () => {
            modal.classList.add('show');
        });
        
        document.getElementById('closeAIModal')?.addEventListener('click', () => {
            modal.classList.remove('show');
        });
        
        document.getElementById('btnBackToOptions')?.addEventListener('click', () => {
            document.getElementById('aiOptions').style.display = 'block';
            document.getElementById('aiInputSection').classList.remove('show');
        });
        
        document.querySelectorAll('.ai-option-card').forEach(card => {
            card.addEventListener('click', () => {
                const action = card.dataset.action;
                document.getElementById('aiOptions').style.display = 'none';
                const inputSection = document.getElementById('aiInputSection');
                const content = document.getElementById('aiInputContent');
                
                if (action === 'generate-email') {
                    content.innerHTML = `
                        <h6 class="mb-3">Describe Your Email</h6>
                        <textarea class="ai-textarea" id="emailDesc" placeholder="Describe what you need..."></textarea>
                        <button class="btn btn-primary mt-3" id="genEmail"><i class="bi bi-stars me-2"></i>Generate</button>
                    `;
                    document.getElementById('genEmail')?.addEventListener('click', () => this.generateEmail());
                } else if (action === 'generate-subject') {
                    content.innerHTML = `
                        <h6 class="mb-3">Generate Subject Lines</h6>
                        <textarea class="ai-textarea" id="subjectDesc" placeholder="Describe your email..."></textarea>
                        <button class="btn btn-primary mt-3" id="genSubject"><i class="bi bi-stars me-2"></i>Generate</button>
                    `;
                }
                
                inputSection.classList.add('show');
            });
        });
    }
    
    generateEmail() {
        document.getElementById('aiInputSection').classList.remove('show');
        document.getElementById('aiGenerating').classList.add('show');
        
        setTimeout(() => {
            this.editor.innerHTML = `
                <p>Hi <span class="token">@{{first_name}}</span>,</p>
                <p>Thank you for your interest in our vehicles at <span class="token">@{{dealer_name}}</span>!</p>
                <p>We have some exciting options available. Please let me know if you'd like to schedule a test drive.</p>
                <p>Best regards,<br><span class="token">@{{advisor_name}}</span></p>
            `;
            this.renderPreview();
            document.getElementById('aiGenerating').classList.remove('show');
            document.getElementById('aiModal').classList.remove('show');
        }, 2000);
    }
    
    // Preview Toggle
    setupPreviewToggle() {
        const mobileBtn = document.getElementById('mobileBtn');
        const desktopBtn = document.getElementById('desktopBtn');
        const preview = document.getElementById('preview');
        
        mobileBtn?.addEventListener('click', () => {
            mobileBtn.classList.add('active');
            desktopBtn?.classList.remove('active');
            preview?.classList.add('mobile');
        });
        
        desktopBtn?.addEventListener('click', () => {
            desktopBtn.classList.add('active');
            mobileBtn?.classList.remove('active');
            preview?.classList.remove('mobile');
        });
    }
    
    // HTML Mode
    setupHtmlMode() {
        const btn = document.getElementById('btnHtmlMode');
        const textarea = document.getElementById('htmlTextarea');
        const wrapper = document.querySelector('.editor-wrapper');
        
        if (!btn || !textarea || !wrapper) return;
        
        let isHtmlMode = false;
        
        btn.addEventListener('click', () => {
            isHtmlMode = !isHtmlMode;
            
            if (isHtmlMode) {
                textarea.value = this.editor.innerHTML;
                wrapper.style.display = 'none';
                textarea.style.display = 'block';
                btn.classList.add('active');
            } else {
                this.editor.innerHTML = textarea.value;
                wrapper.style.display = 'block';
                textarea.style.display = 'none';
                btn.classList.remove('active');
                this.renderPreview();
            }
        });
    }
    
    // Email Suggestions
    setupEmailSuggestions() {
        const users = window.emailUsers || window.users || [];
        
        document.querySelectorAll('.email-suggest-wrapper').forEach(wrapper => {
            const input = wrapper.querySelector('.email-input');
            const box = wrapper.querySelector('.suggestion-box');
            if (!input || !box) return;
            
            input.addEventListener('input', () => {
                const query = input.value.toLowerCase();
                if (!query) {
                    box.style.display = 'none';
                    return;
                }
                
                const filtered = users.filter(u => 
                    u.name.toLowerCase().includes(query) || u.email.toLowerCase().includes(query)
                );
                
                if (filtered.length === 0) {
                    box.style.display = 'none';
                    return;
                }
                
                box.innerHTML = filtered.map(u => `
                    <div class="suggestion-item" data-email="${u.email}">
                        <strong>${u.name}</strong><br><small>${u.email}</small>
                    </div>
                `).join('');
                
                box.querySelectorAll('.suggestion-item').forEach(item => {
                    item.addEventListener('click', () => {
                        input.value = item.dataset.email;
                        box.style.display = 'none';

                        // update runtime template data with selected user
                        const u = users.find(x => x.email === item.dataset.email);
                        if (u) {
                            window.templateData = window.templateData || {};
                            const parts = (u.name || '').split(' ');
                            window.templateData.first_name = parts[0] || window.templateData.first_name;
                            window.templateData.last_name = parts.slice(1).join(' ') || window.templateData.last_name;
                            window.templateData.email = u.email || window.templateData.email;
                            // refresh preview if editor available
                            try { if (window.emailEditor) window.emailEditor.renderPreview(); } catch(e){}
                        }
                    });
                });
                
                box.style.display = 'block';
            });
        });
    }
    
    // Selection Management
    saveSelection() {
        const selection = window.getSelection();
        if (selection.rangeCount > 0) {
            this.savedSelection = selection.getRangeAt(0).cloneRange();
        }
    }
    
    restoreSelection() {
        if (!this.editor.contains(document.activeElement)) {
            this.editor.focus();
        }
        if (this.savedSelection) {
            const selection = window.getSelection();
            selection.removeAllRanges();
            selection.addRange(this.savedSelection);
        }
    }
    
    // Render Preview
    renderPreview() {
        if (!this.preview) return;
        let html = this.editor.innerHTML;

        // Build runtime data: prefer window.templateData, then this.sampleData
        const runtimeData = Object.assign({}, this.sampleData, window.templateData || {});

        // Replace tokens like {{ token }} with runtimeData values
        html = html.replace(/\{\{\s*([^}]+)\s*\}\}/g, (match, token) => {
            const key = token.trim();
            if (typeof runtimeData[key] !== 'undefined' && runtimeData[key] !== null && runtimeData[key] !== '') return runtimeData[key];
            // fallback heuristics
            const fallbacks = [
                key.replace(/_full_name$/,''),
                key.replace(/_name$/,''),
                key.replace(/^advisor_name$/,'assigned_to'),
                key.replace(/^assigned_to_full_name$/,'assigned_to'),
                key.replace(/^assigned_manager_full_name$/,'assigned_manager')
            ];
            for (const f of fallbacks) {
                if (typeof runtimeData[f] !== 'undefined' && runtimeData[f] !== null && runtimeData[f] !== '') return runtimeData[f];
            }
            return match;
        });
        
        const templatePreview = this.preview.querySelector('.template-preview');
        if (templatePreview) {
            templatePreview.innerHTML = html;
        } else {
            this.preview.innerHTML = html;
        }
        
        // Update hidden field for form submission
        const hidden = document.getElementById('emailBodyHidden');
        if (hidden) {
            hidden.value = this.editor.innerHTML;
        }
    }
}

// Ensure EmailEditor instance is reachable
// Replace the EmailEditor initialization in your DOMContentLoaded with:
// window.emailEditor = new EmailEditor();
(function () {
  // tiny toast helper (uses showToast if present)
  function toast(msg, type = 'success') {
    if (typeof showToast === 'function') {
      try { showToast(msg, type); return; } catch (e) { /* ignore */ }
    }
    alert(msg);
  }

  async function submitBrochureForm(e) {
    e.preventDefault();
    const form = e.target;
    const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
    const modalEl = document.getElementById('emailModal');

    // Ensure editor content is up-to-date in hidden field
    try {
      if (window.emailEditor && typeof window.emailEditor.renderPreview === 'function') {
        window.emailEditor.renderPreview();
      } else {
        const editor = document.getElementById('editor');
        const hidden = document.getElementById('emailBodyHidden');
        if (editor && hidden) hidden.value = editor.innerHTML;
      }
    } catch (err) {
      console.warn('renderPreview failed before submit', err);
    }

    // disable button
    if (submitBtn) {
      submitBtn.dataset.origHtml = submitBtn.innerHTML;
      submitBtn.disabled = true;
      submitBtn.classList.add('disabled');
      submitBtn.innerHTML = '<i class="ti ti-loader rotate me-1"></i> Sending...';
    }

    // build FormData
    const formData = new FormData(form);

    // get CSRF token from meta (preferred)
    const meta = document.querySelector('meta[name="csrf-token"]');
    const csrf = meta ? meta.getAttribute('content') : null;

    // Debug logging to help find cause
    console.info('[Brochure] Submitting form to', form.action, 'method', form.method || 'POST');
    try {
      const response = await fetch(form.action, {
        method: form.method || 'POST',
        credentials: 'same-origin',
        headers: csrf ? { 'X-CSRF-TOKEN': csrf } : {},
        body: formData
      });

      // Log status and final URL (helps detect redirect-to-login)
      console.info('[Brochure] fetch finished. status:', response.status, 'ok:', response.ok, 'url:', response.url);

      // If server returned JSON, prefer JSON success path
      const contentType = response.headers.get('content-type') || '';
      let respData = null;
      if (contentType.includes('application/json')) {
        respData = await response.json().catch(()=>null);
      } else {
        // also capture text for debugging (could be redirect HTML)
        respData = await response.text().catch(()=>null);
      }

      if (response.ok) {
        // success: close modal and reload so server flash appears
        try {
          // Bootstrap modal instance hide (if bootstrap in use)
          if (window.bootstrap && modalEl) {
            const modalInstance = window.bootstrap.Modal.getInstance(modalEl) || window.bootstrap.Modal.getOrCreateInstance(modalEl);
            modalInstance.hide();
          } else if (modalEl) {
            modalEl.classList.remove('show');
          }
        } catch (e) { console.warn('Modal hide failed', e); }

        toast('Brochure sent successfully', 'success');

        // Reload to show server flash (if server returns redirect)
        setTimeout(() => { window.location.reload(); }, 600);
        return;
      }

      // Not ok — likely 302->login was followed or 419 CSRF or 500 error
      console.error('[Brochure] Server responded not ok. status:', response.status, 'response:', respData);
      // If response contains login page HTML, hint at auth/CSRF issue
      if (typeof respData === 'string' && respData.indexOf('<form') !== -1 && respData.toLowerCase().includes('login')) {
        toast('Your session may have expired — please log in and try again.', 'error');
      } else if (response.status === 419 || response.status === 401) {
        toast('CSRF or authentication error. Reloading...', 'error');
        setTimeout(()=>window.location.reload(), 800);
      } else {
        toast('Failed to send brochure (server error). Check console for details.', 'error');
      }
    } catch (err) {
      console.error('[Brochure] Request error:', err);
      toast('Network error when sending brochure. Check your connection.', 'error');
    } finally {
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.classList.remove('disabled');
        submitBtn.innerHTML = submitBtn.dataset.origHtml || 'Send Email';
      }
    }
  }

  document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('brochureEmailForm');
    if (!form) return;

    // ensure we expose editor instance (so other code can call renderPreview before submit)
    if (window.emailEditor == null && typeof EmailEditor !== 'undefined') {
      // If you create the instance elsewhere, set window.emailEditor = instance instead
      try { window.emailEditor = window.emailEditor || new EmailEditor(); } catch(e) { /* ignore */ }
    }

    form.addEventListener('submit', submitBrochureForm);

        // When brochure modal is shown, populate templateData from inventory and selected recipient
        const emailModal = document.getElementById('emailModal');
        if (emailModal) {
            emailModal.addEventListener('shown.bs.modal', () => {
                // ensure templateData exists
                window.templateData = window.templateData || {};

                const invIdEl = document.getElementById('brochureInventoryId');
                const selectedInfo = document.getElementById('selectedVehicleInfo');
                const invId = invIdEl?.value || invIdEl?.getAttribute('value') || null;

                if (invId) {
                    fetch(`/inventory/${invId}`)
                        .then(r => r.json())
                        .then(json => {
                            const inv = (json && json.data) ? json.data : (json && json.inventory) ? json.inventory : json;
                            if (inv) {
                                // update display
                                if (selectedInfo) selectedInfo.textContent = `${inv.year || ''} ${inv.make || ''} ${inv.model || ''}`.trim();
                                // populate templateData fields
                                window.templateData.year = inv.year ?? window.templateData.year;
                                window.templateData.make = inv.make ?? window.templateData.make;
                                window.templateData.model = inv.model ?? window.templateData.model;
                                window.templateData.vin = inv.vin ?? window.templateData.vin;
                                window.templateData.stock_number = inv.stock_number ?? window.templateData.stock_number;
                                if (typeof inv.price !== 'undefined') window.templateData.selling_price = '$' + Number(inv.price).toLocaleString();
                                if (typeof inv.internet_price !== 'undefined') window.templateData.internet_price = '$' + Number(inv.internet_price).toLocaleString();
                                if (typeof inv.mileage !== 'undefined') window.templateData.kms = Number(inv.mileage).toLocaleString();
                            }
                        })
                        .catch(err => console.warn('Could not fetch inventory for preview', err))
                        .finally(() => { try { if (window.emailEditor) window.emailEditor.renderPreview(); } catch(e){} });
                } else {
                    if (selectedInfo) selectedInfo.textContent = '-';
                    try { if (window.emailEditor) window.emailEditor.renderPreview(); } catch(e){}
                }

                // update templateData from selected recipient inputs if present
                ['email_to','email_cc','email_bcc'].forEach(name => {
                    const el = document.querySelector(`input[name="${name}"]`);
                    if (!el) return;
                    el.addEventListener('change', () => {
                        const addr = el.value?.trim();
                        if (!addr) return;
                        const users = window.emailUsers || window.users || [];
                        const found = users.find(u => u.email && u.email.toLowerCase() === addr.toLowerCase());
                        if (found) {
                            window.templateData.first_name = (found.name || '').split(' ')[0] || window.templateData.first_name;
                            window.templateData.last_name = (found.name || '').split(' ').slice(1).join(' ') || window.templateData.last_name;
                            window.templateData.email = found.email || window.templateData.email;
                            try { if (window.emailEditor) window.emailEditor.renderPreview(); } catch(e){}
                        }
                    });
                });
            });
        }
  });
})();