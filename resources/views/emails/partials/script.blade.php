<script>
/**
 * Email Module JavaScript
 * Handles all email-related interactions
 */
console.log('🔵 inbox.js loaded');

// Prevent multiple initializations across script re-executions (use window for persistence)
function initEmailModule() {
    if (window.emailModuleInitialized) {
        console.log('⚠️ Email module already initialized, skipping...');
        return;
    }
    
    console.log('🟢 initEmailModule called');
    try {
        // initComposeForm MUST run first so its isSubmitting guard is registered before any other
        // init function touches the form. Also add initFetchRepliesBtn for inbox toolbar button.
        if (typeof initComposeForm === 'function') initComposeForm();
        if (typeof initReplyForm === 'function') initReplyForm();
        if (typeof initUserAutocomplete === 'function') initUserAutocomplete();
        if (typeof initFavoriteToggle === 'function') initFavoriteToggle();
        if (typeof initTemplateToggle === 'function') initTemplateToggle();
        if (typeof initCcBccToggle === 'function') initCcBccToggle();
        if (typeof initAttachmentPreview === 'function') initAttachmentPreview();
        if (typeof initReadToggle === 'function') initReadToggle();
        if (typeof initBulkActions === 'function') initBulkActions();
        if (typeof initRestoreForms === 'function') initRestoreForms();
        if (typeof initReplyToggle === 'function') initReplyToggle();
        if (typeof initFetchRepliesBtn === 'function') initFetchRepliesBtn();
        // Refresh counts on initial load to ensure they're current
        if (typeof refreshSidebarCounts === 'function') refreshSidebarCounts();
        
        window.emailModuleInitialized = true;
        console.log('✅ Email module initialized successfully');
    } catch (e) { 
        console.error('❌ initEmailModule error', e); 
        console.trace();
    }
}

if (document.readyState === 'loading') {
    console.log('⏳ Document still loading, adding DOMContentLoaded listener');
    document.addEventListener('DOMContentLoaded', initEmailModule);
} else {
    // If script is loaded after DOMContentLoaded (page-bottom), run immediately
    console.log('🚀 Document already loaded, initializing immediately');
    setTimeout(initEmailModule, 0);
}

// Track pending requests to avoid duplicate submissions (window-scoped so it persists across re-executions)
window.emailPendingRequests = window.emailPendingRequests || new Set();
const pendingRequests = window.emailPendingRequests;

/**
 * Show a toast notification using SweetAlert2
 * @param {string} message
 * @param {'success'|'error'|'warning'|'info'} type
 */
function showEmailToast(message, type = 'success') {
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: type,
        title: message,
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
    });
}

/**
 * Refresh sidebar counts by calling backend endpoint
 * Expected response: JSON with keys: unread, starred, sent, drafts, deleted
 */
function refreshSidebarCounts() {
    fetch('/email/sidebar-counts', {
        method: 'GET',
        headers: { 'Accept': 'application/json' }
    })
    .then(resp => resp.json())
    .then(data => {
        try {
            if (typeof data.unread !== 'undefined') {
                const el = document.getElementById('email-count-unread');
                if (el) {
                    if (data.unread > 0) {
                        el.textContent = data.unread;
                        el.classList.remove('d-none');
                    } else {
                        el.textContent = '';
                        el.classList.add('d-none');
                    }
                }
            }
            if (typeof data.starred !== 'undefined') {
                const el = document.getElementById('email-count-starred'); if (el) el.textContent = data.starred;
            }
            if (typeof data.sent !== 'undefined') {
                const el = document.getElementById('email-count-sent'); if (el) el.textContent = data.sent;
            }
            if (typeof data.drafts !== 'undefined') {
                const el = document.getElementById('email-count-drafts'); if (el) el.textContent = data.drafts;
            }
            if (typeof data.deleted !== 'undefined') {
                const el = document.getElementById('email-count-deleted'); if (el) el.textContent = data.deleted;
            }
        } catch (e) { console.error('Error updating sidebar counts', e); }
    })
    .catch(err => console.warn('Could not refresh sidebar counts', err));
}

