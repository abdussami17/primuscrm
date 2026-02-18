 {{-- Add Customer Form Submission --}}
 <script>
     document.addEventListener('DOMContentLoaded', function() {
         const form = document.getElementById('addCustomerForm');
         if (form) {
             let isSubmitting = false; // Flag to prevent double submission

            // Use the existing form element (don't clone — cloning clears user-entered values)
            const formElement = form;

            // Use capture-phase listener so we run before other submit handlers and can stop them
            formElement.addEventListener('submit', function(e) {
                 e.preventDefault();
                 e.stopImmediatePropagation(); // Stop other listeners

                 // Prevent double submission
                 if (isSubmitting) {
                     console.log('Form already submitting, ignoring...');
                     return false;
                 }
                 isSubmitting = true;

                 const formData = new FormData(this);
                 const submitBtn = this.querySelector('button[type="submit"]');
                 const originalText = submitBtn.textContent;

                 // Disable button immediately
                 submitBtn.disabled = true;
                 submitBtn.textContent = 'Saving...';

                 // Preserve emails[] array and also set primary `email` for compatibility
                 const emails = formData.getAll('emails[]');
                 if (emails.length > 0) {
                     // Remove any empty entries and re-append to ensure server receives the array
                     formData.delete('emails[]');
                     emails.filter(Boolean).forEach(e => formData.append('emails[]', e));
                     // also set singular `email` for backward compatibility
                     formData.set('email', emails[0]);
                 }

                 // Map form fields to backend names
                 // Handle profile image
                 if (formData.get('profileImage')) {
                     formData.append('profile_image', formData.get('profileImage'));
                     formData.delete('profileImage');
                 }

                 if (formData.get('firstName')) {
                     formData.append('first_name', formData.get('firstName'));
                     formData.delete('firstName');
                 }
                 if (formData.get('middleName')) {
                     formData.append('middle_name', formData.get('middleName'));
                     formData.delete('middleName');
                 }
                 if (formData.get('lastName')) {
                     formData.append('last_name', formData.get('lastName'));
                     formData.delete('lastName');
                 }
                 if (formData.get('cellPhone')) {
                     formData.append('cell_phone', formData.get('cellPhone'));
                     formData.delete('cellPhone');
                 }
                 if (formData.get('homePhone')) {
                     formData.append('phone', formData.get('homePhone'));
                     formData.delete('homePhone');
                 }
                 if (formData.get('workPhone')) {
                     formData.append('work_phone', formData.get('workPhone'));
                     formData.delete('workPhone');
                 }
                 if (formData.get('streetAddress')) {
                     formData.append('address', formData.get('streetAddress'));
                     formData.delete('streetAddress');
                 }
                 if (formData.get('state')) {
                     formData.append('state', formData.get('state'));
                 }
                 if (formData.get('zipCode')) {
                     formData.append('zip_code', formData.get('zipCode'));
                     formData.delete('zipCode');
                 }
                 if (formData.get('assignedTo')) {
                     formData.append('assigned_to', formData.get('assignedTo'));
                     formData.delete('assignedTo');
                 }
                 if (formData.get('financeManager')) {
                     formData.append('finance_manager', formData.get('financeManager'));
                     formData.delete('financeManager');
                 }
                 if (formData.get('inventoryType')) {
                     formData.append('inventory_type', formData.get('inventoryType'));
                     formData.delete('inventoryType');
                 }
                 if (formData.get('secondaryAssignedTo')) {
                     formData.append('secondary_assigned', formData.get('secondaryAssignedTo'));
                     formData.delete('secondaryAssignedTo');
                 }
                 if (formData.get('salesManager')) {
                     formData.append('assigned_manager', formData.get('salesManager'));
                     formData.delete('salesManager');
                 }
                 if (formData.get('bdcAgent')) {
                     formData.append('bdc_agent', formData.get('bdcAgent'));
                     formData.delete('bdcAgent');
                 }
                 if (formData.get('leadType')) {
                     formData.append('lead_type', formData.get('leadType'));
                     formData.delete('leadType');
                 }
                 if (formData.get('leadSource')) {
                     formData.append('lead_source', formData.get('leadSource'));
                     formData.delete('leadSource');
                 }
                 if (formData.get('salesType')) {
                     formData.append('sales_type', formData.get('salesType'));
                     formData.delete('salesType');
                 }
                 if (formData.get('dealType')) {
                     formData.append('deal_type', formData.get('dealType'));
                     formData.delete('dealType');
                 }
                 if (formData.get('leadStatus')) {
                     formData.append('status', formData.get('leadStatus'));
                     formData.delete('leadStatus');
                 }

                 fetch('/customers', {
                         method: 'POST',
                         headers: {
                             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                             'Accept': 'application/json',
                             'X-Requested-With': 'XMLHttpRequest'
                         },
                         credentials: 'same-origin',
                         body: formData
                     })
                     .then(response => {
                         if (!response.ok) {
                             return response.json().then(err => {
                                 throw err;
                             });
                         }
                         return response.json();
                     })
                     .then(data => {
                         if (data.success) {
                             if (typeof Swal !== 'undefined') {
                                 Swal.fire({
                                     icon: 'success',
                                     title: 'Success',
                                     text: data.message || 'Customer added successfully',
                                     timer: 2000,
                                     showConfirmButton: false
                                 });
                             }

                             // Close offcanvas
                             const offcanvas = bootstrap.Offcanvas.getInstance(document
                                 .getElementById('addCustomerCanvas'));
                             if (offcanvas) {
                                 offcanvas.hide();
                             }

                             // Reset form
                             form.reset();

                             // If the global offcanvas loader exists, open the new profile there instead of full reload
                             const newId = data.customer?.id || data?.id || null;
                             if (typeof window.openCustomerProfile === 'function' && newId) {
                                 try {
                                     // hide add-customer offcanvas first
                                     const off = bootstrap.Offcanvas.getInstance(document.getElementById('addCustomerCanvas'));
                                     if (off) off.hide();
                                 } catch (e) {}
                                 try { window.openCustomerProfile(newId); } catch (e) { setTimeout(() => location.reload(), 800); }
                             } else {
                                 // Reload page to show new customer
                                 setTimeout(() => location.reload(), 1000);
                             }
                         } else {
                             throw new Error(data.message || 'Failed to add customer');
                         }
                     })
                     .catch(error => {
                         let errorMessage = 'Something went wrong';

                         if (error.errors) {
                             const errorList = Object.values(error.errors).flat().join('<br>');
                             errorMessage = errorList;
                         } else if (error.message) {
                             errorMessage = error.message;
                         }

                         if (typeof Swal !== 'undefined') {
                             Swal.fire({
                                 icon: 'error',
                                 title: 'Error',
                                 html: errorMessage,
                                 showConfirmButton: true
                             });
                         } else {
                             alert(errorMessage);
                         }
                     })
                     .finally(() => {
                         submitBtn.disabled = false;
                         submitBtn.textContent = originalText;
                     });
            }, { capture: true }); // Re-enable submission
             isSubmitting = false;

         }
     });
 </script>

 {{-- Load Customer Profile Data --}}
 <script>
     document.addEventListener('DOMContentLoaded', function() {
         const customerLinks = document.querySelectorAll('[data-customer-id]');
         const offcanvas = document.getElementById('editVisitCanvas');

         if (customerLinks.length > 0 && offcanvas) {
             customerLinks.forEach(link => {
                 link.addEventListener('click', function(e) {
                     const customerId = this.getAttribute('data-customer-id');
                     if (customerId) {
                         loadCustomerProfile(customerId);
                     }
                 });
             });
         }

         function loadCustomerProfile(customerId) {
             console.log('Loading customer ID:', customerId);

             // Set customer ID on the offcanvas element
             offcanvas.setAttribute('data-customer-id', customerId);

             fetch(`/customers/${customerId}`, {
                     method: 'GET',
                     headers: {
                         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                         'Accept': 'application/json'
                     }
                 })
                 .then(response => response.json())
                 .then(data => {
                     if (data.success && data.customer) {
                         populateCustomerProfile(data.customer);
                     }
                 })
                 .catch(error => {
                     console.error('Error loading customer:', error);
                 });

             // Fetch and render customer deals
             if (typeof fetchCustomerDeals === 'function') {
                 fetchCustomerDeals(customerId);
             }
         }

         function populateCustomerProfile(customer) {
             console.log('Populating profile for:', customer);
             console.log('Profile image path:', customer.profile_image);

             // Update profile picture
             const profileImage = offcanvas.querySelector('#customerProfileImage');
             if (profileImage) {
                 if (customer.profile_image) {
                     // The path is stored as 'uploads/customers/filename.jpg' in database
                     const imagePath = customer.profile_image.startsWith('/') ?
                         customer.profile_image :
                         `/${customer.profile_image}`;
                     profileImage.src = imagePath;
                     console.log('Setting image src to:', imagePath);
                 } else {
                     // Default avatar with customer initials
                     const firstName = customer.first_name || '';
                     const lastName = customer.last_name || '';
                     const initials = (firstName[0] || '') + (lastName[0] || '');
                     profileImage.src =
                         `https://ui-avatars.com/api/?name=${encodeURIComponent(firstName + ' ' + lastName)}&background=0D8ABC&color=fff&size=100`;
                     console.log('No profile image, using avatar for:', firstName, lastName);
                 }
             }

             // Update name fields
             const firstNameInput = offcanvas.querySelector('input[name="firstName"]');
             const middleNameInput = offcanvas.querySelector('input[name="middleName"]');
             const lastNameInput = offcanvas.querySelector('input[name="lastName"]');

             if (firstNameInput) {
                 firstNameInput.value = customer.first_name || '';
                 console.log('Set first name:', customer.first_name);
             }
             if (middleNameInput) {
                 middleNameInput.value = customer.middle_name || '';
                 console.log('Set middle name:', customer.middle_name);
             }
             if (lastNameInput) {
                 lastNameInput.value = customer.last_name || '';
                 console.log('Set last name:', customer.last_name);
             }

             // Update address
             const locationInput = offcanvas.querySelector('#customer_location');
             if (locationInput) {
                 const fullAddress = [
                     customer.address,
                     customer.city,
                     customer.state,
                     customer.zip_code
                 ].filter(Boolean).join(', ');
                 locationInput.value = fullAddress || '';
                 console.log('Set address:', fullAddress);
             }

             // Update phone numbers
             const cellPhoneInput = offcanvas.querySelector('#cellPhone');
             const workPhoneInput = offcanvas.querySelector('#workPhone');
             const homePhoneInput = offcanvas.querySelector('#homePhone');

             if (cellPhoneInput) {
                 cellPhoneInput.value = customer.cell_phone || '';
                 const cellPhoneGroup = cellPhoneInput.closest('.input-group');
                 if (cellPhoneGroup && customer.cell_phone) {
                     const callLink = cellPhoneGroup.querySelector('a[title="Call"]');
                     const textLink = cellPhoneGroup.querySelector('a[title="Text"]');
                     if (callLink) callLink.href = `tel:${customer.cell_phone}`;
                     if (textLink) textLink.href = `sms:${customer.cell_phone}`;
                 }
             }

             if (workPhoneInput) {
                 workPhoneInput.value = customer.work_phone || '';
                 const workPhoneGroup = workPhoneInput.closest('.input-group');
                 if (workPhoneGroup && customer.work_phone) {
                     const callLink = workPhoneGroup.querySelector('a[title="Call"]');
                     if (callLink) callLink.href = `tel:${customer.work_phone}`;
                 }
             }

             if (homePhoneInput) {
                 homePhoneInput.value = customer.phone || '';
                 const homePhoneGroup = homePhoneInput.closest('.input-group');
                 if (homePhoneGroup && customer.phone) {
                     const callLink = homePhoneGroup.querySelector('a[title="Call"]');
                     if (callLink) callLink.href = `tel:${customer.phone}`;
                 }
             }

             // Update email
             const emailInput = offcanvas.querySelector('#emailInput');
             if (emailInput) {
                 emailInput.value = customer.email || '';
                 console.log('Set email:', customer.email);
             }

             // Get co-buyer fields
             const coBuyerCollapse = offcanvas.querySelector('#coBuyerFields');
             const coFirstName = offcanvas.querySelector('input[name="co_buyer_first_name"]');
             const coMiddleName = offcanvas.querySelector('input[name="co_buyer_middle_name"]');
             const coLastName = offcanvas.querySelector('input[name="co_buyer_last_name"]');
             const coEmail = offcanvas.querySelector('input[name="co_buyer_email"]');
             const coCellNumber = offcanvas.querySelector('input[name="co_buyer_cell_phone"]');
             const coWorkNumber = offcanvas.querySelector('input[name="co_buyer_work_phone"]');
             const coHomeNumber = offcanvas.querySelector('input[name="co_buyer_phone"]');
             const coStreetAddress = offcanvas.querySelector('input[name="co_buyer_address"]');
             const coCity = offcanvas.querySelector('input[name="co_buyer_city"]');
             const coState = offcanvas.querySelector('input[name="co_buyer_state"]');
             const coZipCode = offcanvas.querySelector('input[name="co_buyer_zip_code"]');

             // Always clear co-buyer fields first
             if (coFirstName) coFirstName.value = '';
             if (coMiddleName) coMiddleName.value = '';
             if (coLastName) coLastName.value = '';
             if (coEmail) coEmail.value = '';
             if (coCellNumber) coCellNumber.value = '';
             if (coWorkNumber) coWorkNumber.value = '';
             if (coHomeNumber) coHomeNumber.value = '';
             if (coStreetAddress) coStreetAddress.value = '';
             if (coCity) coCity.value = '';
             if (coState) coState.value = '';
             if (coZipCode) coZipCode.value = '';

             // Update co-buyer information if available
             if (customer.co_buyer && (customer.co_buyer.first_name || customer.co_buyer.last_name || customer
                     .co_buyer.email)) {
                 if (coBuyerCollapse) {
                     // Show the co-buyer section
                     const bsCollapse = new bootstrap.Collapse(coBuyerCollapse, {
                         toggle: false
                     });
                     bsCollapse.show();

                     // Populate co-buyer fields
                     if (coFirstName) coFirstName.value = customer.co_buyer.first_name || '';
                     if (coMiddleName) coMiddleName.value = customer.co_buyer.middle_name || '';
                     if (coLastName) coLastName.value = customer.co_buyer.last_name || '';
                     if (coEmail) coEmail.value = customer.co_buyer.email || '';
                     if (coCellNumber) coCellNumber.value = customer.co_buyer.cell_phone || '';
                     if (coWorkNumber) coWorkNumber.value = customer.co_buyer.work_phone || '';
                     if (coHomeNumber) coHomeNumber.value = customer.co_buyer.phone || '';
                     if (coStreetAddress) coStreetAddress.value = customer.co_buyer.address || '';
                     if (coCity) coCity.value = customer.co_buyer.city || '';
                     if (coState) coState.value = customer.co_buyer.state || '';
                     if (coZipCode) coZipCode.value = customer.co_buyer.zip_code || '';

                     console.log('Co-buyer data loaded');
                 }
             } else {
                 // Hide co-buyer section if no data
                 if (coBuyerCollapse && coBuyerCollapse.classList.contains('show')) {
                     const bsCollapse = new bootstrap.Collapse(coBuyerCollapse, {
                         toggle: false
                     });
                     bsCollapse.hide();
                 }
             }

             // Load social media links
             if (typeof loadCustomerSocialLinks === 'function') {
                 loadCustomerSocialLinks(customer);
             }

             // Store customer ID for future updates
             offcanvas.setAttribute('data-current-customer-id', customer.id);

             console.log('Customer profile loaded successfully');
         }
     });
 </script>

 {{-- Update Customer from Offcanvas --}}
 <script>
     document.addEventListener('DOMContentLoaded', function() {
         const updateBtn = document.getElementById('updateCustomerBtn');
         const offcanvas = document.getElementById('editVisitCanvas');

         if (updateBtn && offcanvas) {
             let isSubmitting = false; // Flag to prevent double submission

             // Remove existing listeners by cloning the button
             const newBtn = updateBtn.cloneNode(true);
             updateBtn.parentNode.replaceChild(newBtn, updateBtn);
             const updateButton = document.getElementById('updateCustomerBtn');

             updateButton.addEventListener('click', function(e) {
                 e.preventDefault();
                 e.stopImmediatePropagation(); // Stop other listeners

                 // Prevent double submission
                 if (isSubmitting) {
                     console.log('Update already in progress, ignoring...');
                     return false;
                 }
                 isSubmitting = true;

                 const customerId = offcanvas.getAttribute('data-current-customer-id');
                 if (!customerId) {
                     if (typeof Swal !== 'undefined') {
                         Swal.fire({
                             icon: 'error',
                             title: 'Error',
                             text: 'No customer loaded',
                         });
                     } else {
                         alert('No customer loaded');
                     }
                     return;
                 }

                 // Collect form data
                 const formData = new FormData();
                 // Profile image
                 const profileImageInput = offcanvas.querySelector('#profileImageInput');
                 if (profileImageInput && profileImageInput.files.length > 0) {
                     formData.append('profile_image', profileImageInput.files[0]);
                 }
                 // Customer basic info
                 const firstName = offcanvas.querySelector('input[name="firstName"]')?.value;
                 const middleName = offcanvas.querySelector('input[name="middleName"]')?.value;
                 const lastName = offcanvas.querySelector('input[name="lastName"]')?.value;
                 const emailInput = offcanvas.querySelector('#emailInput')?.value;
                 const cellPhoneInput = offcanvas.querySelector('#cellPhone')?.value;
                 const workPhoneInput = offcanvas.querySelector('#workPhone')?.value;
                 const homePhoneInput = offcanvas.querySelector('#homePhone')?.value;

                 formData.append('first_name', firstName || '');
                 formData.append('middle_name', middleName || '');
                 formData.append('last_name', lastName || '');
                 formData.append('email', emailInput || '');
                 formData.append('phone', homePhoneInput || '');
                 formData.append('cell_phone', cellPhoneInput || '');
                 formData.append('work_phone', workPhoneInput || '');

                 // Co-buyer info
                 const coBuyerFirstName = offcanvas.querySelector('input[name="co_buyer_first_name"]')
                     ?.value;
                 const coBuyerMiddleName = offcanvas.querySelector('input[name="co_buyer_middle_name"]')
                     ?.value;
                 const coBuyerLastName = offcanvas.querySelector('input[name="co_buyer_last_name"]')
                     ?.value;
                 const coBuyerEmail = offcanvas.querySelector('input[name="co_buyer_email"]')?.value;
                 const coBuyerCellPhone = offcanvas.querySelector('input[name="co_buyer_cell_phone"]')
                     ?.value;
                 const coBuyerWorkPhone = offcanvas.querySelector('input[name="co_buyer_work_phone"]')
                     ?.value;
                 const coBuyerPhone = offcanvas.querySelector('input[name="co_buyer_phone"]')?.value;
                 const coBuyerAddress = offcanvas.querySelector('input[name="co_buyer_address"]')?.value;
                 const coBuyerCity = offcanvas.querySelector('input[name="co_buyer_city"]')?.value;
                 const coBuyerState = offcanvas.querySelector('input[name="co_buyer_state"]')?.value;
                 const coBuyerZipCode = offcanvas.querySelector('input[name="co_buyer_zip_code"]')
                     ?.value;

                 if (coBuyerFirstName) formData.append('co_buyer_first_name', coBuyerFirstName);
                 if (coBuyerMiddleName) formData.append('co_buyer_middle_name', coBuyerMiddleName);
                 if (coBuyerLastName) formData.append('co_buyer_last_name', coBuyerLastName);
                 if (coBuyerEmail) formData.append('co_buyer_email', coBuyerEmail);
                 if (coBuyerCellPhone) formData.append('co_buyer_cell_phone', coBuyerCellPhone);
                 if (coBuyerWorkPhone) formData.append('co_buyer_work_phone', coBuyerWorkPhone);
                 if (coBuyerPhone) formData.append('co_buyer_phone', coBuyerPhone);
                 if (coBuyerAddress) formData.append('co_buyer_address', coBuyerAddress);
                 if (coBuyerCity) formData.append('co_buyer_city', coBuyerCity);
                 if (coBuyerState) formData.append('co_buyer_state', coBuyerState);
                 if (coBuyerZipCode) formData.append('co_buyer_zip_code', coBuyerZipCode);

                 formData.append('_method', 'PUT');

                 // Show loading state
                 const originalText = updateButton.textContent;
                 updateButton.disabled = true;
                 updateButton.textContent = 'Saving...';

                 fetch(`/customers/${customerId}`, {
                         method: 'POST',
                         headers: {
                             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                 .content,
                             'Accept': 'application/json'
                         },
                         body: formData
                     })
                     .then(response => {
                         if (!response.ok) {
                             return response.json().then(err => {
                                 throw err;
                             });
                         }
                         return response.json();
                     })
                     .then(data => {
                         if (data.success) {
                             if (typeof Swal !== 'undefined') {
                                 Swal.fire({
                                     icon: 'success',
                                     title: 'Success',
                                     text: data.message || 'Customer updated successfully',
                                     timer: 2000,
                                     showConfirmButton: false
                                 });
                             }

                             // Close offcanvas
                             const bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvas) ||
                                 bootstrap.Offcanvas.getOrCreateInstance(offcanvas);
                             bsOffcanvas.hide();

                             // Reload page to show updated customer
                             setTimeout(() => location.reload(), 1000);
                         } else {
                             throw new Error(data.message || 'Failed to update customer');
                         }
                     })
                     .catch(error => {
                         let errorMessage = 'Something went wrong';

                         if (error.errors) {
                             const errorList = Object.values(error.errors).flat().join('<br>');
                             errorMessage = errorList;
                         } else if (error.message) {
                             errorMessage = error.message;
                         }

                         if (typeof Swal !== 'undefined') {
                             Swal.fire({
                                 icon: 'error',
                                 title: 'Error',
                                 html: errorMessage,
                                 showConfirmButton: true
                             });
                         } else {
                             alert(errorMessage);
                         }
                     })
                     .finally(() => {
                         updateButton.disabled = false;
                         updateButton.textContent = originalText;
                         isSubmitting = false; // Re-enable submission
                     });
             });
         }
     });
 </script>

 {{-- Profile Image Preview --}}
 <script>
     document.addEventListener('DOMContentLoaded', function() {
         // Preview image on edit profile
         const profileImageInput = document.getElementById('profileImageInput');
         if (profileImageInput) {
             profileImageInput.addEventListener('change', function(e) {
                 const file = e.target.files[0];
                 if (file) {
                     const reader = new FileReader();
                     reader.onload = function(e) {
                         const img = document.getElementById('customerProfileImage');
                         if (img) {
                             img.src = e.target.result;
                         }
                     };
                     reader.readAsDataURL(file);
                 }
             });
         }

         // Preview image on add customer
         const addProfileImage = document.getElementById('profileImage');
         if (addProfileImage) {
             addProfileImage.addEventListener('change', function(e) {
                 const file = e.target.files[0];
                 if (file) {
                     // Validate file size (max 2MB)
                     if (file.size > 2 * 1024 * 1024) {
                         if (typeof Swal !== 'undefined') {
                             Swal.fire({
                                 icon: 'error',
                                 title: 'File Too Large',
                                 text: 'Profile image must be less than 2MB',
                                 toast: true,
                                 position: 'top-end',
                                 showConfirmButton: false,
                                 timer: 3000
                             });
                         } else {
                             alert('Profile image must be less than 2MB');
                         }
                         this.value = '';
                     }
                 }
             });
         }
     });
 </script>
