@props(['categories' => []])

<div class="merge-fields-container">
    <div class="merge-fields-header">
        Customer Fields
    </div>

    {{-- Customer Information --}}
    <div class="category-container">
        <div class="category-header" data-category="customer">
            <span><i class="bi bi-person me-2"></i>Customer Information</span>
            <i class="bi bi-chevron-down"></i>
        </div>
        <div class="category-body show" id="customerFields">
            <div class="field-item" data-token="first_name">
                <span class="field-label">First Name</span>
                <span class="field-tag">@{{ first_name }}</span>
            </div>
            <div class="field-item" data-token="last_name">
                <span class="field-label">Last Name</span>
                <span class="field-tag">@{{ last_name }}</span>
            </div>
            <div class="field-item" data-token="email">
                <span class="field-label">Email</span>
                <span class="field-tag">@{{ email }}</span>
            </div>
            <div class="field-item" data-token="alt_email">
                <span class="field-label">Alternative Email</span>
                <span class="field-tag">@{{ alt_email }}</span>
            </div>
            <div class="field-item" data-token="cell_phone">
                <span class="field-label">Cell Phone</span>
                <span class="field-tag">@{{ cell_phone }}</span>
            </div>
            <div class="field-item" data-token="work_phone">
                <span class="field-label">Work Phone</span>
                <span class="field-tag">@{{ work_phone }}</span>
            </div>
            <div class="field-item" data-token="home_phone">
                <span class="field-label">Home Phone</span>
                <span class="field-tag">@{{ home_phone }}</span>
            </div>
            <div class="field-item" data-token="street_address">
                <span class="field-label">Street Address</span>
                <span class="field-tag">@{{ street_address }}</span>
            </div>
            <div class="field-item" data-token="city">
                <span class="field-label">City</span>
                <span class="field-tag">@{{ city }}</span>
            </div>
            <div class="field-item" data-token="province">
                <span class="field-label">Province</span>
                <span class="field-tag">@{{ province }}</span>
            </div>
            <div class="field-item" data-token="postal_code">
                <span class="field-label">Postal Code</span>
                <span class="field-tag">@{{ postal_code }}</span>
            </div>
            <div class="field-item" data-token="country">
                <span class="field-label">Country</span>
                <span class="field-tag">@{{ country }}</span>
            </div>
        </div>
    </div>

    {{-- Vehicle Information --}}
    <div class="category-container">
        <div class="category-header" data-category="vehicle">
            <span><i class="bi bi-car-front me-2"></i>Vehicle Information</span>
            <i class="bi bi-chevron-down"></i>
        </div>
        <div class="category-body" id="vehicleFields">
            <div class="field-item" data-token="year">
                <span class="field-label">Year</span>
                <span class="field-tag">@{{ year }}</span>
            </div>
            <div class="field-item" data-token="make">
                <span class="field-label">Make</span>
                <span class="field-tag">@{{ make }}</span>
            </div>
            <div class="field-item" data-token="model">
                <span class="field-label">Model</span>
                <span class="field-tag">@{{ model }}</span>
            </div>
            <div class="field-item" data-token="vin">
                <span class="field-label">VIN</span>
                <span class="field-tag">@{{ vin }}</span>
            </div>
            <div class="field-item" data-token="stock_number">
                <span class="field-label">Stock Number</span>
                <span class="field-tag">@{{ stock_number }}</span>
            </div>
            <div class="field-item" data-token="selling_price">
                <span class="field-label">Selling Price</span>
                <span class="field-tag">@{{ selling_price }}</span>
            </div>
            <div class="field-item" data-token="internet_price">
                <span class="field-label">Internet Price</span>
                <span class="field-tag">@{{ internet_price }}</span>
            </div>
            <div class="field-item" data-token="kms">
                <span class="field-label">KMs</span>
                <span class="field-tag">@{{ kms }}</span>
            </div>
        </div>
    </div>

    {{-- Dealership --}}
    <div class="category-container">
        <div class="category-header" data-category="dealership">
            <span><i class="bi bi-building me-2"></i>Dealership</span>
            <i class="bi bi-chevron-down"></i>
        </div>
        <div class="category-body" id="dealershipFields">
            <div class="field-item" data-token="dealer_name">
                <span class="field-label">Dealership Name</span>
                <span class="field-tag">@{{ dealer_name }}</span>
            </div>
            <div class="field-item" data-token="dealer_phone">
                <span class="field-label">Dealership Phone</span>
                <span class="field-tag">@{{ dealer_phone }}</span>
            </div>
            <div class="field-item" data-token="dealer_address">
                <span class="field-label">Dealership Address</span>
                <span class="field-tag">@{{ dealer_address }}</span>
            </div>
            <div class="field-item" data-token="dealer_street_address">
                <span class="field-label">Dealership Street Address</span>
                <span class="field-tag">@{{ dealer_street_address }}</span>
            </div>
            <div class="field-item" data-token="dealer_city">
                <span class="field-label">Dealership City</span>
                <span class="field-tag">@{{ dealer_city }}</span>
            </div>
            <div class="field-item" data-token="dealer_province">
                <span class="field-label">Dealership Province</span>
                <span class="field-tag">@{{ dealer_province }}</span>
            </div>
            <div class="field-item" data-token="dealer_postal_code">
                <span class="field-label">Dealership Postal Code</span>
                <span class="field-tag">@{{ dealer_postal_code }}</span>
            </div>
            <div class="field-item" data-token="dealer_email">
                <span class="field-label">Dealership Email</span>
                <span class="field-tag">@{{ dealer_email }}</span>
            </div>
            <div class="field-item" data-token="dealer_website">
                <span class="field-label">Dealership Website</span>
                <span class="field-tag">@{{ dealer_website }}</span>
            </div>
        </div>
    </div>

    {{-- Trade-In Information --}}
    <div class="category-container">
        <div class="category-header" data-category="tradein">
            <span><i class="bi bi-arrow-left-right me-2"></i>Trade-In Information</span>
            <i class="bi bi-chevron-down"></i>
        </div>
        <div class="category-body" id="tradeinFields">
            <div class="field-item" data-token="tradein_year">
                <span class="field-label">Trade-In Year</span>
                <span class="field-tag">@{{ tradein_year }}</span>
            </div>
            <div class="field-item" data-token="tradein_make">
                <span class="field-label">Trade-In Make</span>
                <span class="field-tag">@{{ tradein_make }}</span>
            </div>
            <div class="field-item" data-token="tradein_model">
                <span class="field-label">Trade-In Model</span>
                <span class="field-tag">@{{ tradein_model }}</span>
            </div>
            <div class="field-item" data-token="tradein_vin">
                <span class="field-label">Trade-In VIN</span>
                <span class="field-tag">@{{ tradein_vin }}</span>
            </div>
            <div class="field-item" data-token="tradein_kms">
                <span class="field-label">Trade-In KMs</span>
                <span class="field-tag">@{{ tradein_kms }}</span>
            </div>
            <div class="field-item" data-token="tradein_price">
                <span class="field-label">Trade-In Selling Price</span>
                <span class="field-tag">@{{ tradein_price }}</span>
            </div>
        </div>
    </div>

    {{-- Deal Information --}}

