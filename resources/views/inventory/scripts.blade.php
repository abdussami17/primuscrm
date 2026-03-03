<script>
    

/**
 * Inventory Core JavaScript
 * Handles basic inventory page functionality with minimal JS
 */

document.addEventListener('DOMContentLoaded', function() {
    initSelectAll();
    initImageCountToggle();
    initModals();
    initModalMinimize();
});

/**
 * Select All Checkbox Functionality
 */
function initSelectAll() {
    const selectAll = document.getElementById('select-all');
    if (!selectAll) return;

    selectAll.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
}

/**
 * Image Count Toggle
 */
// function initImageCountToggle() {
//     const checkbox = document.getElementById('showCountCheckbox');
//     if (!checkbox) return;

//     checkbox.addEventListener('change', function() {
//         const overlays = document.querySelectorAll('.image-count-overlay');
//         overlays.forEach(overlay => {
//             overlay.classList.toggle('d-none', !this.checked);
//         });

//         // Save preference via AJAX
//         fetch('/api/user/preferences', {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json',
//                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
//             },
//             body: JSON.stringify({ show_image_count: this.checked })
//         }).catch(() => {});
//     });
// }

function initImageCountToggle() {
    const checkbox = document.getElementById('showCountCheckbox');
    if (!checkbox) return;

    const overlays = document.querySelectorAll('.image-count-overlay');

    function update() {
        overlays.forEach(o =>
            o.classList.toggle('d-none', !checkbox.checked)
        );
    }

    update(); // set initial state
    checkbox.addEventListener('change', update);
}

document.addEventListener('DOMContentLoaded', initImageCountToggle);


/**
 * Initialize Modal Data Loading
 */
function initModals() {
    // Availability Modal
    const availabilityModal = document.getElementById('availabilityModal');
    if (availabilityModal) {
        availabilityModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const inventoryId = button?.dataset?.inventoryId;
            if (inventoryId) loadAvailabilityData(inventoryId);
        });
    }

    // Price Modal
    const priceModal = document.getElementById('priceAdjustmentModal');
    if (priceModal) {
        priceModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const inventoryId = button?.dataset?.inventoryId;
            if (inventoryId) loadPriceData(inventoryId);
        });

        // Toggle more fields
        const toggleBtn = document.getElementById('toggleMoreFields');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                const moreFields = document.getElementById('morePriceFields');
                const visible = moreFields.style.display === 'block';
                moreFields.style.display = visible ? 'none' : 'block';
                this.textContent = visible ? 'Show More' : 'Show Less';
            });
        }

        // Vehicle type change handler
        const vehicleType = document.getElementById('vehicleType');
        if (vehicleType) {
            vehicleType.addEventListener('change', function() {
                const section = document.getElementById('usedCpoFields');
                section.style.display = (this.value === 'used' || this.value === 'certified_pre_owned') ? 'block' : 'none';
            });
        }

        // Fetch book value
        const fetchBtn = document.getElementById('fetchBookValue');
        if (fetchBtn) {
            fetchBtn.addEventListener('click', function() {
                const inventoryId = document.getElementById('priceInventoryId')?.value;
                if (inventoryId) fetchBookValue(inventoryId);
            });
        }
    }

    // Image Modal
    const imageModal = document.getElementById('imageInventory');
    if (imageModal) {
        imageModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const inventoryId = button?.dataset?.inventoryId;
            if (inventoryId) loadImageGallery(inventoryId);
        });

        // Upload box click
        const uploadBox = document.getElementById('uploadBox');
        const uploadInput = document.getElementById('uploadInput');
        if (uploadBox && uploadInput) {
            uploadBox.addEventListener('click', () => uploadInput.click());
            uploadInput.addEventListener('change', handleImageUpload);
        }
    }

    // Initialize datepickers if flatpickr is available
    if (typeof flatpickr !== 'undefined') {
        flatpickr('.cf-datepicker', {
            enableTime: true,
            dateFormat: 'M d, Y h:i K',
            allowInput: false
        });
    }
}

