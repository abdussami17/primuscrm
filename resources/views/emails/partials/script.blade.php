<script>
/**
 * Email Module JavaScript
 * Handles all email-related interactions
 */
console.log('🔵 inbox.js loaded');

// Prevent multiple initializations
let emailModuleInitialized = false;

function initEmailModule() {
    if (emailModuleInitialized) {
        console.log('⚠️ Email module already initialized, skipping...');
        return;
    }
    
    console.log('🟢 initEmailModule called');
    try {
        // Initialize all email functionality ONCE
        if (typeof initUserAutocomplete === 'function') initUserAutocomplete();
        if (typeof initFavoriteToggle === 'function') initFavoriteToggle();
        if (typeof initTemplateToggle === 'function') initTemplateToggle();
        if (typeof initCcBccToggle === 'function') initCcBccToggle();
        if (typeof initAttachmentPreview === 'function') initAttachmentPreview();
        if (typeof initReadToggle === 'function') initReadToggle();
        if (typeof initBulkActions === 'function') initBulkActions();
        if (typeof initRestoreForms === 'function') initRestoreForms();
        if (typeof initReplyToggle === 'function') initReplyToggle();
        // Refresh counts on initial load to ensure they're current
        if (typeof refreshSidebarCounts === 'function') refreshSidebarCounts();
        if (typeof initComposeForm === 'function') initComposeForm();
        
        emailModuleInitialized = true;
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

// Track pending requests to avoid duplicate submissions
const pendingRequests = new Set();

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

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        if (pendingRequests.has('compose')) return;
        pendingRequests.add('compose');

        const action = this.action;
        const method = (this.method || 'POST').toUpperCase();
        const formData = new FormData(this);

        fetch(action, {
            method,
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
                    // close modal and reset form
                    try { const modalEl = document.getElementById('email-view'); const bs = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl); bs.hide(); } catch(e){}
                    form.reset();
                    const attachmentList = document.getElementById('attachmentList');
                    if (attachmentList) attachmentList.innerHTML = '';
                    refreshSidebarCounts();
                } else {
                    console.warn('Compose returned success=false', data);
                }
            } else if (result.type === 'html') {
                // server returned full page HTML (redirect followed); try to extract .mails-list
                try {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(result.data, 'text/html');
                    const newList = doc.querySelector('.mails-list');
                    const currentList = document.querySelector('.mails-list');
                    if (newList && currentList) {
                        currentList.innerHTML = newList.innerHTML;
                    }
                    // close modal and reset form
                    try { const modalEl = document.getElementById('email-view'); const bs = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl); bs.hide(); } catch(e){}
                    form.reset();
                    const attachmentList2 = document.getElementById('attachmentList');
                    if (attachmentList2) attachmentList2.innerHTML = '';
                    refreshSidebarCounts();
                } catch (e) { console.error('Error processing compose HTML response', e); }
            }
        })
        .catch(err => console.error('Compose submit error', err))
        .finally(() => pendingRequests.delete('compose'));
    });
}

/**
 * User Autocomplete for To field
 */
function initUserAutocomplete() {
    const inputBox = document.getElementById('composeInputBox');
    const suggestionsList = document.getElementById('compose-suggestions-list');
    const users = window.emailUsers || [];

    if (!inputBox || !suggestionsList) return;

    inputBox.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        suggestionsList.innerHTML = '';

        if (query.length === 0) {
            suggestionsList.classList.add('d-none');
            return;
        }

        const filtered = users.filter(user =>
            user.name.toLowerCase().includes(query) || 
            user.email.toLowerCase().includes(query)
        );

        if (filtered.length === 0) {
            suggestionsList.classList.add('d-none');
            return;
        }

        filtered.forEach(user => {
            const li = document.createElement('li');
            li.className = 'list-group-item list-group-item-action';
            li.textContent = `${user.name} <${user.email}>`;
            li.addEventListener('click', () => {
                inputBox.value = user.email;
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
    const subjectInput = document.querySelector('input[name="subject"]');
    const bodyTextarea = document.getElementById('email-body');

    if (!insertBtn || !emailBody || !templateSelector || !backBtn) return;

    insertBtn.addEventListener('click', () => {
        emailBody.classList.add('d-none');
        templateSelector.classList.remove('d-none');
    });

    backBtn.addEventListener('click', () => {
        emailBody.classList.remove('d-none');
        templateSelector.classList.add('d-none');
    });

    // Handle template selection
    if (templateSelect) {
        templateSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const subject = selectedOption.dataset.subject;
            const body = selectedOption.dataset.body;

            if (subject && subjectInput) {
                subjectInput.value = subject;
            }
            if (body && bodyTextarea) {
                bodyTextarea.value = body;
            }

            // Switch back to body view
            emailBody.classList.remove('d-none');
            templateSelector.classList.add('d-none');
        });
    }
}

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