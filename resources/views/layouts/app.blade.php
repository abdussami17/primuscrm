<!DOCTYPE html>
<html lang="en" data-layout="single">

<head>
    {{-- =========================================================
    | META CONFIGURATION
    ========================================================== --}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>
        @hasSection('title')
            Primus CRM - @yield('title')
        @else
            Primus CRM
        @endif
    </title>

    {{-- =========================================================
    | FAVICON
    ========================================================== --}}
    <link rel="shortcut icon" href="{{ asset('assets/light_logo.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/light_logo.png') }}">

    {{-- =========================================================
    | THIRD-PARTY CSS (CDN FIRST)
    ========================================================== --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    {{-- =========================================================
    | CORE CSS (LOCAL)
    ========================================================== --}}
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/tabler-icons/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/simplebar/simplebar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/iconsax.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style1.css') }}">

    {{-- =========================================================
    | PRELOAD / THEME CONFIG SCRIPT
    ========================================================== --}}
<script>
(function () {
    try {
        const html = document.documentElement;
        const dark = localStorage.getItem("darkMode") === "enabled";

        // ALWAYS set attributes immediately (no branches)
        html.setAttribute("data-layout", "single");
        html.setAttribute("data-sidebar", "light");
        html.setAttribute("data-color", "primary");
        html.setAttribute("data-topbar", "white");
        html.setAttribute("data-size", "default");
        html.setAttribute("data-width", "fluid");
        html.setAttribute("data-bs-theme", dark ? "dark" : "light");

        // logo swap AFTER DOM only (not visual-critical)
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".logo-img").forEach(img => {
                img.src = dark
                    ? "{{ asset('assets/dark_logo.png') }}"
                    : "{{ asset('assets/light_logo.png') }}";
            });
        });

    } catch (e) {}
})();
</script>


    {{-- =========================================================
    | INLINE PAGE STYLES
    ========================================================== --}}
    <style>
        .sortable-ghost {
            opacity: 0.5;
        }
    </style>
    <style>
        /* Make the global customer profile offcanvas match customers.edit background */
        .customerProfileOffcanvas .offcanvas-body {
            background-color: var(--cf-primary) !important;
        }
    </style>

    {{-- =========================================================
    | PAGE-LEVEL CSS
    ========================================================== --}}
    @stack('styles')
</head>

