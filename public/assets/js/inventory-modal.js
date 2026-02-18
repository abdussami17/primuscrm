// Inventory Modal for Deals - Dynamic Loading

let availableInventory = [];
let selectedInventoryForDeal = null;

/**
 * Load inventory when modal is opened
 */
document.addEventListener('DOMContentLoaded', function() {
    const inventoryModal = document.getElementById('gotoinventoryModal');
    
    if (inventoryModal) {
        inventoryModal.addEventListener('show.bs.modal', function() {
            loadInventoryForModal();
        });
    }
    
    // Search in modal
    const modalSearchInput = document.querySelector('#gotoinventoryModal input[type="text"]');
    if (modalSearchInput) {
        modalSearchInput.addEventListener('input', function(e) {
            searchInventoryInModal(e.target.value);
        });
    }
});

/**
 * Fetch available inventory for the modal
 */
function loadInventoryForModal() {
    fetch('/api/inventory/available')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                availableInventory = data.inventory || [];
                renderInventoryModal(availableInventory);
            }
        })
        .catch(error => {
            console.error('Error loading inventory:', error);
        });
}

/**
 * Render inventory items in the modal
 */
function renderInventoryModal(inventory) {
    const container = document.querySelector('#gotoinventoryModal .go-to-inventory');
    
    if (!container) return;
    
    container.innerHTML = '';
    
    // Update count
    const countText = document.querySelector('#gotoinventoryModal .vehicle-search-record_text');
    if (countText) {
        const total = inventory.length;
        const showing = Math.min(10, total);
        countText.textContent = `Vehicles (1-${showing}) OF ${total}`;
    }
    
    if (inventory.length === 0) {
        container.innerHTML = '<p class="text-center text-muted py-4">No vehicles available in inventory.</p>';
        return;
    }
    
    // Show first 10 items
    const itemsToShow = inventory.slice(0, 10);
    
    itemsToShow.forEach(item => {
        const vehicleCard = createInventoryCard(item);
        container.appendChild(vehicleCard);
    });
}

/**
 * Create an inventory card for the modal
 */
function createInventoryCard(item) {
    const card = document.createElement('div');
    card.className = 'row bg-light border border-1 g-2 p-2';
    card.setAttribute('data-inventory-id', item.id);
    
    // Get first image or use placeholder
    const image = item.images && item.images.length > 0 ? item.images[0] : '/assets/img/car-detail/1.jpg';
    
    // Format price
    const price = parseFloat(item.price).toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2
    });
    
    // Build vehicle details
    const details = [];
    if (item.stock_number) details.push(`Stock #: ${item.stock_number}`);
    if (item.fuel_type) details.push(`Fuel: ${item.fuel_type}`);
    if (item.vin) details.push(`VIN: ${item.vin}`);
    if (item.mileage) details.push(`Odometer: ${item.mileage.toLocaleString()}`);
    if (item.transmission) details.push(`Transmission: ${item.transmission}`);
    if (item.engine) details.push(`Engine: ${item.engine}`);
    if (item.exterior_color) details.push(`Exterior Color: ${item.exterior_color}`);
    if (item.interior_color) details.push(`Interior Color: ${item.interior_color}`);
    if (item.location) details.push(`Lot Location: ${item.location}`);
    
    const detailsText = details.join(' | ');
    
    // Full vehicle name
    const vehicleName = `${item.year} ${item.make} ${item.model}${item.trim ? ' ' + item.trim : ''}`;
    
    card.innerHTML = `
        <div class="col-md-2">
            <img src="${image}" alt="${vehicleName}" style="width: 100%; height: auto;" onerror="this.src='/assets/img/car-detail/1.jpg'">
        </div>
        <div class="col-md-8">
            <h6>${vehicleName}</h6>
            <p class="text-success mb-0">${price}</p>
            <p class="mb-0" style="font-size: 14px;">${detailsText}</p>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary" onclick="selectInventoryForDeal(${item.id})">ADD VEHICLE</button>
        </div>
    `;
    
    return card;
}

/**
 * Select an inventory item for a deal
 */
