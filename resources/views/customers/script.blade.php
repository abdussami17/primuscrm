<style>
    /* Ensure various toast libraries render above Bootstrap modals/backdrops */
    .toast,
    .toast-container,
    .toast-top-right,
    .toast-top-left,
    .toastr,
    .toastify,
    .bs-toast,
    #toast-container,
    .iziToast,
    .toastify__toast {
        z-index: 20000 !important;
    }

    .swal2-container,
    .swal2-toast,
    .swal2-popup,
    .swal2-modal {
        z-index: 20000 !important;
    }

    /* Ensure toast text is readable against background */
    .toast .toast-body,
    .toast-body,
    .alert.position-fixed,
    .toastify__toast,
    .toastr,
    .iziToast {
        color: #000 !important;
    }

    .bg-success.text-white,
    .bg-danger.text-white {
        color: #fff !important;
        /* leave explicit white classes alone */
    }
</style>

<script>
    // Helper: safely hide a bootstrap modal by id or element
    function safeHideModalById(modalId) {
        try {
            const modalEl = document.getElementById(modalId);
            if (!modalEl) return;
            const inst = bootstrap?.Modal?.getInstance(modalEl) || null;
            if (inst?.hide) inst.hide();
        } catch (e) {
            // silently fail
        }
    }

    // Helper: process a JSON API response object and show toast; optionally hide modal
    function processApiResponse(resObj, successMessage = 'Saved successfully', modalId = null) {
        try {
            if (!resObj) {
                showToast('An unexpected error occurred', 'error');
                return false;
            }

            const ok = resObj.success === true || String(resObj.success) === 'true';
            if (ok) {
                showToast(successMessage, 'success');
                if (modalId) safeHideModalById(modalId);
                return true;
            }

            const msg = resObj.message || resObj.error || (resObj.errors && Object.values(resObj.errors).flat()[0]) || 'Request failed';
            showToast(msg, 'error');
            return false;
        } catch {
            showToast('Request failed', 'error');
            return false;
        }
    }

    // Store current customer and deals
    let currentCustomerId = '';
    let currentDeals = [];

    // Show Deals Modal
    function showDealsModal(customerName, customerId) {
        currentCustomerId = customerId;
        const id = customerId.replace('customer-', '');
        const modalCustomerNameEl = document.getElementById('modalCustomerName');
        const totalDealsCountEl = document.getElementById('totalDealsCount');
        if (modalCustomerNameEl) modalCustomerNameEl.textContent = customerName;
        if (totalDealsCountEl) totalDealsCountEl.textContent = '...';

        const tbody = document.getElementById('dealsTableBody');
        if (tbody) {
            tbody.innerHTML = '<tr><td colspan="11" class="text-center py-4"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div> Loading deals...</td></tr>';
        }

        const modalEl = document.getElementById('customerDealsModal');
        if (modalEl) new bootstrap.Modal(modalEl).show();

        fetch(`/customers/${id}/deals`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success && data.deals) {
                currentDeals = data.deals;
                renderDeals(currentDeals);
                if (totalDealsCountEl) totalDealsCountEl.textContent = currentDeals.length;
            } else if (tbody) {
                tbody.innerHTML = '<tr><td colspan="11" class="text-center py-4 text-danger">Failed to load deals</td></tr>';
            }
        })
        .catch(error => {
            if (tbody) tbody.innerHTML = `<tr><td colspan="11" class="text-center py-4 text-danger">Error loading deals: ${error.message}</td></tr>`;
        });
    }

    // Render deals table
    function renderDeals(deals) {
        const tbody = document.getElementById('dealsTableBody');
        const noDealsMsg = document.getElementById('noDealsMessage');
        if (!tbody) return;

        if (deals.length === 0) {
            tbody.innerHTML = '';
            noDealsMsg.classList.remove('d-none');
            document.getElementById('visibleDealsCount').textContent = '0';
            return;
        }

        noDealsMsg.classList.add('d-none');
        document.getElementById('visibleDealsCount').textContent = deals.length;

        tbody.innerHTML = deals.map(deal => {
            const statusBadge = {
                'sold': 'bg-success',
                'pending': 'bg-warning text-dark',
                'negotiation': 'bg-info',
                'lost': 'bg-danger',
                'cancelled': 'bg-secondary'
            }[deal.status] || 'bg-secondary';

            const inventoryBadge = deal.inventory_type === 'new' ? 'bg-primary' : 'bg-secondary';
            const createdDate = deal.created_at ? new Date(deal.created_at).toLocaleDateString() : '-';
            const soldDate = deal.sold_date ? new Date(deal.sold_date).toLocaleDateString() : '-';
            const price = deal.price ? `$${parseFloat(deal.price).toLocaleString()}` : '-';
            const customerEmail = deal.customer?.email || '-';
            const customerCity = deal.customer?.city || '-';

            return `
<tr>
<td class="fw-semibold text-primary">
    <a href="javascript:void(0);" 
       class="addTaskBtn" 
       data-deal-id="${deal.id}"
       data-customer-id="${deal.customer?.id || ''}" 
       data-customer-name="${deal.customer?.first_name || ''} ${deal.customer?.last_name || ''}">
        <i class="ti ti-copy-plus"></i>
    </a>
</td>
<td>${customerEmail}</td>
<td>${customerCity}</td>
<td>${deal.deal_number || '-'}</td>
<td><span class="badge bg-light border border-1 text-dark">${deal.lead_type ? deal.lead_type.charAt(0).toUpperCase() + deal.lead_type.slice(1) : '-'}</span></td>
<td><span class="badge ${statusBadge}">${deal.status ? deal.status.charAt(0).toUpperCase() + deal.status.slice(1) : '-'}</span></td>
<td><span class="badge ${inventoryBadge}">${deal.inventory_type ? deal.inventory_type.toUpperCase() : '-'}</span></td>
<td>${deal.vehicle_description || '-'}</td>
<td class="fw-semibold">${price}</td>
<td>${createdDate}</td>
<td>${soldDate}</td>
</tr>
            `;
        }).join('');
    }

    // Add Task button click
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.addTaskBtn');
        if (!btn) return;

        const customerId = btn.getAttribute('data-customer-id');
        const customerName = btn.getAttribute('data-customer-name');
        const dealId = btn.getAttribute('data-deal-id');

        const addTaskModalEl = document.getElementById('addTaskModal');

        if (!addTaskModalEl) return;

        addTaskModalEl.querySelector('input[name="customer_search"]').value = customerName;
        addTaskModalEl.querySelector('input[name="customer_id"]').value = customerId;
        addTaskModalEl.querySelector('input[name="deal_id"]').value = dealId;

        // Show Add Task modal above current modal without backdrop
        const addTaskInstance = bootstrap.Modal.getInstance(addTaskModalEl) 
                                || new bootstrap.Modal(addTaskModalEl, { backdrop: false, focus: true });
        addTaskInstance.show();
    });

    // Phone scripts DB
    const phoneScriptsDB = [
        { id: "s1", name: "Follow-up Call", body: "Hi, I'm calling to follow up on your recent inquiry..." },
        { id: "s2", name: "Sales Introduction", body: "Hello! I wanted to tell you about our latest offers..." },
        { id: "s3", name: "Service Reminder", body: "Good morning! Your vehicle is due for maintenance..." },
        { id: "s4", name: "Feedback Request", body: "Hi there! We'd love to hear about your experience..." },
        { id: "s5", name: "Appointment Confirmation", body: "Thank you for scheduling with us. Your appointment is..." }
    ];

    // Initialize TomSelect for phone scripts
    function initPhoneScriptTomSelect() {
        const selectEl = document.querySelector('#phoneScriptSelectModal');
        if (!selectEl) return;

        selectEl.innerHTML = phoneScriptsDB.map(s => `<option value="${s.id}">${s.name}</option>`).join('');

        if (typeof TomSelect !== 'undefined' && !selectEl.tomselect && !window.phoneScriptSelect) {
            window.phoneScriptSelect = new TomSelect("#phoneScriptSelectModal", {
                options: phoneScriptsDB.map(s => ({ value: s.id, text: s.name })),
                items: [],
                maxItems: 1,
                placeholder: "Search & select script...",
                searchField: 'text',
                allowEmptyOption: true,
                closeAfterSelect: true
            });
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        initPhoneScriptTomSelect();
        const addTaskModalEl = document.getElementById('addTaskModal');
        if (addTaskModalEl) {
            addTaskModalEl.addEventListener('show.bs.modal', initPhoneScriptTomSelect);
        }
    });
</script>

<script>
    // Delegated fallback: handle clicks on the "Not in Stock? Add Manually" button
    document.addEventListener('click', function(e) {
        try {
            const btn = e.target.closest && e.target.closest(
                '#gotoinventoryModal button[onclick*="openManualVehicleFormFromInventory"]');
            if (!btn) return;
            e.preventDefault();
            // If the function exists, call it
            if (typeof window.openManualVehicleFormFromInventory === 'function') {
                window.openManualVehicleFormFromInventory();
                return;
            }
            // Fallback: show manual modal directly
            const manual = document.getElementById('manualVehicleModal') || document.getElementById(
                'addManuallyModal');
            if (!manual) {
                alert('Manual vehicle form is not available on this page.');
                return;
            }
            try {
                document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
            } catch (e) {}
            try {
                if (manual.parentNode !== document.body) document.body.appendChild(manual);
            } catch (e) {}
            try {
                if (typeof bootstrap.Modal.getOrCreateInstance === 'function') bootstrap.Modal
                    .getOrCreateInstance(manual).show();
                else new bootstrap.Modal(manual).show();
            } catch (err) {
                try {
                    bootstrap.Modal.getInstance(manual)?.show();
                } catch (e) {}
            }
        } catch (err) {
            /* ignore */
        }
    });
</script>


{{-- table drag able --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const table = document.getElementById('customerTable');
        if (!table) return; // nothing to do if table not present on this page
        const headers = table.querySelectorAll('thead tr:first-child th:not(.no-sort)');
        if (!headers || headers.length === 0) return;
        let draggingHeader = null;
        let draggingIndex = null;

        headers.forEach(th => {
            th.setAttribute('draggable', true);

            th.addEventListener('dragstart', function(e) {
                draggingHeader = this;
                draggingIndex = [...this.parentNode.children].indexOf(this);
                this.classList.add('dragging');
                e.dataTransfer.effectAllowed = 'move';
            });

            th.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'move';
                if (this !== draggingHeader) this.classList.add('drag-over');
            });

            th.addEventListener('dragleave', function() {
                this.classList.remove('drag-over');
            });

            th.addEventListener('drop', function(e) {
                e.preventDefault();
                if (this !== draggingHeader) {
                    const targetIndex = [...this.parentNode.children].indexOf(this);
                    moveColumn(draggingIndex, targetIndex);
                }
                this.classList.remove('drag-over');
            });

            th.addEventListener('dragend', function() {
                this.classList.remove('dragging');
                headers.forEach(h => h.classList.remove('drag-over'));
            });
        });

        function moveColumn(from, to) {
            const rows = table.querySelectorAll('tr');
            rows.forEach(row => {
                const cells = [...row.children];
                const movingCell = cells[from];
                if (from < to) {
                    row.insertBefore(movingCell, cells[to].nextSibling);
                } else {
                    row.insertBefore(movingCell, cells[to]);
                }
            });
        }

        // Initialize Bootstrap tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileBtn = document.getElementById('mobileBtn');
        const desktopBtn = document.getElementById('desktopBtn');
        const preview = document.getElementById('preview');

        // Set default to desktop if elements exist
        if (desktopBtn) desktopBtn.classList.add('active');
        if (preview) preview.classList.remove('mobile');

        if (mobileBtn && desktopBtn && preview) {
            mobileBtn.addEventListener('click', function() {
                mobileBtn.classList.add('active');
                desktopBtn.classList.remove('active');
                preview.classList.add('mobile');
            });

            desktopBtn.addEventListener('click', function() {
                desktopBtn.classList.add('active');
                mobileBtn.classList.remove('active');
                preview.classList.remove('mobile');
            });
        }
    });
</script>

<script>
    // HTML Mode Toggle Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const btnHtmlMode = document.getElementById('btnHtmlMode');
        const editor = document.getElementById('editor');
        const htmlTextarea = document.getElementById('htmlTextarea');
        const editorWrapper = document.querySelector('.editor-wrapper');
        const previewContainer = document.querySelector('.preview-container');
        let isHtmlMode = false;

        // Require required elements
        if (!btnHtmlMode || !editor || !htmlTextarea || !editorWrapper || !previewContainer) return;

        btnHtmlMode.addEventListener('click', function(e) {
            e.preventDefault();
            isHtmlMode = !isHtmlMode;

            if (isHtmlMode) {
                // Switch to HTML mode
                // Get current HTML content from editor
                const currentHTML = editor.innerHTML;
                htmlTextarea.value = currentHTML;

                // Hide editor and preview, show textarea
                editorWrapper.classList.add('html-mode');
                editorWrapper.style.display = 'none';
                previewContainer.classList.add('html-mode');
                previewContainer.style.display = 'none';
                htmlTextarea.classList.add('active');
                htmlTextarea.style.display = 'block';

                // Update button appearance
                btnHtmlMode.classList.add('active');
                btnHtmlMode.title = 'Switch back to Normal Mode';
            } else {
                // Switch back to rendered view
                const htmlContent = htmlTextarea.value;

                // Update editor with new HTML
                editor.innerHTML = htmlContent;

                // Show editor and preview, hide textarea
                editorWrapper.classList.remove('html-mode');
                editorWrapper.style.display = 'block';
                previewContainer.classList.remove('html-mode');
                previewContainer.style.display = 'block';
                htmlTextarea.classList.remove('active');
                htmlTextarea.style.display = 'none';

                // Update button appearance
                btnHtmlMode.classList.remove('active');
                btnHtmlMode.title = 'Edit HTML / Switch to HTML mode';

                // Update preview to show exact email appearance
                updateLivePreview();
            }
        });

        // Function to update live preview
        function updateLivePreview() {
            const preview = document.getElementById('preview');
            if (preview) {
                const templatePreview = preview.querySelector('.template-preview');
                if (templatePreview) {
                    templatePreview.innerHTML = editor.innerHTML;
                }
            }
        }

        // Auto-update preview when editor changes
        editor.addEventListener('input', updateLivePreview);
        editor.addEventListener('change', updateLivePreview);
    });
</script>

<script>
    // Signature Editor HTML Mode Toggle
    document.addEventListener('DOMContentLoaded', function() {
        const btnSigHtmlMode = document.getElementById('btnSigHtmlMode');
        const signatureEditor = document.getElementById('signatureEditor');
        const sigHtmlTextarea = document.getElementById('sigHtmlTextarea');
        const signaturePreview = document.getElementById('signaturePreview');
        const sigEditorWrapper = document.querySelector('.signature-editor-wrapper');
        let isSigHtmlMode = false;

        if (!btnSigHtmlMode || !signatureEditor || !sigHtmlTextarea || !signaturePreview || !sigEditorWrapper)
            return;

        btnSigHtmlMode.addEventListener('click', function(e) {
            e.preventDefault();
            isSigHtmlMode = !isSigHtmlMode;

            if (isSigHtmlMode) {
                // Switch to HTML mode
                const currentHTML = signatureEditor.innerHTML;
                sigHtmlTextarea.value = currentHTML;

                // Hide editor and preview, show textarea
                sigEditorWrapper.style.display = 'none';
                if (signaturePreview && signaturePreview.parentElement) signaturePreview.parentElement
                    .style.display = 'none';
                sigHtmlTextarea.classList.add('active');
                sigHtmlTextarea.style.display = 'block';

                // Update button appearance
                btnSigHtmlMode.classList.add('active');
                btnSigHtmlMode.title = 'Switch back to Normal Mode';
            } else {
                // Switch back to rendered view
                const htmlContent = sigHtmlTextarea.value;
                signatureEditor.innerHTML = htmlContent;

                // Show editor and preview, hide textarea
                sigEditorWrapper.style.display = 'block';
                if (signaturePreview && signaturePreview.parentElement) signaturePreview.parentElement
                    .style.display = 'block';
                sigHtmlTextarea.classList.remove('active');
                sigHtmlTextarea.style.display = 'none';

                // Update button appearance
                btnSigHtmlMode.classList.remove('active');
                btnSigHtmlMode.title = 'Edit HTML / Switch to HTML mode';

                // Update preview
                updateSigPreview();
            }
        });

        // Update preview when editor changes
        function updateSigPreview() {
            if (signaturePreview) {
                signaturePreview.innerHTML = signatureEditor.innerHTML;
            }
        }

        signatureEditor.addEventListener('input', updateSigPreview);
        signatureEditor.addEventListener('change', updateSigPreview);

        // Formatting buttons for signature (guarded)
        const sigBold = document.getElementById('sigBold');
        if (sigBold) sigBold.addEventListener('click', function(e) {
            e.preventDefault();
            document.execCommand('bold', false, null);
            signatureEditor.focus();
        });

        const sigItalic = document.getElementById('sigItalic');
        if (sigItalic) sigItalic.addEventListener('click', function(e) {
            e.preventDefault();
            document.execCommand('italic', false, null);
            signatureEditor.focus();
        });

        const sigUnderline = document.getElementById('sigUnderline');
        if (sigUnderline) sigUnderline.addEventListener('click', function(e) {
            e.preventDefault();
            document.execCommand('underline', false, null);
            signatureEditor.focus();
        });

        const sigFontFamily = document.getElementById('sigFontFamily');
        if (sigFontFamily) sigFontFamily.addEventListener('change', function() {
            document.execCommand('fontName', false, this.value);
            signatureEditor.focus();
        });

        const sigFontSize = document.getElementById('sigFontSize');
        if (sigFontSize) sigFontSize.addEventListener('change', function() {
            document.execCommand('fontSize', false, this.value);
            signatureEditor.focus();
        });
    });
</script>