/**
 * Load Availability/Hold Data
 */
function loadAvailabilityData(inventoryId) {
    const customersList = document.getElementById('customersList');
    customersList.innerHTML = '<div class="text-center text-muted py-3">Loading...</div>';

    fetch(`/api/inventory/${inventoryId}/availability`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Update vehicle info
                document.getElementById('modalVehicleName').textContent = data.vehicle?.name || '-';
                document.getElementById('modalStockNumber').textContent = data.vehicle?.stock_number || '-';
                document.getElementById('modalVin').textContent = data.vehicle?.vin || '-';

                // Update customers list
                const customers = data.customers || [];
                document.getElementById('customerCount').textContent = customers.length;

                if (customers.length === 0) {
                    customersList.innerHTML = '<div class="text-center text-muted py-3">No interested customers.</div>';
                    return;
                }

                customersList.innerHTML = customers.map(c => `
                    <div class="customer-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <a href="#" class="customer-link text-black text-decoration-underline fw-semibold" data-url="/customers/${c.id}/canvas" data-ajax-popup="true" data-title="Customer Profile">${c.name}</a>
                                <div class="small text-muted mt-1">Assigned: ${c.assigned_to || 'N/A'}</div>
                            </div>
                        </div>
                        <div class="small text-muted mt-1">
                            Hold Date & Time: ${c.hold_date || 'N/A'} ${c.hold_time || ''}
                        </div>
                    </div>
                `).join('');
            }
        })
        .catch(() => {
            customersList.innerHTML = '<div class="text-center text-danger py-3">Error loading data.</div>';
        });
}

/**
 * Load Price Data
 */
function loadPriceData(inventoryId) {
    document.getElementById('priceInventoryId').value = inventoryId;

    fetch(`/api/inventory/${inventoryId}/price`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const item = data.inventory;
                document.getElementById('priceMsrp').value = formatCurrency(item.msrp);
                document.getElementById('priceSellingPrice').value = formatCurrency(item.price);
                document.getElementById('priceInternetPrice').value = formatCurrency(item.internet_price);

                if (item.condition) {
                    document.getElementById('vehicleType').value = item.condition;
                    const section = document.getElementById('usedCpoFields');
                    section.style.display = (item.condition === 'used' || item.condition === 'certified_pre_owned') ? 'block' : 'none';
                }

                // Load modification history
                if (data.history) {
                    const select = document.getElementById('modificationHistory');
                    select.innerHTML = '<option hidden>View Modification History</option>';
                    data.history.forEach(h => {
                        const option = document.createElement('option');
                        option.textContent = `${h.user} – ${h.date}`;
                        select.appendChild(option);
                    });
                }
            }
        })
        .catch(() => {});
}

/**
 * Fetch Book Value from vAuto
 */
function fetchBookValue(inventoryId) {
    const bookField = document.getElementById('bookValue');
    bookField.value = 'Fetching...';

    fetch(`/api/inventory/${inventoryId}/book-value`)
        .then(res => res.json())
        .then(data => {
            bookField.value = data.success ? formatCurrency(data.value) : 'N/A';
        })
        .catch(() => {
            bookField.value = 'Error';
        });
}

/**
 * Load Image Gallery
 */
function loadImageGallery(inventoryId) {
    document.getElementById('imageInventoryId').value = inventoryId;
    const container = document.getElementById('imageContainer');
    const uploadPlaceholder = container.querySelector('.col-md-3:last-child');

    // Remove existing images (keep upload placeholder)
    container.querySelectorAll('.image-box').forEach(el => el.remove());

    fetch(`/api/inventory/${inventoryId}/images`)
        .then(res => res.json())
        .then(data => {
            if (data.success && data.images) {
                data.images.forEach(img => {
                    const col = createImageElement(img);
                    container.insertBefore(col, uploadPlaceholder);
                });
            }
        })
        .catch(() => {});
}

