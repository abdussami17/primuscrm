{{-- Edit Deal Modal - resources/views/customers/modals/edit-deal.blade.php --}}

@props(['customerId', 'users' => []])

<div id="editDealModal" class="modal fade" style="z-index:9999!important;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Deal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editDealForm" data-deal-id="">
                    @csrf
                    <input type="hidden" name="customer_id" value="{{ $customerId }}">
                    <input type="hidden" name="inventory_id" id="editDealInventoryId">
                    
                    <div class="border rounded p-3 bg-light mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <label class="form-label fw-semibold mb-1">Selected Vehicle</label>
                                <p class="mb-0 text-success fw-semibold" id="editSelectedVehicleDisplay">No vehicle selected</p>
                            </div>
                            <button type="button" 
                                    class="btn btn-outline-primary btn-sm"
                                    onclick="changeVehicleFromEditModal()">
                                <i class="ti ti-switch-horizontal me-1"></i>Change
                            </button>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Deal Number</label>
                            <input type="text" class="form-control" name="deal_number" id="editDealNumber" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" name="status" id="editDealStatus" required>
                                @foreach(['Active', 'Pending F&I', 'Sold', 'Delivered', 'Lost'] as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Lead Type</label>
                            <select class="form-select" name="lead_type" id="editDealLeadType">
                                <option value="">Select</option>
                                @foreach(['Walk-In', 'Phone', 'Internet', 'Referral'] as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Inventory Type</label>
                            <select class="form-select" name="inventory_type" id="editDealInventoryType">
                                <option value="">Select</option>
                                @foreach(['New', 'Used', 'CPO'] as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Vehicle Description</label>
                            <input type="text" class="form-control" name="vehicle_description" id="editDealVehicleDescription">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Price</label>
                            <input type="number" step="0.01" class="form-control" name="price" id="editDealPrice">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Down Payment</label>
                            <input type="number" step="0.01" class="form-control" name="down_payment" id="editDealDownPayment">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Trade-In Value</label>
                            <input type="number" step="0.01" class="form-control" name="trade_in_value" id="editDealTradeInValue">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Sales Person</label>
                            <select class="form-select" name="sales_person_id" id="editDealSalesPerson">
                                <option value="">Select</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Sales Manager</label>
                            <select class="form-select" name="sales_manager_id" id="editDealSalesManager">
                                <option value="">Select</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Finance Manager</label>
                            <select class="form-select" name="finance_manager_id" id="editDealFinanceManager">
                                <option value="">Select</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Deal Type</label>
                            <select class="form-select" name="deal_type" id="editDealType">
                                @foreach(['cash' => 'Cash', 'lease' => 'Lease', 'finance' => 'Finance', 'unknown' => 'Unknown'] as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" name="notes" id="editDealNotes" rows="2"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="editDealForm" class="btn btn-primary">Update Deal</button>
            </div>
        </div>
    </div>
</div>

<script>

// Handle edit deal form submission
document.getElementById('editDealForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const dealId = this.getAttribute('data-deal-id');
    if (!dealId) {
        showToast('Deal ID not found', 'error');
        return;
    }
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());
    
    // Remove CSRF token from data (not needed for API)
    delete data._token;
    
    try {
        await api(`/api/deals/${dealId}`, 'PUT', data);
        showToast('Deal updated successfully');
        
        // Close the modal
        bootstrap.Modal.getInstance(document.getElementById('editDealModal')).hide();
        
        // Refresh the vehicle partial section
        refreshVehiclePartial(dealId);
        
        // Optionally refresh the deals list if it exists
        if (typeof loadDeals === 'function') {
            loadDeals();
        }
        
    } catch (error) {
        showToast(error.message || 'Failed to update deal', 'error');
    }
});

// Function to change vehicle from edit modal
function changeVehicleFromEditModal() {
    const dealId = document.getElementById('editDealForm').getAttribute('data-deal-id');
    
    // Close edit modal
    bootstrap.Modal.getInstance(document.getElementById('editDealModal')).hide();
    
    // Set the deal ID for inventory modal
    document.getElementById('inventoryEditDealId').value = dealId;
    
    // Open inventory modal
    const inventoryModal = document.getElementById('gotoinventoryModal');
    document.getElementById('inventoryModalTitle').textContent = 'Select Vehicle for Deal';
    document.getElementById('skipVehicleBtn').style.display = 'none';
    
    bootstrap.Modal.getOrCreateInstance(inventoryModal).show();
}

// Function to open edit deal modal directly (can be called from deal list)
async function openEditDealModalById(dealId) {
    try {
        const result = await api(`/api/deals/${dealId}`);
        const deal = result.data || result.deal || result;
        
        const form = document.getElementById('editDealForm');
        form.setAttribute('data-deal-id', dealId);
        
        // Populate all fields
        document.getElementById('editDealInventoryId').value = deal.inventory_id || '';
        document.getElementById('editDealVehicleDescription').value = deal.vehicle_description || '';
        document.getElementById('editDealPrice').value = deal.price || '';
        document.getElementById('editDealType').value = deal.deal_type || 'unknown';
        document.getElementById('editSelectedVehicleDisplay').textContent = 
            deal.vehicle_description || (deal.vehicle ? 
                `${deal.vehicle.year} ${deal.vehicle.make} ${deal.vehicle.model}` : 
                'No vehicle selected');
        
        document.getElementById('editDealNumber').value = deal.deal_number || '';
        document.getElementById('editDealStatus').value = deal.status || 'Active';
        document.getElementById('editDealLeadType').value = deal.lead_type || '';
        document.getElementById('editDealInventoryType').value = deal.inventory_type || '';
        document.getElementById('editDealDownPayment').value = deal.down_payment || '';
        document.getElementById('editDealTradeInValue').value = deal.trade_in_value || '';
        document.getElementById('editDealSalesPerson').value = deal.sales_person_id || '';
        document.getElementById('editDealSalesManager').value = deal.sales_manager_id || '';
        document.getElementById('editDealFinanceManager').value = deal.finance_manager_id || '';
        document.getElementById('editDealNotes').value = deal.notes || '';
        
        bootstrap.Modal.getOrCreateInstance(
            document.getElementById('editDealModal')
        ).show();
        
    } catch (error) {
        console.error('Failed to load deal:', error);
        showToast('Failed to load deal data', 'error');
    }
}
</script>