<script>
    const SAMPLE_DATAs = {
        // Customer Information (Updated as per client request)
        first_name: 'Michael',
        last_name: 'Smith',
        email: 'michael.smith@email.com',
        alt_email: 'm.smith@work.com',
        cell_phone: '(555) 123-4567',
        work_phone: '(555) 890-1234',
        home_phone: '(555) 567-8901',
        street_address: '611 Padget Lane',
        city: 'Saskatoon',
        province: 'Saskatchewan',
        postal_code: 'S7W 0H3',
        country: 'Canada',

        // Updated field names
        assigned_to: 'MC Cerda',
        assigned_manager: 'Marie-Amy Mazuzu',
        secondary_assigned: 'John Doe',


        // Dealership Information (Updated as per client request)
        dealer_name: 'Primus Motors',
        dealer_phone: '222-333-4444',
        dealer_address: '123 Main Street, Vancouver, BC, V5K 2X8',
        dealer_email: 'dealer@dealer.com',
        dealer_website: 'www.primusmotors.ca',

        // Vehicle Information (Updated as per client request)
        year: '2025',
        make: 'Ferrari',
        model: 'F80',
        vin: '12345678ABCDEFGHI',
        stock_number: '10101',
        selling_price: '$50,000',
        internet_price: '$49,000',
        kms: '35,000',

        // Trade-In Information
        tradein_year: '2011',
        tradein_make: 'Dodge',
        tradein_model: 'Calibre',
        tradein_vin: 'ABCDEFGHI12345678',
        tradein_kms: '100,000',
        tradein_price: '$10,000',

        // Finance Manager
        finance_manager: 'Robert Wilson',

        // Assigned To
        assigned_to: 'Michael Scott',
        assigned_to_email: 'michael.scott@dealership.com',
        assigned_to_work_number: '555-111-2222',
        assigned_to_cell_number: '555-333-4444',
        assigned_to_title: 'Sales Executive',

        // Assigned Manager
        assigned_manager: 'Sarah Johnson',

        // Secondary Assigned
        secondary_assigned: 'Pam Beesly',
        secondary_assigned_email: 'pam.beesly@dealership.com',
        secondary_assigned_work_number: '555-555-6666',
        secondary_assigned_cell_number: '555-777-8888',
        secondary_assigned_title: 'Assistant Sales Manager',

        // BDC Agent
        bdc_agent: 'Emily Davis',
        bdc_agent_email: 'emily.davis@dealership.com',
        bdc_agent_work_number: '555-101-2020',
        bdc_agent_cell_number: '555-303-4040',
        bdc_agent_title: 'BDC Agent',

        // BDC Manager
        bdc_manager: 'David Brown',
        bdc_manager_email: 'david.brown@dealership.com',
        bdc_manager_work_number: '555-505-6060',
        bdc_manager_cell_number: '555-707-8080',
        bdc_manager_title: 'BDC Manager',

        // General Manager
        general_manager: 'Jennifer Martinez',
        general_manager_email: 'jennifer.martinez@dealership.com',
        general_manager_title: 'General Manager',

        // Sales Manager
        sales_manager: 'Kevin Anderson',
        sales_manager_email: 'kevin.anderson@dealership.com',
        sales_manager_work_number: '555-909-1010',
        sales_manager_cell_number: '555-111-1212',
        sales_manager_title: 'Sales Manager',

        // Service Advisor
        service_advisor: 'Lisa Thompson',

        // Source
        source: 'Website Inquiry',

        // Appointment Date/Time
        appointment_datetime: 'Oct 14, 2025 10:00AM',

        // Inventory Manager
        inventory_manager: 'Mark Robinson',

        // Warranty Expiration
        warranty_expiration: 'Oct 14, 2025'
    };

    const OUTLOOK_COLORS = ['#000000', '#444444', '#666666', '#999999', '#CCCCCC', '#EEEEEE', '#F3F3F3', '#FFFFFF',
        '#FF0000', '#FF9900', '#FFFF00', '#00FF00', '#00FFFF', '#4A86E8', '#0000FF', '#9900FF', '#FF00FF',
        '#C00000',
        '#E26B0A', '#F1C232', '#6AA84F', '#45818E', '#3C78D8', '#3D85C6', '#674EA7', '#A64D79', '#85200C',
        '#990000',
        '#B45F06', '#BF9000', '#38761D', '#134F5C', '#1155CC', '#0B5394', '#351C75', '#741B47'
    ];

    const EMAIL_TEMPLATES = {
        welcome: {
            name: 'Welcome Email',
            subject: 'Welcome to @{{ dealer_name }}, @{{ first_name }}!',
            body: '<h2 style="color: #002140;">Welcome to @{{ dealer_name }}!</h2><p>Dear <span class="token">@{{ first_name }}</span>,</p><p>Thank you for choosing us!</p><div style="text-align: center; margin: 20px 0;"><a href="#" class="cta-button">View Our Inventory</a></div><p><strong>Best regards,</strong><br><span class="token">@{{ advisor_name }}</span></p>'
        },
        promotional: {
            name: 'Promotional Offer',
            subject: 'Exclusive Offer for You!',
            body: '<div style="background: linear-gradient(135deg, #002140 0%, #001a33 100%); color: white; padding: 30px; text-align: center; border-radius: 8px; margin-bottom: 20px;"><h1 style="color: white; margin: 0;">Special Offer!</h1></div><p>Dear <span class="token">@{{ first_name }}</span>,</p><div style="text-align: center; margin: 30px 0;"><a href="#" class="cta-button">Claim Your Offer</a></div>'
        }
    };

    class TemplateBuilder {
        constructor() {
            this.currentTextColor = '#000000';
            this.currentHighlightColor = '#ffff00';
            this.selectedTableSize = {
                rows: 1,
                cols: 1
            };
            this.recognition = null;
            this.currentAIAction = null;
            this.selectedImage = null;
            this.originalImageDimensions = {
                width: 0,
                height: 0
            };
            this.lastVoiceResult = '';
            this.isVoiceRecording = false;
            this.currentFormatting = {
                bold: false,
                italic: false,
                underline: false,
                strikeThrough: false,
                indent: false
            };
            this.init();
        }

        init() {
            this.setupToolbar();
            this.setupColorPickers();
            this.setupTableGrid();
            this.setupMergeFields();
            this.setupImageControls();
            this.setupVoiceRecognition();
            this.setupEditor();
            this.setupAIAssistant();
            this.setupSmartText();
            this.renderPreview();
            const _strikeBtn = document.querySelector('[data-cmd="strikeThrough"]');
            if (_strikeBtn) _strikeBtn.classList.remove('active');
        }

        setupImageControls() {
            // Alignment buttons
            document.querySelectorAll('.image-align-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    if (!this.selectedImage) return;
                    const align = btn.dataset.align;
                    document.querySelectorAll('.image-align-btn').forEach(b => b.classList.remove(
                        'active'));
                    btn.classList.add('active');

                    if (align === 'left') {
                        this.selectedImage.style.display = 'block';
                        this.selectedImage.style.marginLeft = '0';
                        this.selectedImage.style.marginRight = 'auto';
                    } else if (align === 'center') {
                        this.selectedImage.style.display = 'block';
                        this.selectedImage.style.marginLeft = 'auto';
                        this.selectedImage.style.marginRight = 'auto';
                    } else if (align === 'right') {
                        this.selectedImage.style.display = 'block';
                        this.selectedImage.style.marginLeft = 'auto';
                        this.selectedImage.style.marginRight = '0';
                    }
                    this.renderPreview();
                });
            });

            // Size inputs with aspect ratio lock
            const widthInput = document.getElementById('imageWidth');
            const heightInput = document.getElementById('imageHeight');
            const lockAspect = document.getElementById('lockAspectRatio');

            if (widthInput && heightInput && lockAspect) {
                widthInput.addEventListener('input', () => {
                    if (!this.selectedImage) return;
                    const width = parseInt(widthInput.value);
                    if (width && width > 0) {
                        this.selectedImage.style.width = width + 'px';
                        if (lockAspect.checked && this.originalImageDimensions.width > 0) {
                            const ratio = this.originalImageDimensions.height / this.originalImageDimensions
                                .width;
                            const height = Math.round(width * ratio);
                            this.selectedImage.style.height = height + 'px';
                            heightInput.value = height;
                        }
                        this.renderPreview();
                    }
                });

                heightInput.addEventListener('input', () => {
                    if (!this.selectedImage) return;
                    const height = parseInt(heightInput.value);
                    if (height && height > 0) {
                        this.selectedImage.style.height = height + 'px';
                        if (lockAspect.checked && this.originalImageDimensions.height > 0) {
                            const ratio = this.originalImageDimensions.width / this.originalImageDimensions
                                .height;
                            const width = Math.round(height * ratio);
                            this.selectedImage.style.width = width + 'px';
                            widthInput.value = width;
                        }
                        this.renderPreview();
                    }
                });
            }

            // Reset button (guarded)
            const resetBtn = document.getElementById('resetImageSize');
            if (resetBtn) {
                resetBtn.addEventListener('click', () => {
                    if (!this.selectedImage) return;
                    const origWidth = parseInt(this.selectedImage.dataset.originalWidth) || this
                        .originalImageDimensions.width;
                    const origHeight = parseInt(this.selectedImage.dataset.originalHeight) || this
                        .originalImageDimensions.height;
                    let width = origWidth;
                    let height = origHeight;
                    if (width > 600) {
                        height = (height * 600) / width;
                        width = 600;
                    }
                    this.selectedImage.style.width = width + 'px';
                    this.selectedImage.style.height = height + 'px';
                    if (widthInput) widthInput.value = Math.round(width);
                    if (heightInput) heightInput.value = Math.round(height);
                    this.renderPreview();
                });
            }

            // Delete button (guarded)
            const delBtn = document.getElementById('deleteImage');
            if (delBtn) {
                delBtn.addEventListener('click', () => {
                    if (this.selectedImage && confirm('Delete this image?')) {
                        this.selectedImage.remove();
                        this.deselectImage();
                        this.renderPreview();
                    }
                });
            }

            // Close controls when clicking outside
            document.addEventListener('click', (e) => {
                if (!e.target.closest('.image-controls') && !e.target.closest('img') && e.target.id !==
                    'btnImage') {
                    this.deselectImage();
                }
            });
        }

        selectImage(img) {
            this.deselectImage();
            this.selectedImage = img;
            img.classList.add('selected');

            const currentWidth = img.offsetWidth;
            const currentHeight = img.offsetHeight;
            this.originalImageDimensions = {
                width: parseInt(img.dataset.originalWidth) || currentWidth,
                height: parseInt(img.dataset.originalHeight) || currentHeight
            };

            document.getElementById('imageWidth').value = Math.round(currentWidth);
            document.getElementById('imageHeight').value = Math.round(currentHeight);

            const marginLeft = img.style.marginLeft;
            const marginRight = img.style.marginRight;
            document.querySelectorAll('.image-align-btn').forEach(btn => btn.classList.remove('active'));

            if (marginLeft === 'auto' && marginRight === 'auto') {
                document.querySelector('[data-align="center"]').classList.add('active');
            } else if (marginLeft === 'auto') {
                document.querySelector('[data-align="right"]').classList.add('active');
            } else {
                document.querySelector('[data-align="left"]').classList.add('active');
            }

            const controls = document.getElementById('imageControls');
            const rect = img.getBoundingClientRect();
            controls.style.position = 'fixed';
            controls.style.left = (rect.right + 10) + 'px';
            controls.style.top = rect.top + 'px';

            setTimeout(() => {
                const controlsRect = controls.getBoundingClientRect();
                if (controlsRect.right > window.innerWidth) {
                    controls.style.left = (rect.left - controlsRect.width - 10) + 'px';
                }
                if (controlsRect.bottom > window.innerHeight) {
                    controls.style.top = (window.innerHeight - controlsRect.height - 20) + 'px';
                }
            }, 10);

            controls.classList.add('show');
        }

        deselectImage() {
            if (this.selectedImage) {
                this.selectedImage.classList.remove('selected');
                this.selectedImage = null;
            }
            document.getElementById('imageControls').classList.remove('show');
        }

        setupToolbar() {
            // Track current formatting state
            this.currentFormatting = {
                bold: false,
                italic: false,
                underline: false,
                indent: false
            };

            // Basic formatting commands
            document.querySelectorAll('.toolbar-btn[data-cmd]').forEach(btn => {
                btn.addEventListener('click', () => {
                    const cmd = btn.dataset.cmd;

                    // Handle alignment buttons (mutually exclusive)
                    if (['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'].includes(
                            cmd)) {
                        // Remove active from all alignment buttons
                        document.querySelectorAll('[data-cmd^="justify"]').forEach(b => {
                            b.classList.remove('active');
                        });
                        // Add active to clicked button
                        btn.classList.add('active');

                        // Execute the alignment command
                        document.execCommand(cmd, false, null);
                    }

                    // Handle indent/outdent buttons
                    else if (['indent', 'outdent'].includes(cmd)) {
                        // For indent/outdent, we don't maintain active state as they're one-time actions
                        document.execCommand(cmd, false, null);
                        // Update toolbar state to reflect current paragraph state
                        setTimeout(() => this.updateToolbarState(), 10);
                    }
                    // Handle lists and strikethrough
                    else if (['insertUnorderedList', 'insertOrderedList', 'strikeThrough'].includes(
                            cmd)) {
                        // Execute the command directly for lists and strikethrough
                        document.execCommand(cmd, false, null);

                        // For strikethrough, update the button state
                        if (cmd === 'strikeThrough') {
                            const isActive = document.queryCommandState('strikeThrough');
                            btn.classList.toggle('active', isActive);
                            this.currentFormatting.strikeThrough = isActive;
                        }
                    } else {
                        // For bold, italic, underline - use our tracked state
                        if (cmd === 'bold') {
                            this.currentFormatting.bold = !this.currentFormatting.bold;
                            btn.classList.toggle('active', this.currentFormatting.bold);
                            document.execCommand('bold', false, null);
                        } else if (cmd === 'italic') {
                            this.currentFormatting.italic = !this.currentFormatting.italic;
                            btn.classList.toggle('active', this.currentFormatting.italic);
                            document.execCommand('italic', false, null);
                        } else if (cmd === 'underline') {
                            this.currentFormatting.underline = !this.currentFormatting.underline;
                            btn.classList.toggle('active', this.currentFormatting.underline);
                            document.execCommand('underline', false, null);
                        }
                    }

                    this.renderPreview();

                    // Update toolbar state after command execution
                    setTimeout(() => this.updateToolbarState(), 10);
                });
            });

            // Update toolbar state based on current selection
            const editor = document.getElementById('editor');

            editor.addEventListener('click', () => {
                setTimeout(() => this.updateToolbarState(), 10);
            });

            editor.addEventListener('keydown', (e) => {
                // Handle Enter key - differentiate between Enter and Shift+Enter
                if (e.key === 'Enter') {
                    e.preventDefault();

                    if (e.shiftKey) {
                        // Shift+Enter: Insert line break (same line)
                        this.handleShiftEnter();
                    } else {
                        // Enter: Create new paragraph (new line with spacing)
                        this.handleEnter();
                    }
                }
            });

            editor.addEventListener('keyup', (e) => {
                this.updateToolbarState();

                // If it's a regular character key and we have active formatting, apply it
                if (e.key.length === 1 && !e.ctrlKey && !e.metaKey && !e.altKey && !e.shiftKey) {
                    this.applyCurrentFormatting();
                }
            });

            editor.addEventListener('mouseup', () => {
                this.updateToolbarState();
            });

            // Handle focus and selection changes to maintain formatting
            editor.addEventListener('focus', () => {
                this.updateToolbarState();
            });

            // Handle selection changes
            editor.addEventListener('selectionchange', () => {
                this.updateToolbarState();
            });

            // Handle paste events to maintain formatting
            editor.addEventListener('paste', (e) => {
                // Let the paste happen first, then apply formatting
                setTimeout(() => {
                    this.applyCurrentFormatting();
                    this.updateToolbarState();
                }, 10);
            });

            // Font Family
            document.getElementById('fontFamily').addEventListener('change', (e) => {
                document.execCommand('fontName', false, e.target.value);
                this.renderPreview();
            });

            // Font Size
            document.getElementById('fontSize').addEventListener('change', (e) => {
                document.execCommand('fontSize', false, '7');
                document.querySelectorAll('font[size="7"]').forEach(el => {
                    el.removeAttribute('size');
                    el.style.fontSize = e.target.value;
                });
                this.renderPreview();
            });

            // Image upload
            document.getElementById('btnImage').addEventListener('click', () => {
                const input = document.createElement('input');
                input.type = 'file';
                input.accept = 'image/*';
                input.multiple = true;
                input.onchange = (e) => {
                    const files = Array.from(e.target.files);
                    files.forEach(file => {
                        if (file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = (event) => {
                                const img = new Image();
                                img.onload = () => {
                                    const maxWidth = 600;
                                    let width = img.width;
                                    let height = img.height;
                                    if (width > maxWidth) {
                                        height = (height * maxWidth) / width;
                                        width = maxWidth;
                                    }
                                    const imgHtml =
                                        `<img src="${event.target.result}" style="max-width:600px;width:${width}px;height:${height}px;display:block;margin:10px auto;border-radius:8px;" data-original-width="${img.width}" data-original-height="${img.height}">`;
                                    document.execCommand('insertHTML', false, imgHtml);
                                    this.renderPreview();
                                    setTimeout(() => {
                                        const editor = document.getElementById(
                                            'editor');
                                        const images = editor.querySelectorAll(
                                            'img');
                                        const newImage = images[images.length -
                                            1];
                                        this.selectImage(newImage);
                                    }, 100);
                                };
                                img.src = event.target.result;
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                };
                input.click();
            });

            // Link
            document.getElementById('btnLink').addEventListener('click', () => {
                let url = prompt('Enter URL:');
                if (url) {
                    // âœ… Auto add protocol if missing
                    if (!/^https?:\/\//i.test(url)) {
                        url = 'https://' + url;
                    }

                    // Create the link
                    document.execCommand('createLink', false, url);


                    const selection = window.getSelection();
                    if (selection.rangeCount > 0) {
                        const range = selection.getRangeAt(0);
                        let anchor = range.startContainer.parentElement;
                        if (anchor && anchor.tagName === 'A') {
                            anchor.setAttribute('target', '_blank');
                        }
                    }

                    this.renderPreview();
                }
            });


            // Clear Formatting
            document.getElementById('btnClearFormat').addEventListener('click', () => {
                document.execCommand('removeFormat', false, null);
                // Remove active from all toolbar buttons and reset formatting state
                document.querySelectorAll('.toolbar-btn.active').forEach(btn => {
                    btn.classList.remove('active');
                });
                // Reset current formatting state
                this.currentFormatting = {
                    bold: false,
                    italic: false,
                    underline: false,
                    strikeThrough: false, // Add this line
                    indent: false
                };
                this.renderPreview();
            });

            // Attach (placeholder)
            document.getElementById('btnAttach').addEventListener('click', () => {
                alert('File attachment - integrate with backend');
            });

            // Save & Cancel


            // Initialize toolbar state
            this.updateToolbarState();
        }

        // Add this function to handle Enter key (new paragraph with spacing)
        handleEnter() {
            // Save current formatting state
            const wasBold = this.currentFormatting.bold;
            const wasItalic = this.currentFormatting.italic;
            const wasUnderline = this.currentFormatting.underline;

            // Insert new paragraph with proper spacing
            document.execCommand('insertHTML', false, '<p><br></p>');

            // Restore formatting state after inserting new paragraph
            setTimeout(() => {
                this.currentFormatting.bold = wasBold;
                this.currentFormatting.italic = wasItalic;
                this.currentFormatting.underline = wasUnderline;

                // Apply current formatting to the new paragraph
                this.applyCurrentFormatting();
                this.renderPreview();
            }, 10);
        }


        // Add this function to handle Shift+Enter (line break without spacing)
        handleShiftEnter() {
            // Save current formatting state
            const wasBold = this.currentFormatting.bold;
            const wasItalic = this.currentFormatting.italic;
            const wasUnderline = this.currentFormatting.underline;

            // Insert simple line break (same paragraph)
            document.execCommand('insertHTML', false, '<br>');

            // Restore formatting state and apply to continue on same line
            setTimeout(() => {
                this.currentFormatting.bold = wasBold;
                this.currentFormatting.italic = wasItalic;
                this.currentFormatting.underline = wasUnderline;

                this.applyCurrentFormatting();
                this.renderPreview();
            }, 10);
        }

        // Add this function to apply current formatting to new text
        applyCurrentFormatting() {
            // Save current selection
            this.saveSelection();

            // Apply each active formatting
            if (this.currentFormatting.bold) {
                document.execCommand('bold', false, null);
            }
            // Add strikethrough to the applyCurrentFormatting method
            if (this.currentFormatting.strikeThrough) {
                document.execCommand('strikeThrough', false, null);
            }
            if (this.currentFormatting.italic) {
                document.execCommand('italic', false, null);
            }
            if (this.currentFormatting.underline) {
                document.execCommand('underline', false, null);
            }

            // Restore selection after applying formatting
            this.restoreSelection();
        }

        // Add this function to update toolbar state based on current selection
        updateToolbarState() {
            const editor = document.getElementById('editor');

            // Check if editor has focus and selection
            if (document.activeElement !== editor) {
                // If editor doesn't have focus, keep the current formatting state but update buttons
                document.querySelector('[data-cmd="bold"]').classList.toggle('active', this.currentFormatting.bold);
                document.querySelector('[data-cmd="italic"]').classList.toggle('active', this.currentFormatting
                    .italic);
                document.querySelector('[data-cmd="underline"]').classList.toggle('active', this.currentFormatting
                    .underline);
                document.querySelector('[data-cmd="strikeThrough"]').classList.toggle('active', this
                    .currentFormatting.strikeThrough);
                return;
            }

            const selection = window.getSelection();
            if (!selection.rangeCount) {
                return;
            }

            // For empty editor or new line, use our tracked formatting state
            if (selection.isCollapsed && editor.innerHTML.trim() === '') {
                document.querySelector('[data-cmd="bold"]').classList.toggle('active', this.currentFormatting.bold);
                document.querySelector('[data-cmd="italic"]').classList.toggle('active', this.currentFormatting
                    .italic);
                document.querySelector('[data-cmd="underline"]').classList.toggle('active', this.currentFormatting
                    .underline);
                document.querySelector('[data-cmd="strikeThrough"]').classList.toggle('active', this
                    .currentFormatting.strikeThrough);
                return;
            }

            // Check formatting states using both queryCommandState and DOM inspection
            const isBoldCommand = document.queryCommandState('bold');
            const isItalicCommand = document.queryCommandState('italic');
            const isUnderlineCommand = document.queryCommandState('underline');
            const isStrikeThroughCommand = document.queryCommandState('strikeThrough');

            // Also check DOM for formatting
            const domFormatting = this.checkFormattingAtCursor();

            // Use DOM formatting if available, otherwise use command state
            const isBold = domFormatting.bold !== undefined ? domFormatting.bold : isBoldCommand;
            const isItalic = domFormatting.italic !== undefined ? domFormatting.italic : isItalicCommand;
            const isUnderline = domFormatting.underline !== undefined ? domFormatting.underline :
                isUnderlineCommand;
            const isStrikeThrough = domFormatting.strikeThrough !== undefined ? domFormatting.strikeThrough :
                isStrikeThroughCommand;

            // Update button states
            document.querySelector('[data-cmd="bold"]').classList.toggle('active', isBold);
            document.querySelector('[data-cmd="italic"]').classList.toggle('active', isItalic);
            document.querySelector('[data-cmd="underline"]').classList.toggle('active', isUnderline);
            document.querySelector('[data-cmd="strikeThrough"]').classList.toggle('active', isStrikeThrough);

            // Update current formatting state based on actual state
            // But only if we have actual content to check, otherwise keep our tracked state
            if (!selection.isCollapsed || editor.innerHTML.trim() !== '') {
                this.currentFormatting.bold = isBold;
                this.currentFormatting.italic = isItalic;
                this.currentFormatting.underline = isUnderline;
                this.currentFormatting.strikeThrough = isStrikeThrough;
            }

            // Check alignment by examining the current block element
            this.checkAlignmentState();

            // Check indent state by examining the current element
            this.checkIndentState();
        }
        // Add this function to check and update alignment state
        checkAlignmentState() {
            const selection = window.getSelection();
            if (!selection.rangeCount) return;

            const range = selection.getRangeAt(0);
            const node = range.startContainer;

            // Alignment detection
            let alignment = null;
            let current = window.getSelection().anchorNode;

            while (current && current !== document.body) {
                if (current.nodeType === Node.ELEMENT_NODE) {
                    const style = window.getComputedStyle(current);
                    const textAlign = style.textAlign;

                    if (textAlign === 'center') {
                        alignment = 'center';
                        break;
                    } else if (textAlign === 'right') {
                        alignment = 'right';
                        break;
                    } else if (textAlign === 'justify') {
                        alignment = 'justify';
                        break;
                    } else if (textAlign === 'left') {
                        alignment = 'left';
                        break;
                    }
                }
                current = current.parentNode;
            }

            // Update alignment buttons based on detected alignment
            document.querySelectorAll('[data-cmd^="justify"]').forEach(btn => {
                btn.classList.remove('active');
            });

            switch (alignment) {
                case 'left':
                    document.querySelector('[data-cmd="justifyLeft"]').classList.add('active');
                    break;
                case 'center':
                    document.querySelector('[data-cmd="justifyCenter"]').classList.add('active');
                    break;
                case 'right':
                    document.querySelector('[data-cmd="justifyRight"]').classList.add('active');
                    break;
                case 'justify':
                    document.querySelector('[data-cmd="justifyFull"]').classList.add('active');
                    break;
            }
        }

        // Add this function to check formatting at cursor position (for collapsed selection)
        checkFormattingAtCursor() {
            const selection = window.getSelection();
            if (!selection.rangeCount || !selection.isCollapsed) return {};

            const range = selection.getRangeAt(0);
            const node = range.startContainer;

            // Traverse up the DOM tree to find formatting
            let current = node;
            let isBold = false;
            let isItalic = false;
            let isUnderline = false;
            let isStrikeThrough = false;
            let foundFormatting = false;

            while (current && current !== document.body) {
                if (current.nodeType === Node.ELEMENT_NODE) {
                    const style = window.getComputedStyle(current);

                    // Check for bold
                    if (style.fontWeight === 'bold' || style.fontWeight === '700' ||
                        current.tagName === 'B' || current.tagName === 'STRONG') {
                        isBold = true;
                        foundFormatting = true;
                    }
                    if (style.textDecoration.includes('line-through') || current.tagName === 'STRIKE' || current
                        .tagName === 'S') {
                        isStrikeThrough = true;
                        foundFormatting = true;
                    }
                    // Check for italic
                    if (style.fontStyle === 'italic' || current.tagName === 'I' || current.tagName === 'EM') {
                        isItalic = true;
                        foundFormatting = true;
                    }
                    // Check for underline
                    if (style.textDecoration.includes('underline') || current.tagName === 'U') {
                        isUnderline = true;
                        foundFormatting = true;
                    }

                    // If we found any formatting, break early
                    if (foundFormatting) break;
                }
                current = current.parentNode;
            }
            return {
                bold: foundFormatting ? isBold : undefined,
                italic: foundFormatting ? isItalic : undefined,
                underline: foundFormatting ? isUnderline : undefined,
                strikeThrough: foundFormatting ? isStrikeThrough : undefined
            };
        }

        // Add this function to check and update indent state
        checkIndentState() {
            const selection = window.getSelection();
            if (!selection.rangeCount) return;

            const range = selection.getRangeAt(0);
            const node = range.startContainer;

            // Traverse up to find block element
            let current = node;
            while (current && current !== document.body) {
                if (current.nodeType === Node.ELEMENT_NODE) {
                    const style = window.getComputedStyle(current);
                    const marginLeft = parseInt(style.marginLeft) || 0;
                    const paddingLeft = parseInt(style.paddingLeft) || 0;
                    const textIndent = parseInt(style.textIndent) || 0;

                    // Consider it indented if there's significant left spacing
                    const isIndented = (marginLeft + paddingLeft + textIndent) > 20;

                    // Update indent state (we don't show active state for indent/outdent as they're actions)
                    this.currentFormatting.indent = isIndented;

                    break;
                }
                current = current.parentNode;
            }
        }

        setupSmartText() {
            document.getElementById('btnSmartText').addEventListener('click', () => {
                const selection = window.getSelection();
                if (!selection.rangeCount || selection.isCollapsed) {
                    alert('Please select some text first');
                    return;
                }

                const range = selection.getRangeAt(0);
                const text = selection.toString();
                const span = document.createElement('span');
                span.textContent = text;
                span.style.display = 'inline-block';
                span.style.transition = 'opacity 0.3s';
                range.deleteContents();
                range.insertNode(span);

                const btn = document.getElementById('btnSmartText');
                const originalHTML = btn.innerHTML;
                btn.innerHTML = '<i class="bi bi-magic"></i> <span>Enhancing...</span>';
                btn.disabled = true;

                // Text shuffle effect before showing final text
                const chars = '!<>-_\\/[]{}â€"=+*^?#________';
                let frame = 0;
                const iterations = 20;
                const originalText = text;
                const shuffled = setInterval(() => {
                    span.textContent = originalText
                        .split('')
                        .map((c, i) => {
                            if (i < frame) return originalText[i];
                            return chars[Math.floor(Math.random() * chars.length)];
                        })
                        .join('');
                    frame++;
                    if (frame > originalText.length + iterations) {
                        clearInterval(shuffled);
                        span.style.opacity = '0';
                        setTimeout(() => {
                            const enhanced =
                                `<span style="opacity:0; transition:opacity 0.4s;"><p style="margin:0; line-height:1.6;">${originalText}</p></span>`;
                            span.outerHTML = enhanced;
                            const newEl = document.querySelector(
                                'span[style*="opacity:0"]');
                            setTimeout(() => {
                                newEl.style.opacity = '1';
                            }, 20);
                            this.renderPreview();
                            btn.innerHTML = originalHTML;
                            btn.disabled = false;
                        }, 300);
                    }
                }, 40);
            });
        }

        setupAIAssistant() {
            const modal = document.getElementById('aiModal');

            document.getElementById('btnAIAssistant').addEventListener('click', () => {
                modal.classList.add('show');
                this.showAIOptions();
            });

            document.getElementById('closeAIModal').addEventListener('click', () => {
                modal.classList.remove('show');
            });

            modal.addEventListener('click', (e) => {
                if (e.target === modal) modal.classList.remove('show');
            });

            document.getElementById('btnBackToOptions').addEventListener('click', () => {
                this.showAIOptions();
            });

            document.querySelectorAll('.ai-option-card').forEach(card => {
                card.addEventListener('click', () => {
                    this.handleAIAction(card.dataset.action);
                });
            });
        }

        showAIOptions() {
            document.getElementById('aiOptions').style.display = 'block';
            document.getElementById('aiInputSection').classList.remove('show');
            document.getElementById('aiGenerating').classList.remove('show');
        }

        handleAIAction(action) {
            this.currentAIAction = action;
            document.getElementById('aiOptions').style.display = 'none';

            const content = document.getElementById('aiInputContent');

            if (action === 'generate-email') {
                content.innerHTML =
                    '<h6 class="mb-3">Describe Your Email</h6><textarea class="ai-textarea" id="emailDesc" placeholder="Example: Create a welcome email for new customers..."></textarea><div class="mt-3"><button class="btn btn-primary" id="genEmail"><i class="bi bi-stars me-2"></i>Generate Email</button></div>';
                document.getElementById('aiInputSection').classList.add('show');
                document.getElementById('genEmail').addEventListener('click', () => {
                    const desc = document.getElementById('emailDesc').value;
                    if (desc.trim()) this.generateEmail(desc);
                });
            } else if (action === 'use-template') {
                content.innerHTML = '<h6 class="mb-3">Choose a Template</h6><div class="template-gallery">' +
                    Object.keys(EMAIL_TEMPLATES).map(key =>
                        `<div class="template-card" data-template="${key}"><div class="template-preview"><i class="bi bi-file-earmark-text"></i></div><h6 class="small mb-0">${EMAIL_TEMPLATES[key].name}</h6></div>`
                    ).join('') + '</div>';
                document.getElementById('aiInputSection').classList.add('show');
                document.querySelectorAll('.template-card').forEach(card => {
                    card.addEventListener('click', () => {
                        this.applyTemplate(card.dataset.template);
                    });
                });
            } else if (action === 'generate-subject') {
                content.innerHTML =
                    '<h6 class="mb-3">Generate Subject Line</h6><textarea class="ai-textarea" id="subjectDesc" placeholder="Describe your email content..."></textarea><div class="mt-3"><button class="btn btn-primary" id="genSubject"><i class="bi bi-stars me-2"></i>Generate Subjects</button></div>';
                document.getElementById('aiInputSection').classList.add('show');
                document.getElementById('genSubject').addEventListener('click', () => {
                    const desc = document.getElementById('subjectDesc').value;
                    if (desc.trim()) this.generateSubjects(desc);
                });
            } else if (action === 'generate-image') {
                content.innerHTML =
                    '<h6 class="mb-3">Generate Image</h6><textarea class="ai-textarea" id="imageDesc" placeholder="Example: Modern dealership showroom..."></textarea><div class="mt-3"><button class="btn btn-primary" id="genImage"><i class="bi bi-stars me-2"></i>Generate Image</button></div>';
                document.getElementById('aiInputSection').classList.add('show');
                document.getElementById('genImage').addEventListener('click', () => {
                    const desc = document.getElementById('imageDesc').value;
                    if (desc.trim()) this.generateImage(desc);
                });
            }
        }

        generateEmail(desc) {
            this.showGenerating();
            setTimeout(() => {
                const template = /promo|sale|offer/i.test(desc) ? EMAIL_TEMPLATES.promotional :
                    EMAIL_TEMPLATES.welcome;
                this.applyGeneratedContent(template);
            }, 2000);
        }



        generateImage(desc) {
            this.showGenerating();
            setTimeout(() => {
                const img =
                    `<img src="https://placehold.co/600x400/002140/white?text=${encodeURIComponent(desc.split(' ').slice(0, 3).join('+'))}" style="max-width: 600px; border-radius: 8px; margin: 20px auto; display: block;">`;
                document.getElementById('editor').innerHTML += img;
                this.renderPreview();
                document.getElementById('aiModal').classList.remove('show');
            }, 2000);
        }

        applyTemplate(templateKey) {
            this.applyGeneratedContent(EMAIL_TEMPLATES[templateKey]);
        }

        applyGeneratedContent(template) {

            document.getElementById('editor').innerHTML = template.body;
            this.renderPreview();
            document.getElementById('aiModal').classList.remove('show');
            this.showToast('Template applied!');
        }

        showGenerating() {
            document.getElementById('aiInputSection').classList.remove('show');
            document.getElementById('aiGenerating').classList.add('show');
        }

        showToast(msg) {
            const toast = document.createElement('div');
            toast.className = 'position-fixed bottom-0 end-0 p-3';
            toast.style.zIndex = '9999';
            toast.innerHTML =
                `<div class="toast show align-items-center text-bg-success"><div class="d-flex"><div class="toast-body"><i class="bi bi-check-circle me-2"></i>${msg}</div></div></div>`;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }

        setupColorPickers() {
            this.savedSelection = null;

            this.createColorDropdown('textColorDropdown', 'text');
            this.createColorDropdown('highlightColorDropdown', 'highlight');

            // Save selection when opening color picker
            document.getElementById('textColorBtn').addEventListener('mousedown', (e) => {
                e.preventDefault();
            });

            document.getElementById('textColorBtn').addEventListener('click', (e) => {
                e.stopPropagation();
                this.saveSelection();
                this.toggleColorDropdown('textColorDropdown');
            });

            document.getElementById('highlightColorBtn').addEventListener('mousedown', (e) => {
                e.preventDefault();
            });

            document.getElementById('highlightColorBtn').addEventListener('click', (e) => {
                e.stopPropagation();
                this.saveSelection();
                this.toggleColorDropdown('highlightColorDropdown');
            });

            // Prevent dropdown from closing when clicking inside
            document.querySelectorAll('.color-dropdown').forEach(dropdown => {
                dropdown.addEventListener('click', (e) => {
                    e.stopPropagation();
                });
            });

            document.addEventListener('click', (e) => {
                if (!e.target.closest('.color-picker-wrapper') && !e.target.closest('.table-grid-popup')) {
                    document.querySelectorAll('.color-dropdown, .table-grid-popup').forEach(d => d.classList
                        .remove('show'));
                }
            });
        }

        saveSelection() {
            const selection = window.getSelection();
            if (selection.rangeCount > 0) {
                this.savedSelection = selection.getRangeAt(0).cloneRange();
            }
        }

        restoreSelection() {
            const editor = document.getElementById('editor');
            if (!editor.contains(document.activeElement)) {
                editor.focus();
            }
            if (this.savedSelection) {
                const selection = window.getSelection();
                selection.removeAllRanges();
                try {
                    selection.addRange(this.savedSelection);
                } catch (e) {
                    console.log('Could not restore selection');
                }
            }
        }

        createColorDropdown(dropdownId, type) {
            const dropdown = document.getElementById(dropdownId);

            // Color swatches grid
            const grid = document.createElement('div');
            grid.className = 'color-grid';

            OUTLOOK_COLORS.forEach(color => {
                const swatch = document.createElement('div');
                swatch.className = 'color-swatch';
                swatch.style.background = color;
                swatch.addEventListener('mousedown', (e) => e.preventDefault()); // prevent losing selection
                swatch.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    if (type === 'text') this.applyTextColor(color);
                    else this.applyHighlight(color);
                    dropdown.classList.remove('show');
                });
                grid.appendChild(swatch);
            });

            dropdown.appendChild(grid);

            // Hex input always visible
            const hexWrapper = document.createElement('div');
            hexWrapper.className = 'hex-input-wrapper';
            hexWrapper.style.marginTop = '6px';

            hexWrapper.innerHTML = `
                        <label style="font-size:13px">
                          <div class="color-input-group"><span style="color:var(--cf-primary)" class="color-input-label">Hex:</span><input type="text" class="color-input hex-input" placeholder="#000000" maxlength="7"></div>
                        </label>
                      `;

            dropdown.appendChild(hexWrapper);

            const hexInput = hexWrapper.querySelector('.hex-input');

            const applyHexColor = () => {
                let hex = hexInput.value.trim();

                // Allow both #ff0000 and ff0000
                if (!hex.startsWith('#')) hex = '#' + hex;

                // Expand shorthand (#fff → #ffffff)
                if (/^#([0-9A-F]{3})$/i.test(hex)) {
                    hex = '#' + hex.slice(1).split('').map(ch => ch + ch).join('');
                }

                if (/^#[0-9A-F]{6}$/i.test(hex)) {
                    if (type === 'text') this.applyTextColor(hex);
                    else this.applyHighlight(hex);
                }
            };

            // Apply color on typing and on Enter/blur
            hexInput.addEventListener('input', applyHexColor);
            hexInput.addEventListener('change', applyHexColor);
            hexInput.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    applyHexColor();
                    dropdown.classList.remove('show'); // close on Enter
                }
            });
        }

        toggleColorDropdown(dropdownId) {
            document.querySelectorAll('.color-dropdown, .table-grid-popup').forEach(d => {
                if (d.id !== dropdownId) d.classList.remove('show');
            });
            document.getElementById(dropdownId).classList.toggle('show');
        }

        applyTextColor(color) {
            this.restoreSelection();
            document.execCommand('foreColor', false, color);
            this.currentTextColor = color;
            document.getElementById('textColorIndicator').style.background = color;
            this.renderPreview();
        }

        applyHighlight(color) {
            this.restoreSelection();
            document.execCommand('hiliteColor', false, color);
            this.currentHighlightColor = color;
            document.getElementById('highlightColorIndicator').style.background = color;
            this.renderPreview();
        }

        setupTableGrid() {
            const grid = document.getElementById('tableGrid');
            for (let row = 0; row < 10; row++) {
                for (let col = 0; col < 10; col++) {
                    const cell = document.createElement('div');
                    cell.className = 'table-cell';
                    cell.dataset.row = row;
                    cell.dataset.col = col;
                    cell.addEventListener('mouseenter', () => this.highlightTableCells(row + 1, col + 1));
                    cell.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        this.insertTable(row + 1, col + 1);
                    });
                    grid.appendChild(cell);
                }
            }

            // Prevent table grid popup from closing when clicking inside
            document.getElementById('tableGridPopup').addEventListener('click', (e) => {
                e.stopPropagation();
            });

            document.getElementById('btnTable').addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                document.querySelectorAll('.color-dropdown').forEach(d => d.classList.remove('show'));
                document.getElementById('tableGridPopup').classList.toggle('show');
            });
        }

        highlightTableCells(rows, cols) {
            document.querySelectorAll('.table-cell').forEach(cell => {
                const r = parseInt(cell.dataset.row);
                const c = parseInt(cell.dataset.col);
                if (r < rows && c < cols) cell.classList.add('selected');
                else cell.classList.remove('selected');
            });
            document.getElementById('tableSizeLabel').textContent = `${rows} x ${cols} Table`;
            this.selectedTableSize = {
                rows,
                cols
            };
        }

        insertTable(rows, cols) {
            const editor = document.getElementById('editor');

            // Restore the last saved cursor position
            if (this.savedSelection) {
                editor.focus();
                const selection = window.getSelection();
                selection.removeAllRanges();
                selection.addRange(this.savedSelection);
            } else {
                editor.focus();
            }

            // Enhanced table with better styling that will show in preview
            let html = `<table style="width: 100%; border-collapse: collapse; margin: 15px 0; border: 1px solid #d1d5db;">
                                <thead>
                                  <tr >`;

            for (let c = 0; c < cols; c++) {
                html +=
                    `<th style="border: 1px solid #d1d5db; padding: 12px; text-align: left;  color: #000;font-weight:400 !important ;">Header ${c + 1}</th>`;
            }

            html += `</tr>
                                </thead>
                                <tbody>`;

            for (let r = 0; r < rows - 1; r++) {
                html += `<tr>`;
                for (let c = 0; c < cols; c++) {
                    html +=
                        `<td style="border: 1px solid #d1d5db; padding: 12px; text-align: left; color: #000;">Cell ${r + 1}-${c + 1}</td>`;
                }
                html += `</tr>`;
            }

            html += `</tbody>
                              </table>
                              <p><br></p>`;

            document.execCommand('insertHTML', false, html);
            document.getElementById('tableGridPopup').classList.remove('show');

            // Save cursor position after insert
            const selection = window.getSelection();
            if (selection.rangeCount > 0) {
                this.savedSelection = selection.getRangeAt(0).cloneRange();
            }

            this.renderPreview();
        }

        setupMergeFields() {
            document.querySelectorAll('.category-header').forEach(header => {
                header.addEventListener('click', () => {
                    const body = header.nextElementSibling;
                    const icon = header.querySelector('i:last-child');
                    body.classList.toggle('show');
                    icon.classList.toggle('bi-chevron-down');
                    icon.classList.toggle('bi-chevron-up');
                });
            });

            document.querySelectorAll('.field-item').forEach(item => {
                item.addEventListener('click', () => this.insertToken(item.dataset.token));
            });
        }

        insertToken(tokenName) {
            const editor = document.getElementById('editor');

            // Restore the last saved cursor position
            if (this.savedSelection) {
                editor.focus();
                const selection = window.getSelection();
                selection.removeAllRanges();
                selection.addRange(this.savedSelection);
            } else {
                // If no saved position, focus at the end
                editor.focus();
                const range = document.createRange();
                range.selectNodeContents(editor);
                range.collapse(false);
                const selection = window.getSelection();
                selection.removeAllRanges();
                selection.addRange(range);
            }

            // Create and insert token
            const token = document.createElement('span');
            token.className = 'token';
            token.textContent = `@{{ $ {
    tokenName }}}`;
            token.contentEditable = 'false';

            const selection = window.getSelection();
            if (selection.rangeCount > 0) {
                const range = selection.getRangeAt(0);
                range.deleteContents();
                range.insertNode(token);

                // Add a space after the token
                const space = document.createTextNode('\u00A0');
                range.setStartAfter(token);
                range.insertNode(space);

                // Move cursor after the space
                range.setStartAfter(space);
                range.collapse(true);
                selection.removeAllRanges();
                selection.addRange(range);

                // Save the new position
                this.savedSelection = range.cloneRange();
            }

            this.renderPreview();
        }
        setupVoiceRecognition() {
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            if (!SpeechRecognition) {
                document.getElementById('btnVoice').style.display = 'none';
                return;
            }

            this.recognition = new SpeechRecognition();
            this.recognition.continuous = true;
            this.recognition.interimResults = true;

            // Disable auto-punctuation
            if ('autoPunctuation' in this.recognition) {
                this.recognition.autoPunctuation = false;
            }

            const btn = document.getElementById('btnVoice');

            btn.addEventListener('click', () => {
                if (btn.classList.contains('recording')) {
                    this.recognition.stop();
                    btn.classList.remove('recording');
                } else {
                    this.recognition.start();
                    btn.classList.add('recording');
                }
            });

            this.recognition.onresult = (event) => {
                let finalTranscript = '';

                // Loop through results and only take the final ones
                for (let i = event.resultIndex; i < event.results.length; i++) {
                    if (event.results[i].isFinal) {
                        finalTranscript += event.results[i][0].transcript;
                    }
                }

                if (finalTranscript) {
                    let processed = finalTranscript.toLowerCase();

                    // Spoken commands handling
                    processed = processed
                        .replace(/\bcomma\b/g, ',')
                        .replace(/\bspace\b/g, ' ')
                        .replace(/\b(full stop|period)\b/g, '.')
                        .replace(/\b(new line|next line)\b/g, '\n')
                        // Remove spaces before punctuation
                        .replace(/\s+([,.!?;:])/g, '$1')
                        // Fix double spaces
                        .replace(/\s+/g, ' ');

                    // Remove only unwanted auto-dots, not manual ones
                    if (!/\b(full stop|period)\b/i.test(finalTranscript)) {
                        processed = processed.replace(/\.+$/, '');
                    }

                    // Prevent double dots (if both Google + replacement add one)
                    processed = processed.replace(/\.{2,}/g, '.');

                    document.execCommand('insertText', false, processed);
                    this.renderPreview();
                }
            };

            this.recognition.onerror = () => btn.classList.remove('recording');
            this.recognition.onend = () => btn.classList.remove('recording');
        }

        setupEditor() {
            const editor = document.getElementById('editor');
            editor.addEventListener('click', (e) => {
                if (e.target.tagName === 'IMG') {
                    e.preventDefault();
                    this.selectImage(e.target);
                } else {
                    this.deselectImage();
                }
            });
            editor.addEventListener('input', () => this.renderPreview());


            // Save cursor position whenever editor loses focus
            editor.addEventListener('blur', () => {
                this.saveSelection();
            });

            // Save cursor position on any selection change
            editor.addEventListener('mouseup', () => {
                this.saveSelection();
            });

            editor.addEventListener('keyup', () => {
                this.saveSelection();
            });
        }

        renderPreview() {
            let html = document.getElementById('editor').innerHTML;

            // Ensure tables maintain their styling in preview
            html = html.replace(/<table/g,
                '<table style="border-collapse: collapse; width: 100%; margin: 15px 0;"');
            html = html.replace(/<th/g,
                '<th style="border: 1px solid #d1d5db; padding: 12px; text-align: left;font-weight:400 !important;color:#000 "'
            );
            html = html.replace(/<td/g,
                '<td style="border: 1px solid #d1d5db; padding: 12px; text-align: left;color:#000"');

            // Replace tokens with sample data
            html = html.replace(/\{\{([^}]+)\}\}/g, (match, token) => {
                return SAMPLE_DATAs[token.trim()] || match;
            });

            document.getElementById('preview').innerHTML = html;
        }


    }

    new TemplateBuilder();