/**
 * Create Image Element
 */
function createImageElement(src) {
    const col = document.createElement('div');
    col.classList.add('col-md-3', 'image-box');
    col.innerHTML = `
        <div class="image-wrapper">
            <img src="${src}" alt="Vehicle Image">
            <button type="button" class="delete-btn" onclick="this.closest('.image-box').remove()">&times;</button>
        </div>
    `;
    return col;
}

/**
 * Handle Image Upload
 */
function handleImageUpload(event) {
    const container = document.getElementById('imageContainer');
    const uploadPlaceholder = container.querySelector('.col-md-3:last-child');

    for (const file of event.target.files) {
        if (!file.type.startsWith('image/')) continue;

        const reader = new FileReader();
        reader.onload = function(e) {
            const col = createImageElement(e.target.result);
            container.insertBefore(col, uploadPlaceholder);
        };
        reader.readAsDataURL(file);
    }
    event.target.value = '';
}

document.addEventListener('click', function(e) {
    const a = e.target.closest && e.target.closest('.customer-name');
    if (!a) return;
    e.preventDefault();
    const id = a.getAttribute('data-customer-id') || a.dataset.customerId;
    if (!id) return;
    if (typeof window.openCustomerProfile === 'function') {
        try { window.openCustomerProfile(id); } catch (err) { console.error('openCustomerProfile failed', err); }
    } else {
        // fallback: navigate to canvas URL
        window.location.href = `/customers/${id}/canvas`;
    }
}, { capture: true });
/**
 * Modal Minimize Functionality
 */
function initModalMinimize() {
    const modalEl = document.getElementById('emailModal');
    const minimizeBtn = document.getElementById('minimizeModalBtn');
    const minimizedBar = document.getElementById('minimizedBar');

    if (!modalEl || !minimizeBtn || !minimizedBar) return;

    const bsModal = bootstrap.Modal.getOrCreateInstance(modalEl);

    // Restore modal state from storage
    const modalState = localStorage.getItem('modalState');
    if (modalState === 'minimized') {
        minimizedBar.classList.remove('d-none');
    }

    // Minimize click
    minimizeBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
        localStorage.setItem('modalState', 'minimized');
        bsModal.hide();
        minimizedBar.classList.remove('d-none');
    });

    // Restore from bar
    minimizedBar.addEventListener('click', function() {
        localStorage.setItem('modalState', 'open');
        minimizedBar.classList.add('d-none');
        bsModal.show();
    });

    // Modal closed normally
    modalEl.addEventListener('hidden.bs.modal', function() {
        if (localStorage.getItem('modalState') !== 'minimized') {
            localStorage.setItem('modalState', 'closed');
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
            minimizedBar.classList.add('d-none');
        }
    });
}

/**
 * Format Currency
 */
function formatCurrency(value) {
    const num = parseFloat(value) || 0;
    return '$' + num.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

</script>



<script>
    document.addEventListener('DOMContentLoaded', function () {
    
        const table = document.getElementById('inventoryTable');
        if (!table) return;
    
        const tbody = table.querySelector('tbody');
        if (!tbody) return;
    
        let rows = Array.from(tbody.querySelectorAll('tr'));
        if (!rows.length) return;
    
        rows.reverse();
    
        const perPageSelect = document.getElementById('rows-per-page');
        const startEl = document.getElementById('start-item');
        const endEl = document.getElementById('end-item');
        const totalEl = document.getElementById('total-items');
    
        if (!perPageSelect) return;
    
        let perPage = 25;
    
        totalEl.textContent = rows.length;
    
        function render() {
            rows.forEach(r => r.style.display = 'none');
    
            rows.slice(0, perPage).forEach(r => r.style.display = '');
    
            startEl.textContent = rows.length ? 1 : 0;
            endEl.textContent = Math.min(perPage, rows.length);
        }
    
        perPageSelect.addEventListener('change', function () {
            perPage = parseInt(this.value);
            render();
        });
    
        render();
    
    });
    </script>