<div class="category-container">
    <div class="category-header" data-category="deal">
        <span><i class="bi bi-file-earmark-text me-2"></i>Deal Information</span>
        <i class="bi bi-chevron-down"></i>
    </div>
    <div class="category-body " id="dealFields">
        
        <!-- Finance Manager -->
        <div class="field-item" data-token="finance_manager">
            <span class="field-label">Finance Manager</span>
            <span class="field-tag">@{{ finance_manager }}</span>
        </div>
    
        <!-- Assigned To -->
        <div class="field-item" data-token="assigned_to_full_name">
            <span class="field-label">Assigned To</span>
            <span class="field-tag">@{{ assigned_to_full_name }}</span>
        </div>
        <div class="field-item" data-token="assigned_to_email">
            <span class="field-label">Assigned To Email</span>
            <span class="field-tag">@{{ assigned_to_email }}</span>
        </div>
        <div class="field-item" data-token="assigned_to_work_number">
            <span class="field-label">Assigned To Work Number</span>
            <span class="field-tag">@{{ assigned_to_work_number }}</span>
        </div>
        <div class="field-item" data-token="assigned_to_cell_number">
            <span class="field-label">Assigned To Cell Number</span>
            <span class="field-tag">@{{ assigned_to_cell_number }}</span>
        </div>
        <div class="field-item" data-token="assigned_to_title">
            <span class="field-label">Assigned To Title</span>
            <span class="field-tag">@{{ assigned_to_title }}</span>
        </div>
    
        <!-- Assigned Manager -->
        <div class="field-item" data-token="assigned_manager">
            <span class="field-label">Assigned Manager</span>
            <span class="field-tag">@{{ assigned_manager }}</span>
        </div>
        <div class="field-item" data-token="assigned_manager_email">
            <span class="field-label">Assigned Manager Email</span>
            <span class="field-tag">@{{ assigned_manager_email }}</span>
        </div>
        <div class="field-item" data-token="assigned_manager_work_number">
            <span class="field-label">Assigned Manager Work Number</span>
            <span class="field-tag">@{{ assigned_manager_work_number }}</span>
        </div>
        <div class="field-item" data-token="assigned_manager_cell_number">
            <span class="field-label">Assigned Manager Cell Number</span>
            <span class="field-tag">@{{ assigned_manager_cell_number }}</span>
        </div>
    
        <!-- Secondary Assigned -->
        <div class="field-item" data-token="secondary_assigned_full_name">
            <span class="field-label">Secondary Assigned</span>
            <span class="field-tag">@{{ secondary_assigned_full_name }}</span>
        </div>
        <div class="field-item" data-token="secondary_assigned_email">
            <span class="field-label">Secondary Assigned Email</span>
            <span class="field-tag">@{{ secondary_assigned_email }}</span>
        </div>
        <div class="field-item" data-token="secondary_assigned_work_number">
            <span class="field-label">Secondary Assigned Work Number</span>
            <span class="field-tag">@{{ secondary_assigned_work_number }}</span>
        </div>
        <div class="field-item" data-token="secondary_assigned_cell_number">
            <span class="field-label">Secondary Assigned Cell Number</span>
            <span class="field-tag">@{{ secondary_assigned_cell_number }}</span>
        </div>
        <div class="field-item" data-token="secondary_assigned_title">
            <span class="field-label">Secondary Assigned Title</span>
            <span class="field-tag">@{{ secondary_assigned_title }}</span>
        </div>
    
        <!-- BDC Agent -->
        <div class="field-item" data-token="bdc_agent_full_name">
            <span class="field-label">BDC Agent</span>
            <span class="field-tag">@{{ bdc_agent_full_name }}</span>
        </div>
        <div class="field-item" data-token="bdc_agent_email">
            <span class="field-label">BDC Agent Email</span>
            <span class="field-tag">@{{ bdc_agent_email }}</span>
        </div>
        <div class="field-item" data-token="bdc_agent_work_number">
            <span class="field-label">BDC Agent Work Number</span>
            <span class="field-tag">@{{ bdc_agent_work_number }}</span>
        </div>
        <div class="field-item" data-token="bdc_agent_cell_number">
            <span class="field-label">BDC Agent Cell Number</span>
            <span class="field-tag">@{{ bdc_agent_cell_number }}</span>
        </div>
        <div class="field-item" data-token="bdc_agent_title">
            <span class="field-label">BDC Agent Title</span>
            <span class="field-tag">@{{ bdc_agent_title }}</span>
        </div>
    
        <!-- BDC Manager -->
        <div class="field-item" data-token="bdc_manager_full_name">
            <span class="field-label">BDC Manager</span>
            <span class="field-tag">@{{ bdc_manager_full_name }}</span>
        </div>
        <div class="field-item" data-token="bdc_manager_email">
            <span class="field-label">BDC Manager Email</span>
            <span class="field-tag">@{{ bdc_manager_email }}</span>
        </div>
        <div class="field-item" data-token="bdc_manager_work_number">
            <span class="field-label">BDC Manager Work Number</span>
            <span class="field-tag">@{{ bdc_manager_work_number }}</span>
        </div>
        <div class="field-item" data-token="bdc_manager_cell_number">
            <span class="field-label">BDC Manager Cell Number</span>
            <span class="field-tag">@{{ bdc_manager_cell_number }}</span>
        </div>
        <div class="field-item" data-token="bdc_manager_title">
            <span class="field-label">BDC Manager Title</span>
            <span class="field-tag">@{{ bdc_manager_title }}</span>
        </div>
    
        <!-- General Manager (exclude phone numbers) -->
        <div class="field-item" data-token="general_manager_full_name">
            <span class="field-label">General Manager</span>
            <span class="field-tag">@{{ general_manager_full_name }}</span>
        </div>
        <div class="field-item" data-token="general_manager_email">
            <span class="field-label">General Manager Email</span>
            <span class="field-tag">@{{ general_manager_email }}</span>
        </div>
        <div class="field-item" data-token="general_manager_title">
            <span class="field-label">General Manager Title</span>
            <span class="field-tag">@{{ general_manager_title }}</span>
        </div>
    
        <!-- Sales Manager -->
        <div class="field-item" data-token="sales_manager">
            <span class="field-label">Sales Manager</span>
            <span class="field-tag">@{{ sales_manager }}</span>
        </div>
    
        <!-- Service Advisor -->
        <div class="field-item" data-token="service_advisor">
            <span class="field-label">Service Advisor</span>
            <span class="field-tag">@{{ service_advisor }}</span>
        </div>
    
        <!-- Advisor Name -->
        <div class="field-item" data-token="advisor_name">
            <span class="field-label">Advisor Name</span>
            <span class="field-tag">@{{ advisor_name }}</span>
        </div>
    
        <!-- Source -->
        <div class="field-item" data-token="source">
            <span class="field-label">Source</span>
            <span class="field-tag">@{{ source }}</span>
        </div>
    
        <!-- Appointment Date/Time -->
        <div class="field-item" data-token="appointment_datetime">
            <span class="field-label">Appointment Date/Time</span>
            <span class="field-tag">@{{ appointment_datetime }}</span>
        </div>
    
        <!-- Inventory Manager -->
        <div class="field-item" data-token="inventory_manager">
            <span class="field-label">Inventory Manager</span>
            <span class="field-tag">@{{ inventory_manager }}</span>
        </div>
    
        <!-- Warranty Expiration -->
        <div class="field-item" data-token="warranty_expiration">
            <span class="field-label">Warranty Expiration Date</span>
            <span class="field-tag">@{{ warranty_expiration }}</span>
        </div>
    
    </div>
