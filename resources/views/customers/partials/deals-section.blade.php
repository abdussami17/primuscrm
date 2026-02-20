@props(['customerId', 'users' => [], 'deals' => []])

<div class="col-md-12 mt-0">
    <div class="card-box">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0">
                Events
                <button type="button" class="btn btn-light btn-sm ms-1 border" data-bs-toggle="modal"
                    data-bs-target="#gotoinventoryModal">
                    <i class="ti ti-plus" style="font-size:12px;"></i>
                </button>
            </h6>

            <ul class="nav deals-tabs">
                @foreach (['all' => 'All', 'active' => 'Active', 'sold' => 'Sold / Delivered', 'lost' => 'Lost', 'pending' => 'Pending F&I'] as $key => $label)
                    <li class="nav-item">
                        <button class="nav-link {{ $key === 'all' ? 'active' : '' }}" data-filter="{{ $key }}"
                            onclick="filterDeals('{{ $key }}')">
                            {{ $label }}
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>

        <div id="dealsContainer">
            @forelse ($deals as $deal)
                @php
                    $statusClass = match ($deal->status) {
                        'Sold', 'Delivered' => 'sold',
                        'Lost' => 'lost',
                        'Pending F&I' => 'pending',
                        default => 'active',
                    };

                    $statusColor = match ($deal->status) {
                        'Sold', 'Delivered' => '#198754',
                        'Lost' => '#dc3545',
                        'Pending F&I' => '#ffc107',
                        default => 'rgb(0, 33, 64)',
                    };
                @endphp

                <div class="deal-box mb-3 p-2 border rounded bg-white shadow-sm" data-deal-id="{{ $deal->id }}"
                    data-status="{{ $statusClass }}">

                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="d-flex align-items-center">
                                <p class="deal-vehicle-name fw-semibold mb-0 {{ trim($deal->vehicle_description ?? '') === 'No Vehicle Entered' ? 'text-danger' : '' }}"
                                    style="cursor:pointer;"
                                    onclick="toggleDealDetails(this.closest('.deal-box'),{{ $deal->id }})">
                                    {{ $deal->vehicle_description ?? 'Added Manually Vehicle' }}
                                </p>

                                <i class="toggle-deal-details-icon ti ti-caret-down-filled ms-2" style="cursor:pointer;"
                                    onclick="toggleDealDetails(this.closest('.deal-box'),{{ $deal->id }})"></i>
                            </div>

                            <small class="text-muted small mb-0">
                                Created: {{ $deal->created_at->format('F d, Y') }}
                            </small>
                        </div>

                        <div class="text-end">
                            <div class="d-flex align-items-center gap-1">
                                <i class="ti ti-trash text-danger" style="cursor:pointer;"
                                    onclick="deleteDeal({{ $deal->id }})"></i>

                                <span class="fw-bold" style="color:{{ $statusColor }}">
                                    {{ $deal->status }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row deals-detail-area g-2 mt-2 d-none">

                        {{-- Assigned To (Sales Person) --}}
                        <div class="col-md-4">
                            <label class="form-label form-label-sm mb-1">Assigned To</label>
                            <select class="form-select form-select-sm"
                                onchange="updateDealField({{ $deal->id }}, 'sales_person_id', this.value)">
                                <option hidden>-- Select --</option>
                                @foreach ($salesManagers as $user)
                                    <option value="{{ $user->id }}" @selected($deal->sales_person_id == $user->id)>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Secondary Assigned To (Sales Manager) --}}
                        <div class="col-md-4">
                            <label class="form-label form-label-sm mb-1">Secondary Assigned To</label>
                            <select class="form-select form-select-sm"
                                onchange="updateDealField({{ $deal->id }}, 'sales_manager_id', this.value)">
                                <option hidden>-- Select --</option>
                                @foreach ($financeManagers as $user)
                                    <option value="{{ $user->id }}" @selected($deal->sales_manager_id == $user->id)>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Finance / BDC Agent --}}
                        <div class="col-md-4">
                            <label class="form-label form-label-sm mb-1">BDC / Finance Manager</label>
                            <select class="form-select form-select-sm"
                                onchange="updateDealField({{ $deal->id }}, 'finance_manager_id', this.value)">
                                <option hidden>-- Select --</option>
                                @foreach ($financeManagers as $user)
                                    <option value="{{ $user->id }}" @selected($deal->finance_manager_id == $user->id)>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Lead Type --}}
                        <div class="col-md-3">
                            <label class="form-label form-label-sm mb-1">Lead Type</label>
                            <select class="form-select form-select-sm"
                                onchange="updateDealField({{ $deal->id }}, 'lead_type', this.value)">
                                @foreach (['Internet', 'Walk-In', 'Phone Up', 'Text Up', 'Website Chat', 'Import', 'Wholesale', 'Lease Renewal'] as $type)
                                    <option value="{{ $type }}" @selected($deal->lead_type === $type)>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Deal Status --}}
                        <div class="col-md-3">
                            <label class="form-label form-label-sm mb-1">Deal Status</label>
                            <select class="form-select form-select-sm"
                                onchange="updateDealField({{ $deal->id }}, 'status', this.value)">
                                @foreach (['Active', 'Pending F&I', 'Sold', 'Lost', 'Duplicate', 'Invalid'] as $status)
                                    <option value="{{ $status }}" @selected($deal->status === $status)>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Inventory Type --}}
                        <div class="col-md-3">
                            <label class="form-label form-label-sm mb-1">Inventory Type</label>
                            <select class="form-select form-select-sm"
                                onchange="updateDealField({{ $deal->id }}, 'inventory_type', this.value)">
                                @foreach (['New', 'Pre-Owned', 'CPO', 'Demo', 'Wholesale', 'Unknown'] as $type)
                                    <option value="{{ $type }}" @selected($deal->inventory_type === $type)>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Deal Type --}}
                        <div class="col-md-3">
                            <label class="form-label form-label-sm mb-1">Deal Type</label>
                            <select class="form-select form-select-sm"
                                onchange="updateDealField({{ $deal->id }}, 'deal_type', this.value)">
                                @foreach (['finance' => 'Finance', 'cash' => 'Cash', 'lease' => 'Lease', 'unknown' => 'Unknown'] as $val => $label)
                                    <option value="{{ $val }}" @selected(strtolower($deal->deal_type ?? '') === $val)>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Source Field --}}
                        <div class="col-md-4">
                            <label class="form-label form-label-sm mb-1">Source</label>
                            <select class="form-select form-select-sm"
                                onchange="updateDealField({{ $deal->id }}, 'source', this.value)">
                                @foreach ([
        'walk_in' => 'Walk-in',
        'phone_up' => 'Phone Up',
        'text' => 'Text',
        'repeat_customer' => 'Repeat Customer',
        'referral' => 'Referral',
        'services' => 'Services',
        'sales' => 'Sales',
        'lease_renewal' => 'Lease Renewal',
        'drive_by' => 'Drive By',
        'dealer_website' => 'Dealer Website',

        'unknown' => 'Unknown',
    ] as $val => $label)
                                    <option value="{{ $val }}" @selected(strtolower($deal->source ?? '') === $val)>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </div>


                        {{-- Sales Type Field --}}
                        <div class="col-md-4">
                            <label class="form-label form-label-sm mb-1">Sales Type</label>
                            <select class="form-select form-select-sm"
                                onchange="updateDealField({{ $deal->id }}, 'sales_type', this.value)">
                                @foreach ([
        'sales_lead' => 'Sales Lead',
        'service_lead' => 'Service Lead',
        'parts_lead' => 'Parts Lead',
    ] as $val => $label)
                                    <option value="{{ $val }}" @selected(strtolower($deal->sales_type ?? '') === $val)>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

