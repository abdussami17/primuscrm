@php
    // Ensure variables exist when this partial is included outside desklog views
    $users = $users ?? \App\Models\User::where('is_active', true)->orderBy('name')->get();

    // Some installs may not have a `sort` column on flag_definitions — safely fallback to `id`.
    $flagDefinitions = $flagDefinitions ?? null;
    if (is_null($flagDefinitions)) {
        try {
            $hasSort = \Illuminate\Support\Facades\Schema::hasColumn('flag_definitions', 'sort');
        } catch (\Throwable $e) {
            $hasSort = false;
        }
        $flagDefinitions = $hasSort
            ? \App\Models\FlagDefinition::orderBy('sort')->get()
            : \App\Models\FlagDefinition::orderBy('id')->get();
    }
@endphp

<!-- Showroom Visit offcanvas (shared) -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="editShowroomVisitCanvas">
    <div class="offcanvas-header d-block pb-0">
        <div class="border-bottom d-flex align-items-center justify-content-between pb-3">
            <h6 class="offcanvas-title">Edit Showroom Visit</h6>
            <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="offcanvas"
                aria-label="Close">
                <i class="fa-solid fa-x"></i>
            </button>
        </div>
    </div>
    <div class="offcanvas-body pt-3">
        <div class="container">
            <div class="row g-2 mb-3">
                <div class="col-md-4 mb-2">
                    <div class="mb-1"><strong>Assigned To:</strong></div>
                    <select class="form-select" id="showroom_assigned_to">
                        <option value="" selected>-- Select --</option>
                        @foreach ($users as $u)
                            <option value="{{ data_get($u, 'id') }}">{{ data_get($u, 'name') }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="mb-1"><strong>Assigned Manager:</strong></div>
                    <select class="form-select" id="showroom_assigned_manager">
                        <option value="">-- Select --</option>
                        @foreach ($users as $u)
                            <option value="{{ data_get($u, 'id') }}">{{ data_get($u, 'name') }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="mb-1"><strong>Lead Type:</strong></div>
                    <select class="form-select" id="showroom_lead_type">
                        <option value="Internet">Internet</option>
                        <option value="Walk-In">Walk-In</option>
                        <option value="Phone Up">Phone Up</option>
                        <option value="Text Up">Text Up</option>
                        <option value="Website Chat">Website Chat</option>
                        <option value="Import">Import</option>
                        <option value="Wholesale">Wholesale</option>
                        <option value="Lease Renewal">Lease Renewal</option>
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="mb-1"><strong>Deal Type:</strong></div>
                    <select class="form-select" id="showroom_deal_type">
                        <option value="Finance">Finance</option>
                        <option value="Lease">Lease</option>
                        <option value="Cash">Cash</option>
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="mb-1"><strong>Source:</strong></div>
                    <select class="form-select" id="showroom_source">
                        <option value="Facebook">Facebook</option>
                        <option value="Marketplace">Marketplace</option>
                        <option value="Dealer Website">Dealer Website</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <div class="section-title"><img src="{{ asset('assets/img/icons/user_illustration.png') }}"
                        class="title-icon">Did you enter all of their personal information?</div>
                <div class="personal-content">
                    <p> Customer: <a href="#" data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas"
                            id="showroom_customer_link">—</a></p>
                    <p> Email: <span id="showroom_customer_email">—</span></p>
                    <p> Home: <span id="showroom_customer_home">—</span></p>
                    <p> Work: <span id="showroom_customer_work">—</span></p>
                    <p> Cell: <span id="showroom_customer_cell">—</span></p>
                </div>
            </div>

            <div class="form-section">
                <div class="section-title"><img src="{{ asset('assets/img/icons/vehicle_illustration.png') }}"
                        class="title-icon">Is this the correct vehicle they are interested in?</div>
                <div class="personal-content mb-4 mt-3">
                    <p> Vehicle: <a href="#" data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo"
                            id="showroom_vehicle_link">(none)</a></p>
                    <p> Trade-In: <a href="#" data-bs-toggle="modal" data-bs-target="#tradeInModal">(no
                            trade)</a></p>
                </div>
            </div>

            @if (isset($flagDefinitions) && $flagDefinitions->count())
                <div class="form-section checkboxes-area ps-4 pe-4 row">
                    @foreach ($flagDefinitions as $flag)
                        <div class="col-md-12 mb-2 d-flex justify-content-between align-items-center">
                            <span>{{ $flag->label }}</span>
                            <div>
                                @if ($flag->input_type === 'radio')
                                    <input class="form-check-input me-1" type="radio"
                                        name="flags[{{ $flag->key }}]" id="flag_{{ $flag->key }}_yes"
                                        value="1">
                                    <label class="form-check-label me-3"
                                        for="flag_{{ $flag->key }}_yes">Yes</label>
                                    <input class="form-check-input me-1" type="radio"
                                        name="flags[{{ $flag->key }}]" id="flag_{{ $flag->key }}_no"
                                        value="0" checked>
                                    <label class="form-check-label" for="flag_{{ $flag->key }}_no">No</label>
                                @elseif($flag->input_type === 'checkbox')
                                    <input class="form-check-input me-1" type="checkbox"
                                        name="flags[{{ $flag->key }}]" id="flag_{{ $flag->key }}"
                                        value="1">
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="form-section checkboxes-area ps-4 pe-4 row">
                    <div class="col-12 text-muted small">No visit flags configured.</div>
                </div>
            @endif

            <!-- Note: showroom visit changes can be recorded as a customer note using the normal note submission -->
            <div class="container px-3 mt-3">
                <div class="mb-2 small text-muted">Checking the box below will add the showroom visit summary to the
                    customer's notes using the standard note submission workflow.</div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" value="1" id="showroom_add_note" checked>
                    <label class="form-check-label" for="showroom_add_note">Also add this to customer's notes</label>
                </div>
                <div class="mb-3">
                    <label class="form-label small">Optional note text</label>
                    <textarea id="showroom_note_text" class="form-control" rows="3"
                        placeholder="Enter note to add to customer (optional)"></textarea>
                    <input type="hidden" id="showroom_note_deal_id" value="">
                    <input type="hidden" id="showroom_visit_id" value="">
                </div>
            </div>
            <div class="d-flex justify-content-end mt-3">
                <button class="btn btn-light border" data-bs-dismiss="offcanvas">Cancel</button>
                <button class="btn btn-primary ms-2" id="saveShowroomVisit">Save</button>
            </div>
        </div>
    </div>
</div>