</script>



<script>
    document.addEventListener('DOMContentLoaded', function() {

        const massSendRadio = document.getElementById("massSend");
        const dripFunctionRadio = document.getElementById("dripFunction");
        const startDateCol = document.getElementById("startDateCol");
        const endDateCol = document.getElementById("endDateCol");
        const drippingBox = document.getElementById("dripping-box");
        const startDateInput = document.getElementById("startDate");
        const endDateInput = document.getElementById("endDate");

        function updateDateFields() {
            if (massSendRadio.checked) {
                startDateCol.style.display = "block";
                endDateCol.style.display = "none";
                drippingBox.style.display = "none";
            } else if (dripFunctionRadio.checked) {
                startDateCol.style.display = "block";
                endDateCol.style.display = "block";
                drippingBox.style.display = "block";
            }

            startDateInput.value = "";
            endDateInput.value = "";
        }

        massSendRadio.addEventListener("change", updateDateFields);
        dripFunctionRadio.addEventListener("change", updateDateFields);
        massSendRadio.checked = true;
        updateDateFields();

        startDateInput.addEventListener("click", () => startDateInput.showPicker && startDateInput
            .showPicker());
        endDateInput.addEventListener("click", () => endDateInput.showPicker && endDateInput.showPicker());



        // ===== Email Functions =====
        let deleteTarget = null;

        window.addEmailField = function() {
            const container = document.getElementById('email-container');
            const field = document.createElement('div');
            field.className = "input-group mb-2";
            field.innerHTML = `
                        <input type="email" class="form-control" name="emails[]" placeholder="Email">
                        <div class="input-group-text">
                          <input type="radio" name="defaultEmail" title="Set as default">
                        </div>
                        <button class="btn btn-outline-danger" type="button" onclick="showCustomConfirm(this)">
                          <i class="fa fa-trash"></i>
                        </button>
                      `;
            container.appendChild(field);
        }

        window.showCustomConfirm = function(button) {
            deleteTarget = button;
            const modal = new bootstrap.Modal(document.getElementById('customConfirmModal'));
            modal.show();
        }

        window.toggleCoBuyer = function() {
            const section = document.getElementById('coBuyerFields');
            if (section) {
                section.classList.toggle('d-none');
            }
        }

        // ===== Froala Editor =====
        if (document.getElementById('mytextarea')) {
            const froalaEditor = new FroalaEditor('#mytextarea', {
                toolbarButtons: [
                    'bold', 'italic', 'underline', 'strikeThrough', '|',
                    'fontFamily', 'fontSize', '|',
                    'color', 'backgroundColor', '|',
                    'align', 'formatOL', 'formatUL', '|',
                    'insertImage', 'insertLink', 'insertTable', '|',
                    'undo', 'redo', 'html'
                ],
                imageEditButtons: [
                    'imageReplace', 'imageAlign', 'imageRemove', '|',
                    'imageDisplay', 'imageStyle', 'imageAlt', 'imageSize'
                ],
                imageMove: true,
                dragInline: true,
                fontSize: ['8', '10', '12', '14', '16', '18', '20', '24', '28', '32', '36'],
                height: 300
            });
        }

        // ===== Template Auto-fill =====
        const templateSelect = document.getElementById("templateSelect");
        const subjectField = document.getElementById("subjectField");
        const templates = {
            "New Year": {
                subject: "Happy New Year!",
                body: '<img src="https://tse3.mm.bing.net/th/id/OIP.qYCUWrXU149uQhB8FwKzcwHaE8?rs=1&pid=ImgDetMain&o=7&rm=3" style="width:100%;height:100%"><p>Wishing you a prosperous New Year full of success and joy.</p>'
            },
            "Book Dream Car": {
                subject: "Book Your Dream Car Today!",
                body: '<img src="https://tse3.mm.bing.net/th/id/OIP.qYCUWrXU149uQhB8FwKzcwHaE8?rs=1&pid=ImgDetMain&o=7&rm=3" style="width:100%;height:100%"><p>Reserve your perfect car before someone else drives it away.</p>'
            },
            "Marketing Email": {
                subject: "Exclusive Offers Just for You",
                body: '<img src="https://tse3.mm.bing.net/th/id/OIP.qYCUWrXU149uQhB8FwKzcwHaE8?rs=1&pid=ImgDetMain&o=7&rm=3" style="width:100%;height:100%"><p>Check out our latest deals tailored to your needs.</p>'
            },
            "Blank Template": {
                subject: "",
                body: ''
            }
        };

        if (templateSelect && subjectField) {
            templateSelect.addEventListener("change", function() {
                const selected = this.value;
                if (templates[selected]) {
                    subjectField.value = templates[selected].subject;
                    if (window.froalaEditor) {
                        window.froalaEditor.html.set(templates[selected].body);
                    }
                } else {
                    subjectField.value = "";
                    if (window.froalaEditor) {
                        window.froalaEditor.html.set("");
                    }
                }
            });
        }

        // Dynamically load templates when the campaign modal opens
        const emailModalEl = document.getElementById('emailModal');
        let campaignTemplatesMap = {};
        if (emailModalEl) {
            emailModalEl.addEventListener('show.bs.modal', async function() {
                try {
                    const r = await fetch('/api/templates');
                    if (!r.ok) return;
                    const json = await r.json().catch(() => null);
                    const tmpl = Array.isArray(json) ? json : (json?.data || json?.templates || []);
                    campaignTemplatesMap = {};
                    if (Array.isArray(tmpl) && templateSelect) {
                        // Populate options — prefer TomSelect API if initialized
                        campaignTemplatesMap = {};
                        try {
                            if (templateSelect.tomselect) {
                                templateSelect.tomselect.clearOptions();
                                tmpl.forEach(t => {
                                    templateSelect.tomselect.addOption({
                                        value: t.id,
                                        text: t.name || (t.template_name ||
                                            `Template ${t.id}`)
                                    });
                                    campaignTemplatesMap[String(t.id)] = {
                                        subject: t.subject || '',
                                        body: t.body || ''
                                    };
                                });
                                // refresh dropdown
                                try {
                                    templateSelect.tomselect.refreshOptions();
                                } catch (e) {}
                            } else {
                                // clear existing options (keep a first 'No selection')
                                const firstOption = templateSelect.querySelector('option[hidden]');
                                templateSelect.innerHTML = '';
                                if (firstOption) templateSelect.appendChild(firstOption);
                                tmpl.forEach(t => {
                                    const opt = document.createElement('option');
                                    opt.value = t.id;
                                    opt.text = t.name || (t.template_name ||
                                        `Template ${t.id}`);
                                    templateSelect.appendChild(opt);
                                    campaignTemplatesMap[String(t.id)] = {
                                        subject: t.subject || '',
                                        body: t.body || ''
                                    };
                                });
                            }
                        } catch (e) {
                            // fallback to DOM population
                            templateSelect.innerHTML = '';
                            tmpl.forEach(t => {
                                const opt = document.createElement('option');
                                opt.value = t.id;
                                opt.text = t.name || (t.template_name ||
                                    `Template ${t.id}`);
                                templateSelect.appendChild(opt);
                                campaignTemplatesMap[String(t.id)] = {
                                    subject: t.subject || '',
                                    body: t.body || ''
                                };
                            });
                        }
                    }
                    // load senders and languages as well
                    try {
                        const sres = await fetch('/api/senders');
                        if (sres.ok) {
                            const sd = await sres.json().catch(() => null) || {};
                            const teams = sd.teams || [];
                            const individuals = sd.individuals || [];
                            if (templateSelect) {
                                // populate senderSelect with teams and individuals
                                const senderEl = document.getElementById('senderSelect');
                                if (senderEl) {
                                    senderEl.innerHTML = '';
                                    const emptyOpt = document.createElement('option');
                                    emptyOpt.hidden = true;
                                    emptyOpt.value = '';
                                    emptyOpt.text = '--Select Sender--';
                                    senderEl.appendChild(emptyOpt);
                                    // Teams group
                                    const gTeams = document.createElement('optgroup');
                                    gTeams.label = 'Teams';
                                    teams.forEach(t => {
                                        const o = document.createElement('option');
                                        o.value = `team:${t.id}`;
                                        o.dataset.type = 'team';
                                        o.dataset.roleId = t.id;
                                        o.text = t.label;
                                        gTeams.appendChild(o);
                                    });
                                    senderEl.appendChild(gTeams);
                                    // Individuals group
                                    const gInd = document.createElement('optgroup');
                                    gInd.label = 'Individuals';
                                    individuals.forEach(u => {
                                        const o = document.createElement('option');
                                        o.value = u.id;
                                        o.dataset.type = 'individual';
                                        o.text = u.name;
                                        gInd.appendChild(o);
                                    });
                                    senderEl.appendChild(gInd);
                                }

                                // Populate backupSender (individuals only)
                                const backupEl = document.getElementById('backupSender');
                                if (backupEl) {
                                    backupEl.innerHTML = '';
                                    const emptyOpt2 = document.createElement('option');
                                    emptyOpt2.hidden = true;
                                    emptyOpt2.value = '';
                                    emptyOpt2.text = '--Select Backup Sender--';
                                    backupEl.appendChild(emptyOpt2);
                                    individuals.forEach(u => {
                                        const o = document.createElement('option');
                                        o.value = u.id;
                                        o.text = u.name;
                                        backupEl.appendChild(o);
                                    });
                                }

                                // Populate assignedToSelect with all individuals
                                const assignedEl = document.getElementById('assignedToSelect');
                                if (assignedEl) {
                                    assignedEl.innerHTML = '';
                                    const emptyOpt3 = document.createElement('option');
                                    emptyOpt3.hidden = true;
                                    emptyOpt3.value = '';
                                    emptyOpt3.text = '--Select Member--';
                                    assignedEl.appendChild(emptyOpt3);
                                    individuals.forEach(u => {
                                        const o = document.createElement('option');
                                        o.value = u.id;
                                        o.text = u.name;
                                        assignedEl.appendChild(o);
                                    });
                                }
                            }

                            // store teams map for later use when selecting a team
                            window.__campaignTeams = (sd.teams || []).reduce((acc, t) => {
                                acc[t.id] = t;
                                return acc;
                            }, {});
                        }

                        const lres = await fetch('/api/languages');
                        if (lres.ok) {
                            const langs = await lres.json().catch(() => null) || [];
                            const langEl = document.querySelector(
                                '#account-2 select[aria-label]') || document.querySelector(
                                '#account-2 select');
                            if (langEl) {
                                langEl.innerHTML = '';
                                langs.forEach(l => {
                                    const o = document.createElement('option');
                                    o.value = l.code || l.label;
                                    o.text = l.label || l.code;
                                    langEl.appendChild(o);
                                });
                            }
                        }
                    } catch (err) {
                        console.warn('Failed to load senders/languages', err);
                    }
                } catch (err) {
                    console.warn('Failed to load templates', err);
                }
            });
        }

        // If a dynamic templates map is present, prefer it
        const originalTemplateChange = templateSelect && templateSelect.onchange;

        if (templateSelect) {
            templateSelect.addEventListener('change', function() {
                const id = this.value;
                if (campaignTemplatesMap && campaignTemplatesMap[id]) {
                    subjectField.value = campaignTemplatesMap[id].subject || '';
                    if (window.froalaEditor) window.froalaEditor.html.set(campaignTemplatesMap[id]
                        .body || '');
                    return;
                }
                // fall back to existing templates object
                const selected = this.value;
                if (templates[selected]) {
                    subjectField.value = templates[selected].subject;
                    if (window.froalaEditor) window.froalaEditor.html.set(templates[selected].body);
                } else {
                    subjectField.value = "";
                    if (window.froalaEditor) window.froalaEditor.html.set("");
                }
            });
        }

        // Toggle Assigned To when sender is a team
        const senderSelectEl = document.getElementById('senderSelect');
        const assignedToContainer = document.getElementById('assignedToContainer');
        if (senderSelectEl && assignedToContainer) {
            senderSelectEl.addEventListener('change', function() {
                const opt = this.selectedOptions && this.selectedOptions[0];
                const type = opt && opt.dataset && opt.dataset.type;
                if (type === 'team') {
                    assignedToContainer.style.display = '';
                    // populate assignedToSelect with team members if available
                    const roleId = opt.dataset.roleId;
                    const assignedEl = document.getElementById('assignedToSelect');
                    if (assignedEl) {
                        assignedEl.innerHTML = '';
                        const emptyOpt = document.createElement('option');
                        emptyOpt.hidden = true;
                        emptyOpt.value = '';
                        emptyOpt.text = '--Select Member--';
                        assignedEl.appendChild(emptyOpt);
                        const team = window.__campaignTeams && window.__campaignTeams[roleId];
                        if (team && Array.isArray(team.members)) {
                            team.members.forEach(m => {
                                const o = document.createElement('option');
                                o.value = m.id;
                                o.text = m.name;
                                assignedEl.appendChild(o);
                            });
                        }
                    }
                } else {
                    assignedToContainer.style.display = 'none';
                }
            });
        }

        // Toggle mass/drip boxes when set type radios change
        const massRadio = document.getElementById('massSend');
        const dripRadio = document.getElementById('dripFunction');
        const massBox = document.getElementById('mass-box');
        const dripBox = document.getElementById('dripping-box');

        function updateSetTypeUI() {
            if (massRadio && massBox && dripBox && massRadio.checked) {
                massBox.style.display = 'block';
                dripBox.style.display = 'none';
            } else if (dripRadio && massBox && dripBox && dripRadio.checked) {
                massBox.style.display = 'none';
                dripBox.style.display = 'block';
            }
        }
        if (massRadio) massRadio.addEventListener('change', updateSetTypeUI);
        if (dripRadio) dripRadio.addEventListener('change', updateSetTypeUI);
        // initialize
        updateSetTypeUI();

        // ===== Wizard Functionality =====
        if ($('#campaignWizard').length) {
            $(document).ready(function() {
                var $wizard = $('#campaignWizard');
                var $progressBar = $wizard.find('.progress-bar');
                var $tabs = $wizard.find('.nav-pills li');
                var $tabLinks = $wizard.find('.nav-pills li a');
                var $tabContent = $wizard.find('.tab-content .tab-pane');
                var currentTab = 0;

                // Set initial state
                updateActiveTab();
                updateProgressBar();
                updateButtonVisibility();

                // Previous button click handler
                $('#prevStep').click(function(e) {
                    e.preventDefault();
                    if (currentTab > 0) {
                        currentTab--;
                        updateActiveTab();
                        updateProgressBar();
                        updateButtonVisibility();
                    }
                });

                // Next button click handler
                $('#nextStep').click(function(e) {
                    e.preventDefault();
                    if (currentTab < $tabs.length - 1) {
                        currentTab++;
                        updateActiveTab();
                        updateProgressBar();
                        updateButtonVisibility();
                    }
                });

                // Finish button click handler
                $('#finishStep').click(function(e) {
                    e.preventDefault();
                    currentTab = $tabs.length - 1;
                    updateActiveTab();
                    updateProgressBar();
                    updateButtonVisibility();
                    // gather campaign data from wizard and submit via API
                    try {
                        // collect selected recipients (checked rows)
                        const recipients = [];
                        document.querySelectorAll('tbody tr td .form-check-input:checked')
                            .forEach(cb => {
                                const tr = cb.closest('tr');
                                const cid = tr?.dataset?.customerId || tr?.getAttribute(
                                    'data-customer-id') || null;
                                if (cid) {
                                    const n = Number(cid);
                                    recipients.push(Number.isNaN(n) ? cid : n);
                                } else if (cb.value && cb.value.includes && cb.value
                                    .indexOf('@') !== -1) {
                                    recipients.push(cb.value);
                                } else if (cb.value) {
                                    recipients.push(cb.value);
                                }
                            });

                        const templateSelectEl = document.getElementById('templateSelect');
                        // If TomSelect is used, prefer its API to get the value
                        let selectedTemplateIdRaw = null;
                        if (templateSelectEl) {
                            if (templateSelectEl.tomselect && typeof templateSelectEl.tomselect
                                .getValue === 'function') {
                                selectedTemplateIdRaw = templateSelectEl.tomselect.getValue();
                            } else {
                                selectedTemplateIdRaw = templateSelectEl?.selectedOptions?.[0]
                                    ?.value ?? templateSelectEl?.value ?? null;
                            }
                        }
                        const selectedTemplateId = (selectedTemplateIdRaw && !isNaN(Number(
                                selectedTemplateIdRaw))) ? Number(selectedTemplateIdRaw) :
                            selectedTemplateIdRaw;
                        let selectedTemplateName = templateSelectEl?.selectedOptions?.[0]
                            ?.text || null;
                        // If we loaded templates into campaignTemplatesMap, resolve name by id when missing
                        if ((!selectedTemplateName || selectedTemplateName === '') &&
                            selectedTemplateIdRaw && campaignTemplatesMap) {
                            const tm = campaignTemplatesMap[String(selectedTemplateIdRaw)];
                            if (tm && tm.subject !== undefined) {
                                // tm holds subject/body map; try to find name if present
                                selectedTemplateName = tm.name || tm.template_name ||
                                    selectedTemplateName;
                            }
                        }

                        const payload = {
                            name: document.getElementById('campaignNameField')?.value ||
                                null,
                            template_id: selectedTemplateId,
                            template_name: selectedTemplateName,
                            sender_type: document.getElementById('senderSelect')
                                ?.selectedOptions?.[0]?.dataset?.type || null,
                            sender: document.getElementById('senderSelect')?.value || null,
                            backup_sender: document.getElementById('backupSender')?.value ||
                                null,
                            language: document.getElementById('languageSelect')?.value ||
                                null,
                            subject: document.getElementById('subjectField')?.value || null,
                            body: window.froalaEditor ? window.froalaEditor.html.get() :
                                document.getElementById('summaryBody')?.innerText || null,
                            start_at: document.getElementById('startDate')?.value || null,
                            end_at: document.getElementById('endDate')?.value || null,
                            set_type: document.getElementById('massSend')?.checked ?
                                'mass' : 'drip',
                            drip_initial_count: document.getElementById('dripInitialCount')
                                ?.value || null,
                            drip_days: document.getElementById('dripDays')?.value || null,
                            recipients: recipients
                        };

                        fetch('/api/campaigns', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]')?.content || ''
                            },
                            credentials: 'same-origin',
                            body: JSON.stringify(payload)
                        }).then(async res => {
                            let json = null;
                            const contentType = res.headers.get('content-type') ||
                                '';
                            if (contentType.includes('application/json')) {
                                try {
                                    json = await res.clone().json();
                                } catch (e) {
                                    json = null;
                                }
                            }

                            if (!res.ok) {
                                // Prefer server-provided message and validation errors
                                if (json && json.errors) {
                                    const errs = Object.values(json.errors).flat()
                                        .join('\n');
                                    const msg = (json.message ? json.message +
                                        '\n' : '') + errs;
                                    alert('Failed to save campaign: ' + msg);
                                } else if (json && json.message) {
                                    alert('Failed to save campaign: ' + json
                                        .message);
                                } else {
                                    const txt = await res.text().catch(() => null);
                                    alert('Failed to save campaign: ' + (txt || res
                                        .status));
                                }
                                return;
                            }

                            // Success: show server message if provided
                            if (!json) json = await res.json().catch(() => null);
                            const successMsg = (json && json.message) ? json
                                .message : 'Campaign saved';
                            $('#emailModal').modal('hide');
                            if (typeof showToast === 'function') showToast(
                                successMsg);
                            else alert(successMsg);
                        }).catch(err => {
                            console.error('Save campaign error', err);
                            alert('Failed to save campaign');
                        });
                    } catch (err) {
                        console.error(err);
                        alert('Failed to save campaign');
                    }
                });

                // Tab click handler
                $tabLinks.click(function(e) {
                    e.preventDefault();
                    var tabHref = $(this).attr('href');
                    currentTab = $tabContent.index($(tabHref));
                    updateActiveTab();
                    updateProgressBar();
                    updateButtonVisibility();
                });

                // Update active tab
                function updateActiveTab() {
                    $tabs.removeClass('active');
                    $tabs.eq(currentTab).addClass('active');
                    $tabContent.removeClass('active show');
                    $tabContent.eq(currentTab).addClass('active show');
                    $tabLinks.eq(currentTab).tab('show');
                    // If we're on the final tab, populate the summary from current inputs
                    try {
                        if (currentTab === $tabs.length - 1) {
                            updateCampaignSummary();
                        }
                    } catch (e) {
                        console.warn('updateCampaignSummary failed', e);
                    }
                }

                // Update progress bar
                function updateProgressBar() {
                    var percent = ((currentTab + 1) / $tabs.length) * 100;
                    $progressBar.css('width', percent + '%');
                }

                // Populate the summary fields on the final review tab
                function updateCampaignSummary() {
                    try {
                        const templateSelectEl = document.getElementById('templateSelect');
                        const templateName = templateSelectEl?.selectedOptions?.[0]?.text || '';
                        const senderEl = document.getElementById('senderSelect');
                        const senderText = senderEl?.selectedOptions?.[0]?.text || '';
                        const backupEl = document.getElementById('backupSender');
                        const backupText = backupEl?.selectedOptions?.[0]?.text || '';
                        const assignedEl = document.getElementById('assignedToSelect');
                        const assignedText = assignedEl?.selectedOptions?.[0]?.text || '';
                        const langEl = document.querySelector('#account-2 select[aria-label]') ||
                            document.querySelector('#account-2 select');
                        const langText = langEl?.selectedOptions?.[0]?.text || '';
                        const assignedtoSelect = document.getElementById('assignedToSelect');
                        const assignedtoText = assignedtoSelect?.selectedOptions?.[0]?.text || '';

                        const campaignName = document.getElementById('campaignNameField')?.value || '';
                        const subject = document.getElementById('subjectField')?.value || '';
                        const bodyHtml = window.froalaEditor ? window.froalaEditor.html.get() : (
                            document.getElementById('editor')?.innerHTML || document.getElementById(
                                'summaryBody')?.innerHTML || '');
                        const startAt = document.getElementById('startDate')?.value || '';
                        const endAt = document.getElementById('endDate')?.value || '';
                        const setType = document.getElementById('massSend')?.checked ?
                            'One-time Mass Send' : 'Dripping Function';
                        const recipients = [];
                        document.querySelectorAll('tbody tr td .form-check-input:checked').forEach(
                            cb => {
                                const tr = cb.closest('tr');
                                const cid = tr?.dataset?.customerId || tr?.getAttribute(
                                    'data-customer-id') || null;
                                if (cid) recipients.push(cid);
                            });
                        const recipientsCount = recipients.length;
                        const dripInitial = document.getElementById('dripInitialCount')?.value || '';
                        const dripDays = Number(document.getElementById('dripDays')?.value || 0) || 0;

                        // set summary fields
                        const setText = (id, text) => {
                            const el = document.getElementById(id);
                            if (el) el.textContent = text;
                        };
                        setText('summaryTemplate', templateName || '—');
                        setText('summarySender', senderText || '—');
                        setText('summaryAssignedTo', assignedText || '—');
                        setText('summaryFallbackSender', backupText || '—');
                        setText('summaryCampaignName', campaignName || '—');
                        setText('summaryStartDate', startAt ? (new Date(startAt)).toLocaleString() :
                            '—');
                        setText('summaryEndDate', endAt ? (new Date(endAt)).toLocaleString() : '—');
                        setText('summarySetType', setType);
                        setText('summaryRecipients', `${recipientsCount} selected`);
                        // drip schedule and totals
                        if (setType === 'One-time Mass Send') {
                            setText('summaryDripSchedule', 'All at once');
                        } else {
                            const perDay = dripDays > 0 ? Math.ceil((recipientsCount || 0) / dripDays) :
                                (dripInitial ? dripInitial + ' initial' : '—');
                            setText('summaryDripSchedule', perDay ? `${perDay} per day` : '—');
                        }
                        setText('summaryDripTotal', `${recipientsCount} messages`);
                        setText('summarySubject', subject || '—');
                        const summaryBodyEl = document.getElementById('summaryBody');
                        if (summaryBodyEl) summaryBodyEl.innerHTML = bodyHtml || '';
                    } catch (e) {
                        console.warn('Failed to populate campaign summary', e);
                    }
                }

                // Update button visibility
                function updateButtonVisibility() {
                    if (currentTab === 0) {
                        $('#prevStep').hide();
                    } else {
                        $('#prevStep').show();
                    }
                    if (currentTab === $tabs.length - 1) {
                        $('#nextStep').hide();
                        $('#finishStep').show();
                    } else {
                        $('#nextStep').show();
                        $('#finishStep').hide();
                    }
                }
            });
        }

        // ===== Checkbox Selection =====
        const selectAllCheckbox = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('tbody tr td .form-check-input');
        const sendCampaignBtn = document.getElementById('btnSendCampaign');

        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                const isChecked = this.checked;
                checkboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
                updateSendCampaignButton();
            });
        }

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                if (selectAllCheckbox) {
                    selectAllCheckbox.checked = allChecked;
                }
                updateSendCampaignButton();
            });
        });

        function updateSendCampaignButton() {
            if (!sendCampaignBtn) return;
            const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
            if (anyChecked) {
                sendCampaignBtn.disabled = false;
                sendCampaignBtn.classList.remove('btn-secondary');
                sendCampaignBtn.classList.add('btn-primary');
            } else {
                sendCampaignBtn.disabled = true;
                sendCampaignBtn.classList.remove('btn-primary');
                sendCampaignBtn.classList.add('btn-secondary');
            }
        }

        updateSendCampaignButton();

        // ===== Date Picker =====
        const fromInput = document.getElementById("fromDate");
        const toInput = document.getElementById("toDate");

        if (fromInput && toInput) {
            let fromPicker, toPicker;

            fromPicker = flatpickr("#fromCalendar", {
                inline: true,
                dateFormat: "F j, Y",
                onChange: function(selectedDates) {
                    if (selectedDates[0]) {
                        const dateStr = fromPicker.formatDate(selectedDates[0], "F j, Y");
                        fromInput.value = dateStr;
                        toPicker.set("minDate", selectedDates[0]);
                        if (toPicker.selectedDates[0] && toPicker.selectedDates[0] < selectedDates[
                                0]) {
                            toPicker.setDate(selectedDates[0], true);
                        }
                    }
                },
            });

            toPicker = flatpickr("#toCalendar", {
                inline: true,
                dateFormat: "F j, Y",
                onChange: function(selectedDates) {
                    if (selectedDates[0]) {
                        const dateStr = toPicker.formatDate(selectedDates[0], "F j, Y");
                        toInput.value = dateStr;
                        fromPicker.set("maxDate", selectedDates[0]);
                        if (fromPicker.selectedDates[0] && fromPicker.selectedDates[0] >
                            selectedDates[0]) {
                            fromPicker.setDate(selectedDates[0], true);
                        }
                    }
                },
            });

            function setRange(start, end) {
                fromPicker.setDate(start, true);
                toPicker.setDate(end, true);
                fromInput.value = fromPicker.formatDate(start, "F j, Y");
                toInput.value = toPicker.formatDate(end, "F j, Y");
                fromPicker.set("maxDate", end);
                toPicker.set("minDate", start);
            }

            // Date range button handlers
            const buttonHandlers = {
                "yesterdayBtn": () => {
                    const yesterday = new Date();
                    yesterday.setDate(yesterday.getDate() - 1);
                    setRange(yesterday, yesterday);
                },
                "todayBtn": () => {
                    const today = new Date();
                    setRange(today, today);
                },
                "last7Btn": () => {
                    const end = new Date();
                    const start = new Date();
                    start.setDate(end.getDate() - 6);
                    setRange(start, end);
                },
                "thisMonthBtn": () => {
                    const now = new Date();
                    const start = new Date(now.getFullYear(), now.getMonth(), 1);
                    const end = new Date(now.getFullYear(), now.getMonth() + 1, 0);
                    setRange(start, end);
                },
                "lastMonthBtn": () => {
                    const now = new Date();
                    const start = new Date(now.getFullYear(), now.getMonth() - 1, 1);
                    const end = new Date(now.getFullYear(), now.getMonth(), 0);
                    setRange(start, end);
                },
                "lastQuarterBtn": () => {
                    const now = new Date();
                    const currentQuarter = Math.floor(now.getMonth() / 3);
                    const start = new Date(now.getFullYear(), (currentQuarter - 1) * 3, 1);
                    const end = new Date(now.getFullYear(), currentQuarter * 3, 0);
                    setRange(start, end);
                },
                "thisYearBtn": () => {
                    const now = new Date();
                    const start = new Date(now.getFullYear(), 0, 1);
                    const end = new Date(now.getFullYear(), 11, 31);
                    setRange(start, end);
                },
                "lastYearBtn": () => {
                    const now = new Date();
                    const start = new Date(now.getFullYear() - 1, 0, 1);
                    const end = new Date(now.getFullYear() - 1, 11, 31);
                    setRange(start, end);
                }
            };

            // Attach event listeners to buttons
            Object.keys(buttonHandlers).forEach(buttonId => {
                const button = document.getElementById(buttonId);
                if (button) {
                    button.addEventListener("click", buttonHandlers[buttonId]);
                }
            });

            // Reset button
            const resetBtn = document.getElementById("resetBtn");
            if (resetBtn) {
                resetBtn.addEventListener("click", function() {
                    fromPicker.clear();
                    toPicker.clear();
                    fromInput.value = "";
                    toInput.value = "";
                    fromPicker.set("maxDate", null);
                    toPicker.set("minDate", null);
                });
            }

            // Modal reset on close
            const modal = document.getElementById("filterModal");
            if (modal) {
                modal.addEventListener("hidden.bs.modal", function() {
                    document.getElementById("dateField").value = "Sold Date";
                    fromPicker.clear();
                    toPicker.clear();
                    fromInput.value = "";
                    toInput.value = "";
                    fromPicker.set("maxDate", null);
                    toPicker.set("minDate", null);
                });
            }
            window.addEventListener("DOMContentLoaded", () => {
                startDateInput.value = "";
                endDateInput.value = "";
                massSendRadio.checked = true; // default checked
                updateDateFields();
            });
        }
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Customer Checkbox Management
        const selectAllCheckbox = document.getElementById('select-all');
        const customerCheckboxes = document.querySelectorAll('.customer-checkbox');
        const bulkDeleteBtn = document.getElementById('btnBulkDelete');
        const selectedCountSpan = document.getElementById('selectedCount');

        // Update bulk delete button visibility and count
        function updateBulkDeleteButton() {
            const checkedBoxes = document.querySelectorAll('.customer-checkbox:checked');
            const count = checkedBoxes.length;

            if (count > 0) {
                bulkDeleteBtn.style.display = 'inline-flex';
                selectedCountSpan.textContent = count;
            } else {
                bulkDeleteBtn.style.display = 'none';
            }
        }

        // Select all checkbox handler
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                customerCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateBulkDeleteButton();
            });
        }

        // Individual checkbox handlers
        customerCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                // Update select-all state
                const allChecked = Array.from(customerCheckboxes).every(cb => cb.checked);
                const someChecked = Array.from(customerCheckboxes).some(cb => cb.checked);

                if (selectAllCheckbox) {
                    selectAllCheckbox.checked = allChecked;
                    selectAllCheckbox.indeterminate = someChecked && !allChecked;
                }

                updateBulkDeleteButton();
            });
        });

        // Global variable to store modal instance
        const deleteModalEl = document.getElementById('delete_modal');
        const deleteModal = new bootstrap.Modal(deleteModalEl);

        let deleteCustomerId = null;

        // Open modal when delete button is clicked
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('delete-customer') || e.target.closest(
                    '.delete-customer')) {
                e.preventDefault();

                const deleteBtn = e.target.classList.contains('delete-customer') ?
                    e.target :
                    e.target.closest('.delete-customer');

                deleteCustomerId = deleteBtn.getAttribute('data-id');

                // Dynamically update modal text
                document.getElementById('delete_modal_text').textContent =
                    "Are you sure you want to delete this customer?";

                // Show modal
                deleteModal.show();
            }
        });

        // Confirm Delete Button Click
        document.getElementById('confirm_delete_btn').addEventListener('click', function() {
            if (!deleteCustomerId) return;

            fetch(`/customers/${deleteCustomerId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Hide modal
                    deleteModal.hide();

                    if (data.success) {
                        // Show success toast
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: data.message || 'Customer has been deleted.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });

                        // Reload page or remove row
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message || 'Failed to delete customer.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }

                    deleteCustomerId = null;
                })
                .catch(error => {
                    deleteModal.hide();
                    console.error('Delete error:', error);

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'An error occurred while deleting the customer.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    deleteCustomerId = null;
                });
        });


        // Bulk Delete Handler
        if (bulkDeleteBtn) {
            bulkDeleteBtn.addEventListener('click', function(e) {
                e.preventDefault();

                const checkedBoxes = document.querySelectorAll('.customer-checkbox:checked');
                const customerIds = Array.from(checkedBoxes).map(cb => cb.getAttribute(
                    'data-customer-id'));
                const count = customerIds.length;

                if (count === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Selection',
                        text: 'Please select at least one customer to delete.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: `You are about to delete ${count} customer(s). This action cannot be undone!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: `Yes, delete ${count} customer(s)!`,
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send bulk delete request
                        fetch('/customers/bulk-delete', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').content,
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    ids: customerIds
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: data.message ||
                                            `${data.count} customer(s) have been deleted.`,
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: true
                                    });

                                    // Reload the page
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 1000);
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: data.message ||
                                            'Failed to delete customers.',
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 3000
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Bulk delete error:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'An error occurred while deleting customers.',
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            });
                    }
                });
            });
        }
    });