<body>

    {{-- =============================================================
| APPLICATION WRAPPER
============================================================== --}}
    <div class="main-wrapper">

        {{-- Header --}}
        @include('partials.header')

        {{-- Sidebar --}}
        @include('partials.sidebar')

        {{-- Page Content --}}
        <div class="page-wrapper">
            @yield('content')
        </div>
    </div>

    {{-- =============================================================
| Modals
============================================================== --}}

    {{-- Add Customer Modal --}}

    <div class="offcanvas offcanvas-end customerProfileOffcanvas" tabindex="-1" id="commonCanvas">
        <div class="offcanvas-header d-block pb-0">
            <div class="border-bottom d-flex align-items-center justify-content-between pb-3">
                <h5 class="offcanvas-title">Add Customer</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
               
            </div>
        </div>
        <div class="offcanvas-body pt-3" >
 </div>
    </div>
    {{-- Global shared showroom offcanvas (render at body root so it behaves identically everywhere) --}}
    @include('components.showroom-offcanvas')

    {{-- License Scanner Modal  --}}
    <div class="modal fade" id="licenseScannerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-id-card me-2"></i>Driver's License Scanner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p class="text-muted">Open front/back camera, capture image, then click <strong>Scan &
                            Fill</strong>.</p>

                    <div class="row g-3">
                        <!-- FRONT -->
                        <div class="col-md-6">
                            <h6 class="mb-2">Front Side</h6>
                            <div class="preview-box" id="frontPreviewBox">
                                <div id="frontPlaceholder">
                                    <div class="text-center">
                                        <i class="fa-solid fa-image fa-2x text-muted"></i>
                                        <div class="mt-2">
                                            <button class="btn btn-light border-1 border" id="openFrontCamBtn">Open
                                                Front Camera</button>
                                        </div>
                                    </div>
                                </div>


                                <img id="frontImg" src="" alt="" style="display:none;">
                                <div class="video-wrap w-100" id="frontVideoWrap">
                                    <video id="cameraStreamFront" autoplay playsinline></video>
                                    <div class="capture-controls text-center mt-2">
                                        <button class="btn btn-light border-1 border" id="cancelFrontBtn"
                                            style="display:none;">Cancel</button>
                                        <button class="btn btn-light border-1 border" id="captureFrontBtn"
                                            style="display:none;">Capture</button>
                                    </div>

                                </div>
                                <!-- scanning overlay will be injected here -->
                            </div>
                            <div class="mt-2 text-center">
                                <button class="btn btn-light border-1 border" id="retakeFrontBtn"
                                    style="display:none;">Retake
                                    Front</button>
                            </div>
                        </div>

                        <!-- BACK -->
                        <div class="col-md-6">
                            <h6 class="mb-2">Back Side</h6>
                            <div class="preview-box" id="backPreviewBox">
                                <div id="backPlaceholder">
                                    <div class="text-center">
                                        <i class="fa-solid fa-image fa-2x text-muted"></i>
                                        <div class="mt-2">
                                            <button class="btn btn-light border-1 border" id="openBackCamBtn">Open
                                                Back Camera</button>
                                        </div>
                                    </div>
                                </div>
                                <img id="backImg" src="" alt="" style="display:none;">
                                <div class="video-wrap w-100" id="backVideoWrap">
                                    <video id="cameraStreamBack" autoplay playsinline></video>
                                    <!-- BACK -->
                                    <div class="capture-controls text-center mt-2">
                                        <button class="btn btn-light border-1 border" id="cancelBackBtn"
                                            style="display:none;">Cancel</button>
                                        <button class="btn btn-light border-1 border" id="captureBackBtn"
                                            style="display:none;">Capture</button>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2 text-center">
                                <button class="btn btn-sm btn-light border border-1" id="retakeBackBtn"
                                    style="display:none;">Retake
                                    Back</button>
                            </div>
                        </div>
                    </div>

                    <!-- hidden canvas used for capture -->
                    <canvas id="captureCanvas" style="display:none;"></canvas>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light border border-1" id="closeScannerBtn"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="scanFillBtn" disabled>Scan & Fill</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Customer Email Confirm Modal -->
    <div class="modal fade" id="customConfirmModal" tabindex="-1" aria-labelledby="customConfirmLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h6 class="modal-title" id="customConfirmLabel">Confirm Deletion</h6>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this email?
                </div>
                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Notification Offcanvas --}}

    <div class="offcanvas offcanvas-end" tabindex="-1" id="notificationCanvas"
        aria-labelledby="notificationCanvasLabel">
        <!-- Header -->
        <div class="offcanvas-header border-bottom d-flex align-items-center justify-content-between pb-3">
            <h6 id="notificationCanvasLabel" class="offcanvas-title mb-0">Notifications</h6>
            <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="offcanvas"
                aria-label="Close">
                <i class="fa-solid fa-x"></i>
            </button>
        </div>

        <!-- Body -->
        <div class="offcanvas-body p-0 d-flex flex-column" style="height: 100vh; overflow: hidden;">

            <!-- Search -->
            <div class="p-3 border-bottom">
                <div class="search-box position-relative w-100">
                    <i class="ti ti-search position-absolute"
                        style="top: 50%; left: 10px; transform: translateY(-50%);"></i>
                    <input type="text" class="form-control ps-4" placeholder="Search notifications"
                        aria-label="Search notifications">
                </div>
            </div>

            <!-- Notification List -->
            <div class="notification-body flex-grow-1 overflow-auto p-3">

                <!-- Notification Item Template -->
                <div class="dropdown-item notification-item py-2 text-wrap border-bottom" id="notification-1">
                    <div class="d-flex">
                        <div class="me-3 flex-shrink-0">
                            <img src="assets/img/users/user-03.jpg" class="avatar-md rounded-circle"
                                alt="New Customer">
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-0 fw-semibold text-dark">John Doe</p>
                            <p class="mb-1 fs-14">Added as a <span class="fw-semibold">new customer</span> in the CRM.
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fs-12"><i class="isax isax-clock me-1"></i>Just now</span>
                                <div class="notification-action d-flex gap-2">
                                    <button class="btn rounded-circle bg-primary text-white" style="padding: 2px;"
                                        data-bs-toggle="tooltip" title="Mark as Read" aria-label="Mark as Read">
                                        <i class="ti ti-check fs-10"></i>
                                    </button>
                                    <button class="btn rounded-circle text-danger p-0"
                                        data-dismissible="#notification-1" aria-label="Dismiss Notification">
                                        <i class="isax isax-close-circle fs-12"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Example: Lead Added -->
                <div class="dropdown-item notification-item py-2 text-wrap border-bottom" id="notification-2">
                    <div class="d-flex">
                        <div class="avatar-sm me-3 flex-shrink-0">
                            <span class="avatar-title bg-soft-success text-success fs-18 rounded-circle"><i
                                    class="isax isax-user-add"></i></span>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-0 fw-semibold text-dark">New Lead</p>
                            <p class="mb-1 fs-14">A new <span class="fw-semibold">lead</span> has been added:
                                <strong>Emily
                                    Smith</strong>.
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fs-12"><i class="isax isax-clock me-1"></i>5 min ago</span>
                                <div class="notification-action d-flex gap-2">
                                    <button class="btn rounded-circle bg-primary text-white" style="padding: 2px;"
                                        data-bs-toggle="tooltip" title="Mark as Read" aria-label="Mark as Read">
                                        <i class="ti ti-check fs-10"></i>
                                    </button>
                                    <button class="btn rounded-circle text-danger p-0"
                                        data-dismissible="#notification-2" aria-label="Dismiss Notification">
                                        <i class="isax isax-close-circle fs-12"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Example: Appointment -->
                <div class="dropdown-item notification-item py-2 text-wrap border-bottom" id="notification-3">
                    <div class="d-flex">
                        <div class="avatar-sm me-3 flex-shrink-0">
                            <span class="avatar-title bg-soft-warning text-warning fs-18 rounded-circle"><i
                                    class="isax isax-calendar"></i></span>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-0 fw-semibold text-dark">New Appointment</p>
                            <p class="mb-1 fs-14">Appointment scheduled with <span class="fw-semibold">Michael
                                    Brown</span> for test
                                drive.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fs-12"><i class="isax isax-clock me-1"></i>15 min ago</span>
                                <div class="notification-action d-flex gap-2">
                                    <button class="btn rounded-circle bg-primary text-white" style="padding: 2px;"
                                        data-bs-toggle="tooltip" title="Mark as Read" aria-label="Mark as Read">
                                        <i class="ti ti-check fs-10"></i>
                                    </button>
                                    <button class="btn rounded-circle text-danger p-0"
                                        data-dismissible="#notification-3" aria-label="Dismiss Notification">
                                        <i class="isax isax-close-circle fs-12"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Example: Invoice Generated -->
                <div class="dropdown-item notification-item py-2 text-wrap border-bottom" id="notification-4">
                    <div class="d-flex">
                        <div class="avatar-sm me-3 flex-shrink-0">
                            <span class="avatar-title bg-soft-primary text-primary fs-18 rounded-circle"><i
                                    class="isax isax-document"></i></span>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-0 fs-14">Invoice <span class="fw-semibold">#INV2301</span> generated for
                                <span class="fw-semibold">John Doe</span>.
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fs-12"><i class="isax isax-clock me-1"></i>30 min ago</span>
                                <div class="notification-action d-flex gap-2">
                                    <button class="btn rounded-circle bg-primary text-white" style="padding: 2px;"
                                        data-bs-toggle="tooltip" title="Mark as Read" aria-label="Mark as Read">
                                        <i class="ti ti-check fs-10"></i>
                                    </button>
                                    <button class="btn rounded-circle text-danger p-0"
                                        data-dismissible="#notification-4" aria-label="Dismiss Notification">
                                        <i class="isax isax-close-circle fs-12"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End Notification List -->

        </div>
    </div>




    <!-- Lost Reason Modal -->
    <div id="lostReasonModal" class="lost-modal-backdrop" style="display:none;">
        <div class="lost-modal">
            <h6 class="mb-2 text-center">Why are we marking this lead lost?</h6>
            <select id="lostReasonSelect" class="form-select form-select-sm mb-3">
                <option value="" disabled selected hidden>-- Select Reason --</option>
                <option value="Bad Credit">Bad Credit</option>
                <option value="Bad Email">Bad Email</option>
                <option value="Bad Phone Number">Bad Phone Number</option>
                <option value="Did Not Respond">Did Not Respond</option>
                <option value="Diff Dealer, Diff Brand">Diff Dealer, Diff Brand</option>
                <option value="Diff Dealer, Same Brand">Diff Dealer, Same Brand</option>
                <option value="Diff Dealer, Same Group">Diff Dealer, Same Group</option>
                <option value="Import Lead">Import Lead</option>
                <option value="No Agreement Reached">No Agreement Reached</option>
                <option value="No Credit">No Credit</option>
                <option value="No Longer Owns">No Longer Owns</option>
                <option value="Other Salesperson Lead">Other Salesperson Lead</option>
                <option value="Out of Market">Out of Market</option>
                <option value="Requested No More Contact">Requested No More Contact</option>
                <option value="Service Lead">Service Lead</option>
                <option value="Sold Privately">Sold Privately</option>
            </select>

            <div class="text-center">
                <button class="btn btn-primary btn-sm" id="saveLostReason">Save</button>
                <button class="btn btn-light btn-sm" id="cancelLostReason">Cancel</button>
            </div>
        </div>
    </div>
    <script>
        let activeDropdown = null; // track which dropdown triggered the modal
        let lostReasons = new WeakMap(); // store reason per dropdown

        document.querySelectorAll(".sales-status").forEach(dropdown => {
            dropdown.addEventListener("change", (e) => {
                const value = e.target.value;

                // Remove old info icon if exists
                const existingIcon = e.target.parentElement.querySelector(".lost-info");
                if (existingIcon) existingIcon.remove();

                if (value === "Lost") {
                    activeDropdown = e.target;
                    document.getElementById("lostReasonModal").style.display = "flex";

                    // Prefill reason if already exists
                    const prevReason = lostReasons.get(activeDropdown) || "";
                    document.getElementById("lostReasonSelect").value = prevReason || "";
                } else {
                    // Clear Lost Reason if changed away from Lost
                    lostReasons.delete(e.target);
                }
            });
        });

        // Save Lost Reason
        document.getElementById("saveLostReason").addEventListener("click", () => {
            const reason = document.getElementById("lostReasonSelect").value;
            if (!reason) {
                alert("Please select a Lost Reason.");
                return;
            }

            lostReasons.set(activeDropdown, reason);
            document.getElementById("lostReasonModal").style.display = "none";

            // Add info icon beside dropdown
            const icon = document.createElement("span");
            icon.className = "lost-info";
            icon.innerHTML = `&#9432;<span class="lost-tooltip">Lost Reasoning: ${reason}</span>`;
            activeDropdown.insertAdjacentElement("afterend", icon);

            // Click to reopen modal
            icon.addEventListener("click", () => {
                document.getElementById("lostReasonModal").style.display = "flex";
                document.getElementById("lostReasonSelect").value = lostReasons.get(activeDropdown) || "";
                activeDropdown = icon.previousElementSibling;
            });
        });

        // Cancel modal
        document.getElementById("cancelLostReason").addEventListener("click", () => {
            document.getElementById("lostReasonModal").style.display = "none";
            activeDropdown.value = "Active"; // Reset if cancelled
        });
    </script>

    <!-- Service Appointment Modal -->
  

    <!-- Documents Modal -->
    <div class="modal fade" id="documentsModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Customer Documents</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="list-group" id="docList">
                        <!-- Documents will be loaded here dynamically -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Document Modal -->
    <div class="modal fade" id="uploadDocModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload <span id="uploadDocTypeLabel"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="uploadDocForm" enctype="multipart/form-data">
                        <input type="hidden" id="uploadDocType">
                        <div class="mb-3">
                            <label class="form-label">Choose File <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="uploadDocFile"
                                accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" required>
                            <small class="text-muted">Max 10MB (PDF, JPG, PNG, DOC, DOCX)</small>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-upload me-1"></i>Upload
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Error Modal --}}

    <div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-danger">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">⚠️ Action Required</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <p id="errorMessage" class="mb-3"></p>
                    <button class="btn btn-outline-info" id="helpBtn">
                        <i class="bi bi-info-circle"></i> Need Help?
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Send TO DMS MODAL --}}



    <div class="modal fade" id="sendToDmsModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-primary">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-white">Send Deal to DMS</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-2 text-muted">Add any note or comment before sending this deal to DMS:</p>
                    <textarea class="form-control mb-3" id="dmsMessage" rows="4" placeholder="Type your note here..."></textarea>
                    <div class="text-end">
                        <button class="btn btn-light border border-1" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" id="confirmSendToDms">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PDF Preview Modal -->
    <div class="modal fade" id="pdfModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfTitle">Document Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="pdfImage" src="" alt="PDF Preview" class="img-fluid">
                </div>
                <div class="modal-footer">
                    <button id="savePdfBtn" class="btn btn-primary">Save to Notes</button>
                    <div class="btn-group ms-2">
                        <button class="btn btn-light border-1 border dropdown-toggle"
                            data-bs-toggle="dropdown">Print</button>
                        <ul class="dropdown-menu">

                            <li><a class="dropdown-item" href="#">PDF</a></li>
                            <li><a class="dropdown-item" href="#">Excel</a></li>
                            <li><a class="dropdown-item" href="#">CSV</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Showroom Visit Modal --}}

    <div class="modal fade" id="editVisitsModal" tabindex="-1" aria-labelledby="editVisitModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editVisitModalLabel">Edit Showroom Visit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Notes -->
                    <div class="mb-3">
                        <label for="visitNotesnput" class="form-label">Visit Notes</label>
                        <textarea class="form-control" id="visitNotesnput" rows="4" placeholder="Add or update visit notes..."
                            maxlength="150"></textarea>
                    </div>

                    <!-- Duration input as HH:MM:SS (text field) -->
                    <div class="mb-3">
                        <label for="visitDurationInput" class="form-label">Visit Duration (HH:MM:SS)</label>
                        <input type="text" class="form-control" id="visitDurationInput"
                            placeholder="00:05:30" />
                        <small class="form-text text-muted">Format: HH:mm:ss (use leading zeros)</small>
                    </div>

                    <!-- Start Time (datetime-local) -->
                    <div class="mb-3">
                        <label for="visitTime" class="form-label">Start Time</label>
                        <input type="datetime-local" class="form-control" id="visitTime">
                    </div>

                    <!-- End time readonly (computed) -->
                    <div class="mb-3">
                        <label for="visitEndTime" class="form-label">End Time</label>
                        <input type="datetime-local" class="form-control" id="visitEndTime" readonly />
                        <small class="form-text text-muted">End time is auto-calculated when visit is stopped</small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="saveVisitChanges">Save Changes</button>
                    <button type="button" class="btn btn-light border-1 border"
                        data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View License Modal -->
    <div class="modal fade" id="viewLicenseModal" tabindex="-1" aria-labelledby="tradeInModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Customer License View</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="license-image">
                        <img src="https://tse1.mm.bing.net/th/id/OIP.gbNvjm6-lk09pTvkwH19xwAAAA?rs=1&pid=ImgDetMain&o=7&rm=3"
                            alt="license-image">
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-start">
                    <button class="btn btn-light border border-1" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addmanuallyModal" tabindex="-1" aria-labelledby="tradeInModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="crm-header model-crm-header d-flex justify-content-between align-items-center">
                    What kind of vehicle does your customer want?
                    <button type="button" data-bs-dismiss="modal" aria-label="Close">
                        <i class="isax isax-close-circle"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="row g-3" action="customers.html">

                        <!-- First Row -->
                        <div class="col-md-4">
                            <label class="form-label">Inventory Type</label>
                            <select class="form-select form-select ">
                                <option hidden>Select Inventory Type</option>

                                <option>New</option>
                                <option>Pre-Owned</option>
                                <option>CPO</option>
                                <option>Demo</option>
                                <option>Wholesale</option>
                                <option>Unknown</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Year</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Make</label>
                            <input type="text" class="form-control">
                        </div>

                        <!-- Second Row -->
                        <div class="col-md-4">
                            <label class="form-label">Model</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Trim</label>
                            <input type="text" class="form-control">
                        </div>

                        <!-- Third Row -->
                        <div class="col-md-6">
                            <label class="form-label">Exterior Color</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Interior Color</label>
                            <input type="text" class="form-control">
                        </div>

                        <!-- Fourth Row -->
                        <div class="col-md-4">
                            <label class="form-label">Body Style</label>
                            <select class="form-select">
                                <option>Select</option>
                                <option>SUV</option>
                                <option>Sedan</option>
                                <option>Truck</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">MPG</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="City">
                                <input type="text" class="form-control" placeholder="Hwy">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Fuel</label>
                            <input type="text" class="form-control">
                        </div>

                        <!-- Fifth Row -->
                        <div class="col-md-6">
                            <label class="form-label">Transmission</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Model Code</label>
                            <input type="text" class="form-control">
                        </div>

                        <!-- Section Title -->
                        <div class="col-12 mt-3">
                            <h6>What are your customer’s preferred limits?</h6>
                        </div>

                        <!-- Sixth Row -->
                        <div class="col-md-6">
                            <label class="form-label">Max Price</label>
                            <input type="number" class="form-control" placeholder="0.00">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Max Odometer</label>
                            <input type="number" class="form-control">
                        </div>



                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light border border-1"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>



    {{-- Vehicle Information Modal --}}


    <div class="offcanvas offcanvas-end" tabindex="-1" id="editvehicleinfo">
        <div class="offcanvas-header d-block pb-0">
            <div class="border-bottom d-flex align-items-center justify-content-between pb-3">
                <h6 class="offcanvas-title">Edit Vehicle Information</h6>
                <button type="button" class="btn-close btn-close-modal custom-btn-close"
                    data-bs-dismiss="offcanvas" aria-label="Close">
                    <i class="fa-solid fa-x"></i>
                </button>
            </div>
        </div>
        <div class="offcanvas-body pt-3">
            <div class="container py-0">
                <form>
                    <img height="150px" class="mb-2" width="150px" src="assets/img/cars/FORD-ESCAPE.webp"
                        alt="">
                    <div class="row g-2 mb-3 align-items-end">
                        <div class="col-md-2">
                            <button onclick="window.location='inventory.html'" class="btn btn-primary w-100"
                                type="button">Search
                                Inventory</button>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Stock #</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="stockInput">
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="checkStock()">Select</button>
                            </div>
                            <div id="stockError" class="text-danger mt-1" style="font-size: 12px; display: none;">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">VIN</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="vinInput">
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="checkVIN()">Decode</button>
                            </div>
                            <div id="vinError" class="text-danger mt-1" style="font-size: 12px; display: none;">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <a href="index.html" class="edit-vehicle-link">View CARFAX Report</a>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-2">
                            <label class="form-label">Inventory Type:</label>
                            <select class="form-select" id="invType">
                                <option>New</option>
                                <option>Pre-Owned</option>
                                <option>CPO</option>
                                <option>Demo</option>
                                <option>Wholesale</option>
                                <option>Unknown</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Year:</label>
                            <select class="form-select" id="year">
                                <option>-- None --</option>
                                <option>2023</option>
                                <option>2022</option>
                                <option>2021</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Make:</label>
                            <select class="form-select" id="make">
                                <option>-- None --</option>
                                <option>Toyota</option>
                                <option>Ford</option>
                                <option>Honda</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Model:</label>
                            <select class="form-select" id="model">
                                <option>-- None --</option>
                                <option>Camry</option>
                                <option>F-150</option>
                                <option>Civic</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Trim:</label>
                            <select class="form-select" id="trim">
                                <option>-- None --</option>
                                <option>LE</option>
                                <option>SE</option>
                                <option>XLE</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">KMs:</label>
                            <input type="text" class="form-control" id="kms">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Trans:</label>
                            <select class="form-select" id="trans">
                                <option>-- None --</option>
                                <option>Automatic</option>
                                <option>Manual</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Doors:</label>
                            <select class="form-select" id="doors">
                                <option>-- None --</option>
                                <option>2</option>
                                <option>4</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Drive Train:</label>
                            <input type="text" class="form-control" id="drivetrain">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Body Style:</label>
                            <select class="form-select" id="bodystyle">
                                <option>-- None --</option>
                                <option>Sedan</option>
                                <option>SUV</option>
                                <option>Truck</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Interior:</label>
                            <input type="text" class="form-control" id="interior">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Exterior:</label>
                            <input type="text" class="form-control" id="exterior">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Vehicle Weight:</label>
                            <input type="text" class="form-control" id="weight" placeholder="lbs">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label"># Axles:</label>
                            <input type="text" class="form-control" id="axles">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Selling Price:</label>
                            <input type="text" class="form-control" id="sellprice">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Internet Price:</label>
                            <input type="text" class="form-control" id="webprice">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Invoice:</label>
                            <input type="text" class="form-control" id="invoice">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">MSRP:</label>
                            <input type="text" class="form-control" id="msrp">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Cost:</label>
                            <input type="text" class="form-control" id="cost">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Memo:</label>
                            <textarea class="form-control" rows="3" id="memo"></textarea>
                        </div>
                    </div>

                    <div class="text-end mt-3">
                        <button class="btn btn-primary" type="submit">Save</button>
                        <button class="btn btn-danger" type="button">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div id="filterTaskModal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Filter Task & Appointment</h4>
                    <button type="button" class="btn-close btn-close-modal custom-btn-close"
                        data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-x"></i>
                    </button>
                </div>
                <form id="filtertaskform">
                    <div class="modal-body pb-2">
                        <div class="row g-2">

                            <!-- Status Type -->
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Status Type</label>
                                <select id="statusType" multiple>
                                    <option value="open">Open</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="completed">Completed</option>
                                    <option value="missed">Missed</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="walkin">Walk-In</option>
                                    <option value="noresponse">No Response</option>
                                    <option value="noshow">No Show</option>
                                </select>
                            </div>

                            <!-- Task Type -->
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Task Type</label>
                                <select id="taskType" multiple>
                                    <option value="" hidden>-- Select --</option>
                                    <option value="call">Inbound Call</option>
                                    <option value="call_outbound">Outbound Call</option>
                                    <option value="text_inbound">Inbound Text</option>
                                    <option value="text_outbound">Outbound Text</option>
                                    <option value="email_inbound">Inbound Email</option>
                                    <option value="email_outbound">Outbound Email</option>
                                    <option value="csi">CSI</option>
                                    <option value="appointment">Appointment</option>
                                    <option value="other">Other</option>

                                </select>
                            </div>


                        </div>
                    </div>
                    <div class="modal-footer justify-content-end gap-1">
                        <button type="button" class="btn btn-light border border-1"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Apply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new TomSelect("#statusType", {
                placeholder: "Enter Status Type Here",
                plugins: ['checkbox_options'],
                maxItems: null,
                persist: false,
                dropdownParent: "body"
            });

            new TomSelect("#taskType", {
                placeholder: "Enter Task Type Here",
                plugins: ['checkbox_options'],
                maxItems: null,
                persist: false,
                dropdownParent: "body"
            });

        });
    </script>
    <style>
        .ts-dropdown {
            z-index: 100000 !important;
            /* above modal */
            position: absolute !important;
            /* detach from parent overflow */

            /* match input width */
            max-height: 250px;
            /* prevent too tall */
            overflow-y: auto;
            /* scrollable */
        }
    </style>
    {{-- =============================================================
| CORE JAVASCRIPT (LOAD AT BOTTOM)
============================================================== --}}
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
     <script src="{{ asset('assets/js/custom.js') }}"></script>

    <script data-cfasync="false" src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    {{-- =============================================================
| PLUGINS
============================================================== --}}
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/plugins/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom-calendar.js') }}"></script>

    {{-- =============================================================
| CDN LIBRARIES
============================================================== --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.sheetjs.com/xlsx-0.20.3/package/dist/xlsx.full.min.js"></script>
    {{-- =============================================================
| GLOBAL FIX SOLUTIONS
============================================================== --}}
<script>
     function succeesAlert(message){
  Swal.fire({
                title: 'Success!',
                text: message, 
                icon: 'success'
            });
 }

function warningAlert(message) {

    Swal.fire({
        title: 'Warning!',
        html: errorText, // Use `html` instead of `text` to support formatting
        icon: 'warning',
    });
}
</script>
    <script>
        (function() {
            if (!window.bootstrap || !bootstrap.Modal) return;

            const OriginalModal = bootstrap.Modal;

            bootstrap.Modal = function(element, options) {
                // If element doesn't exist, return a dummy modal instance
                if (!element) {
                    return {
                        show() {},
                        hide() {},
                        toggle() {},
                        dispose() {},
                        handleUpdate() {}
                    };
                }

                // If modal instance already exists, return it
                let instance = OriginalModal.getInstance(element);
                if (instance) return instance;

                // Otherwise create a new modal normally
                return new OriginalModal(element, options);
            };

            // Preserve getInstance
            bootstrap.Modal.getInstance = OriginalModal.getInstance;
        })();
    </script>
    <style>
        .ts-wrapper.form-control,
        .ts-wrapper.form-select {
            box-shadow: none;
            display: flex;
            height: auto;
            padding: 0 !important;
        }

        .ts-wrapper.form-control:not(.disabled) .ts-control,
        .ts-wrapper.form-control:not(.disabled).single.input-active .ts-control,
        .ts-wrapper.form-select:not(.disabled) .ts-control,
        .ts-wrapper.form-select:not(.disabled).single.input-active .ts-control {
            background: transparent !important;
            border: none !important
        }

        #leadFilterModal .ts-wrapper .ts-control {
            min-height: unset !important;
        }
    </style>

    {{-- =============================================================
| THEME & CUSTOM SCRIPTS
============================================================== --}}
    <!-- TomSelect (global) - required by showroom offcanvas selects and other pages -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

    <script src="{{ asset('assets/js/theme-script.js') }}"></script>
    <script data-cfasync="false" src="{{ asset('assets/js/script.js') }}"></script>
    <script data-cfasync="false" src="{{ asset('assets/js/index.js') }}"></script>
    <script data-cfasync="false" src="{{ asset('assets/js/inventory-modal.js') }}"></script>

   

    {{-- =============================================================
| PAGE-LEVEL JS
============================================================== --}}
    @stack('scripts')

    <script>
        // Open customer profile in the global offcanvas (`#commonCanvas`)
        async function openCustomerProfile(customerId) {
            if (!customerId) return;
            try {
                // If any Bootstrap modals are currently open, hide them first to remove their backdrops
                const openModals = Array.from(document.querySelectorAll('.modal.show'));
                if (openModals.length) {
                    await Promise.all(openModals.map(modalEl => new Promise(resolve => {
                        try {
                            const inst = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                            const handler = function() { try { modalEl.removeEventListener('hidden.bs.modal', handler); } catch(e){}; resolve(); };
                            modalEl.addEventListener('hidden.bs.modal', handler);
                            try { inst.hide(); } catch (e) { resolve(); }
                        } catch (e) { resolve(); }
                    })));
                }

                const res = await fetch(`/customers/${customerId}/canvas`, { credentials: 'same-origin' });
                if (!res.ok) throw new Error('Failed to load customer profile');
                const html = await res.text();

                const canvasEl = document.getElementById('commonCanvas');
                if (!canvasEl) return;

                const body = canvasEl.querySelector('.offcanvas-body');
                if (!body) return;

                // Parse returned HTML and extract the main fragment to avoid inserting full page (prevents duplicate modals/backdrops)
                const tmp = document.createElement('div'); tmp.innerHTML = html;
                // Prefer element that carries data-customer-id (from customers.edit template)
                const fragment = tmp.querySelector('[data-customer-id]') || tmp.querySelector('.customerProfileOffcanvas') || tmp;

                // Clear existing body and insert only the fragment's inner content
                try { body.innerHTML = ''; } catch(e) { body.innerHTML = fragment.innerHTML || fragment.outerHTML || html; }
                // If fragment is an element, adopt it into the DOM to preserve structure
                if (fragment && fragment instanceof Element) {
                    const node = fragment.cloneNode(true);
                    body.appendChild(node);

                    // Move any modals or offcanvas elements from the fetched fragment into document.body
                    const modalEls = tmp.querySelectorAll('.modal, .offcanvas');
                    modalEls.forEach(el => {
                        // Skip the main commonCanvas if present
                        if (el.id === 'commonCanvas') return;
                        try {
                            const clone = el.cloneNode(true);
                            document.body.appendChild(clone);
                        } catch(e) { console.warn('Failed to move modal/offcanvas to body', e); }
                    });

                    // Execute any scripts that were in the returned HTML (inline or external)
                    const scripts = tmp.querySelectorAll('script');
                    scripts.forEach(s => {
                        try {
                            const ns = document.createElement('script');
                            if (s.type) ns.type = s.type;
                            if (s.src) {
                                ns.src = s.src;
                                ns.async = false;
                                document.body.appendChild(ns);
                            } else {
                                ns.text = s.textContent || s.innerText || '';
                                document.body.appendChild(ns);
                                setTimeout(() => { try { ns.remove(); } catch(e){} }, 1);
                            }
                        } catch(e) { console.warn('Failed to execute injected script', e); }
                    });
                } else {
                    body.innerHTML = html;
                    // Move modal/offcanvas nodes to body
                    const modalEls = tmp.querySelectorAll('.modal, .offcanvas');
                    modalEls.forEach(el => { if (el.id === 'commonCanvas') return; try { const clone = el.cloneNode(true); document.body.appendChild(clone); } catch(e){} });
                    // Execute scripts from tmp as a fallback
                    const scripts = tmp.querySelectorAll('script');
                    scripts.forEach(s => {
                        try {
                            const ns = document.createElement('script');
                            if (s.type) ns.type = s.type;
                            if (s.src) { ns.src = s.src; ns.async = false; document.body.appendChild(ns); }
                            else { ns.text = s.textContent || s.innerText || ''; document.body.appendChild(ns); setTimeout(() => { try { ns.remove(); } catch(e){} }, 1); }
                        } catch(e) { console.warn('Failed to execute injected script', e); }
                    });
                }

                // Remove any modal/offcanvas backdrops and modal-open class that may remain
                document.querySelectorAll('.modal-backdrop, .offcanvas-backdrop').forEach(b => b.remove());
                document.querySelectorAll('.modal.show').forEach(m => { try { m.classList.remove('show'); m.style.display = 'none'; } catch(e){} });
                document.body.classList.remove('modal-open');
                document.body.style.removeProperty('overflow');
                document.body.style.removeProperty('padding-right');

                // Show the offcanvas WITHOUT backdrop to avoid page blur; force it on top
                try {
                    // remove any existing backdrops just before show
                    document.querySelectorAll('.modal-backdrop, .offcanvas-backdrop').forEach(b => b.remove());
                    canvasEl.style.zIndex = 200050;
                    const inst = new bootstrap.Offcanvas(canvasEl, { backdrop: false });
                    inst.show();
                } catch(e) {
                    try { bootstrap.Offcanvas.getOrCreateInstance(canvasEl).show(); } catch(e2) { new bootstrap.Offcanvas(canvasEl).show(); }
                }

                // Re-run fragment initialization hook if provided
                if (typeof window.afterCustomerCanvasLoad === 'function') {
                    try { window.afterCustomerCanvasLoad(customerId); } catch(e){}
                }
            } catch (err) {
                console.error('openCustomerProfile error', err);
                if (typeof Swal !== 'undefined') Swal.fire('Error', 'Failed to open customer profile', 'error');
            }
        }
        try { window.openCustomerProfile = openCustomerProfile; } catch(e){}
    </script>
    <script>
        // Initialize TomSelect for showroom selects and bind save handler for shared offcanvas
        document.addEventListener('DOMContentLoaded', function() {
            function initTom(id) {
                const el = document.getElementById(id);
                if (!el) return;
                if (typeof TomSelect !== 'undefined' && !el.tomselect) {
                    try {
                        new TomSelect(el, { hideSelected: true });
                    } catch (e) { console.debug('TomSelect init failed for', id, e); }
                }
            }

            ['showroom_assigned_to','showroom_assigned_manager','showroom_lead_type','showroom_deal_type','showroom_source'].forEach(initTom);

            function setSelectValue(el, val) {
                if (!el) return;
                try {
                    if (el.tomselect) el.tomselect.setValue(val, true);
                    else el.value = val;
                } catch (e) { try { el.value = val; } catch (err) {} }
            }

            const saveBtn = document.getElementById('saveShowroomVisit');
            if (saveBtn && !saveBtn.dataset.bound) {
                saveBtn.dataset.bound = '1';
                saveBtn.addEventListener('click', async function(e) {
                    e.preventDefault();
                    if (this.disabled) return;
                    this.disabled = true;

                    const visitId = document.getElementById('showroom_visit_id')?.value || '';
                    if (!visitId) {
                        alert('No showroom visit selected');
                        this.disabled = false;
                        return;
                    }

                    const offcanvasEl = document.getElementById('editShowroomVisitCanvas');
                    const formData = new FormData();

                    // Notes and optional note behavior
                    const notes = document.getElementById('showroom_note_text')?.value || '';
                    if (notes) formData.append('notes', notes);

                    // Assigned and dropdowns
                    const assignedTo = document.getElementById('showroom_assigned_to');
                    const assignedManager = document.getElementById('showroom_assigned_manager');
                    const leadType = document.getElementById('showroom_lead_type');
                    const dealType = document.getElementById('showroom_deal_type');
                    const source = document.getElementById('showroom_source');

                    if (assignedTo) formData.append('user_id', assignedTo.value || '');
                    if (assignedManager) formData.append('assigned_manager', assignedManager.value || '');
                    if (leadType) formData.append('lead_type', leadType.value || '');
                    if (dealType) formData.append('deal_type', dealType.value || '');
                    if (source) formData.append('source', source.value || '');

                    // Flags
                    if (offcanvasEl) {
                        const inputs = offcanvasEl.querySelectorAll('[name^="flags"]');
                        inputs.forEach((el) => {
                            const name = el.getAttribute('name') || '';
                            const m = name.match(/^flags\[(.+)\]$/);
                            if (!m) return;
                            const key = m[1];
                            let val = '0';
                            if (el.type === 'radio') {
                                const grp = offcanvasEl.querySelectorAll(`[name="flags[${key}]"]`);
                                for (const r of grp) { if (r.checked) { val = r.value; break; } }
                            } else if (el.type === 'checkbox') {
                                val = el.checked ? '1' : '0';
                            }
                            formData.append(`flags[${key}]`, val);
                        });
                    }

                    // CSRF token
                    const tokenMeta = document.querySelector('meta[name="csrf-token"]');
                    const token = tokenMeta ? tokenMeta.getAttribute('content') : '';

                    try {
                        const url = `/api/visits/${encodeURIComponent(visitId)}`;
                        const res = await fetch(url, {
                            method: 'PUT',
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            },
                            body: formData,
                            credentials: 'same-origin'
                        });
                        const json = await (res.json?.() || res.text());
                        if (!res.ok) throw json;

                        // Close offcanvas
                        const off = bootstrap.Offcanvas.getInstance(offcanvasEl);
                        if (off) off.hide();

                        // Notify and refresh notes/list
                        if (typeof showAlert === 'function') showAlert('Showroom visit saved', 'success');
                        if (typeof loadNotes === 'function') loadNotes();
                        if (typeof window.scheduleRealtimeFilter === 'function') window.scheduleRealtimeFilter();
                    } catch (err) {
                        console.error('Failed to save showroom visit', err);
                        if (typeof showAlert === 'function') showAlert('Failed to save showroom visit', 'danger');
                    } finally {
                        this.disabled = false;
                    }
                });
            }
        });
    </script>

    <script>
        (function(){
            function safeCleanup() {
                // allow Bootstrap to finish its hide animation
                setTimeout(function(){
                    var anyModalShown = document.querySelector('.modal.show') !== null;
                    var anyOffcanvasShown = document.querySelector('.offcanvas.show') !== null;
                    if (!anyModalShown && !anyOffcanvasShown) {
                        document.querySelectorAll('.modal-backdrop, .offcanvas-backdrop').forEach(function(b){ try { b.remove(); } catch(e){} });
                        document.body.classList.remove('modal-open');
                        document.body.style.removeProperty('overflow');
                        document.body.style.removeProperty('padding-right');
                    }
                }, 20);
            }

            document.addEventListener('hidden.bs.modal', safeCleanup);
            document.addEventListener('hidden.bs.offcanvas', safeCleanup);
        })();
    </script>

    {{-- =============================================================
    | CLOUDFLARE (KEEP LAST)
    ============================================================== --}}
   <script data-cfasync="false"
 src="{{ asset('assets/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js') }}"
        data-cf-settings="65c7fe927c0a86c8f89afb90-|49" defer></script>

    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
        integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
        data-cf-beacon='{"token":"3ca157e612a14eccbb30cf6db6691c29"}' crossorigin="anonymous"></script>
 -->

<script>
    // Prevent a single modal's close button from accidentally closing multiple stacked modals.
    // Some pages manipulate backdrops and modal classes; ensure only the closest .modal instance is hidden.
    document.addEventListener('click', function (e) {
        try {
            const btn = e.target.closest && e.target.closest('[data-bs-dismiss="modal"]');
            if (!btn) return;

            // Find the closest modal ancestor for this button
            const modalEl = btn.closest('.modal');
            if (!modalEl) return; // if not inside a modal, let bootstrap handle it (offcanvas, etc.)

            // Prevent default bootstrap data handler to avoid any global handlers
            e.preventDefault();
            e.stopPropagation();

            // Hide only the modal that contains the clicked button
            const inst = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            try { inst.hide(); } catch (err) { /* ignore */ }
        } catch (err) { /* ignore */ }
    }, { capture: true });
</script>
</body>

</html>
