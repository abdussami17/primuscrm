{{-- Merge Fields Panel --}}
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
        <div class="category-body" id="customerFields">
            @foreach([
                'first_name' => 'First Name',
                'last_name' => 'Last Name',
                'email' => 'Email',
                'alt_email' => 'Alternative Email',
                'cell_phone' => 'Cell Phone',
                'work_phone' => 'Work Phone',
                'home_phone' => 'Home Phone',
                'street_address' => 'Street Address',
                'city' => 'City',
                'province' => 'Province',
                'postal_code' => 'Postal Code',
                'country' => 'Country',
            ] as $token => $label)
            <div class="field-item" data-token="{{ $token }}">
                <span class="field-label">{{ $label }}</span>
                <span class="field-tag">@{{{{ $token }}}}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Vehicle Information --}}
    <div class="category-container">
        <div class="category-header" data-category="vehicle">
            <span><i class="bi bi-car-front me-2"></i>Vehicle Information</span>
            <i class="bi bi-chevron-down"></i>
        </div>
        <div class="category-body" id="vehicleFields">
            @foreach([
                'year' => 'Year',
                'make' => 'Make',
                'model' => 'Model',
                'vin' => 'VIN',
                'stock_number' => 'Stock Number',
                'selling_price' => 'Selling Price',
                'internet_price' => 'Internet Price',
                'kms' => 'KMs',
            ] as $token => $label)
            <div class="field-item" data-token="{{ $token }}">
                <span class="field-label">{{ $label }}</span>
                <span class="field-tag">@{{{{ $token }}}}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Dealership Information --}}
    <div class="category-container">
        <div class="category-header" data-category="dealership">
            <span><i class="bi bi-building me-2"></i>Dealership</span>
            <i class="bi bi-chevron-down"></i>
        </div>
        <div class="category-body" id="dealershipFields">
            @foreach([
                'dealer_name' => 'Dealership Name',
                'dealer_phone' => 'Dealership Phone',
                'dealer_address' => 'Dealership Address',
                'dealer_email' => 'Dealership Email',
                'dealer_website' => 'Dealership Website',
            ] as $token => $label)
            <div class="field-item" data-token="{{ $token }}">
                <span class="field-label">{{ $label }}</span>
                <span class="field-tag">@{{{{ $token }}}}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Trade-In Information --}}
    <div class="category-container">
        <div class="category-header" data-category="tradein">
            <span><i class="bi bi-arrow-left-right me-2"></i>Trade-In Information</span>
            <i class="bi bi-chevron-down"></i>
        </div>
        <div class="category-body" id="tradeinFields">
            @foreach([
                'tradein_year' => 'Trade-In Year',
                'tradein_make' => 'Trade-In Make',
                'tradein_model' => 'Trade-In Model',
                'tradein_vin' => 'Trade-In VIN',
                'tradein_kms' => 'Trade-In KMs',
                'tradein_price' => 'Trade-In Selling Price',
            ] as $token => $label)
            <div class="field-item" data-token="{{ $token }}">
                <span class="field-label">{{ $label }}</span>
                <span class="field-tag">@{{{{ $token }}}}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Deal Information --}}
    <div class="category-container">
        <div class="category-header" data-category="deal">
            <span><i class="bi bi-file-earmark-text me-2"></i>Deal Information</span>
            <i class="bi bi-chevron-down"></i>
        </div>
        <div class="category-body" id="dealFields">
            @foreach([
                'finance_manager' => 'Finance Manager',
                'assigned_to' => 'Assigned To',
                'assigned_manager' => 'Assigned Manager',
                'secondary_assigned' => 'Secondary Assigned',
                'bdc_agent' => 'BDC Agent',
                'bdc_manager' => 'BDC Manager',
                'general_manager' => 'General Manager',
                'sales_manager' => 'Sales Manager',
                'advisor_name' => 'Advisor Name',
                'service_advisor' => 'Service Advisor',
                'source' => 'Source',
                'appointment_datetime' => 'Appointment Date/Time',
                'inventory_manager' => 'Inventory Manager',
                'warranty_expiration' => 'Warranty Expiration Date',
            ] as $token => $label)
            <div class="field-item" data-token="{{ $token }}">
                <span class="field-label">{{ $label }}</span>
                <span class="field-tag">@{{{{ $token }}}}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>