</div>
</div>

@push('scripts')
<script>
// Initialize all merge-fields containers (supports multiple instances
// and dynamically-inserted components). Also bind document-level
// selection handlers immediately so token insertion works on any page.

function initMergeFields() {
    document.querySelectorAll('.merge-fields-container').forEach(container => {
        if (container.dataset.mergeInitialized) return;
        container.dataset.mergeInitialized = '1';

        // initialize max-heights so already-open categories are visible
        container.querySelectorAll('.category-body').forEach(body => {
            if (body.classList.contains('show')) {
                body.style.maxHeight = body.scrollHeight + 'px';
            } else {
                body.style.maxHeight = '0px';
            }
        });

        container.addEventListener('click', function(e) {
            const header = e.target.closest && e.target.closest('.category-header');
            if (!header) return;

            const body = header.nextElementSibling;
            const icon = header.querySelector('i:last-child');

            if (!body) return;

            const willShow = !body.classList.contains('show');
            if (willShow) {
                body.classList.add('show');
                body.style.maxHeight = body.scrollHeight + 'px';
            } else {
                body.classList.remove('show');
                body.style.maxHeight = '0px';
            }

            if (icon) {
                icon.classList.toggle('bi-chevron-down', !willShow);
                icon.classList.toggle('bi-chevron-up', willShow);
            }
        });

        // adjust heights on window resize (in case content wraps differently)
        const resizeHandler = () => {
            container.querySelectorAll('.category-body.show').forEach(body => {
                body.style.maxHeight = body.scrollHeight + 'px';
            });
        };
        window.addEventListener('resize', resizeHandler);
        container._mergeResizeHandler = resizeHandler;
    });
}