</script>

<script>
    new TomSelect("#templateSelect", {
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        },
        placeholder: "Click to search templates",
        maxOptions: 1000
    });
</script>

{{-- customer table datable --}}
<script>
    $(document).ready(function() {
        if (!$.fn.DataTable.isDataTable('#customerTable')) {
            $('#customerTable').DataTable({
                dom: 'Bfrtip',
                buttons: ['colvis'],
                fixedHeader: true,
                pageLength: 10,
                responsive: true,
                language: {
                    paginate: {
                        previous: '<i class="isax isax-arrow-left"></i>',
                        next: '<i class="isax isax-arrow-right-1"></i>'
                    }
                }
            });
        }
    });
</script>


{{-- customer table logic  --}}

<script>
    let currentNotesRowId = null;
    let checkboxFilterInstances = {};
    let activeFilterDropdown = null;

    document.addEventListener("DOMContentLoaded", function() {
        const table = document.getElementById("customerTable");
        const filtersRow = document.getElementById("filtersRow");
        const filterWrappers = filtersRow.querySelectorAll(".filter-wrapper");
        let rows = Array.from(table.querySelectorAll("tbody tr"));

        function isBlankValue(value) {
            if (!value || value === '') return true;
            var trimmed = value.toString().trim();
            return trimmed === '' || trimmed === 'N/A' || trimmed === '-';
        }

        function extractTextFromCell(cell) {
            if (!cell) return '';
            let text = cell.innerText || cell.textContent || '';

            const badge = cell.querySelector('span.badge, .badge');
            if (badge) text = badge.innerText || badge.textContent || '';

            const link = cell.querySelector('a');
            if (link) text = link.innerText || link.textContent || '';

            return text.trim();
        }

        // Map human column names to tr.dataset keys
        function mapColumnToDataKeyShared(name) {
            const k = normalizeText(name);
            const map = {
                'customer name': 'fullName',
                'first name': 'fullName',
                'middle name': 'fullName',
                'last name': 'fullName',
                'email': 'email',
                'city': 'city',
                'postal code': 'zipCode',
                'province': 'state',
                'home phone': 'phone',
                'cell phone': 'cellPhone',
                'work phone': 'workPhone',
                'assigned to': 'assignedTo',
                'secondary assigned to': 'secondaryAssignedTo',
                'assigned manager': 'assignedManager',
                'bdc agent': 'bdcAgent',
                'lead source': 'leadSource',
                'lead type': 'leadType',
                'status': 'status',
                'interested make': 'interestedMake',
                'dealership franchises': 'dealershipFranchises',
                'sales status': 'salesStatus',
                'sales type': 'salesType',
                'deal type': 'dealType',
                'assigned by': 'assignedBy',
                'assigned date': 'assignedDate',
                'sold by': 'soldBy',
                'created date': 'createdDate',
                'sold date': 'soldDate',
                'delivery date': 'deliveryDate',
                'appointment date': 'appointmentDate',
                'last contacted date': 'lastContactedDate'
            };
            return map[k] || null;
        }

        function formatDateForFilter(dateStr) {
            if (!dateStr || dateStr === '-') return '';
            const date = new Date(dateStr);
            if (isNaN(date.getTime())) return '';

            const months = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];
            return `${months[date.getMonth()]} ${date.getDate()}, ${date.getFullYear()}`;
        }

        // Initialize filter dropdowns
        // helper: create filter trigger + setup for a wrapper
        function createFilterForWrapper(wrapper, colIndex) {
            if (!wrapper) return;
            if (wrapper.querySelector('.filter-dropdown-trigger')) return;

            const triggerBtn = document.createElement('button');
            triggerBtn.className = 'btn btn-sm btn-light filter-dropdown-trigger w-100 text-start';
            triggerBtn.type = 'button';
            triggerBtn.innerHTML = `
                    <span class="filter-text">Filter</span>
                    <span class="filter-icon float-end"><i class="ti ti-caret-down-filled ms-1"></i></span>
                `;
            triggerBtn.setAttribute('data-col', colIndex);

            wrapper.appendChild(triggerBtn);

            initializeFilterData(colIndex);

            triggerBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                toggleFilterDropdown(colIndex, this);
            });
        }
        // expose globally so other callers (outside this scope) can use it
        try {
            window.createFilterForWrapper = createFilterForWrapper;
        } catch (e) {}

        // initialize existing wrappers
        filterWrappers.forEach((wrapper) => {
            const colIndex = parseInt(wrapper.getAttribute('data-col'));
            createFilterForWrapper(wrapper, colIndex);
        });

        // Ensure any headers that were added server-side or restored have filter wrappers/triggers
        try {
            Array.from(mainHeaderRow.cells).forEach((th, idx) => {
                const addedName = th.dataset.addedCol;
                if (!addedName) return;
                // find corresponding wrapper cell in filterRow
                let wrapper = null;
                try {
                    wrapper = filterRow.querySelector('[data-added-col="' + CSS.escape(addedName) +
                        '"] .filter-wrapper');
                } catch (e) {
                    wrapper = null;
                }
                // if no wrapper exists, create a filter cell at the right position
                if (!wrapper) {
                    const thFilter = document.createElement('th');
                    thFilter.dataset.addedCol = addedName;
                    const w = document.createElement('div');
                    w.className = 'filter-wrapper';
                    w.setAttribute('data-col', idx);
                    thFilter.appendChild(w);
                    // insert before last cell
                    filterRow.insertBefore(thFilter, filterRow.cells[filterRow.cells.length - 1]);
                    wrapper = w;
                }
                // ensure wrapper has data-col and trigger
                wrapper.setAttribute('data-col', idx);
                if (!wrapper.querySelector('.filter-dropdown-trigger')) createFilterForWrapper(wrapper,
                    idx);
            });
            // rebuild header map after modifications
            rebuildHeaderMap();
        } catch (e) {
            console.warn('ensure added column wrappers failed', e);
        }

        // Initialize filter data for each column
        function initializeFilterData(colIndex) {
            let values = new Set();
            let hasBlankValues = false;

            rows.forEach(row => {
                let cell = row.cells[colIndex];
                let text = '';
                if (cell) text = extractTextFromCell(cell);

                // if cell text blank, try to use dataset fallback using header name
                if (isBlankValue(text)) {
                    try {
                        const headerText = (mainHeaderRow && mainHeaderRow.cells[colIndex]) ? (
                            mainHeaderRow.cells[colIndex].innerText || mainHeaderRow.cells[colIndex]
                            .textContent || '') : '';
                        const dataKey = mapColumnToDataKeyShared(headerText);
                        if (dataKey && row.dataset && row.dataset[dataKey]) {
                            text = row.dataset[dataKey];
                        }
                    } catch (e) {}
                }

                if (isBlankValue(text)) hasBlankValues = true;
                else if (text && text.length > 0) values.add(text);
            });

            // Store filter data
            checkboxFilterInstances[colIndex] = {
                values: Array.from(values).sort(),
                hasBlanks: hasBlankValues,
                selectedValues: new Set(),
                triggerBtn: null
            };
        }

        // Reinitialize filters after table body is replaced (AJAX updates)
        function reinitializeFilters() {
            // refresh row list
            rows = Array.from(table.querySelectorAll("tbody tr"));

            // rebuild filter data for each wrapper
            filterWrappers.forEach((wrapper) => {
                const colIndex = parseInt(wrapper.getAttribute("data-col"));
                initializeFilterData(colIndex);

                // update trigger button text/count if present
                const triggerBtn = wrapper.querySelector('.filter-dropdown-trigger');
                if (triggerBtn) {
                    const fd = checkboxFilterInstances[colIndex];
                    const selected = fd && fd.selectedValues ? fd.selectedValues.size : 0;
                    const textEl = triggerBtn.querySelector('.filter-text');
                    if (textEl) textEl.textContent = selected === 0 ? 'Filter' : `Filter (${selected})`;
                }
            });
            // restore any previously added client-side columns from storage
            try {
                const added = getAddedColumnsStorage();
                added.forEach(name => {
                    // If headerMap already contains it, skip
                    const key = (name || '').toString().replace(/\s+/g, ' ').trim().toLowerCase();
                    if (!headerMap.hasOwnProperty(key)) {
                        addColumn(name);
                    }
                });
            } catch (e) {
                console.warn('Failed to restore added columns', e);
            }
        }

        // Toggle filter dropdown
        function toggleFilterDropdown(colIndex, triggerBtn) {
            // Close any open dropdown
            if (activeFilterDropdown) {
                activeFilterDropdown.remove();
                activeFilterDropdown = null;
            }

            // Create new dropdown
            const dropdown = document.createElement("div");
            dropdown.className = "checkbox-filter-dropdown card shadow-lg";
            dropdown.style.position = "absolute";
            dropdown.style.zIndex = "1060";
            dropdown.style.minWidth = "250px";
            dropdown.style.maxHeight = "400px";
            dropdown.style.overflow = "hidden";

            // Position dropdown
            const rect = triggerBtn.getBoundingClientRect();
            dropdown.style.top = (rect.bottom + window.scrollY) + "px";
            dropdown.style.left = (rect.left + window.scrollX) + "px";

            // Get filter data
            const filterData = checkboxFilterInstances[colIndex];
            if (!filterData) return;

            // Build dropdown content
            dropdown.innerHTML = `
                <div class="card-body p-3">
                    <div class="checkbox-filter-header">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="selectAllCheckbox_${colIndex}">
                            <label class="form-check-label fw-semibold" for="selectAllCheckbox_${colIndex}">Select All</label>
                        </div>
                        <input type="text" class="form-control form-control-sm mb-2 search-filter"
                               placeholder="Search options..." data-col="${colIndex}">
                    </div>
                    <div class="checkbox-filter-options" style="max-height: 250px; overflow-y: auto;">
                        ${generateCheckboxOptions(colIndex, filterData)}
                    </div>
                    <div class="checkbox-filter-footer mt-3 pt-2 border-top">
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-sm btn-primary apply-filter-btn" data-col="${colIndex}">
                                Apply Filter
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary clear-filter-btn" data-col="${colIndex}">
                                Clear
                            </button>
                        </div>
                        <div class="mt-2 small text-muted selected-count" data-col="${colIndex}">
                            Selected: 0
                        </div>
                    </div>
                </div>
            `;

            document.body.appendChild(dropdown);
            activeFilterDropdown = dropdown;

            // Initialize dropdown functionality
            initializeDropdownFunctionality(colIndex, dropdown, triggerBtn, filterData);

            // Close dropdown when clicking outside
            setTimeout(() => {
                document.addEventListener("click", function closeDropdown(e) {
                    if (!dropdown.contains(e.target) && e.target !== triggerBtn) {
                        dropdown.remove();
                        document.removeEventListener("click", closeDropdown);
                        activeFilterDropdown = null;
                    }
                });
            }, 10);
        }

        // Generate checkbox options HTML
        function generateCheckboxOptions(colIndex, filterData) {
            let html = '';

            // Add (Blanks) option if applicable
            if (filterData.hasBlanks) {
                const isChecked = filterData.selectedValues.has('(Blanks)');
                html += `
                    <div class="form-check mb-1">
                        <input class="form-check-input filter-checkbox" type="checkbox"
                               value="(Blanks)" id="blank_${colIndex}"
                               data-col="${colIndex}" ${isChecked ? 'checked' : ''}>
                        <label class="form-check-label" for="blank_${colIndex}">
                            <span class="text-muted">(Blanks)</span>
                        </label>
                    </div>
                `;
            }

            // Add regular options
            filterData.values.forEach((value, index) => {
                const isChecked = filterData.selectedValues.has(value);
                html += `
                    <div class="form-check mb-1">
                        <input class="form-check-input filter-checkbox" type="checkbox"
                               value="${value}" id="opt_${colIndex}_${index}"
                               data-col="${colIndex}" ${isChecked ? 'checked' : ''}>
                        <label class="form-check-label" for="opt_${colIndex}_${index}">
                            ${value}
                        </label>
                    </div>
                `;
            });

            return html;
        }

        // Initialize dropdown functionality
        function initializeDropdownFunctionality(colIndex, dropdown, triggerBtn, filterData) {
            const selectAllCheckbox = dropdown.querySelector(`#selectAllCheckbox_${colIndex}`);
            const searchInput = dropdown.querySelector('.search-filter');
            const applyBtn = dropdown.querySelector('.apply-filter-btn');
            const clearBtn = dropdown.querySelector('.clear-filter-btn');
            const selectedCount = dropdown.querySelector('.selected-count');
            const optionsContainer = dropdown.querySelector('.checkbox-filter-options');

            // Update selected count
            function updateSelectedCount() {
                const selected = filterData.selectedValues.size;
                selectedCount.textContent = `Selected: ${selected}`;

                // Update trigger button text
                if (selected === 0) {
                    triggerBtn.querySelector('.filter-text').textContent = 'Filter';
                } else {
                    triggerBtn.querySelector('.filter-text').textContent = `Filter (${selected})`;
                }
            }

            // Search functionality
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const checkboxes = optionsContainer.querySelectorAll('.form-check');

                checkboxes.forEach(div => {
                    const label = div.querySelector('label');
                    const text = label.textContent.toLowerCase();
                    div.style.display = text.includes(searchTerm) ? 'block' : 'none';
                });
            });

            // Select All functionality
            selectAllCheckbox.addEventListener('change', function() {
                const checkboxes = optionsContainer.querySelectorAll('.filter-checkbox');
                checkboxes.forEach(cb => {
                    cb.checked = this.checked;
                    if (this.checked) {
                        filterData.selectedValues.add(cb.value);
                    } else {
                        filterData.selectedValues.delete(cb.value);
                    }
                });
                updateSelectedCount();
            });

            // Individual checkbox functionality
            optionsContainer.addEventListener('change', function(e) {
                if (e.target.classList.contains('filter-checkbox')) {
                    const checkbox = e.target;
                    if (checkbox.checked) {
                        filterData.selectedValues.add(checkbox.value);
                    } else {
                        filterData.selectedValues.delete(checkbox.value);
                        selectAllCheckbox.checked = false;
                    }
                    updateSelectedCount();
                }
            });

            // Apply filter - FIXED: Close dropdown after applying
            applyBtn.addEventListener('click', function() {
                applyColumnFilter(colIndex);

                // Close the dropdown immediately
                if (activeFilterDropdown) {
                    activeFilterDropdown.remove();
                    activeFilterDropdown = null;
                }

                // Also remove the click outside event listener
                document.removeEventListener("click", handleClickOutside);
            });

            // Clear filter - Also close dropdown
            clearBtn.addEventListener('click', function() {
                filterData.selectedValues.clear();
                const checkboxes = optionsContainer.querySelectorAll('.filter-checkbox');
                checkboxes.forEach(cb => cb.checked = false);
                selectAllCheckbox.checked = false;
                applyColumnFilter(colIndex);
                updateSelectedCount();

                // Close dropdown after clearing
                if (activeFilterDropdown) {
                    activeFilterDropdown.remove();
                    activeFilterDropdown = null;
                }

                // Remove click outside event listener
                document.removeEventListener("click", handleClickOutside);
            });

            // Function to handle click outside
            function handleClickOutside(e) {
                if (!dropdown.contains(e.target) && e.target !== triggerBtn) {
                    dropdown.remove();
                    document.removeEventListener("click", handleClickOutside);
                    activeFilterDropdown = null;
                }
            }

            // Set up click outside listener
            setTimeout(() => {
                document.addEventListener("click", handleClickOutside);
            }, 10);

            // Initial count update
            updateSelectedCount();
        }

        // Apply filter for specific column
        function applyColumnFilter(colIndex) {
            const filterData = checkboxFilterInstances[colIndex];
            if (!filterData) return;

            // Apply all filters
            applyAllFilters();
        }

        // Apply all filters to all rows
        function applyAllFilters() {
            rows.forEach(row => {
                let show = true;

                // Check each column filter
                for (const [colIndex, filterData] of Object.entries(checkboxFilterInstances)) {
                    if (filterData.selectedValues.size === 0) continue;

                    const cell = row.cells[parseInt(colIndex)];
                    let cellMatches = false;
                    const cellText = extractTextFromCell(cell);

                    // Check if cell matches any selected value
                    for (const selectedValue of filterData.selectedValues) {
                        if (selectedValue === '(Blanks)' && isBlankValue(cellText)) {
                            cellMatches = true;
                            break;
                        } else if (selectedValue === cellText) {
                            cellMatches = true;
                            break;
                        }
                    }

                    if (!cellMatches) {
                        show = false;
                        break;
                    }
                }

                row.style.display = show ? "" : "none";
            });

            updateVisibleRowsCount();
            updateSelectAllCheckbox();
        }

        // Update visible rows count
        function updateVisibleRowsCount() {
            const visibleRows = rows.filter(r => r.style.display !== "none").length;
            console.log(`Showing ${visibleRows} of ${rows.length} rows`);
        }

        // Update Select All checkbox state
        function updateSelectAllCheckbox() {
            const selectAllCheckbox = document.getElementById("select-all");
            if (!selectAllCheckbox) return;

            const visibleCheckboxes = Array.from(document.querySelectorAll(
                    ".form-check-input:not(#select-all)"))
                .filter(cb => {
                    const tr = cb.closest("tr");
                    return tr && tr.style.display !== "none";
                });

            if (visibleCheckboxes.length === 0) {
                selectAllCheckbox.checked = false;
                selectAllCheckbox.indeterminate = false;
                return;
            }

            const checkedCount = visibleCheckboxes.filter(cb => cb.checked).length;
            selectAllCheckbox.checked = checkedCount === visibleCheckboxes.length;
            selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < visibleCheckboxes.length;
        }

        // --- Select All Checkbox (for main table checkboxes) ---
        const selectAllCheckbox = document.getElementById("select-all");
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener("change", function() {
                const visibleCheckboxes = Array.from(document.querySelectorAll(
                        ".form-check-input:not(#select-all)"))
                    .filter(cb => {
                        const tr = cb.closest("tr");
                        return tr && tr.style.display !== "none";
                    });

                visibleCheckboxes.forEach(cb => {
                    cb.checked = this.checked;
                });
            });

            document.addEventListener("change", function(e) {
                if (e.target.classList.contains("form-check-input") && e.target.id !== "select-all") {
                    updateSelectAllCheckbox();
                }
            });
        }

        // Show all rows by default
        applyAllFilters();

        // Expose a safe global wrapper to refresh client-side filters from other scripts
        window.refreshClientFilters = function() {
            try {
                reinitializeFilters();
                applyAllFilters();
                updateSelectAllCheckbox();
                try {
                    if (window.rebindCustomerHover) window.rebindCustomerHover();
                } catch (e) {}
            } catch (e) {
                console.warn('refreshClientFilters failed', e);
            }
        };
    });