/**
 * Hook restore form submissions (forms with class `restore-email-form`)
 */
function initRestoreForms() {
    document.querySelectorAll('form.restore-email-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const action = this.action;
            const formData = new FormData(this);

            // simple id extraction from action if needed
            const m = action.match(/\/email\/(\d+)\/restore/);
            const emailId = m ? m[1] : null;
            const key = emailId ? `restore:${emailId}` : `restore:${action}`;
            if (pendingRequests.has(key)) return;
            pendingRequests.add(key);

            fetch(action, {
                method: this.method || 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json, text/html'
                },
                body: formData
            })
            .then(response => {
                const ct = response.headers.get('content-type') || '';
                if (ct.includes('application/json')) return response.json().then(d => ({ type: 'json', data: d }));
                return response.text().then(t => ({ type: 'html', data: t }));
            })
            .then(result => {
                if (result.type === 'json') {
                    const data = result.data;
                    if (data.success) {
                        // If the server returned the updated html snippet, replace list
                        if (data.html) {
                            try {
                                const parser = new DOMParser();
                                const doc = parser.parseFromString(data.html, 'text/html');
                                const newList = doc.querySelector('.mails-list');
                                const currentList = document.querySelector('.mails-list');
                                if (newList && currentList) {
                                    currentList.innerHTML = newList.innerHTML;
                                }
                            } catch (e) { console.error(e); }
                        } else if (emailId) {
                            // otherwise just remove the item from the list
                            const item = document.querySelector(`[data-email-id="${emailId}"]`);
                            if (item) item.remove();
                        }
                        refreshSidebarCounts();
                    }
                } else if (result.type === 'html') {
                    try {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(result.data, 'text/html');
                        const newList = doc.querySelector('.mails-list');
                        const currentList = document.querySelector('.mails-list');
                        if (newList && currentList) {
                            currentList.innerHTML = newList.innerHTML;
                        }
                        refreshSidebarCounts();
                    } catch (e) { console.error(e); }
                }
            })
            .catch(err => console.error('Restore error', err))
            .finally(() => pendingRequests.delete(key));
        });
    });
}

/**
 * Handle compose form submission via AJAX and process HTML/JSON responses.
 */
 function initComposeForm() {
    const form = document.getElementById('composeEmailForm');
    if (!form) return;
    // Prevent attaching multiple submit listeners on the same form element
    if (form.dataset.composeHandled) return;
    form.dataset.composeHandled = '1';

    let isSubmitting = false;

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (isSubmitting) return;

        // Sync rich-text editor → hidden textarea before building FormData
        const editor = document.getElementById('editor');
        const emailBody = document.getElementById('email-body');
        if (editor && emailBody) emailBody.value = editor.innerHTML;

        isSubmitting = true;

        // Disable all submit buttons
        const submitButtons = form.querySelectorAll('button[type="submit"]');
        submitButtons.forEach(btn => {
            btn.disabled = true;
            btn.dataset.originalText = btn.innerHTML;
            btn.innerHTML = 'Sending...';
        });

        const action = this.action;
        const method = (this.method || 'POST').toUpperCase();
        const formData = new FormData(this);

        fetch(action, {
            method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => {
            const ct = response.headers.get('content-type') || '';
            if (ct.includes('application/json')) return response.json().then(d => ({ type: 'json', data: d }));
            return response.text().then(t => ({ type: 'html', data: t }));
        })
        .then(result => {
            if (result.type === 'json' && result.data.success) {
                handleComposeSuccess(result.data.html);
                if (result.data.warning) {
                    showEmailToast(result.data.warning, 'warning');
                } else {
                    showEmailToast('Email sent successfully!');
                }
            } else if (result.type === 'html') {
                handleComposeSuccess(result.data);
                showEmailToast('Email sent successfully!');
            } else {
                console.warn('Compose returned failure:', result);
                showEmailToast((result.data && result.data.message) || 'Failed to send email. Please try again.', 'error');
            }
        })
        .catch(err => {
            console.error('Compose submit error', err);
            showEmailToast('Something went wrong. Please try again.', 'error');
        })
        .finally(() => {
            isSubmitting = false;
            submitButtons.forEach(btn => {
                btn.disabled = false;
                btn.innerHTML = btn.dataset.originalText;
            });
        });

        function handleComposeSuccess(html) {
            if (!html) html = '';
            try {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newList = doc.querySelector('.mails-list');
                const currentList = document.querySelector('.mails-list');
                if (newList && currentList) currentList.innerHTML = newList.innerHTML;
            } catch (e) { console.error(e); }

            // close modal and reset form
            try {
                const modalEl = document.getElementById('email-view');
                const bs = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                bs.hide();
            } catch(e){}

            form.reset();
            const attachmentList = document.getElementById('attachmentList');
            if (attachmentList) attachmentList.innerHTML = '';
            refreshSidebarCounts();
        }
    });
}
/**
 * User Autocomplete for To field
 */