{{-- Sales Status --}}
                        <div class="col-md-4">
                            <label class="form-label form-label-sm mb-1">Sales Status</label>
                            <select class="form-select form-select-sm"
                                onchange="updateDealField({{ $deal->id }}, 'sales_status', this.value)">
                                @foreach([
                                    'uncontacted'   => 'Uncontacted',
                                    'attempted'     => 'Attempted',
                                    'contacted'     => 'Contacted',
                                    'dealer_visit'  => 'Dealer Visit',
                                    'demo'          => 'Demo',
                                    'write_up'      => 'Write-Up',
                                    'pending'       => 'Pending',
                                    'f&i'           => 'F&I',
                                    'sold'          => 'Sold',
                                    'delivered'     => 'Delivered',
                                ] as $val => $label)
                                    <option value="{{ $val }}" @selected(strtolower($deal->sales_status ?? '') === $val)>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
            @empty
                <div class="text-center py-4 text-muted">
                    <i class="ti ti-car-off" style="font-size:48px;"></i>
                    <p class="mt-2">No deals found. Click + to add a new deal.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>


<div class="modal fade" id="documentsModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Customer Documents</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="documentsModalBody">

                <div class="list-group mb-3" id="docList">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="ti ti-file-text me-2"></i>Bill of Sale.pdf</span>
                        <div>
                            <button class="btn btn-sm btn-primary me-2 open-doc-btn">Open PDF</button>
                        </div>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="ti ti-file-text me-2"></i>Finance Agreement.pdf</span>
                        <div>
                            <button class="btn btn-sm btn-primary me-2 open-doc-btn">Open PDF</button>
                        </div>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="ti ti-file-text me-2"></i>Lease Agreement.pdf</span>
                        <div>
                            <button class="btn btn-sm btn-primary me-2 open-doc-btn">Open PDF</button>
                        </div>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="ti ti-file-text me-2"></i>Warranty Form.pdf</span>
                        <div>
                            <button class="btn btn-sm btn-primary me-2 open-doc-btn">Open PDF</button>
                        </div>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="ti ti-file-text me-2"></i>Insurance Form.pdf</span>
                        <div>
                            <button class="btn btn-sm btn-primary me-2 open-doc-btn">Open PDF</button>
                        </div>
                    </div>
                </div>
                <div class="small text-muted">
                    Dealer default PDF forms-open, fill and save copy to Notes.
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('documentsBtn')?.addEventListener('click', async () => {
        const dealId = AppState.currentDealId; // selected deal
        const customerId = AppState.customerId; // assuming set globally

        try {
            const res = await fetch(`/api/customers/${customerId}/documents?deal_id=${dealId}`);
            const data = await res.json();
            if (!data.success) throw new Error('Failed to load documents');

            const docList = document.getElementById('docList');
            docList.innerHTML = ''; // clear previous

            // Expected document types
            const allTypes = data.documentTypes;

            // Map uploaded documents by type
            const uploadedMap = {};
            data.documents.forEach(doc => {
                uploadedMap[doc.document_type] = doc;
            });

            allTypes.forEach(type => {
                const doc = uploadedMap[type];
                const div = document.createElement('div');
                div.className = 'list-group-item d-flex justify-content-between align-items-center';

                if (doc && doc.file_path) {
                    // Already uploaded → show Open button
                    div.innerHTML = `
                    <span><i class="ti ti-file-text me-2"></i>${doc.document_type} - ${doc.file_name}</span>
                    <div>
                        <button class="btn btn-sm btn-primary me-2" onclick="window.open('/${doc.file_path}', '_blank')">Open PDF</button>
                        <button class="btn btn-sm btn-danger" onclick="deleteDocument(${doc.id}, this)">Delete</button>
                    </div>
                `;
                } else {
                    // Not uploaded → show upload input
                    div.innerHTML = `
                    <span><i class="ti ti-file-text me-2"></i>${type} (Not uploaded)</span>
                    <div>
                        <input type="file" class="form-control form-control-sm upload-doc-input" data-type="${type}" data-customer="${customerId}" data-deal="${dealId}" />
                    </div>
                `;
                }

                docList.appendChild(div);
            });

            new bootstrap.Modal(document.getElementById('documentsModal')).show();

            // Attach onchange event for all new file inputs
            document.querySelectorAll('.upload-doc-input').forEach(input => {
                input.onchange = uploadDocument;
            });

        } catch (err) {
            console.error(err);
            showToast('Failed to load documents', 'error');
        }
    });

    async function uploadDocument(event) {
        const input = event.target;
        const file = input.files[0];
        if (!file) return;

        const customerId = input.dataset.customer;
        const dealId = input.dataset.deal;
        const docType = input.dataset.type;

        const formData = new FormData();
        formData.append('customer_id', customerId);
        formData.append('deals_id', dealId);
        formData.append('document_type', docType);
        formData.append('document_file', file);

        try {
            const res = await fetch(`/api/customers/${customerId}/documents`, {
                method: 'POST',
                body: formData
            });

            const data = await res.json();
            if (!data.success) throw new Error(data.message);

            showToast('Document uploaded successfully', 'success');

            // Refresh modal

        } catch (err) {
            console.error(err);
            showToast('Upload failed: ' + err.message, 'error');
        }
    }


    async function deleteDocument(documentId, btn) {
        if (!confirm('Delete this document?')) return;

        try {
            const res = await fetch(`/api/documents/${documentId}`, {
                method: 'DELETE'
            });
            const data = await res.json();

            if (!data.success) throw new Error(data.message);

            btn.closest('.list-group-item').remove();
            showToast('Document deleted');
        } catch (err) {
            console.error(err);
            showToast('Failed to delete document', 'error');
        }
    }

    /* ================================
       TOGGLE DETAILS
    ================================ */
    function toggleDealDetails(dealBox, dealId) {
        const details = dealBox.querySelector('.deals-detail-area');

        const icon = dealBox.querySelector('.toggle-deal-details-icon');

        // Toggle the deal details visibility (guard against missing elements)
        if (details) {
            const isHidden = details.classList.toggle('d-none');
            if (icon) {
                icon.classList.toggle('ti-caret-down-filled');
                icon.classList.toggle('ti-caret-up-filled');
            }

            // Call selectDeal
            selectDeal(dealId);

            // Buttons to enable/disable
            const buttons = [
                document.getElementById('sendToDmsBtn'),
                document.getElementById('sendToCreditAppBtn'),
                document.getElementById('documentsBtn')
            ];

            if (isHidden) {
                // If details are now hidden → disable buttons
                buttons.forEach(btn => btn?.setAttribute('disabled', true));
            } else {
                // If details are now visible → enable buttons
                buttons.forEach(btn => btn?.removeAttribute('disabled'));
            }
            return;
        }

        // Fallback: if details missing, still trigger selectDeal
        if (icon) {
            icon.classList.toggle('ti-caret-down-filled');
            icon.classList.toggle('ti-caret-up-filled');
        }
        selectDeal(dealId);
    }


    /* ================================
       FILTER DEALS
    ================================ */
    function filterDeals(filter) {
        document.querySelectorAll('.deals-tabs .nav-link').forEach(btn => {
            btn.classList.toggle('active', btn.dataset.filter === filter);
        });

        document.querySelectorAll('.deal-box').forEach(box => {
            box.style.display =
                filter === 'all' || box.dataset.status === filter ?
                '' :
                'none';
        });
    }

    /* ================================
       UPDATE DEAL FIELD (API)
    ================================ */
    async function updateDealField(dealId, field, value) {
        try {
            await api(`/api/deals/${dealId}/field`, 'PATCH', {
                field,
                value
            });
            showToast('Updated');
        } catch {
            showToast('Update failed', 'error');
        }
    }

    /* ================================
       DELETE DEAL
    ================================ */
    async function deleteDeal(dealId) {
        if (!confirm('Delete this deal?')) return;

        try {
            await api(`/api/deals/${dealId}`, 'DELETE');
            document.querySelector(`[data-deal-id="${dealId}"]`)?.remove();
            showToast('Deal deleted');
        } catch {
            showToast('Delete failed', 'error');
        }
    }
</script>
