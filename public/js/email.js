/**
 * Email Module JavaScript
 * Handles all email-related interactions
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all email functionality
    initUserAutocomplete();
    initFavoriteToggle();
    initTemplateToggle();
    initCcBccToggle();
    initAttachmentPreview();
    initReadToggle();
    initBulkActions();
});

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
 * Favorite/Star Toggle
 */
function initFavoriteToggle() {
    document.querySelectorAll('.favorite-icon').forEach(icon => {
        icon.addEventListener('click', function() {
            const emailId = this.dataset.emailId;
            const iconElement = this.querySelector('i');

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
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    // Revert on failure
                    if (iconElement.classList.contains('ti-star-filled')) {
                        iconElement.classList.replace('ti-star-filled', 'ti-star');
                        iconElement.classList.remove('text-warning');
                    } else {
                        iconElement.classList.replace('ti-star', 'ti-star-filled');
                        iconElement.classList.add('text-warning');
                    }
                }
            })
            .catch(error => {
                console.error('Error toggling star:', error);
            });
        });
    });
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
 * Toggle Read/Unread Status
 */
function initReadToggle() {
    document.querySelectorAll('.toggle-read-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const emailId = this.dataset.emailId;

            fetch(`/email/${emailId}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update UI
                    const emailItem = document.querySelector(`[data-email-id="${emailId}"]`);
                    if (emailItem) {
                        const nameEl = emailItem.querySelector('h6');
                        const subjectEl = emailItem.querySelector('.fw-semibold');
                        const dotEl = emailItem.querySelector('.ti-point-filled');

                        if (data.is_read) {
                            nameEl?.classList.remove('fw-bold');
                            subjectEl?.classList.remove('fw-bold');
                            dotEl?.remove();
                            this.textContent = 'Mark as Unread';
                        } else {
                            nameEl?.classList.add('fw-bold');
                            subjectEl?.classList.add('fw-bold');
                            this.textContent = 'Mark as Read';
                        }
                    }
                }
            })
            .catch(error => {
                console.error('Error toggling read status:', error);
            });
        });
    });
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
                fetch('/email/bulk-delete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email_ids: selectedIds })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove deleted emails from UI
                        selectedIds.forEach(id => {
                            const emailItem = document.querySelector(`[data-email-id="${id}"]`);
                            if (emailItem) {
                                emailItem.remove();
                            }
                        });
                    }
                })
                .catch(error => {
                    console.error('Error deleting emails:', error);
                });
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
 * Reply Box Toggle
 */
function initReplyToggle() {
    document.querySelectorAll('.toggle-reply').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const replyBox = document.getElementById('replybackbox');
            if (replyBox) {
                replyBox.classList.toggle('d-none');
            }
        });
    });
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

// Initialize reply toggle when on reply page
document.addEventListener('DOMContentLoaded', function() {
    initReplyToggle();
});