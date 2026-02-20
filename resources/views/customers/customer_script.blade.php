
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