function initUserAutocomplete() {
    const inputBox = document.getElementById('composeInputBox');
    const suggestionsList = document.getElementById('compose-suggestions-list');
    const customers = window.emailCustomers || [];

    if (!inputBox || !suggestionsList) return;

    inputBox.addEventListener('input', function() {
        this.classList.remove('is-invalid');
        const query = this.value.toLowerCase();
        suggestionsList.innerHTML = '';

        if (query.length === 0) {
            suggestionsList.classList.add('d-none');
            return;
        }

        const filtered = customers.filter(c =>
            c.name.toLowerCase().includes(query) ||
            c.email.toLowerCase().includes(query)
        );

        if (filtered.length === 0) {
            suggestionsList.classList.add('d-none');
            return;
        }

        filtered.forEach(c => {
            const li = document.createElement('li');
            li.className = 'list-group-item list-group-item-action';
            li.style.cursor = 'pointer';
            li.innerHTML = `<span class="fw-semibold">${c.name}</span> <span class="text-muted">&lt;${c.email}&gt;</span>`;
            li.addEventListener('click', () => {
                inputBox.value = c.email;
                inputBox.classList.remove('is-invalid');
                // Populate hidden customer_id so token resolution works server-side
                const hiddenCid = document.getElementById('composeCustomerId');
                if (hiddenCid) hiddenCid.value = c.id;
                suggestionsList.classList.add('d-none');
            });
            suggestionsList.appendChild(li);
        });

        suggestionsList.classList.remove('d-none');
    });

    // Hide suggestions on outside click
    document.addEventListener('click', function(e) {
        if (!inputBox.contains(e.target) && !suggestionsList.contains(e.target)) {
            suggestionsList.classList.add('d-none');
        }
    });
}

/**
 * Handle reply form submission via AJAX (in reply.blade.php thread view)
 */
