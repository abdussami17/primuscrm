{{-- Image Gallery Modal --}}
<div id="imageInventory" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="crm-header model-crm-header d-flex justify-content-between align-items-center">
                Vehicle Images
                <button type="button" data-bs-dismiss="modal" aria-label="Close">
                    <i class="isax isax-close-circle"></i>
                </button>
            </div>

            <div class="modal-body pt-1">
                <form id="imageUploadForm" action="{{ route('inventory.update-images') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="inventory_id" id="imageInventoryId">
                    
                    <div class="row g-3" id="imageContainer">
                        {{-- Images will be loaded dynamically --}}
                        
                        {{-- Upload Placeholder --}}
                        <div class="col-md-3">
                            <div class="place-holder-box" id="uploadBox">
                                <i class="ti ti-upload"></i>
                            </div>
                            <input type="file" name="images[]" id="uploadInput" multiple accept="image/*" style="display: none;">
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-light border border-1" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="imageUploadForm" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

<style>
.image-wrapper {
    position: relative;
    width: 100%;
}

.image-wrapper img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 8px;
}

.delete-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    background: rgba(0, 0, 0, 0.6);
    color: white;
    border: none;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    font-size: 14px;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
}

.delete-btn:hover {
    background: rgba(255, 0, 0, 0.8);
}

.place-holder-box {
    width: 100%;
    height: 150px;
    border: 2px dashed #ccc;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
}

.place-holder-box:hover {
    border-color: var(--cf-primary);
    background: rgba(0, 33, 64, 0.05);
}

.place-holder-box i {
    font-size: 32px;
    color: #999;
}
</style>