</script>


{{-- merge csutomers logic --}}

<script>
    let customers = [];
    let currentStep = 1;
    let selectedMainCustomer = null;
    let selectedDuplicateCustomer = null;

    // Initialize modal and fetch customers
    document.addEventListener('DOMContentLoaded', function() {
        fetchCustomers();
        setupSearch();
        setupEventListeners();
    });

    function fetchCustomers() {
        fetch('/customers', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success && data.customers) {
                    customers = data.customers.map(customer => ({
                        id: customer.id,
                        firstName: customer.first_name || '',
                        middleName: customer.middle_name || '',
                        lastName: customer.last_name || '',
                        email: customer.email || '',
                        mobilePhone: customer.cell_phone || '',
                        homePhone: customer.phone || '',
                        workPhone: customer.work_phone || '',
                        address: [customer.address, customer.city, customer.state, customer.zip_code]
                            .filter(Boolean).join(', ') || 'No Address',
                        initials: ((customer.first_name?.[0] || '') + (customer.last_name?.[0] || ''))
                            .toUpperCase(),
                        city: customer.city || '',
                        state: customer.state || '',
                        zipCode: customer.zip_code || '',
                        issues: []
                    }));
                    renderCustomers('customerList1', customers);
                }
            })
            .catch(error => {
                console.error('Error fetching customers:', error);
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to load customers',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            });
    }

    function setupEventListeners() {
        document.getElementById('goBackBtn').addEventListener('click', goBack);
        document.getElementById('mergeBtn').addEventListener('click', mergeRecords);

        // Reset modal when closed
        document.getElementById('duplicateModal').addEventListener('hidden.bs.modal', resetModal);
    }

    function setupSearch() {
        document.getElementById('searchInput1').addEventListener('input', function() {
            filterCustomers('customerList1', this.value);
        });

        document.getElementById('searchInput2').addEventListener('input', function() {
            filterCustomers('customerList2', this.value);
        });
    }

    function filterCustomers(containerId, searchTerm) {
        const filteredCustomers = customers.filter(customer =>
            `${customer.firstName} ${customer.lastName}`.toLowerCase().includes(searchTerm.toLowerCase()) ||
            customer.email.toLowerCase().includes(searchTerm.toLowerCase())
        );
        renderCustomers(containerId, filteredCustomers);
    }

    function renderCustomers(containerId, customerList) {
        const container = document.getElementById(containerId);
        container.innerHTML = '';

        customerList.forEach(customer => {
            const customerCard = createCustomerCard(customer, containerId === 'customerList1' ? 'main' :
                'duplicate');
            container.appendChild(customerCard);
        });
    }

    function createCustomerCard(customer, type) {
        const card = document.createElement('div');
        card.className = 'customer-card d-flex align-items-center';

        const issuesHtml = customer.issues.length > 0 ?
            customer.issues.map(issue => `<span class="invalid-field me-2">&lt;-${issue}-&gt;</span>`).join('') : '';

        const fullName =
            `${customer.firstName} ${customer.middleName ? customer.middleName + ' ' : ''}${customer.lastName}`;

        card.innerHTML = `
                <div class="record-id">ID # ${customer.id}</div>
                <div class="customer-avatar">${customer.initials}</div>
                <div class="customer-info">
                    <div class="customer-name">${fullName}</div>
                    <div class="customer-details">
                        <div>M: ${customer.mobilePhone || '-'}</div>
                        <div>H: ${customer.homePhone || '-'}</div>
                        <div>${customer.email || '-'}</div>
                        <div>${customer.address} ${issuesHtml}</div>
                    </div>
                </div>
                <button class="action-btn" onclick="selectCustomer(${customer.id}, '${type}')">
                    ${type === 'main' ? 'KEEP THE MAIN' : 'MERGE THE DUPLICATE'}
                </button>
            `;

        return card;
    }

    function selectCustomer(customerId, type) {
        const customer = customers.find(c => c.id === customerId);

        if (type === 'main') {
            selectedMainCustomer = customer;
            goToStep2();
        } else {
            selectedDuplicateCustomer = customer;
            goToStep3();
        }
    }

    function goToStep2() {
        currentStep = 2;
        updateStepIndicator();
        document.getElementById('stepTitle').textContent = 'Step 2 of 3 - Choose Duplicate';

        // Hide step 1, show step 2
        document.getElementById('step1Content').style.display = 'none';
        document.getElementById('step2Content').style.display = 'block';

        // Show selected main customer
        document.getElementById('selectedMainCustomer').innerHTML = createSelectedCustomerHtml(selectedMainCustomer);

        // Render customers for step 2 (excluding the selected main customer)
        const availableCustomers = customers.filter(c => c.id !== selectedMainCustomer.id);
        renderCustomers('customerList2', availableCustomers);

        // Show go back button
        document.getElementById('goBackBtn').style.display = 'inline-block';
    }

    function goToStep3() {
        currentStep = 3;
        updateStepIndicator();
        document.getElementById('stepTitle').textContent = 'Step 3 of 3 - Confirm';

        // Hide step 2, show step 3
        document.getElementById('step2Content').style.display = 'none';
        document.getElementById('step3Content').style.display = 'block';

        // Populate the comparison table
        populateStep3Comparison();

        // Show merge button
        document.getElementById('mergeBtn').style.display = 'inline-block';
    }

    function populateStep3Comparison() {
        // Set record IDs
        document.getElementById('mainRecordId').textContent = selectedMainCustomer.id;
        document.getElementById('duplicateRecordId').textContent = selectedDuplicateCustomer.id;

        // Set first names
        document.getElementById('mainFirstName').textContent = selectedMainCustomer.firstName || '-';
        document.getElementById('duplicateFirstName').textContent = selectedDuplicateCustomer.firstName || '-';

        // Set middle names
        document.getElementById('mainMiddleName').textContent = selectedMainCustomer.middleName || '-';
        document.getElementById('duplicateMiddleName').textContent = selectedDuplicateCustomer.middleName || '-';

        // Set last names
        document.getElementById('mainLastName').textContent = selectedMainCustomer.lastName || '-';
        document.getElementById('duplicateLastName').textContent = selectedDuplicateCustomer.lastName || '-';

        // Set physical addresses
        document.getElementById('mainAddress').textContent = selectedMainCustomer.address;
        document.getElementById('duplicateAddress').textContent = selectedDuplicateCustomer.address;

        // Set mobile phones
        document.getElementById('mainMobile').textContent = selectedMainCustomer.mobilePhone || '-';
        document.getElementById('duplicateMobile').textContent = selectedDuplicateCustomer.mobilePhone || '-';

        // Set home phones
        document.getElementById('mainHome').textContent = selectedMainCustomer.homePhone || '-';
        document.getElementById('duplicateHome').textContent = selectedDuplicateCustomer.homePhone || '-';

        // Set work phones
        document.getElementById('mainWork').textContent = selectedMainCustomer.workPhone || '-';
        document.getElementById('duplicateWork').textContent = selectedDuplicateCustomer.workPhone || '-';

        // Set emails
        document.getElementById('mainEmail').textContent = selectedMainCustomer.email;
        document.getElementById('duplicateEmail').textContent = selectedDuplicateCustomer.email;

        // Show invalid address issues for duplicate
        const issuesContainer = document.getElementById('duplicateAddressIssues');
        issuesContainer.innerHTML = '';
        if (selectedDuplicateCustomer.issues.length > 0) {
            selectedDuplicateCustomer.issues.forEach(issue => {
                const tag = document.createElement('span');
                tag.className = 'invalid-tag';
                tag.textContent = `← ${issue} →`;
                issuesContainer.appendChild(tag);
            });
        }
    }

    function createSelectedCustomerHtml(customer) {
        const issuesHtml = customer.issues.length > 0 ?
            customer.issues.map(issue => `<span class="invalid-field me-2">&lt;-${issue}-&gt;</span>`).join('') : '';

        const fullName =
            `${customer.firstName} ${customer.middleName ? customer.middleName + ' ' : ''}${customer.lastName}`;

        return `
                <div class="customer-card d-flex align-items-center">
                    <div class="record-id">ID # ${customer.id}</div>
                    <div class="customer-avatar">${customer.initials}</div>
                    <div class="customer-info">
                        <div class="customer-name">${fullName}</div>
                        <div class="customer-details">
                            <div>M: ${customer.mobilePhone || '-'}</div>
                            <div>H: ${customer.homePhone || '-'}</div>
                            <div>${customer.email || '-'}</div>
                            <div>${customer.address} ${issuesHtml}</div>
                        </div>
                    </div>
                </div>
            `;
    }

    function updateStepIndicator() {
        // Reset all steps
        document.querySelectorAll('.step').forEach((step, index) => {
            step.className = 'step';
            if (index < currentStep - 1) {
                step.classList.add('completed');
            } else if (index === currentStep - 1) {
                step.classList.add('active');
            }
        });

        // Update lines
        document.querySelectorAll('.step-line').forEach((line, index) => {
            line.className = 'step-line';
            if (index < currentStep - 1) {
                line.classList.add('active');
            }
        });
    }

    function goBack() {
        if (currentStep === 2) {
            currentStep = 1;
            document.getElementById('stepTitle').textContent = 'Step 1 of 3 - Choose Main Record';
            document.getElementById('step2Content').style.display = 'none';
            document.getElementById('step1Content').style.display = 'block';
            document.getElementById('goBackBtn').style.display = 'none';
            selectedMainCustomer = null;
        } else if (currentStep === 3) {
            currentStep = 2;
            document.getElementById('stepTitle').textContent = 'Step 2 of 3 - Choose Duplicate';
            document.getElementById('step3Content').style.display = 'none';
            document.getElementById('step2Content').style.display = 'block';
            document.getElementById('mergeBtn').style.display = 'none';
            selectedDuplicateCustomer = null;
        }
        updateStepIndicator();
    }

    function mergeRecords() {
        // Collect selected field values
        const mergedData = {
            main_customer_id: selectedMainCustomer.id,
            duplicate_customer_id: selectedDuplicateCustomer.id,
            merged_fields: {
                first_name: getSelectedFieldValue('firstName', 'FirstName'),
                middle_name: getSelectedFieldValue('middleName', 'MiddleName'),
                last_name: getSelectedFieldValue('lastName', 'LastName'),
                cell_phone: getSelectedFieldValue('mobile', 'Mobile'),
                phone: getSelectedFieldValue('home', 'Home'),
                work_phone: getSelectedFieldValue('work', 'Work'),
                email: getSelectedFieldValue('email', 'Email')
            }
        };

        console.log('Merge data:', mergedData);

        // Hide step 3 content and buttons
        document.getElementById('step3Content').style.display = 'none';
        document.getElementById('goBackBtn').style.display = 'none';
        document.getElementById('mergeBtn').style.display = 'none';

        // Show loading
        document.getElementById('loadingContent').style.display = 'block';

        // Send merge request to backend
        fetch('/customers/merge', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(mergedData)
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response ok:', response.ok);
                if (!response.ok) {
                    return response.text().then(text => {
                        console.error('Response text:', text);
                        try {
                            const json = JSON.parse(text);
                            throw new Error(json.message || 'Network response was not ok');
                        } catch (e) {
                            throw new Error(text || 'Network response was not ok');
                        }
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Merge response:', data);
                // Close main modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('duplicateModal'));
                if (modal) {
                    modal.hide();
                }

                if (data.success) {
                    // Show success modal
                    setTimeout(() => {
                        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                        successModal.show();

                        // Reload page after success modal is closed
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    }, 300);
                } else {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Merge Failed',
                            text: data.message || 'Failed to merge customers',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                }
            })
            .catch(error => {
                console.error('Merge error:', error);

                // Hide loading
                document.getElementById('loadingContent').style.display = 'none';

                const modal = bootstrap.Modal.getInstance(document.getElementById('duplicateModal'));
                if (modal) {
                    modal.hide();
                }

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message || 'An error occurred while merging customers',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            });
    }

    function getSelectedFieldValue(radioName, elementSuffix) {
        const selected = document.querySelector(`input[name="${radioName}"]:checked`);
        if (!selected) return null;

        const value = selected.value;
        const elementId = value === 'main' ? `main${elementSuffix}` : `duplicate${elementSuffix}`;
        const element = document.getElementById(elementId);

        if (!element) {
            console.warn(`Element not found: ${elementId}`);
            return null;
        }

        const textValue = element.textContent.trim();
        return (textValue === '-' || textValue === '') ? null : textValue;
    }

    function resetModal() {
        currentStep = 1;
        selectedMainCustomer = null;
        selectedDuplicateCustomer = null;

        // Reset step indicator
        updateStepIndicator();

        // Reset content visibility
        document.getElementById('stepTitle').textContent = 'Step 1 of 3 - Choose Main Record';
        document.getElementById('step1Content').style.display = 'block';
        document.getElementById('step2Content').style.display = 'none';
        document.getElementById('step3Content').style.display = 'none';
        document.getElementById('loadingContent').style.display = 'none';

        // Reset buttons
        document.getElementById('goBackBtn').style.display = 'none';
        document.getElementById('mergeBtn').style.display = 'none';

        // Clear search inputs
        document.getElementById('searchInput1').value = '';
        document.getElementById('searchInput2').value = '';

        // Re-render initial customer list
        renderCustomers('customerList1', customers);
    }
</script>

{{-- Date Filter & Export Functionality --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if flatpickr is loaded
        if (typeof flatpickr === 'undefined') {
            console.error('Flatpickr is not loaded!');
            return;
        }

        // Date filter variables
        let filteredRows = [];
        let currentDateField = 'Created Date';
        let fromDate = null;
        let toDate = null;

        // Initialize or reuse Flatpickr instances for date pickers
        const fromEl = document.getElementById('fromCalendar');
        const toEl = document.getElementById('toCalendar');
        let fromCalendar, toCalendar;

        if (fromEl && fromEl._flatpickr) {
            fromCalendar = fromEl._flatpickr;
        } else if (fromEl) {
            fromCalendar = flatpickr(fromEl, {
                dateFormat: "Y-m-d",
                allowInput: true,
                onChange: function(selectedDates, dateStr) {
                    fromDate = dateStr;
                    document.getElementById('fromDate').value = dateStr;
                    console.log('From date selected:', dateStr);
                }
            });
        }

        if (toEl && toEl._flatpickr) {
            toCalendar = toEl._flatpickr;
        } else if (toEl) {
            toCalendar = flatpickr(toEl, {
                dateFormat: "Y-m-d",
                allowInput: true,
                onChange: function(selectedDates, dateStr) {
                    toDate = dateStr;
                    document.getElementById('toDate').value = dateStr;
                    console.log('To date selected:', dateStr);
                }
            });
        }

        // Quick date range buttons
        document.getElementById('beginningbtn').addEventListener('click', function() {
            if (fromCalendar) fromCalendar.setDate(new Date('1970-01-01'));
            if (toCalendar) toCalendar.setDate(new Date());
        });

        document.getElementById('todayBtn').addEventListener('click', function() {
            const today = new Date();
            fromCalendar.setDate(today);
            toCalendar.setDate(today);
        });

        document.getElementById('yesterdayBtn').addEventListener('click', function() {
            const yesterday = new Date();
            yesterday.setDate(yesterday.getDate() - 1);
            fromCalendar.setDate(yesterday);
            toCalendar.setDate(yesterday);
        });

        document.getElementById('last7Btn').addEventListener('click', function() {
            const today = new Date();
            const last7 = new Date();
            last7.setDate(today.getDate() - 7);
            fromCalendar.setDate(last7);
            toCalendar.setDate(today);
        });

        document.getElementById('next7Btn').addEventListener('click', function() {
            const today = new Date();
            const next7 = new Date();
            next7.setDate(today.getDate() + 7);
            fromCalendar.setDate(today);
            toCalendar.setDate(next7);
        });

        document.getElementById('thisMonthBtn').addEventListener('click', function() {
            const today = new Date();
            const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
            const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
            fromCalendar.setDate(firstDay);
            toCalendar.setDate(lastDay);
        });

        document.getElementById('lastMonthBtn').addEventListener('click', function() {
            const today = new Date();
            const firstDay = new Date(today.getFullYear(), today.getMonth() - 1, 1);
            const lastDay = new Date(today.getFullYear(), today.getMonth(), 0);
            fromCalendar.setDate(firstDay);
            toCalendar.setDate(lastDay);
        });

        document.getElementById('lastQuarterBtn').addEventListener('click', function() {
            const today = new Date();
            const quarter = Math.floor(today.getMonth() / 3);
            const firstDay = new Date(today.getFullYear(), (quarter - 1) * 3, 1);
            const lastDay = new Date(today.getFullYear(), quarter * 3, 0);
            fromCalendar.setDate(firstDay);
            toCalendar.setDate(lastDay);
        });

        document.getElementById('thisYearBtn').addEventListener('click', function() {
            const today = new Date();
            const firstDay = new Date(today.getFullYear(), 0, 1);
            const lastDay = new Date(today.getFullYear(), 11, 31);
            fromCalendar.setDate(firstDay);
            toCalendar.setDate(lastDay);
        });

        document.getElementById('lastYearBtn').addEventListener('click', function() {
            const today = new Date();
            const firstDay = new Date(today.getFullYear() - 1, 0, 1);
            const lastDay = new Date(today.getFullYear() - 1, 11, 31);
            fromCalendar.setDate(firstDay);
            toCalendar.setDate(lastDay);
        });

        // Date field selection
        document.getElementById('dateField').addEventListener('change', function() {
            currentDateField = this.value;
        });

        // Apply filter
        document.getElementById('applyBtn').addEventListener('click', function() {
            // Get current values from inputs
            const fromValue = document.getElementById('fromDate').value;
            const toValue = document.getElementById('toDate').value;

            if (!fromValue || !toValue) {
                alert('Please select both start and end dates');
                return;
            }

            // Update the variables
            fromDate = fromValue;
            toDate = toValue;

            filterTableByDate();
            // Safely hide the filter modal if it exists
            (function() {
                const modalEl = document.getElementById('filterModal');
                if (!modalEl) return;
                let modalInst = null;
                try {
                    modalInst = bootstrap.Modal.getInstance(modalEl);
                } catch (e) {
                    modalInst = null;
                }
                if (!modalInst && typeof bootstrap.Modal === 'function') {
                    try {
                        modalInst = new bootstrap.Modal(modalEl);
                    } catch (e) {
                        modalInst = null;
                    }
                }
                if (modalInst && typeof modalInst.hide === 'function') {
                    try {
                        modalInst.hide();
                    } catch (e) {
                        console.warn('Failed to hide filter modal', e);
                    }
                }
            })();
        });

        // Reset filter
        document.getElementById('resetBtn').addEventListener('click', function() {
            fromCalendar.clear();
            toCalendar.clear();
            fromDate = null;
            toDate = null;
            currentDateField = 'Created Date';
            document.getElementById('dateField').value = 'Created Date';

            // Reload all customers
            fetch('/customers', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector('#customerTable tbody').innerHTML = data.html;
                        // Refresh client-side filters to reflect new rows
                        try {
                            if (window.refreshClientFilters) window.refreshClientFilters();
                        } catch (e) {
                            console.warn('Failed to reinit filters after reset', e);
                        }
                    }
                });
        });

        function filterTableByDate() {
            // Show loading state
            const tbody = document.querySelector('#customerTable tbody');
            const loadingRow =
                '<tr><td colspan="35" class="text-center py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></td></tr>';
            tbody.innerHTML = loadingRow;

            // Send AJAX request to server
            // Parse incoming date strings robustly and normalize to SQL datetimes
            function toSQLDateTime(str, endOfDay) {
                if (!str) return null;
                // Try native Date parse first (handles 'January 1, 2026' and ISO)
                let d = new Date(str);
                if (isNaN(d.getTime())) {
                    // Try Flatpickr parse with common human format
                    if (typeof flatpickr !== 'undefined' && flatpickr.parseDate) {
                        try {
                            d = flatpickr.parseDate(str, "F j, Y");
                        } catch (e) {
                            d = new Date(str);
                        }
                    }
                }
                if (isNaN(d.getTime())) return null;
                const yyyy = d.getFullYear();
                const mm = String(d.getMonth() + 1).padStart(2, '0');
                const dd = String(d.getDate()).padStart(2, '0');
                const time = endOfDay ? '23:59:59' : '00:00:00';
                return `${yyyy}-${mm}-${dd} ${time}`;
            }

            const payloadFrom = toSQLDateTime(fromDate, false);
            const payloadTo = toSQLDateTime(toDate, true);

            if (!payloadFrom || !payloadTo) {
                console.warn('Invalid date parsing for', {
                    fromDate,
                    toDate
                });
                alert('Unable to parse selected dates. Please reselect the date range.');
                return;
            }

            const params = {
                date_field: currentDateField,
                from_date: payloadFrom,
                to_date: payloadTo
            };

            // Debug info
            try {
                console.debug('Fetching /customers with', params);
            } catch (e) {}

            fetch('/customers?' + new URLSearchParams(params), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        tbody.innerHTML = data.html;
                        // Refresh client-side filters after date-filter AJAX
                        try {
                            if (window.refreshClientFilters) window.refreshClientFilters();
                        } catch (e) {
                            console.warn('Failed to reinit filters after date filter', e);
                        }
                    } else {
                        alert('Error filtering customers');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error filtering customers');
                });
        }

        function setDateRange(from, to) {
            fromCalendar.setDate(from);
            toCalendar.setDate(to);
        }

        function showAllRows() {
            // Not used anymore - keeping for compatibility
        }

        // Export functionality
        // Map visible header text to tr.dataset keys
        function resolveDataKey(headerText) {
            const key = headerText.trim().toLowerCase().replace(/\s+/g, ' ');
            const map = {
                'customer name': 'fullName',
                'email': 'email',
                'city': 'city',
                'postal code': 'zipCode',
                'province': 'state',
                'home phone': 'phone',
                'cell phone': 'cellPhone',
                'work phone': 'workPhone',
                'assigned to': 'assignedTo',
                'secondary assigned to': 'secondaryAssignedTo',
                'finance manager': 'assignedManager',
                'bdc agent': 'bdcAgent',
                'source': 'leadSource',
                'lead type': 'leadType',
                'lead status': 'status',
                'visits': 'visits',
                'inventory type': 'inventoryType',
                'dealership': 'dealershipFranchises',
                'sales status': 'salesStatus',
                'sales type': 'salesType',
                'deal type': 'dealType',
                'lead status type': 'leadStatusType',
                'appointment status': 'appointmentStatus',
                'original assigned by': 'assignedBy',
                'original assigned date': 'assignedDate',
                'original assigned to': 'originalAssignedTo',
                'sold by': 'soldBy',
                'status': 'status',
                'created date': 'createdDate',
                'sold date': 'soldDate',
                'delivery date': 'deliveryDate',
                'appointment date': 'appointmentDate',
                'last contacted date': 'lastContactedDate'
            };
            return map[key] || null;
        }

        function getExportColumns() {
            const table = document.getElementById('customerTable');
            const ths = table.querySelectorAll('thead tr:first-child th');
            const cols = [];
            const total = ths.length;
            ths.forEach((th, index) => {
                // skip first (checkbox) and last (action)
                if (index === 0 || index === total - 1) return;
                const headerText = th.textContent.trim().replace(/\s+/g, ' ');
                const dataKey = resolveDataKey(headerText);
                cols.push({
                    header: headerText,
                    dataKey
                });
            });
            return cols;
        }

        function cleanCellText(cell) {
            // Clone then remove hover/tooling boxes to avoid exporting hidden details
            try {
                const clone = cell.cloneNode(true);
                clone.querySelectorAll('.custom-hover-box, .tooltip, .badge, button, a').forEach(n => n
                    .remove());
                return clone.textContent.replace(/\s+/g, ' ').trim();
            } catch (e) {
                return cell.textContent.replace(/\s+/g, ' ').trim();
            }
        }

        function getTableData() {
            const table = document.getElementById('customerTable');
            const rows = table.querySelectorAll('tbody tr');
            const cols = getExportColumns();
            const data = [];

            rows.forEach(row => {
                if (row.style.display !== 'none') {
                    const rowData = [];
                    cols.forEach((col, colIndex) => {
                        // Prefer dataset values when available
                        if (col.dataKey && row.dataset && row.dataset[col.dataKey] !==
                            undefined) {
                            rowData.push((row.dataset[col.dataKey] || '').toString().trim());
                        } else {
                            // Fallback to the corresponding cell (offset by 1 because of checkbox column)
                            const cell = row.cells[colIndex + 1];
                            rowData.push(cell ? cleanCellText(cell) : '');
                        }
                    });
                    data.push(rowData);
                }
            });

            return data;
        }

        // Backwards-compatible header helper used by export functions
        function getTableHeaders() {
            try {
                return getExportColumns().map(c => c.header);
            } catch (e) {
                // Fallback: read the first header row (skip checkbox/action)
                const table = document.getElementById('customerTable');
                const headers = [];
                table.querySelectorAll('thead tr:first-child th').forEach((th, index) => {
                    const total = table.querySelectorAll('thead tr:first-child th').length;
                    if (index === 0 || index === total - 1) return;
                    headers.push(th.textContent.trim().replace(/\s+/g, ' '));
                });
                return headers;
            }
        }

        // Export to CSV
        window.exportToCSV = function() {
            const headers = getTableHeaders();
            const data = getTableData();

            let csv = headers.join(',') + '\\n';
            data.forEach(row => {
                csv += row.map(cell => `"${cell}"`).join(',') + '\\n';
            });

            const blob = new Blob([csv], {
                type: 'text/csv'
            });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'customers_' + new Date().toISOString().split('T')[0] + '.csv';
            a.click();
            window.URL.revokeObjectURL(url);
        };

        // Export to Excel (XLSX)
        window.exportToExcel = function() {
            const headers = getTableHeaders();
            const data = getTableData();

            let html = '<table><thead><tr>';
            headers.forEach(header => {
                html += `<th>${header}</th>`;
            });
            html += '</tr></thead><tbody>';

            data.forEach(row => {
                html += '<tr>';
                row.forEach(cell => {
                    html += `<td>${cell}</td>`;
                });
                html += '</tr>';
            });
            html += '</tbody></table>';

            const blob = new Blob([html], {
                type: 'application/vnd.ms-excel'
            });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'customers_' + new Date().toISOString().split('T')[0] + '.xls';
            a.click();
            window.URL.revokeObjectURL(url);
        };

        // Export to PDF
        window.exportToPDF = function() {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF('l', 'mm', 'a4');

            const headers = getTableHeaders();
            const data = getTableData();

            doc.autoTable({
                head: [headers],
                body: data,
                startY: 20,
                styles: {
                    fontSize: 8
                },
                headStyles: {
                    fillColor: [0, 33, 64]
                }
            });

            doc.save('customers_' + new Date().toISOString().split('T')[0] + '.pdf');
        };

        // Print functionality
        window.printTable = function() {
            const printWindow = window.open('', '', 'height=600,width=800');
            const table = document.getElementById('customerTable').cloneNode(true);

            // Remove action column and checkboxes
            table.querySelectorAll('th:first-child, td:first-child, th:last-child, td:last-child').forEach(
                el => el.remove());

            printWindow.document.write('<html><head><title>Customers Report</title>');
            printWindow.document.write(
                '<style>table { width: 100%; border-collapse: collapse; } th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 10px; } th { background-color: #002140; color: white; }</style>'
            );
            printWindow.document.write('</head><body>');
            printWindow.document.write('<h2>Customers Report - ' + new Date().toLocaleDateString() +
                '</h2>');
            printWindow.document.write(table.outerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        };

        // Bind export buttons
        const printBtn = document.getElementById('printBtn');
        if (printBtn) {
            printBtn.addEventListener('click', printTable);
        }

        const exportPDFBtn = document.getElementById('exportPDF');
        if (exportPDFBtn) {
            exportPDFBtn.addEventListener('click', function(e) {
                e.preventDefault();
                exportToPDF();
            });
        }

        const exportExcelBtn = document.getElementById('exportExcel');
        if (exportExcelBtn) {
            exportExcelBtn.addEventListener('click', function(e) {
                e.preventDefault();
                exportToExcel();
            });
        }

        const exportCSVBtn = document.getElementById('exportCSV');
        if (exportCSVBtn) {
            exportCSVBtn.addEventListener('click', function(e) {
                e.preventDefault();
                exportToCSV();
            });
        }
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {

        // ✅ Initialize all Bootstrap tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });


        // ✅ Bootstrap success alert function
        function showSuccess(message) {
            const alert = document.createElement("div");
            alert.className = "alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3";
            alert.style.zIndex = "1055";
            alert.innerHTML = `
                              ${message}
                              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            `;
            document.body.appendChild(alert);

            setTimeout(() => {
                alert.classList.remove("show");
                alert.remove();
            }, 3000);
        }

    });
</script>

<script>
    // Store customer social media links - make them global
    window.customerSocialMediaLinks = {
        facebook: '',
        instagram: '',
        twitter: '',
        youtube: ''
    };

    window.currentCustomerSocialPlatform = '';
    window.currentCustomerId = null;

    // Open Customer Social Media Modal or Link - make it global
    window.openCustomerSocialModal = function(platform) {
        const offcanvas = document.getElementById('editVisitCanvas');
        window.currentCustomerId = offcanvas?.getAttribute('data-customer-id');

        if (!window.currentCustomerId) {
            alert('Please select a customer first');
            return;
        }

        const existingUrl = window.customerSocialMediaLinks[platform];

        // If URL exists, open it in new tab
        if (existingUrl) {
            window.open(existingUrl, '_blank');
            return;
        }

        // Otherwise, open modal to add URL
        window.currentCustomerSocialPlatform = platform;
        const modal = document.getElementById('customerSocialMediaModal');
        const title = document.getElementById('customerSocialModalTitle');
        const label = document.getElementById('customerSocialModalLabel');
        const input = document.getElementById('customerSocialMediaUrl');

        // Capitalize platform name
        const platformName = platform.charAt(0).toUpperCase() + platform.slice(1);
        if (platform === 'twitter') {
            title.textContent = 'Twitter/X Profile';
            label.textContent = 'Twitter/X URL';
            input.placeholder = 'https://twitter.com/username';
        } else {
            title.textContent = platformName + ' Profile';
            label.textContent = platformName + ' URL';
            input.placeholder = `https://${platform}.com/username`;
        }

        // Set current value
        input.value = window.customerSocialMediaLinks[platform] || '';

        modal.style.display = 'flex';
    };

    // Close Customer Social Media Modal - make it global
    window.closeCustomerSocialModal = function() {
        document.getElementById('customerSocialMediaModal').style.display = 'none';
        window.currentCustomerSocialPlatform = '';
    };

    // Save Customer Social Media Link - make it global
    window.saveCustomerSocialLink = function() {
        const url = document.getElementById('customerSocialMediaUrl').value.trim();
        const icon = document.querySelector(
            `.customer-social-icon[data-platform="${window.currentCustomerSocialPlatform}"]`);

        if (!window.currentCustomerId) {
            alert('Customer ID not found');
            return;
        }

        // Update local object
        window.customerSocialMediaLinks[window.currentCustomerSocialPlatform] = url;

        // Update icon state
        if (url) {
            icon.classList.add('active');
        } else {
            icon.classList.remove('active');
        }

        // Save to database
        const updateData = {};
        updateData[`${window.currentCustomerSocialPlatform}_url`] = url;

        fetch(`/customers/${window.currentCustomerId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(updateData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Saved!',
                        text: 'Social media link updated successfully',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });
                } else {
                    throw new Error(data.message || 'Failed to save');
                }
            })
            .catch(error => {
                console.error('Error saving social link:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to save social media link',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            });

        window.closeCustomerSocialModal();
    };

    // Remove Customer Social Media Link - make it global
    window.removeCustomerSocialLink = function() {
        const icon = document.querySelector(
            `.customer-social-icon[data-platform="${window.currentCustomerSocialPlatform}"]`);

        if (!window.currentCustomerId) {
            alert('Customer ID not found');
            return;
        }

        // Update local object
        window.customerSocialMediaLinks[window.currentCustomerSocialPlatform] = '';
        document.getElementById('customerSocialMediaUrl').value = '';

        if (icon) {
            icon.classList.remove('active');
        }

        // Save to database (empty string to remove)
        const updateData = {};
        updateData[`${window.currentCustomerSocialPlatform}_url`] = '';

        fetch(`/customers/${window.currentCustomerId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(updateData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Removed!',
                        text: 'Social media link removed',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });
                }
            })
            .catch(error => {
                console.error('Error removing social link:', error);
            });

        window.closeCustomerSocialModal();
    };

    // Close modal on outside click
    window.onclick = function(event) {
        const modal = document.getElementById('customerSocialMediaModal');
        if (event.target === modal) {
            window.closeCustomerSocialModal();
        }
    }

    // Optional: Load saved social media links on page load
    // You can call this function with customer data from your backend
    window.loadCustomerSocialLinks = function(customer) {
        window.customerSocialMediaLinks = {
            facebook: customer.facebook_url || '',
            instagram: customer.instagram_url || '',
            twitter: customer.twitter_url || '',
            youtube: customer.youtube_url || ''
        };

        // Update icon states
        Object.keys(window.customerSocialMediaLinks).forEach(platform => {
            const icon = document.querySelector(`.customer-social-icon[data-platform="${platform}"]`);
            if (icon) {
                if (window.customerSocialMediaLinks[platform]) {
                    icon.classList.add('active');
                } else {
                    icon.classList.remove('active');
                }
            }
        });
    };

    // Example usage:
    // loadCustomerSocialLinks({
    //   facebook: 'https://facebook.com/customer',
    //   instagram: 'https://instagram.com/customer'
    // });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {

        const dncIcon = document.querySelector(".do-not-contact-icon");
        const callIcon = document.querySelector(".call-action-icon");

        const modal = new bootstrap.Modal(document.getElementById('doNotContactModal'));
        let dncSettings = {
            call: false,
            text: false,
            email: false
        };

        // Open Modal
        dncIcon.addEventListener("click", () => {
            modal.show();
        });

        // Save DNC
        document.getElementById("saveDNC").addEventListener("click", () => {

            dncSettings.call = document.getElementById("dncCall").checked;
            dncSettings.text = document.getElementById("dncText").checked;
            dncSettings.email = document.getElementById("dncEmail").checked;

            // If Do Not Call selected -> Gray out call icon
            if (dncSettings.call) {
                callIcon.style.color = "#999";
                callIcon.style.cursor = "not-allowed";
            } else {
                callIcon.style.color = "";
                callIcon.style.cursor = "pointer";
            }

            modal.hide();
        });

        // Call Attempt Logic
        callIcon.addEventListener("click", function() {
            if (dncSettings.call) {
                alert("Customer requested Do Not Call");
                return;
            }

            alert("Calling customer...");
        });

    });