function initReplyForm() {
    const form = document.getElementById('replyEmailForm');
    if (!form) return;
    // Prevent attaching multiple submit listeners on the same form element
    if (form.dataset.replyHandled) return;
    form.dataset.replyHandled = '1';

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Use the window-scoped pendingRequests Set as a shared lock so no second
        // fetch can fire even if multiple closures exist (e.g., from script re-execution)
        if (pendingRequests.has('reply:submit')) return;
        pendingRequests.add('reply:submit');

        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) { submitBtn.disabled = true; submitBtn.innerHTML = 'Sending...'; }

        const action = form.action;
        const formData = new FormData(form);

        fetch(action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            if (!data.success) {
                showEmailToast(data.message || 'Failed to send reply.', 'error');
                return;
            }

            showEmailToast('Reply sent successfully!');

            // Build and inject the new reply card into the thread container
            const body = formData.get('body') || '';
            const now = new Date();
            const timeStr = now.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
                          + ' ' + now.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });

            const userName   = document.querySelector('meta[name="user-name"]')?.content
                             || '{{ auth()->user()->name ?? "You" }}';
            const userInitials = userName.split(' ').map(w => w[0]).join('').toUpperCase().slice(0, 2);

            const newCard = document.createElement('div');
            newCard.className = 'card shadow-none mt-3';
            newCard.innerHTML = `
                <div class="card-body">
                    <div class="bg-light rounded p-3 mb-3">
                        <div class="d-flex align-items-center flex-fill">
                            <a href="javascript:void(0);" class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                <span class="avatar-title bg-primary">${userInitials}</span>
                            </a>
                            <div class="flex-fill">
                                <h6 class="mb-1">
                                    ${userName}
                                    <span class="badge bg-primary ms-1" style="font-size:9px">You</span>
                                </h6>
                                <p class="mb-0 text-muted">${timeStr}</p>
                            </div>
                        </div>
                    </div>
                    <div class="text-dark email-content">${body.replace(/\n/g, '<br>')}</div>
                </div>
            `;

            // Ensure the container exists and is visible
            let container = document.getElementById('olderMessagesContainer');
            if (!container) {
                // Create container + toggle button if thread has no older messages yet
                const center = document.createElement('div');
                center.className = 'text-center';
                center.innerHTML = '<a href="javascript:void(0);" class="btn btn-dark btn-sm" id="viewOlderMessages">View Thread Messages (0)</a>';
                const mainCard = document.querySelector('.mail-detail .card.shadow-none');
                if (mainCard) mainCard.after(center);

                container = document.createElement('div');
                container.className = 'older-messages';
                container.id = 'olderMessagesContainer';
                center.after(container);

                // Wire toggle button
                center.querySelector('#viewOlderMessages').addEventListener('click', function() {
                    container.classList.toggle('d-none');
                    const count = container.querySelectorAll('.card').length;
                    this.textContent = container.classList.contains('d-none')
                        ? `View Thread Messages (${count})`
                        : 'Hide Thread Messages';
                });
            }

            container.classList.remove('d-none');
            container.appendChild(newCard);

            // Update toggle button count
            const toggleBtn = document.getElementById('viewOlderMessages');
            if (toggleBtn) {
                const count = container.querySelectorAll('.card').length;
                toggleBtn.textContent = `View Thread Messages (${count})`;
            }

            // Reset reply form and hide reply box
            form.querySelector('textarea[name="body"]').value = '';
            document.getElementById('replybackbox')?.classList.add('d-none');
        })
        .catch(err => {
            console.error('Reply submit error', err);
            showEmailToast('Something went wrong. Please try again.', 'error');
        })
        .finally(() => {
            pendingRequests.delete('reply:submit');
            if (submitBtn) { submitBtn.disabled = false; submitBtn.innerHTML = 'Send <i class="ti ti-arrow-right ms-2"></i>'; }
        });
    });
}

/**
 * Favorite/Star Toggle - Using Event Delegation
 */
