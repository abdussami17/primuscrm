<!-- Email Modal -->
<div id="addSmartSequenceModal" class="modal fade">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <form method="POST" action="{{ route('smart-sequences.store') }}" id="sequenceForm">
                @csrf
                <input type="hidden" name="sequence_id" id="sequenceId" value="{{ $sequence->id ?? '' }}">
                
                <!-- Modal Header -->
                <div class="crm-header model-crm-header d-flex justify-content-between align-items-center">
                    <span id="modalTitle">Create Smart Sequence</span>
                    <div class="d-flex gap-2">
                        <button type="button" id="minimizeModalBtn" class="btn btn-sm btn-light border-0">
                            <i class="ti ti-minimize"></i>
                        </button>
                        <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-light me-1 border-0">
                            <i class="ti ti-circle-x"></i>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="group_area-box-parent mt-2">
                        <!-- Configuration Section -->
                        <div class="group_area-box mb-3 shadow-sm">
                            <div class="crm-header">
                                <i class="ti ti-settings me-1 text-white"></i> Smart Configuration
                            </div>
                            <div class="d-flex p-3 justify-content-normal align-items-end">
                                <div class="col-md-12 row g-2">
                                    <div class="col-md-4">
                                        <label for="sequence-title" class="form-label">Title</label>
                                        <input type="text" id="sequence-title" name="title" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Criteria Section -->
                        <div class="group_area-box mb-3 shadow-sm">
                            <div class="crm-header">
                                <i class="ti ti-list-check text-white me-1"></i>Smart Criteria
                            </div>
                            <div class="p-3">
                                <div id="criteria-container">
                                    <!-- Criteria groups will be added here -->
                                </div>
                                <div class="mt-3">
                                    <button type="button" class="add-criteria-button" id="addCriteriaBtn">+ Criteria</button>
                                    <button type="button" class="add-criteria-button" id="addOrGroupBtn" style="background: #ffc107; color: #000;">+ OR Criteria</button>
                                </div>
                            </div>
                        </div>

                        <!-- Action & Delay Section -->
                        <div class="group_area-box mb-3 shadow-sm">
                            <div class="crm-header">
                                <i class="ti ti-repeat me-1 text-white"></i> Smart Action & Smart Delay
                            </div>
                            <div class="p-3">
                                <button type="button" class="add-action-button" id="addActionBtn">+ Action</button>
                                <div class="action-delay-container" id="actionContainer">
                                    <!-- Actions will be added here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer d-flex justify-content-end gap-1">
                    <button type="button" class="btn btn-light border border-1" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveSequenceBtn">Save Sequence</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Email Preview Modal -->
<div class="modal fade" id="emailPreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Email Template Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="emailPreviewContent" class="p-3 border rounded" style="background: #fff; min-height: 300px;">
                    <p>Select a template to preview</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
    .criteria-group {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        position: relative;
        padding-top: 35px;
    }

    .criteria-group.or-group {
        background: #fff3cd;
        border: 1px solid #ffc107;
    }

    .criteria-group-label {
        position: absolute;
        top: -10px;
        left: 15px;
        background: #0d6efd;
        color: white;
        padding: 2px 10px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: bold;
    }

    .criteria-group.or-group .criteria-group-label {
        background: #ffc107;
        color: #000;
    }

    .criteria-rows-container {
        margin-top: 10px;
    }

    .criteria-row {
        background: white;
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 10px;
        border: 1px solid #e9ecef;
    }

    .remove-group-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 4px;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        cursor: pointer;
    }

    .remove-group-btn:hover {
        background: #c82333;
    }

    .add-criteria-button {
        background: #28a745;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
        margin-right: 4px;
    }

    .add-criteria-button:hover {
        background: #218838;
    }

    .btn-icon-only {
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 4px;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .btn-icon-only:hover {
        background: #c82333;
    }

    .date-input-container {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .date-input-container span {
        color: #6c757d;
        font-size: 14px;
    }

    .action-delay-container-row {
        margin-bottom: 15px;
    }

    .action-sequence {
        font-size: 12px;
        padding: 3px 8px;
    }

    .check-btn {
        background: #6c757d;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 5px 10px;
        font-size: 12px;
        cursor: pointer;
        margin-bottom: 5px;
    }

    .check-btn.valid {
        background: #28a745;
    }

    .check-btn.invalid {
        background: #dc3545;
    }

    /* .delete-btn {
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 5px 10px;
        font-size: 12px;
        cursor: pointer;
    }

    .delete-btn:hover {
        background: #c82333;
    } */

    .add-action-button {
        background: #0d6efd;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
        margin-bottom: 15px;
    }

    .add-action-button:hover {
        background: #0b5ed7;
    }

    .crm-header {
        background: #0d6efd;
        color: white;
        padding: 0.75rem 1rem;
        font-weight: 500;
    }
    
    .model-crm-header {
        border-radius: 0;
    }
    
    .group_area-box {
        background: white;
        border-radius: 0.5rem;
        overflow: hidden;
    }
</style>

@include('smart-sequences.partials.modal-scripts')