// run now (for pages where DOMContentLoaded already fired) and on DOM ready
if (document.readyState !== 'loading') initMergeFields();
document.addEventListener('DOMContentLoaded', initMergeFields);

// Avoid binding multiple times for document-level selection/click handlers
if (!window._mergeFieldsComponentBound) {
    window._mergeFieldsComponentBound = true;

    window._mergeFieldLastActive = { el: null, start: null, end: null, range: null };

    function captureSelectionForActiveElement() {
        try {
            const active = document.activeElement;
            if (!active) return null;
            const info = { el: null, start: null, end: null, range: null };

            if (active.isContentEditable) {
                const sel = window.getSelection();
                if (sel && sel.rangeCount > 0 && active.contains(sel.anchorNode)) {
                    info.el = active;
                    info.range = sel.getRangeAt(0).cloneRange();
                } else {
                    info.el = active;
                    const r = document.createRange();
                    r.selectNodeContents(active);
                    r.collapse(false);
                    info.range = r;
                }
                return info;
            }

            const tag = active.tagName;
            if (tag === 'INPUT' || tag === 'TEXTAREA') {
                info.el = active;
                try {
                    info.start = active.selectionStart;
                    info.end = active.selectionEnd;
                } catch (err) {
                    info.start = null;
                    info.end = null;
                }
                return info;
            }

            return null;
        } catch (e) {
            return null;
        }
    }

    document.addEventListener('focusin', function() {
        const info = captureSelectionForActiveElement();
        if (info && info.el) window._mergeFieldLastActive = info;
    }, true);

    ['mouseup','keyup','input','click'].forEach(evt => {
        document.addEventListener(evt, function() {
            const info = captureSelectionForActiveElement();
            if (info && info.el) window._mergeFieldLastActive = info;
        }, true);
    });

    document.addEventListener('mousedown', function(e) {
        const item = e.target.closest && e.target.closest('.field-item');
        if (!item) return;
        try {
            const info = captureSelectionForActiveElement();
            if (info && info.el) window._mergeFieldLastActive = info;
        } catch (err) {}
        try { e.preventDefault(); } catch (err) {}
    }, true);

    document.addEventListener('click', function(e) {
        const item = e.target.closest && e.target.closest('.field-item');
        if (!item) return;
        try { e.stopImmediatePropagation(); } catch (err) {}
        const token = item.dataset.token;
        insertToken(token);
    }, true);
}