</script>

<script>
    document.getElementById("openMap").addEventListener("click", function(e) {
        e.preventDefault();
        let address = document.getElementById("customer_location").value;
        if (address.trim() !== "") {
            let url = "https://www.google.com/maps/search/?api=1&query=" + encodeURIComponent(address);
            window.open(url, "_blank"); // Opens in new tab
        } else {
            alert("Please enter a location first.");
        }
    });
</script>

<!-- Script for primary email send button -->
<script>
    (function() {
        const input = document.getElementById('emailInput');
        const btn = document.getElementById('sendEmailBtn');

        function validEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }

        btn.addEventListener('click', function() {
            const email = (input.value || '').trim();
            if (!email || !validEmail(email)) {
                alert('Please enter a valid email address.');
                input.focus();
                return;
            }

            const mailto = 'mailto:' + encodeURIComponent(email);

            try {
                const a = document.createElement('a');
                a.href = mailto;
                a.style.display = 'none';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            } catch (e) {}

            try {
                window.location.href = mailto;
            } catch (e) {}

            try {
                const iframe = document.createElement('iframe');
                iframe.src = mailto;
                iframe.style.display = 'none';
                document.body.appendChild(iframe);
                setTimeout(() => document.body.removeChild(iframe), 1000);
            } catch (e) {}

            setTimeout(function() {
                if (confirm(
                        "If your mail app didn't open, open Gmail compose in a new tab? (Cancel to copy address)"
                    )) {
                    const gmailUrl = 'https://mail.google.com/mail/?view=cm&fs=1&to=' +
                        encodeURIComponent(email);
                    window.open(gmailUrl, '_blank');
                } else {
                    if (navigator.clipboard && navigator.clipboard.writeText) {
                        navigator.clipboard.writeText(email).then(
                            () => alert(
                                'Email address copied to clipboard — paste it into your mail app.'
                            ),
                            () => prompt('Copy this address manually:', email)
                        );
                    } else {
                        prompt('Copy this address:', email);
                    }
                }
            }, 250);
        });
    })();