function initFavoriteToggle() {
    // Remove any existing delegated listener to prevent duplicates
    const oldListener = document._favoriteToggleListener;
    if (oldListener) {
        document.removeEventListener('click', oldListener);
    }
    
    // Create new listener
    const listener = function(e) {
        const favoriteIcon = e.target.closest('.favorite-icon');
        if (!favoriteIcon) return;
        
        e.preventDefault();
        e.stopPropagation();
        
        const emailId = favoriteIcon.dataset.emailId;
        const iconElement = favoriteIcon.querySelector('i');

        // Prevent duplicate requests for same email
        if (pendingRequests.has(`star:${emailId}`)) return;
        pendingRequests.add(`star:${emailId}`);

        // Optimistic UI update
        if (iconElement.classList.contains('ti-star')) {
            iconElement.classList.replace('ti-star', 'ti-star-filled');
            iconElement.classList.add('text-warning');
        } else {
            iconElement.classList.replace('ti-star-filled', 'ti-star');
            iconElement.classList.remove('text-warning');
        }

        // Send request to server
        fetch(`/email/${emailId}/star`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json, text/html'
            }
        })
        .then(response => {
            const contentType = response.headers.get('content-type') || '';
            if (contentType.includes('application/json')) {
                return response.json().then(data => ({ type: 'json', data }));
            }
            return response.text().then(text => ({ type: 'html', data: text }));
        })
        .then(result => {
            if (result.type === 'json') {
                const data = result.data;
                if (data.success === false) {
                    // revert optimistic UI change
                    if (iconElement.classList.contains('ti-star-filled')) {
                        iconElement.classList.replace('ti-star-filled', 'ti-star');
                        iconElement.classList.remove('text-warning');
                    } else {
                        iconElement.classList.replace('ti-star', 'ti-star-filled');
                        iconElement.classList.add('text-warning');
                    }
                }
                // if server returned HTML snippet inside json, replace list
                if (data.html) {
                    try {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(data.html, 'text/html');
                        const newList = doc.querySelector('.mails-list');
                        const currentList = document.querySelector('.mails-list');
                        if (newList && currentList) {
                            currentList.innerHTML = newList.innerHTML;
                        }
                    } catch (e) { console.error(e); }
                }
                refreshSidebarCounts();
            } else if (result.type === 'html') {
                // server returned full HTML — try to extract .mails-list
                try {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(result.data, 'text/html');
                    const newList = doc.querySelector('.mails-list');
                    const currentList = document.querySelector('.mails-list');
                    if (newList && currentList) {
                        currentList.innerHTML = newList.innerHTML;
                    }
                    refreshSidebarCounts();
                } catch (e) {
                    console.error('Error parsing HTML response:', e);
                }
            }
        })
        .catch(error => {
            console.error('Error toggling star:', error);
        })
        .finally(() => {
            pendingRequests.delete(`star:${emailId}`);
        });
    };
    
    // Store and attach listener
    document._favoriteToggleListener = listener;
    document.addEventListener('click', listener);
}

/**
 * Template Toggle in Compose Modal
 */
 function initTemplateToggle() {
    const insertBtn = document.getElementById('insertTemplateBtn');
    const emailBody = document.getElementById('email-body-section'); 
    const templateSelector = document.getElementById('template-select-section');
    const backBtn = document.getElementById('backToBody');
    const templateSelect = document.getElementById('templateSelect');
    const subjectInput = document.getElementById('subjectInput');
    const editor = document.getElementById('editor');

    if (!insertBtn || !emailBody || !templateSelector || !backBtn) return;

    insertBtn.addEventListener('click', () => {
        emailBody.classList.add('d-none');
        templateSelector.classList.remove('d-none');
    });

    backBtn.addEventListener('click', () => {
        emailBody.classList.remove('d-none');
        templateSelector.classList.add('d-none');
    });

    if (templateSelect) {
        templateSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const subject = selectedOption.dataset.subject;
            const body = selectedOption.dataset.body;

            if (subject && subjectInput) subjectInput.value = subject;

            if (body && editor) {
                editor.innerHTML = body;

                // 🔥 Dispatch InputEvent so preview updates automatically
                const ev = new InputEvent('input', {
                    bubbles: true,
                    cancelable: true,
                    inputType: 'insertFromPaste',
                    data: body
                });
                editor.dispatchEvent(ev);
            }

            emailBody.classList.remove('d-none');
            templateSelector.classList.add('d-none');
        });
    }
}


// ✅ ALWAYS initialize after DOM
document.addEventListener('DOMContentLoaded', initTemplateToggle);