// insertToken supports contenteditable elements and plain inputs/textareas
function insertToken(tokenName) {
    if (!tokenName) return;
    const tokenTextPlain = `@{{ ${tokenName} }}`;
    const last = window._mergeFieldLastActive && window._mergeFieldLastActive.el ? window._mergeFieldLastActive : null;

    function dispatchInputEvent(el) {
        try {
            const ev = new Event('input', { bubbles: true });
            el.dispatchEvent(ev);
        } catch (e) {}
    }

    // Insert into last active editable
    if (last && last.el) {
        try {
            const el = last.el;

            if (el.isContentEditable) {
                const sel = window.getSelection();
                if (last.range) {
                    try { sel.removeAllRanges(); sel.addRange(last.range.cloneRange()); } catch {}
                }

                const tokenNode = document.createElement('span');
                tokenNode.className = 'token';
                tokenNode.textContent = tokenTextPlain;
                tokenNode.contentEditable = 'false';
                tokenNode.setAttribute('data-token', tokenName);
                tokenNode.setAttribute('data-placeholder', tokenTextPlain);

                if (sel && sel.rangeCount > 0) {
                    const r = sel.getRangeAt(0);
                    r.deleteContents();
                    r.insertNode(tokenNode);
                    const space = document.createTextNode(' ');
                    tokenNode.parentNode.insertBefore(space, tokenNode.nextSibling);

                    const newRange = document.createRange();
                    newRange.setStartAfter(space);
                    newRange.collapse(true);
                    sel.removeAllRanges();
                    sel.addRange(newRange);
                    window._mergeFieldLastActive.range = newRange.cloneRange();
                } else {
                    el.appendChild(tokenNode);
                    el.appendChild(document.createTextNode(' '));
                }

                try { el.focus(); } catch (err) {}
                if (typeof updatePreview === 'function') updatePreview();
                return;
            }

            const tag = el.tagName;
            if (tag === 'INPUT' || tag === 'TEXTAREA') {
                const input = el;
                const val = input.value || '';
                let start = (window._mergeFieldLastActive.start != null) ? window._mergeFieldLastActive.start : (input.selectionStart != null ? input.selectionStart : val.length);
                let end = (window._mergeFieldLastActive.end != null) ? window._mergeFieldLastActive.end : (input.selectionEnd != null ? input.selectionEnd : start);

                start = typeof start === 'number' ? start : 0;
                end = typeof end === 'number' ? end : start;

                const insertion = tokenTextPlain + ' ';
                const newVal = val.slice(0, start) + insertion + val.slice(end);
                input.value = newVal;

                const caret = start + insertion.length;
                try { input.setSelectionRange(caret, caret); } catch {}
                try { input.focus(); } catch (err) {}

                window._mergeFieldLastActive.start = caret;
                window._mergeFieldLastActive.end = caret;

                dispatchInputEvent(input);
                if (typeof updatePreview === 'function') updatePreview();
                return;
            }
        } catch (err) {
            console.error('Error inserting into last active element:', err);
        }
    }

    // fallback to #editor
    const editor = document.getElementById('editor');
    if (editor) {
        try {
            editor.focus();
            const token = document.createElement('span');
            token.className = 'token';
            token.textContent = tokenTextPlain;
            token.contentEditable = 'false';
            token.setAttribute('data-token', tokenName);
            token.setAttribute('data-placeholder', tokenTextPlain);

            const selection = window.getSelection();
            if (selection.rangeCount > 0) {
                const range = selection.getRangeAt(0);
                range.deleteContents();
                range.insertNode(token);
                const space = document.createTextNode(' ');
                range.setStartAfter(token);
                range.insertNode(space);
                range.setStartAfter(space);
                range.collapse(true);
                selection.removeAllRanges();
                selection.addRange(range);
            } else {
                editor.appendChild(token);
                editor.appendChild(document.createTextNode(' '));
            }

            if (typeof updatePreview === 'function') updatePreview();
            return;
        } catch (err) {
            console.error('Editor fallback failed:', err);
        }
    }

    console.warn('No active editable element found to insert token into.');
}
</script>
@endpush