</script>
<!-- JS: Image Preview -->
<script>
    (function() {
        const profileImageInput = document.getElementById('profileImageInput');
        if (!profileImageInput) return;
        profileImageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const customerProfileImage = document.getElementById('customerProfileImage');
                if (customerProfileImage) customerProfileImage.src = URL.createObjectURL(file);
            }
        });
    })();
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        // Keep checkbox always checked (not disabled)
        const checkbox = document.querySelector(".co_buyer_data_available_indicator");
        if (checkbox) {
            checkbox.checked = true;
            checkbox.addEventListener("click", function(e) {
                e.preventDefault(); // Prevent unchecking
                this.checked = true; // Force checked
            });
        }

        // Initialize tooltips
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
            new bootstrap.Tooltip(el);
        });

        // Delete confirmation logic
        document.querySelectorAll(".delete-customer-icon").forEach(icon => {
            icon.addEventListener("click", function() {

                if (confirm("Are you sure you want to delete this co-buyer?")) {
                    showSuccessAlert("Co-buyer deleted successfully.");
                }

            });
        });

        // Success alert function
        function showSuccessAlert(message) {
            const alert = document.createElement("div");
            alert.className =
                "alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3";
            alert.style.zIndex = "2000";
            alert.innerHTML = `
                            ${message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                          `;
            document.body.appendChild(alert);

            setTimeout(() => {
                alert.classList.remove("show");
                alert.remove();
            }, 3000);
        }

    });
</script>
<script>
    // Run after DOM loads
    document.addEventListener("DOMContentLoaded", function() {
        // Select all inputs inside coBuyerFields
        const inputs = document.querySelectorAll("#coBuyerFields input");

        inputs.forEach(input => {
            const key = "coBuyer_" + input.name; // unique key per input

            // Load saved value if exists
            const savedValue = localStorage.getItem(key);
            if (savedValue !== null) {
                input.value = savedValue;
            }

            // Save on change or typing
            input.addEventListener("input", function() {
                localStorage.setItem(key, input.value);
            });
        });
    });
</script>

<!-- End Co-Buyer Section -->


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const sendToDmsBtn = document.getElementById("sendToDmsBtn");
        const documentsBtn = document.getElementById("documentsBtn");
        const dealToggles = document.querySelectorAll(".toggle-deal-details-icon");
        const errorModal = new bootstrap.Modal(document.getElementById("errorModal"));
        // Helper to show a bootstrap modal by id, resilient to different bootstrap bundles
        function showBootstrapModalById(id) {
            const el = document.getElementById(id);
            if (!el) {
                console.error('Modal element not found:', id);
                return null;
            }

            // Ensure modal is a direct child of body so it stacks above offcanvas/offscreen elements
            try {
                if (el.parentNode !== document.body) document.body.appendChild(el);
            } catch (e) {
                console.warn('Could not move modal to body', e);
            }

            // If any offcanvas is open, hide it first so modal appears centered on top (matches screenshot)
            // NOTE: for `sendToDmsModal` we DON'T hide underlying offcanvas — show modal on top instead
            try {
                if (id !== 'sendToDmsModal') {
                    document.querySelectorAll('.offcanvas.show').forEach(off => {
                        try {
                            if (typeof bootstrap.Offcanvas !== 'undefined') {
                                const inst = (typeof bootstrap.Offcanvas.getInstance === 'function') ?
                                    bootstrap.Offcanvas.getInstance(off) || new bootstrap.Offcanvas(
                                        off) : new bootstrap.Offcanvas(off);
                                if (inst && typeof inst.hide === 'function') inst.hide();
                            } else {
                                off.classList.remove('show');
                            }
                        } catch (e) {
                            /* ignore individual offcanvas hide errors */
                        }
                    });
                }
            } catch (e) {
                /* ignore */
            }

            try {
                let modalInstance = null;
                if (typeof bootstrap.Modal.getOrCreateInstance === 'function') {
                    modalInstance = bootstrap.Modal.getOrCreateInstance(el);
                    modalInstagotoinventoryModalgotoinventoryModalnce.show();
                } else if (typeof bootstrap.Modal.getInstance === 'function' && bootstrap.Modal.getInstance(
                        el)) {
                    modalInstance = bootstrap.Modal.getInstance(el);
                    modalInstance.show();
                } else {
                    modalInstance = new bootstrap.Modal(el);
                    modalInstance.show();
                }

                // Ensure modal/backdrop z-index is above other UI elements
                try {
                    const modalDialog = el.querySelector('.modal-dialog');
                    if (modalDialog) modalDialog.style.zIndex = 200050;
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) backdrop.style.zIndex = 200000;
                } catch (e) {
                    /* ignore styling errors */
                }

                return modalInstance;
            } catch (err) {
                console.error('Error showing modal', id, err);
                // last-resort: manipulate classes and create backdrop
                el.classList.add('show');
                el.style.display = 'block';
                document.body.classList.add('modal-open');

                // create a simple backdrop if none exists
                try {
                    if (!document.querySelector('.modal-backdrop')) {
                        const back = document.createElement('div');
                        back.className = 'modal-backdrop fade show';
                        back.style.zIndex = 200000;
                        document.body.appendChild(back);
                    }
                } catch (e) {
                    /* ignore */
                }

                return null;
            } finally {
                // Extra defensive adjustments after showing modal to ensure it is interactive
                setTimeout(() => {
                    try {
                        // Force-hide any offcanvas elements that might steal focus/overlay the modal
                        // Skip force-hiding when showing the sendToDms modal so underlying profile stays visible
                        if (id !== 'sendToDmsModal') {
                            document.querySelectorAll('.offcanvas.show').forEach(off => {
                                try {
                                    off.classList.remove('show');
                                    off.setAttribute('aria-hidden', 'true');
                                    off.style.display = 'none';
                                } catch (e) {}
                            });
                        }

                        // Bring modal and dialog to front
                        try {
                            if (el) {
                                el.style.zIndex = 200050;
                                el.style.pointerEvents = 'auto';
                                const md = el.querySelector('.modal-dialog');
                                if (md) md.style.zIndex = 200051;
                            }
                        } catch (e) {}

                        // Lower backdrop z-index so modal sits above it
                        try {
                            document.querySelectorAll('.modal-backdrop').forEach(back => {
                                back.style.zIndex = 200000;
                            });
                        } catch (e) {}

                        // Focus modal for keyboard/interaction
                        try {
                            if (el && typeof el.focus === 'function') el.focus();
                            if (window.sendToDmsModalInstance && window.sendToDmsModalInstance
                                ._element) {
                                try {
                                    window.sendToDmsModalInstance._element.focus();
                                } catch (e) {}
                            }
                        } catch (e) {}
                    } catch (err) {
                        console.warn('Post-modal adjustments failed', err);
                    }
                }, 50);
            }
        }
        const errorMessage = document.getElementById("errorMessage");
        const helpBtn = document.getElementById("helpBtn");

        // ✅ Initialize Bootstrap tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function(el) {
            return new bootstrap.Tooltip(el);
        });

        // ✅ Check if any deal is open
        function isAnyDealOpen() {
            return document.querySelectorAll(".deals-detail-area:not(.d-none)").length > 0;
        }

        // ✅ Update button states based on deal open/close
        function updateButtonStates() {
            const hasOpenDeal = isAnyDealOpen();
            try {
                if (sendToDmsBtn) {
                    sendToDmsBtn.disabled = !hasOpenDeal;
                    if (hasOpenDeal) {
                        sendToDmsBtn.classList.remove('disabled');
                        sendToDmsBtn.removeAttribute('aria-disabled');
                    } else {
                        sendToDmsBtn.classList.add('disabled');
                        sendToDmsBtn.setAttribute('aria-disabled', 'true');
                    }
                }
            } catch (e) {}
            try {
                if (documentsBtn) documentsBtn.disabled = !hasOpenDeal;
            } catch (e) {}
        }

        // ✅ Toggle Deal Open/Close
        dealToggles.forEach(icon => {
            icon.addEventListener("click", function() {
                const dealBox = this.closest(".deal-box");
                const detailsArea = dealBox.querySelector(".deals-detail-area");

                if (!detailsArea) return;

                // Hide all others
                document.querySelectorAll(".deals-detail-area").forEach(area => {
                    if (area !== detailsArea) area.classList.add("d-none");
                });

                // Toggle visibility
                detailsArea.classList.toggle("d-none");

                // Update icons
                document.querySelectorAll(".toggle-deal-details-icon").forEach(i => {
                    i.classList.remove("ti-caret-up-filled", "text-primary");
                    i.classList.add("ti-caret-down-filled");
                });

                if (!detailsArea.classList.contains("d-none")) {
                    this.classList.remove("ti-caret-down-filled");
                    this.classList.add("ti-caret-up-filled", "text-primary");
                }

                // Update button states
                updateButtonStates();
            });
        });

        // Initial button state
        updateButtonStates();

        // ✅ Show Error Modal with message
        function showError(msg) {
            errorMessage.textContent = msg;
            errorModal.show();
        }

        // ✅ Send to DMS Button - always allow click; create/get modal instance on demand
        if (sendToDmsBtn) {
            // ensure initial disabled state
            sendToDmsBtn.disabled = !isAnyDealOpen();
            if (sendToDmsBtn.disabled) sendToDmsBtn.classList.add('disabled');

            sendToDmsBtn.addEventListener("click", function(e) {
                // ignore clicks when disabled
                if (sendToDmsBtn.disabled) return;
                const inst = showBootstrapModalById('sendToDmsModal');
                // keep reference so confirm button can hide the same instance
                window.sendToDmsModalInstance = inst;
            });
        }

        // Add delegated click handler for dynamic/late-added sendToDmsBtn (safer)
        document.addEventListener('click', function(e) {
            try {
                const btn = e.target.closest && e.target.closest('#sendToDmsBtn');
                if (!btn) return;
                console.debug('Delegated: sendToDmsBtn clicked', btn);
                if (btn.disabled) {
                    console.debug('Delegated: sendToDmsBtn is disabled, ignoring click');
                    return;
                }
                const inst = showBootstrapModalById('sendToDmsModal');
                window.sendToDmsModalInstance = inst;
            } catch (err) {
                console.warn('Delegated sendToDmsBtn handler error', err);
            }
        });

        // ✅ Documents Button - show documents modal
        documentsBtn.addEventListener("click", function() {
            if (typeof renderDocs === 'function') {
                renderDocs();
            }
            const documentsModal = new bootstrap.Modal(document.getElementById("documentsModal"));
            documentsModal.show();
        });

        // ✅ Confirm Send to DMS (direct handler if element exists)
        (function() {
            const confirmBtn = document.getElementById("confirmSendToDms");
            const desklogAddNoteUrl = "{{ route('desk-log.add-note') }}";
            const desklogManagerUrl = "{{ route('desk-log.manager') }}";
            if (confirmBtn) {
                confirmBtn.addEventListener("click", async function() {
                    const noteEl = document.getElementById("dmsMessage");
                    const note = noteEl ? noteEl.value.trim() : '';
                    console.debug('confirmSendToDms handler triggered', {
                        note
                    });
                    const inst = window.sendToDmsModalInstance;

                    // Determine current deal id
                    const dealId = (window.AppState && window.AppState.currentDealId) ? window
                        .AppState.currentDealId : (document.querySelector(
                            '[data-deal-id-input]') || {}).value;
                    if (!dealId) {
                        (typeof showToast === 'function') ? showToast('No open deal selected',
                            'error'): alert('No open deal selected');
                        return;
                    }

                    // Hide modal
                    if (inst && typeof inst.hide === 'function') {
                        inst.hide();
                    } else {
                        const el = document.getElementById('sendToDmsModal');
                        if (el) {
                            el.classList.remove('show');
                            el.style.display = 'none';
                        }
                        const backdrop = document.querySelector('.modal-backdrop');
                        if (backdrop) backdrop.remove();
                        document.body.classList.remove('modal-open');
                    }

                    try {
                        const csrf = (window.AppState && window.AppState.csrfToken) || document
                            .querySelector('meta[name="csrf-token"]')?.content || '';
                        const res = await fetch(desklogAddNoteUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrf,
                                'Accept': 'application/json'
                            },
                            credentials: 'same-origin',
                            body: JSON.stringify({
                                deal_id: dealId,
                                note: note
                            })
                        });

                        if (!res.ok) {
                            const errText = await res.text();
                            console.warn('Desklog add-note failed', res.status, errText);
                            (typeof showToast === 'function') ? showToast(
                                'Failed to save note to Desklog', 'error'): alert(
                                'Failed to save note to Desklog');
                            return;
                        }

                        // Success — show toast then navigate to desklog manager
                        (typeof showToast === 'function') ? showToast('Note saved to Desklog',
                            'success'): alert('Note saved to Desklog');
                        // Small delay so user sees toast
                        setTimeout(() => {
                            window.location.href = desklogManagerUrl;
                        }, 600);
                    } catch (err) {
                        console.error('Error saving desklog note', err);
                        (typeof showToast === 'function') ? showToast('Error saving note',
                            'error'): alert('Error saving note');
                    }
                });
            }
        })();

        // Delegated confirm handler in case button is added later
        document.addEventListener('click', function(e) {
            try {
                const btn = e.target.closest && e.target.closest('#confirmSendToDms');
                if (!btn) return;
                console.debug('Delegated: confirmSendToDms clicked');
                const note = (document.getElementById('dmsMessage') || {}).value || '';

                const inst = window.sendToDmsModalInstance;
                if (inst && typeof inst.hide === 'function') inst.hide();
                else {
                    const el = document.getElementById('sendToDmsModal');
                    if (el) {
                        el.classList.remove('show');
                        el.style.display = 'none';
                    }
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) backdrop.remove();
                    document.body.classList.remove('modal-open');
                }

                // Post to desklog add-note
                (async function() {
                    const desklogAddNoteUrl = "{{ route('desk-log.add-note') }}";
                    const desklogManagerUrl = "{{ route('desk-log.manager') }}";
                    const dealId = (window.AppState && window.AppState.currentDealId) ? window
                        .AppState.currentDealId : (document.querySelector(
                            '[data-deal-id-input]') || {}).value;
                    if (!dealId) {
                        (typeof showToast === 'function') ? showToast('No open deal selected',
                            'error'): alert('No open deal selected');
                        return;
                    }
                    try {
                        const csrf = (window.AppState && window.AppState.csrfToken) || document
                            .querySelector('meta[name="csrf-token"]')?.content || '';
                        const res = await fetch(desklogAddNoteUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrf,
                                'Accept': 'application/json'
                            },
                            credentials: 'same-origin',
                            body: JSON.stringify({
                                deal_id: dealId,
                                note: note
                            })
                        });
                        if (!res.ok) {
                            console.warn('Desklog add-note failed', res.status);
                            (typeof showToast === 'function') ? showToast(
                                'Failed to save note to Desklog', 'error'): alert(
                                'Failed to save note to Desklog');
                            return;
                        }
                        (typeof showToast === 'function') ? showToast('Note saved to Desklog',
                            'success'): alert('Note saved to Desklog');
                        setTimeout(() => {
                            window.location.href = desklogManagerUrl;
                        }, 600);
                    } catch (err) {
                        console.error('Error saving desklog note', err);
                        (typeof showToast === 'function') ? showToast('Error saving note',
                            'error'): alert('Error saving note');
                    }
                })();

            } catch (err) {
                console.warn('Delegated confirmSendToDms handler error', err);
            }
        });


        // ✅ Help button — visual highlight effect
        helpBtn.addEventListener("click", function() {
            errorModal.hide();
            const dropdown = document.querySelector(".toggle-deal-details-icon");
            if (dropdown) {
                dropdown.scrollIntoView({
                    behavior: "smooth",
                    block: "center"
                });
                dropdown.classList.add("highlight-pulse");
                setTimeout(() => dropdown.classList.remove("highlight-pulse"), 3000);
            }
        });
    });
