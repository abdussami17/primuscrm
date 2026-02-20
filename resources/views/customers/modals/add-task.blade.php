{{-- Add Task Modal - resources/views/customers/modals/add-task.blade.php --}}

@props(['customerId', 'users' => []])

<div id="addTaskModal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Task</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="taskFormModal" action="javascript:void(0);">
                <div class="modal-body pb-2">
                    <div class="row g-2">

                        <!-- Due Date -->
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Due Date</label>
                            <input type="date" value="" name="due_date" id="dueDatePickerModal"
                                class="bg-light form-control cf-datepicker" placeholder="Select Due Date">
                            <input type="hidden" id="taskIdModal" name="task_id">

                        </div>

                        <!-- Customer (pre-filled from current customer) -->
                        <div class="col-md-6 mb-4 position-relative">
                            <label class="form-label">Customer</label>
                            @php
                                $customerDisplay = isset($customer)
                                    ? trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? ''))
                                    : ($customerId ?? ''
                                        ? 'Customer #' . $customerId
                                        : '');
                                $customerIdValue = $customer->id ?? ($customerId ?? '');
                            @endphp
                            <input type="text" name="customer_search" class="form-control" id="customerSearchModal"
                                placeholder="Customer" value="{{ $customerDisplay }}" readonly>
                            <input type="hidden" name="customer_id" value="{{ $customerIdValue }}">
                            <input type="hidden" name="deal_id" id="dealIdModal" value="">
                            <div id="customerSuggestionsModal" class="list-group position-absolute w-100 mt-1 "
                                style="z-index: 1050; display:none;"></div>
                        </div>

                        <!-- Assigned To -->
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Assigned To</label>
                            <select class="form-select" id="assignedToModal" name="assigned_to">
                                <option value="" hidden>-- Select --</option>
                                @if ($users->isNotEmpty())
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                @else
                                    <option value="">No record found</option>
                                @endif

                            </select>
                        </div>

                        <!-- Status Type -->
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Status Type</label>
                            <select class="form-select" id="statusTypeModal" name="status_type">
                                <option value="" hidden>-- Select --</option>
                                <option value="Pending">Pending</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>

                        <!-- Task Type -->
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Task Type</label>
                            <select class="form-select" id="taskTypeModal" name="task_type">
                                <option value="" hidden>-- Select --</option>
                                <option value="Follow-up Call">Follow-up Call</option>
                                <option value="Appointment">Appointment</option>
                                <option value="Test Drive">Test Drive</option>
                                <option value="Vehicle Pick-up">Vehicle Pick-up</option>
                                <option value="Credit Application">Credit Application</option>
                                <option value="Delivery">Delivery</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <!-- Phone Scripts with Tom Select -->
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Phone Scripts</label>
                            <select id="phoneScriptSelectModal" name="phoneScriptSelectModal"
                                placeholder="Search & select script..." class="form-select w-100">
                                @if (isset($phoneScripts) && $phoneScripts->isNotEmpty())
                                    @foreach ($phoneScripts as $script)
                                        <option value="{{ $script->id }}">{{ $script->name }}</option>
                                    @endforeach
                                @else
                                    <option value="">No scripts found</option>
                                @endif
                            </select>
                        </div>

                        <!-- Priority -->
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Priority</label>
                            <select class="form-select" id="priorityModal" name="priority">
                                <option value="" hidden>-- Select --</option>
                                <option value="High">High</option>
                                <option value="Medium">Medium</option>
                                <option value="Low">Low</option>
                            </select>
                        </div>

                        <!-- Deal List (kept hidden; only hidden deal_id is used) -->
                        <div class="col-md-12 mb-4 d-none" id="dealSectionModal" hidden>
                            <label class="form-label deal-section-header">Select Deal</label>
                            <div class="list-group" id="dealListModal"></div>
                        </div>

                        <!-- Description -->
                        <div class="col-md-12 mb-2">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="descriptionFieldModal" rows="3"
                                placeholder="Enter task description (max 140 characters)"></textarea>
                            <div class="description-counter"><span id="charCountModal">0</span>/140</div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer justify-content-end gap-1">
                    <button type="button" class="btn btn-light border border-1"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Task</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    
        // Remove stray modal backdrops
        document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
    
        const taskForm = document.getElementById('taskFormModal');
        if (!taskForm) return;
    
        // Prevent attaching multiple listeners
        if (taskForm.dataset.listenerAttached === 'true') return;
        taskForm.dataset.listenerAttached = 'true';
    
        let isProcessing = false;
    
        taskForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            if (isProcessing) return;
            isProcessing = true;
    
            const submitButton = taskForm.querySelector('button[type="submit"]');
            if (submitButton) submitButton.disabled = true;
    
            try {
                const formData = new FormData(taskForm);
                const payload = Object.fromEntries(formData.entries());
    
                // Remove deal_id if empty
                if (!payload.deal_id) delete payload.deal_id;
    
                // Client-side validation
                const requiredFields = ['customer_id', 'assigned_to', 'due_date', 'task_type'];
                for (let field of requiredFields) {
                    if (!payload[field] || payload[field].trim() === '') {
                        alert(`Please fill required field: ${field}`);
                        isProcessing = false;
                        if (submitButton) submitButton.disabled = false;
                        return;
                    }
                }
    
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
    
                const response = await fetch('/tasks', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });
    
                const data = await response.json();
    
                if (!response.ok) {
                    let errMsg = (data.errors)
                        ? Object.values(data.errors).flat().join('\n')
                        : data.message || 'Failed to create task';
                    alert(errMsg);
                    return;
                }
    
                // Success
                if (typeof showToast === 'function') {
                    showToast('Task created successfully', 'success');
                } else {
                    alert('Task created successfully');
                }
    
                // Close modal
                const modalEl = document.getElementById('addTaskModal');
                try { bootstrap.Modal.getInstance(modalEl)?.hide(); } catch (err) {}
    
                // Reset form and hidden fields
                taskForm.reset();
                const dealSection = document.getElementById('dealSectionModal');
                const dealList = document.getElementById('dealListModal');
                const dealInput = document.getElementById('dealIdModal');
                if (dealSection) dealSection.classList.add('d-none');
                if (dealList) dealList.innerHTML = '';
                if (dealInput) dealInput.value = '';
    
                // Refresh tasks if functions exist
                if (typeof loadTasks === 'function') loadTasks();
                if (typeof fetchTasks === 'function') fetchTasks();
    
            } catch (error) {
                alert(error.message || 'Unexpected error creating task');
            } finally {
                isProcessing = false;
                if (submitButton) submitButton.disabled = false;
            }
        });
    
        // Set hidden deal_id when a deal is selected
        document.addEventListener('deal:selected', function(e) {
            try {
                const dealId = e?.detail?.dealId || '';
                const dealInput = document.getElementById('dealIdModal') 
                                  || document.querySelector('input[name="deal_id"]');
                if (dealInput) dealInput.value = dealId;
            } catch (err) {
                // silently ignore
            }
        });
    
        // Reset modal on hide
        const modalEl = document.getElementById('addTaskModal');
        if (modalEl && typeof bootstrap !== 'undefined') {
            modalEl.addEventListener('hidden.bs.modal', function() {
                taskForm.reset();
                const dealSection = document.getElementById('dealSectionModal');
                const dealList = document.getElementById('dealListModal');
                const dealInput = document.getElementById('dealIdModal');
                if (dealSection) dealSection.classList.add('d-none');
                if (dealList) dealList.innerHTML = '';
                if (dealInput) dealInput.value = '';
                isProcessing = false;
                const submitButton = taskForm.querySelector('button[type="submit"]');
                if (submitButton) submitButton.disabled = false;
            });
        }
    
    });
    </script>