function selectInventoryForDeal(inventoryId) {
    const inventory = availableInventory.find(item => item.id === inventoryId);
    
    if (!inventory) {
        alert('Inventory item not found');
        return;
    }
    
    selectedInventoryForDeal = inventory;
    
    // Force close the inventory modal completely
    const inventoryModalElement = document.getElementById('gotoinventoryModal');
    
    // Hide using Bootstrap
    const inventoryModal = bootstrap.Modal.getInstance(inventoryModalElement);
    if (inventoryModal) {
        inventoryModal.hide();
    }
    
    // Force hide the modal element
    if (inventoryModalElement) {
        inventoryModalElement.classList.remove('show');
        inventoryModalElement.style.display = 'none';
        inventoryModalElement.setAttribute('aria-hidden', 'true');
        inventoryModalElement.removeAttribute('aria-modal');
    }
    
    // Remove all modal backdrops and reset body
    const removeAllModals = () => {
        // Remove all backdrops
        document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
            backdrop.remove();
        });
        
        // Hide all other modals
        document.querySelectorAll('.modal.show').forEach(modal => {
            if (modal.id !== 'addDealModal') {
                modal.classList.remove('show');
                modal.style.display = 'none';
            }
        });
        
        // Reset body
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
    };
    
    // Execute immediately
    removeAllModals();
    
    // Wait a bit then populate and open deal modal
    setTimeout(() => {
        // Double check everything is clean
        removeAllModals();
        
        populateDealFormWithInventory(inventory);
        
        // Open the add deal modal
        const addDealModalElement = document.getElementById('addDealModal');
        
        if (!addDealModalElement) {
            console.error('Add Deal Modal element not found!');
            alert('Error: Deal modal not found on this page.');
            return;
        }
        
        try {
            const addDealModal = new bootstrap.Modal(addDealModalElement, {
                backdrop: true,
                keyboard: true
            });
            addDealModal.show();
            
            // Ensure backdrop and modal are on top
            setTimeout(() => {
                const backdrops = document.querySelectorAll('.modal-backdrop');
                backdrops.forEach(backdrop => {
                    backdrop.style.zIndex = '9998';
                });
                addDealModalElement.style.zIndex = '9999';
            }, 50);
        } catch (error) {
            console.error('Error opening deal modal:', error);
            alert('Error opening deal modal: ' + error.message);
        }
    }, 200);
}

/**
 * Populate deal form with selected inventory
 */
function populateDealFormWithInventory(inventory) {
    // Set inventory_id
    const inventoryIdField = document.getElementById('dealInventoryId');
    if (inventoryIdField) {
        inventoryIdField.value = inventory.id;
    }
    
    // Set vehicle description
    const vehicleDescription = `${inventory.year} ${inventory.make} ${inventory.model}${inventory.trim ? ' ' + inventory.trim : ''}`;
    const vehicleDescField = document.getElementById('dealVehicleDescription');
    if (vehicleDescField) {
        vehicleDescField.value = vehicleDescription;
    }
    
    // Update selected vehicle display
    const vehicleDisplay = document.getElementById('selectedVehicleDisplay');
    if (vehicleDisplay) {
        vehicleDisplay.textContent = vehicleDescription;
    }
    
    // Set price
    const priceField = document.getElementById('dealPrice');
    if (priceField) {
        priceField.value = inventory.price;
    }
    
    // Set inventory type based on condition
    const inventoryTypeField = document.getElementById('dealInventoryType');
    if (inventoryTypeField) {
        const conditionMap = {
            'new': 'New',
            'used': 'Used',
            'certified_pre_owned': 'CPO'
        };
        inventoryTypeField.value = conditionMap[inventory.condition] || 'New';
    }
    
    console.log('Inventory selected for deal:', inventory);
}

/**
 * Search inventory in modal
 */
function searchInventoryInModal(searchTerm) {
    if (!searchTerm) {
        renderInventoryModal(availableInventory);
        return;
    }
    
    const searchLower = searchTerm.toLowerCase();
    const filtered = availableInventory.filter(item => {
        return (
            (item.stock_number && item.stock_number.toLowerCase().includes(searchLower)) ||
            (item.vin && item.vin.toLowerCase().includes(searchLower)) ||
            (item.make && item.make.toLowerCase().includes(searchLower)) ||
            (item.model && item.model.toLowerCase().includes(searchLower)) ||
            (item.year && item.year.toString().includes(searchLower))
        );
    });
    
    renderInventoryModal(filtered);
}

/**
 * Get selected inventory for current deal
 */
function getSelectedInventory() {
    return selectedInventoryForDeal;
}

/**
 * Clear selected inventory
 */
function clearSelectedInventory() {
    selectedInventoryForDeal = null;
}