</script>
<script>
    document.querySelectorAll(".deals-tabs .nav-link").forEach(btn => {
        btn.addEventListener("click", function() {
            // remove active
            document.querySelectorAll(".deals-tabs .nav-link").forEach(b => b.classList.remove(
                "active"));
            this.classList.add("active");

            const filter = this.getAttribute("data-filter");

            // Use the global applyDealFilter function if available
            if (typeof applyDealFilter === 'function') {
                applyDealFilter(filter);
            } else {
                // Fallback to inline filtering
                document.querySelectorAll(".deal-box").forEach(box => {
                    if (filter === "all" || box.dataset.status === filter) {
                        box.style.display = "block";
                    } else {
                        box.style.display = "none";
                    }
                });
            }
        });
    });
</script>

<script>
    // VIN Decode functionality
    document.getElementById('vinInput')?.addEventListener('blur', function() {
        const vin = this.value.trim();
        if (vin.length === 17) {
            // Call VIN decode API here
            // For now, mock data:
            document.getElementById('vehicleYear').value = '2020';
            document.getElementById('vehicleMake').value = 'Toyota';
            document.getElementById('vehicleModel').value = 'Camry';
        }
    });

    // Send to vAuto with Validation
    document.getElementById('sendToVAuto')?.addEventListener('click', function() {
        const userRole = 'manager'; // Get from session/auth

        // Permission check
        if (!['manager', 'admin', 'owner'].includes(userRole.toLowerCase())) {
            showMessage('error', 'Permission Denied: Only Manager or above can send to V-Auto');
            return;
        }

        // Validation checks
        const errors = [];

        // 1. VIN decoded check
        if (!document.getElementById('vehicleYear').value ||
            !document.getElementById('vehicleMake').value ||
            !document.getElementById('vehicleModel').value) {
            errors.push('VIN must be decoded successfully (Year/Make/Model required)');
        }

        // 2. Odometer check
        if (!document.getElementById('odometerInput').value) {
            errors.push('Odometer reading is required');
        }

        // 3. Photo check
        if (!document.getElementById('vehiclePhotos').files.length) {
            errors.push('At least 1 photo is required');
        }

        // 4. Trade Allowance check
        if (!document.getElementById('tradeAllowance').value) {
            errors.push('Trade Allowance is required');
        }

        // 5. Appraised By check
        if (!document.getElementById('appraisedBy').value) {
            errors.push('Appraised By field is required');
        }

        // 6. Appraisal Date/Time check
        if (!document.getElementById('appraisalDateTime').value) {
            errors.push('Appraisal Date/Time is required');
        }

        if (errors.length > 0) {
            showMessage('error', 'Please fix the following errors:<br>• ' + errors.join('<br>• '));
            return;
        }

        // All validations passed - send to vAuto
        const tradeData = {
            customerId: 'CUST_12345', // Backend ID
            dealId: 'DEAL_67890', // Backend ID
            tradeId: 'TRADE_' + Date.now(), // Backend ID
            vin: document.getElementById('vinInput').value,
            year: document.getElementById('vehicleYear').value,
            make: document.getElementById('vehicleMake').value,
            model: document.getElementById('vehicleModel').value,
            odometer: document.getElementById('odometerInput').value,
            // ... other fields
        };

        // API call to vAuto
        fetch('/api/vauto/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(tradeData)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showMessage('success', 'Successfully sent to V-Auto! Trade ID: ' + data.tradeId);
                } else {
                    showMessage('error', 'Failed to send to V-Auto: ' + data.error);
                }
            })
            .catch(err => {
                showMessage('error', 'Network error: ' + err.message);
            });
    });

    // Service Appointment Shortcut
    document.getElementById('createServiceAppointment')?.addEventListener('click', function() {
        const modal = new bootstrap.Modal(document.getElementById('serviceAppointmentModal'));
        modal.show();
    });

    // Helper function for messages
    function showMessage(type, message) {
        const msgDiv = document.getElementById('tradeInMessages');
        const alertClass = type === 'error' ? 'alert-danger' : 'alert-success';
        msgDiv.innerHTML = `<div class="alert ${alertClass} alert-dismissible fade show" role="alert">
              ${message}
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>`;
    }
</script>

<script>
    // Show More History click
    document.getElementById('showMoreHistory').addEventListener('click', function() {
        const fullHistory = document.getElementById('fullHistory');

        // Correct bootstrap.Tab usage
        const historyTab = new bootstrap.Tab(document.getElementById('history-tab'));
        const activityTimelineTab = new bootstrap.Tab(document.getElementById('activityTimelineSection'));
        const taskAndAppointmentsTab = new bootstrap.Tab(document.getElementById('taskandappointmentSection'));

        // Show the main history tab (you can switch to others as needed)
        historyTab.show();

        // Fill with extra history items
        fullHistory.innerHTML = `
          <div class="history-item border-bottom pb-3">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <span class="fw-bold">John Doe</span>
                <span class="text-muted ms-2">Today, 10:30 AM</span>
              </div>
              <span class="badge bg-light text-dark">Note</span>
            </div>
            <p class="mb-1 mt-1">Discussed financing options with customer. They're interested in the 60-month plan.</p>
          </div>

          <div class="history-item border-bottom pb-3">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <span class="fw-bold">Sarah Johnson</span>
                <span class="text-muted ms-2">Yesterday, 3:45 PM</span>
              </div>
              <span class="badge bg-light text-dark">Email</span>
            </div>
            <p class="mb-1 mt-1">Sent follow-up email with updated pricing for the Mercedes-Benz.</p>
          </div>

          <div class="history-item border-bottom pb-3">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <span class="fw-bold">Mike Wilson</span>
                <span class="text-muted ms-2">Yesterday, 11:20 AM</span>
              </div>
              <span class="badge bg-light text-dark">Call</span>
            </div>
            <p class="mb-1 mt-1">Customer called to inquire about delivery timeline. Confirmed 3-5 business days.</p>
          </div>

          <div class="history-item border-bottom pb-3">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <span class="fw-bold">Lisa Brown</span>
                <span class="text-muted ms-2">2 days ago</span>
              </div>
              <span class="badge bg-light text-dark">Note</span>
            </div>
            <p class="mb-1 mt-1">Test drive completed. Customer seemed very interested in the vehicle's features.</p>
          </div>

          <div class="history-item border-bottom pb-3">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <span class="fw-bold">David Lee</span>
                <span class="text-muted ms-2">3 days ago</span>
              </div>
              <span class="badge bg-light text-dark">Email</span>
            </div>
            <p class="mb-1 mt-1">Initial contact made. Customer inquired about availability of the Mercedes-Benz model.</p>
          </div>

          <div class="history-item border-bottom pb-3">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <span class="fw-bold">Robert Taylor</span>
                <span class="text-muted ms-2">4 days ago</span>
              </div>
              <span class="badge bg-light text-dark">Note</span>
            </div>
            <p class="mb-1 mt-1">Customer visited the dealership. Showed them the Mercedes-Benz and Honda Accord.</p>
          </div>

          <div class="history-item border-bottom pb-3">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <span class="fw-bold">Emily Chen</span>
                <span class="text-muted ms-2">5 days ago</span>
              </div>
              <span class="badge bg-light text-dark">Email</span>
            </div>
            <p class="mb-1 mt-1">Sent initial information package about available vehicles in their price range.</p>
          </div>
        `;
    });

    // Add Note click
    document.getElementById('addNote').addEventListener('click', function() {
        const noteText = document.getElementById('noteText').value.trim();
        if (noteText) {
            const newNote = document.createElement('div');
            newNote.className = 'history-item border-bottom pb-3';
            newNote.innerHTML = `
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <span class="fw-bold">You</span>
                <span class="text-muted ms-2">Just now</span>
              </div>
              <span class="badge bg-light text-dark">Note</span>
            </div>
            <p class="mb-1 mt-1">${noteText}</p>
          `;
            const recentHistory = document.getElementById('recentHistory');
            recentHistory.insertBefore(newNote, recentHistory.firstChild);
            document.getElementById('noteText').value = '';
            alert('Note added successfully!');
        } else {
            alert('Please enter a note before adding.');
        }
    });
</script>


<script>
    // Add click event listeners to all deal boxes
    document.querySelectorAll('.deal-box  .toggle-deal-details-icon').forEach(box => {
        box.addEventListener('click', function() {
            const vehicles = document.getElementById("vehiclesInterest");
            const notes = document.getElementById("notesHistory");

            // Check if sections are currently hidden
            const isHidden = window.getComputedStyle(vehicles).display === "none";

            // Toggle display
            if (isHidden) {
                vehicles.style.display = "block";
                notes.style.display = "block";
            } else {
                vehicles.style.display = "none";
                notes.style.display = "none";
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toggleBtns = document.querySelectorAll(".toggle-deal-details-icon");
        const taskSection = document.getElementById("taskandappointmentSection");
        const activitySection = document.getElementById("activityTimelineSection");

        toggleBtns.forEach(function(btn) {
            btn.addEventListener("click", function() {
                const isVisible = taskSection.style.display === "block" || activitySection.style
                    .display === "block";

                if (isVisible) {
                    // Hide both
                    taskSection.style.display = "none";
                    activitySection.style.display = "none";
                } else {
                    // Show both
                    taskSection.style.display = "block";
                    activitySection.style.display = "block";
                }
            });
        });
    });
</script>




<style>
    /* small styling for N/A cells */
    .na-cell {
        color: #6c757d;
        font-style: italic;
    }

    /* optional: prevent tiny layout jump when hiding columns */
    table td,
    table th {
        white-space: nowrap;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const table = document.getElementById('customerTable');
        if (!table) return;

        const thead = table.tHead;
        const mainHeaderRow = thead ? thead.rows[0] : null;
        const filterRow = table.querySelector('#filtersRow');
        const tbody = table.tBodies[0];
        const checkboxSelector = '.dropdown-menu .form-check-input';

        // normalize text helper
        const normalizeText = (s) => (s || '').replace(/\s+/g, ' ').replace(/\u00A0/g, ' ').trim()
            .toLowerCase();

        // build header map: normalized header text -> index
        let headerMap = {};

        function rebuildHeaderMap() {
            headerMap = {};
            if (!mainHeaderRow) return;
            Array.from(mainHeaderRow.cells).forEach((th, idx) => {
                const txt = th.innerText || th.textContent || '';
                headerMap[normalizeText(txt)] = idx;
            });
        }

        rebuildHeaderMap();

        // normalize existing cells to show "N/A" if missing or '-' and mark class
        function normalizeExistingCells() {
            Array.from(tbody.rows).forEach(row => {
                Array.from(row.cells).forEach(td => {
                    // Skip cells that contain interactive elements (checkboxes, inputs, buttons, links)
                    if (td.querySelector('input, select, button, a, .form-check')) return;
                    const txt = (td.textContent || '').trim();
                    if (!txt || txt === '-') {
                        td.textContent = 'N/A';
                        td.classList.add('na-cell');
                    }
                });
            });
        }
        normalizeExistingCells();

        // show/hide existing column by index
        function setColumnVisibility(idx, visible) {
            // header rows (all)
            Array.from(table.querySelectorAll('thead tr')).forEach(row => {
                const cell = row.cells[idx];
                if (cell) cell.style.display = visible ? '' : 'none';
            });
            // body rows
            Array.from(tbody.rows).forEach(row => {
                const cell = row.cells[idx];
                if (cell) cell.style.display = visible ? '' : 'none';
            });
        }

        // Utility: persist added columns to localStorage so they survive AJAX table refreshes
        function getAddedColumnsStorage() {
            try {
                const raw = localStorage.getItem('customer_added_columns');
                return raw ? JSON.parse(raw) : [];
            } catch (e) {
                return [];
            }
        }

        function setAddedColumnsStorage(list) {
            try {
                localStorage.setItem('customer_added_columns', JSON.stringify(list));
            } catch (e) {}
        }

        // add a new client-side column before the last header cell (so "Action" stays last)
        function addColumn(colName) {
            if (!mainHeaderRow) return;

            // compute insert position: before final header cell
            const insertBeforeIndex = Math.max(0, mainHeaderRow.cells.length - 1);

            // create header <th>
            const th = document.createElement('th');
            th.dataset.addedCol = colName;
            th.innerHTML = `<span class="header-text">${colName}</span>`;
            mainHeaderRow.insertBefore(th, mainHeaderRow.cells[insertBeforeIndex]);

            // create matching cell in filter row (if exists)
            if (filterRow) {
                const thFilter = document.createElement('th');
                thFilter.dataset.addedCol = colName;
                const wrapper = document.createElement('div');
                wrapper.className = 'filter-wrapper';
                wrapper.dataset.col = ''; // will set after rebuildHeaderMap
                thFilter.appendChild(wrapper);
                filterRow.insertBefore(thFilter, filterRow.cells[filterRow.cells.length - 1]);
            }

            // add td "N/A" to each tbody row
            Array.from(tbody.rows).forEach(row => {
                const td = document.createElement('td');
                td.dataset.addedCol = colName;
                td.textContent = 'N/A';
                td.classList.add('na-cell');
                row.insertBefore(td, row.cells[row.cells.length - 1]);
            });

            // header map changed
            rebuildHeaderMap();
            // find index of newly added header by locating the actual <th>
            const key = normalizeText(colName);
            let newIndex = null;
            try {
                const thAdded = mainHeaderRow.querySelector('[data-added-col="' + CSS.escape(colName) + '"]');
                if (thAdded) {
                    newIndex = Array.from(mainHeaderRow.cells).indexOf(thAdded);
                } else if (headerMap.hasOwnProperty(key)) {
                    newIndex = headerMap[key];
                }
            } catch (e) {
                newIndex = (headerMap.hasOwnProperty(key) ? headerMap[key] : null);
            }

            // populate values for each row using data-* attributes when available
            if (newIndex !== null) {
                // update wrapper data-col and initialize filter for it
                try {
                    const wrapper = filterRow.querySelector('[data-added-col="' + CSS.escape(colName) +
                        '"] .filter-wrapper');
                    if (wrapper) {
                        wrapper.setAttribute('data-col', newIndex);
                        createFilterForWrapper(wrapper, newIndex);
                    }
                } catch (e) {
                    console.warn('Failed to attach filter for added column', e);
                }

                // normalize key to dataset mapping: map common column names to data-* attributes
                function mapColumnToDataKey(name) {
                    const k = normalizeText(name);
                    const map = {
                        'customer name': 'fullName',
                        'first name': 'fullName',
                        'middle name': 'fullName',
                        'last name': 'fullName',
                        'email': 'email',
                        'city': 'city',
                        'postal code': 'zipCode',
                        'province': 'state',
                        'home phone': 'phone',
                        'cell phone': 'cellPhone',
                        'work phone': 'workPhone',
                        'assigned to': 'assignedTo',
                        'secondary assigned': 'secondaryAssignedTo',
                        'assigned manager': 'assignedManager',
                        'bdc agent': 'bdcAgent',
                        'lead source': 'leadSource',
                        'lead type': 'leadType',
                        'status': 'status',
                        'interested make': 'interestedMake',
                        'dealership franchises': 'dealershipFranchises',
                        'sales status': 'salesStatus',
                        'sales type': 'salesType',
                        'deal type': 'dealType',
                        'assigned by': 'assignedBy',
                        'assigned date': 'assignedDate',
                        'sold by': 'soldBy',
                        'created date': 'createdDate',
                        'sold date': 'soldDate',
                        'delivery date': 'deliveryDate',
                        'appointment date': 'appointmentDate',
                        'last contacted date': 'lastContactedDate'
                    };
                    return map[k] || null;
                }

                const dataKey = mapColumnToDataKey(colName);

                Array.from(tbody.rows).forEach(row => {
                    let value = null;
                    try {
                        if (dataKey && row.dataset) {
                            // dataset keys are camelCased in JS
                            value = row.dataset[dataKey];
                        }
                    } catch (e) {
                        value = null;
                    }

                    // debug: if dataset is unexpectedly empty, log once
                    if (typeof window.__logRowDatasetsOnce === 'undefined') {
                        try {
                            console.debug('ROW dataset example', row.dataset);
                        } catch (e) {}
                        window.__logRowDatasetsOnce = true;
                    }

                    // If this added column is a name part (first/middle/last) and dataset provided fullName,
                    // always compute the correct part from fullName rather than using fullName as-is.
                    if (/first name|middle name|last name/i.test(colName)) {
                        const full = (row.dataset && row.dataset.fullName) ? row.dataset.fullName : (row
                            .cells[headerMap[normalizeText('customer name')]] ? (row.cells[
                                headerMap[normalizeText('customer name')]].innerText || '') : '');
                        let parts = (full || '').trim().split(/\s+/).filter(p => p && !/^\d+$/.test(p));
                        parts = parts.filter(p => p.length > 0 && /[A-Za-z\-']/.test(p));
                        let partVal = '';
                        if (/first name/i.test(colName)) partVal = parts.length ? parts[0] : '';
                        if (/last name/i.test(colName)) partVal = parts.length > 1 ? parts[parts
                            .length - 1] : (parts[0] || '');
                        if (/middle name/i.test(colName)) partVal = parts.length > 2 ? parts.slice(1, -
                            1).join(' ') : '';
                        // prefer the computed part over raw dataset.fullName
                        value = partVal;
                    }

                    // write value into the added td
                    try {
                        const td = row.querySelector('[data-added-col="' + CSS.escape(colName) + '"]');
                        if (td) {
                            if (value && value.length > 0 && value !== '-') {
                                td.textContent = value;
                                td.classList.remove('na-cell');
                            } else {
                                td.textContent = 'N/A';
                                td.classList.add('na-cell');
                            }
                        }
                    } catch (e) {}
                });

                // refresh filter data for this new column
                try {
                    initializeFilterData(newIndex);
                } catch (e) {}
            }
            // persist
            try {
                const list = getAddedColumnsStorage();
                if (!list.includes(colName)) {
                    list.push(colName);
                    setAddedColumnsStorage(list);
                }
            } catch (e) {}
        }

        // remove added client-side column by name
        function removeAddedColumn(colName) {
            Array.from(table.querySelectorAll('[data-added-col="' + CSS.escape(colName) + '"]')).forEach(el =>
                el.remove());
            rebuildHeaderMap();
            // remove from storage
            try {
                let list = getAddedColumnsStorage();
                list = list.filter(n => n !== colName);
                setAddedColumnsStorage(list);
            } catch (e) {}
        }

        // attach handlers to dropdown checkboxes
        const checkboxes = document.querySelectorAll(checkboxSelector);
        checkboxes.forEach(cb => {
            // determine label text (column name) next to the checkbox
            let label = cb.closest('label');
            let colName = '';
            if (label) {
                // text may include the checkbox, so remove input text by cloning
                // easier: get label text content but remove input children's text
                const clone = label.cloneNode(true);
                // remove any input children
                clone.querySelectorAll('input').forEach(n => n.remove());
                colName = (clone.textContent || '').trim();
            } else {
                colName = (cb.getAttribute('data-col-name') || cb.getAttribute('data-name') || '')
                    .trim();
            }
            if (!colName) return;

            // store for later
            cb.dataset.colName = colName;

            // initial checkbox state: checkable if header exists and visible
            const key = normalizeText(colName);
            if (headerMap.hasOwnProperty(key)) {
                const idx = headerMap[key];
                const th = mainHeaderRow.cells[idx];
                cb.checked = !(th && th.style.display === 'none');
            } else {
                cb.checked = false;
            }

            cb.addEventListener('change', function() {
                const name = this.dataset.colName;
                const k = normalizeText(name);
                if (this.checked) {
                    // show existing column or create new
                    if (headerMap.hasOwnProperty(k)) {
                        setColumnVisibility(headerMap[k], true);
                    } else {
                        addColumn(name);
                    }
                } else {
                    // hide existing or remove created
                    if (headerMap.hasOwnProperty(k)) {
                        setColumnVisibility(headerMap[k], false);
                    } else {
                        removeAddedColumn(name);
                    }
                }
            });
        });

        // Keep N/A for any new rows inserted later
        const observer = new MutationObserver((mutations) => {
            for (const m of mutations) {
                m.addedNodes.forEach(node => {
                    if (node.nodeType === 1 && node.tagName === 'TR') {
                        Array.from(node.cells).forEach(td => {
                            // Skip cells that contain interactive elements
                            if (td.querySelector(
                                    'input, select, button, a, .form-check')) return;
                            const txt = (td.textContent || '').trim();
                            if (!txt || txt === '-') {
                                td.textContent = 'N/A';
                                td.classList.add('na-cell');
                            }
                        });
                    }
                });
            }
        });
        observer.observe(tbody, {
            childList: true,
            subtree: false
        });
    });

    // Hover fallback: ensure custom hover boxes show reliably across browsers
    (function() {
        function attachHoverHandlers() {
            document.querySelectorAll('#customerTable .name-cell').forEach(el => {
                const hover = el.querySelector('.custom-hover-box');
                if (!hover) return;

                let hideTimer = null;

                const show = () => {
                    if (hideTimer) {
                        clearTimeout(hideTimer);
                        hideTimer = null;
                    }
                    hover.style.display = 'block';
                    hover.style.zIndex = 3000;
                };
                const hide = () => {
                    if (hideTimer) clearTimeout(hideTimer);
                    hideTimer = setTimeout(() => {
                        hover.style.display = 'none';
                    }, 80);
                };

                el.addEventListener('mouseenter', show);
                el.addEventListener('mouseleave', hide);
                hover.addEventListener('mouseenter', show);
                hover.addEventListener('mouseleave', hide);
            });
        }

        // Attach once DOM ready and also after AJAX replacements
        document.addEventListener('DOMContentLoaded', attachHoverHandlers);
        // expose for manual reattach if table body is replaced via AJAX
        window.rebindCustomerHover = attachHoverHandlers;
    })();
</script>

<script>
    (function() {
        let popup = null;

        function createPopup() {
            if (!popup) {
                popup = document.createElement('div');
                popup.id = 'customerHoverPopup';
                document.body.appendChild(popup);
            }
        }

        function showPopupFromCell(cell) {
            if (!cell) return;
            createPopup();

            const hover = cell.querySelector('.custom-hover-box');
            if (!hover) return;

            popup.innerHTML = hover.innerHTML;

            const rect = cell.getBoundingClientRect();
            const scrollY = window.scrollY || window.pageYOffset;
            const scrollX = window.scrollX || window.pageXOffset;

            let left = rect.left + scrollX;
            let top = rect.bottom + scrollY + 5;

            // Prevent overflow on right
            const popupRect = popup.getBoundingClientRect();
            const rightSpace = window.innerWidth - rect.left;
            if (rightSpace < popupRect.width + 20) {
                left = rect.right + scrollX - popupRect.width;
            }

            popup.style.left = left + 'px';
            popup.style.top = top + 'px';
            popup.classList.add('show');
        }


        function hidePopup() {
            if (popup) popup.classList.remove('show');
        }

        let hoverTarget = null;

        document.addEventListener('mouseover', function(e) {
            const cell = e.target.closest('.name-cell');
            if (cell && cell.querySelector('.custom-hover-box')) {
                hoverTarget = cell;
                showPopupFromCell(cell);
            }
        });

        document.addEventListener('mouseout', function(e) {
            const related = e.relatedTarget;
            if (!related) {
                hidePopup();
                hoverTarget = null;
                return;
            }
            if (hoverTarget && (related === hoverTarget || hoverTarget.contains(related))) return;
            if (popup && (related === popup || popup.contains(related))) return;
            hidePopup();
            hoverTarget = null;
        });

        window.addEventListener('scroll', hidePopup);
        window.addEventListener('resize', hidePopup);
    })();
</script>