/**
 * CC/BCC Toggle
 */
function initCcBccToggle() {
    const showCcBtn = document.getElementById('showCcBtn');
    const showBccBtn = document.getElementById('showBccBtn');
    const ccField = document.getElementById('ccField');
    const bccField = document.getElementById('bccField');

    if (showCcBtn && ccField) {
        showCcBtn.addEventListener('click', () => {
            ccField.classList.toggle('d-none');
        });
    }

    if (showBccBtn && bccField) {
        showBccBtn.addEventListener('click', () => {
            bccField.classList.toggle('d-none');
        });
    }
}

/**
 * Attachment Preview
 */
function initAttachmentPreview() {
    const attachmentInput = document.getElementById('attachmentInput');
    const attachmentPreview = document.getElementById('attachmentPreview');
    const attachmentList = document.getElementById('attachmentList');

    if (!attachmentInput || !attachmentPreview || !attachmentList) return;

    attachmentInput.addEventListener('change', function() {
        attachmentList.innerHTML = '';

        if (this.files.length > 0) {
            attachmentPreview.classList.remove('d-none');

            Array.from(this.files).forEach((file, index) => {
                const badge = document.createElement('span');
                badge.className = 'badge bg-light text-dark border';
                badge.innerHTML = `
                    <i class="ti ti-file me-1"></i>
                    ${file.name}
                    <span class="ms-2 text-muted">(${formatFileSize(file.size)})</span>
                `;
                attachmentList.appendChild(badge);
            });
        } else {
            attachmentPreview.classList.add('d-none');
        }
    });
}

/**
 * Format file size
 */
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

/**
 * Toggle Read/Unread Status - Using Event Delegation
 */