@push('styles')
<style>
.merge-fields-container {
    background: white;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    overflow: hidden;
}

.merge-fields-header {
    background: linear-gradient(135deg, var(--primary-color, #002140) 0%, var(--primary-dark, #001a33) 100%);
    color: white;
    padding: 16px;
    font-weight: 600;
    font-size: 15px;
}

.category-header {
    background: #f9fafb;
    padding: 10px 16px;
    border-bottom: 1px solid #e5e7eb;
    cursor: pointer;
    font-weight: 600;
    font-size: 13px;
    color: #374151;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: all 0.15s ease;
}

.category-header:hover {
    background: #f3f4f6;
}

.category-body {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
}

.category-body.show {
    max-height: 2000px;
}

.field-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 16px;
    border-bottom: 1px solid #f3f4f6;
    cursor: pointer;
    transition: all 0.15s ease;
}

.field-item:hover {
    background: #f9fafb;
    padding-left: 20px;
}

.field-label {
    font-size: 13px;
    color: #374151;
}

.field-tag {
    background: var(--primary-color, #002140);
    color: white;
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 11px;
    font-family: monospace;
}

/* Token styling: inherit formatting in editor */
.token {
    background: #e3f2fd;
    color: #1976d2;
    padding: 2px 6px;
    border-radius: 3px;
    font-size: 12px;
    font-weight: inherit;
    cursor: pointer;
}
</style>
@endpush