function initReadToggle() {
    // Remove any existing delegated listener
    const oldListener = document._readToggleListener;
    if (oldListener) {
        document.removeEventListener('click', oldListener);
    }
    
    const listener = function(e) {
        const btn = e.target.closest('.toggle-read-btn');
        if (!btn) return;
        
        e.preventDefault();
        e.stopPropagation();
        
        const emailId = btn.dataset.emailId;

        // Prevent duplicate requests
        if (pendingRequests.has(`read:${emailId}`)) return;
        pendingRequests.add(`read:${emailId}`);

        fetch(`/email/${emailId}/read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json, text/html'
            }
        })
        .then(response => {
            const ct = response.headers.get('content-type') || '';
            if (ct.includes('application/json')) return response.json().then(d => ({ type: 'json', data: d }));
            return response.text().then(t => ({ type: 'html', data: t }));
        })
        .then(result => {
            if (result.type === 'json') {
                const data = result.data;
                if (data.success) {
                    const emailItem = document.querySelector(`[data-email-id="${emailId}"]`);
                    if (emailItem) {
                        const nameEl = emailItem.querySelector('h6');
                        const subjectEl = emailItem.querySelector('.fw-semibold');
                        const dotEl = emailItem.querySelector('.ti-point-filled');

                        if (data.is_read) {
                            if (nameEl) nameEl.classList.remove('fw-bold');
                            if (subjectEl) subjectEl.classList.remove('fw-bold');
                            if (dotEl) dotEl.remove();
                            btn.textContent = 'Mark as Unread';
                        } else {
                            if (nameEl) nameEl.classList.add('fw-bold');
                            if (subjectEl) subjectEl.classList.add('fw-bold');
                            btn.textContent = 'Mark as Read';
                        }
                        // refresh counts when read status changes
                        refreshSidebarCounts();
                    }
                }
            } else if (result.type === 'html') {
                // Replace list from returned HTML
                try {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(result.data, 'text/html');
                    const newList = doc.querySelector('.mails-list');
                    const currentList = document.querySelector('.mails-list');
                    if (newList && currentList) {
                        currentList.innerHTML = newList.innerHTML;
                    }
                    refreshSidebarCounts();
                } catch (e) { console.error(e); }
            }
        })
        .catch(error => {
            console.error('Error toggling read status:', error);
        })
        .finally(() => pendingRequests.delete(`read:${emailId}`));
    };
    
    // Store and attach listener
    document._readToggleListener = listener;
    document.addEventListener('click', listener);
}

/**
 * Bulk Actions (Select All, Delete Selected)
 */
function initBulkActions() {
    const selectAllCheckbox = document.getElementById('selectAllEmails');
    const emailCheckboxes = document.querySelectorAll('.email-checkbox');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            emailCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkDeleteVisibility();
        });
    }

    emailCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkDeleteVisibility);
    });

    if (bulkDeleteBtn) {
        bulkDeleteBtn.addEventListener('click', function() {
            const selectedIds = Array.from(document.querySelectorAll('.email-checkbox:checked'))
                .map(cb => cb.value);

            if (selectedIds.length === 0) return;

            if (confirm(`Delete ${selectedIds.length} email(s)?`)) {
                // prevent duplicate bulk deletes
                if (pendingRequests.has('bulk-delete')) return;
                pendingRequests.add('bulk-delete');

                fetch('/email/bulk-delete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json, text/html'
                    },
                    body: JSON.stringify({ email_ids: selectedIds })
                })
                .then(response => {
                    const ct = response.headers.get('content-type') || '';
                    if (ct.includes('application/json')) return response.json().then(d => ({ type: 'json', data: d }));
                    return response.text().then(t => ({ type: 'html', data: t }));
                })
                .then(result => {
                    if (result.type === 'json') {
                        const data = result.data;
                        if (data.success) {
                            selectedIds.forEach(id => {
                                const emailItem = document.querySelector(`[data-email-id="${id}"]`);
                                if (emailItem) emailItem.remove();
                            });
                            // refresh counts after bulk delete
                            refreshSidebarCounts();
                        }
                    } else if (result.type === 'html') {
                        try {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(result.data, 'text/html');
                            const newList = doc.querySelector('.mails-list');
                            const currentList = document.querySelector('.mails-list');
                            if (newList && currentList) {
                                currentList.innerHTML = newList.innerHTML;
                            }
                            refreshSidebarCounts();
                        } catch (e) {console.error(e); }
                    }
                })
                .catch(error => {
                    console.error('Error deleting emails:', error);
                })
                .finally(() => pendingRequests.delete('bulk-delete'));
            }
        });
    }
}

function updateBulkDeleteVisibility() {
    const selectedCount = document.querySelectorAll('.email-checkbox:checked').length;
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');

    if (bulkDeleteBtn) {
        if (selectedCount > 0) {
            bulkDeleteBtn.classList.remove('d-none');
            bulkDeleteBtn.textContent = `Delete (${selectedCount})`;
        } else {
            bulkDeleteBtn.classList.add('d-none');
        }
    }
}

/**
 * Reply Box Toggle - Using Event Delegation
 */
function initReplyToggle() {
    // Remove any existing delegated listener
    const oldListener = document._replyToggleListener;
    if (oldListener) {
        document.removeEventListener('click', oldListener);
    }
    
    const listener = function(e) {
        const btn = e.target.closest('.toggle-reply');
        if (!btn) return;
        
        e.preventDefault();
        e.stopPropagation();
        
        const replyBox = document.getElementById('replybackbox');
        if (replyBox) {
            replyBox.classList.toggle('d-none');
        }
    };
    
    // Store and attach listener
    document._replyToggleListener = listener;
    document.addEventListener('click', listener);
}

/**
 * Filter Dropdown
 */
function applyFilter(element) {
    const filterValue = element.dataset.value;
    document.getElementById('selectedFilter').value = filterValue;
    
    // Build URL with filter parameter
    const url = new URL(window.location.href);
    url.searchParams.set('filter', filterValue);
    window.location.href = url.toString();
}

</script>