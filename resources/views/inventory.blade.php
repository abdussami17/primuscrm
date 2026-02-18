@extends('layouts.app')

@section('title','Inventory')


@section('content')

<div class="content content-two pt-0">

    <!-- Page Header -->
    <div class="position-relative d-flex align-items-center justify-content-between flex-wrap gap-3 "
      style="min-height: 80px;">

      <!-- Left: Title -->
      <div>
        <h6 class="mb-0">Inventory</h6>
      </div>

      <!-- Center: Logo -->
      <img src="assets/light_logo.png" alt="Logo" class="mobile-logo-no logo-img"
        style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); max-width: 80px; height: auto;">

      <!-- Right: Buttons -->
      <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">

        <div>
          <a href="javascript:void(0);" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal"
            data-bs-target="#emailModal">
            <i class="isax isax-eye me-1"></i>View Brochure Wizard
          </a>
        </div>
      </div>

    </div>

    <!-- End Page Header -->

    <div class="mb-3">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div class="d-flex align-items-center flex-wrap gap-2">
          <div class="table-search d-flex align-items-center mb-0">
            <div class="search-input">
              <a href="javascript:void(0);" class="btn-searchset"><i class="isax isax-search-normal fs-12"></i></a>
            </div>
          </div>
          <a class="btn btn-outline-white fw-normal d-inline-flex align-items-center" href="javascript:void(0);"
            data-bs-toggle="offcanvas" data-bs-target="#customcanvas">
            <i class="isax isax-filter me-1"></i>Filter
          </a>
        </div>
        <div class="d-flex align-items-center flex-wrap gap-2">
          <div class="dropdown">
            <a href="javascript:void(0);" 
               class="btn btn-outline-white d-inline-flex align-items-center"
               data-bs-toggle="dropdown">
               All Vehicles <i class="ti ti-chevron-down ms-2 fw-bold"></i>
            </a>
        
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a href="javascript:void(0);" class="dropdown-item">
                  <i class="ti ti-check me-1 fw-bold"></i> All Vehicles
                </a>
              </li>
              <li>
                <a href="javascript:void(0);" class="dropdown-item">New</a>
              </li>
              <li>
                <a href="javascript:void(0);" class="dropdown-item">Pre-Owned</a>
              </li>
              <li>
                <a href="javascript:void(0);" class="dropdown-item">CPO</a>
              </li>
              <li>
                <a href="javascript:void(0);" class="dropdown-item">Demo</a>
              </li>
              <li>
                <a href="javascript:void(0);" class="dropdown-item">Wholesale</a>
              </li>
              <li>
                <a href="javascript:void(0);" class="dropdown-item">Lease Renewal</a>
              </li>
              <li>
                <a href="javascript:void(0);" class="dropdown-item">Unknown</a>
              </li>
            </ul>
          </div>
        </div>
        
      </div>
      <div class="align-items-center gap-2 flex-wrap filter-info mt-3">
        <h6 class="fs-13 fw-semibold">Filters</h6>
        <span class="tag bg-light border rounded-1 fs-12 text-dark badge"><span
            class="num-count d-inline-flex align-items-center justify-content-center bg-success fs-10 me-1">5</span>Users
          Selected<span class="ms-1 tag-close"><i class="fa-solid fa-x fs-10"></i></span></span>
        <span class="tag bg-light border rounded-1 fs-12 text-dark badge"><span
            class="num-count d-inline-flex align-items-center justify-content-center bg-success fs-10 me-1">5</span>Status
          Selected<span class="ms-1 tag-close"><i class="fa-solid fa-x fs-10"></i></span></span>
        <a href="#" class="link-danger fw-medium text-decoration-underline ms-md-1">Clear All</a>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-nowrap datatable">
        <thead class="thead-light">
          <tr>
            <th class="no-sort">
              <div class="form-check form-check-md">
                <input class="form-check-input" type="checkbox" id="select-all">
              </div>
            </th>
            <th>Photos</th>
            <th>Stock #</th>
            <th>CARFAX</th>
            <th>VB</th>
            <th>Year</th>
            <th>Make</th>
            <th>Model</th>
            <th>Trim</th>
            <th>Body Style</th>
            <th>Drive Type</th>
            <th>Doors</th>
            <th>Interior / Exterior</th>
            <th>VIN</th>
            <th>Price</th>
            <th>Hold Details</th>
            <th>KM's</th>
            <th>Age</th>
            <th>Inventory Type</th>
          </tr>
        </thead>
        <tbody>
          <!-- Dynamic inventory rows will be loaded here -->
        </tbody>
      </table>
    </div>
    <div class="form-check mt-3">
      <input class="form-check-input image-count-toggle" type="checkbox" id="showCountCheckbox">
      <label class="form-check-label" for="showCountCheckbox">Show Image Count</label>
    </div>
    <p class="mt-2">
      <span class="text-danger fw-bold">Red</span> Stock numbers must be removed manually. They will not get removed
      via a DMS import.<br>Use the search box to search by make, model, stock # or VIN.<br>Click on column headings
      to sort.
    </p>


  </div>

  <div class="offcanvas offcanvas-start inventoryFilterModal" tabindex="-1" id="customcanvas">
    <div class="crm-header  p-3 d-flex justify-content-between align-items-center">

      <h6 style="font-size: 16px;" class="text-white">FILTER INVENTORY</h6>
      <button type="button" class="border-0  bg-transparent" data-bs-dismiss="offcanvas" aria-label="Close">
        <i style="font-size: 18px;" class="isax isax-close-circle text-white"></i>
      </button>

    </div>

    <div class="offcanvas-body pt-3">
      <form>
        <div class="row">
          <!-- Year Min -->
          <div class="col-md-6 mb-3">
            <label class="form-label">Year (Min)</label>
            <select id="yearMin" class="form-control">
              <option value="">Select...</option>
              <option>2025</option>
              <option>2024</option>
              <option>2023</option>
              <option>2022</option>
            </select>
          </div>

          <!-- Year Max -->
          <div class="col-md-6 mb-3">
            <label class="form-label">Year (Max)</label>
            <select id="yearMax" class="form-control">
              <option value="">Select...</option>
              <option>2025</option>
              <option>2024</option>
              <option>2023</option>
              <option>2022</option>
            </select>
          </div>

          <!-- Make -->
          <div class="col-md-12 mb-3">
            <label class="form-label">Make</label>
            <select id="makeSelect" class="form-control">
              <option value="">Select...</option>
              <option>Ford</option>
              <option>Hyundai</option>
              <option>Mission Trailers</option>
              <option>Trailtech</option>
            </select>
          </div>

          <!-- Model -->
          <div class="col-md-12 mb-3">
            <label class="form-label">Model</label>
            <select id="modelSelect" class="form-control">
              <option value="">Select...</option>
              <option>F-150</option>
              <option>Elantra</option>
              <option>Santa Fe</option>
              <option>TrailerX</option>
            </select>
          </div>

          <!-- Trim -->
          <div class="col-md-12 mb-3">
            <label class="form-label">Trim</label>
            <select id="trimSelect" class="form-control">
              <option value="">Select...</option>
              <option>Base</option>
              <option>SE</option>
              <option>SEL</option>
              <option>Limited</option>
            </select>
          </div>

          <!-- Color (Int) -->
          <div class="col-md-6 mb-3">
            <label class="form-label">Color (Int)</label>
            <select id="colorInt" class="form-control">
              <option value="">Select...</option>
              <option>Black</option>
              <option>Gray</option>
              <option>Beige</option>
            </select>
          </div>

          <!-- Color (Ext) -->
          <div class="col-md-6 mb-3">
            <label class="form-label">Color (Ext)</label>
            <select id="colorExt" class="form-control">
              <option value="">Select...</option>
              <option>White</option>
              <option>Blue</option>
              <option>Red</option>
              <option>Silver</option>
            </select>
          </div>



          <!-- Mileage Min -->
          <div class="col-md-6 mb-3">
            <label class="form-label">Mileage (Min)</label>
            <select id="mileageMin" class="form-control">
              <option value="">Select...</option>
              <option>0</option>
              <option>10000</option>
              <option>20000</option>
            </select>
          </div>

          <!-- Mileage Max -->
          <div class="col-md-6 mb-3">
            <label class="form-label">Mileage (Max)</label>
            <select id="mileageMax" class="form-control">
              <option value="">Select...</option>
              <option>30000</option>
              <option>40000</option>
              <option>50000</option>
            </select>
          </div>
        </div>

        <!-- Footer -->
        <div class="offcanvas-footer mt-5">
          <div class="row g-2">
            <div class="col-6">
              <a href="#" class="btn btn-outline-secondary w-100" id="reset-filters">Reset</a>
            </div>
            <div class="col-6">
              <button type="submit" data-bs-dismiss="offcanvas" class="btn btn-primary w-100">Submit</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
{{-- Filter Invntory Logic --}}

<script>
    // Init TomSelect for all selects
    document.querySelectorAll("select").forEach(select => {
      new TomSelect(select, {
        create: false,
        searchField: [],
        controlInput: null,
        sortField: { field: "text", direction: "asc" }
      });
    });

    // Reset filters
    document.getElementById("reset-filters").addEventListener("click", function (e) {
      e.preventDefault();
      document.querySelectorAll("select").forEach(select => {
        if (select.tomselect) select.tomselect.clear();
      });
    });
  </script>



    <!-- Start Modal  -->
    <div id="emailModal" class="modal fade">
        <div class="modal-dialog modal-fullscreen">
          <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
              <h1 class="modal-title " id="addTemplateModal">Brochure Wizard - View Brochure</h1>
            <div>
              <button type="button"  id="minimizeModalBtn" class="btn btn-sm btn-light border-0">
                <i class="ti ti-minimize" data-bs-toggle="tooltip" data-bs-title="Minimze"></i>
              </button>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
              
            </div>
  
            <div class="modal-body pt-1">
              <!-- SECTION 1: EMAIL FORM -->
              
                <p class="text-black mt-2">Selected Auto: <span class="fw-bold">2023 Mission Trailers MODP 7X14</span></p>
                <div class="row g-2">
                  <div class="mb-3 col-md-4">
                    <label class="form-label">Email From:</label>
                    <input type="email" class="form-control" value="aaron.powell@dawsoncreekford.ca">
                    <div class="form-check mt-1">
                      <input type="checkbox" class="form-check-input" id="bccToMe">
                      <label class="form-check-label" for="bccToMe">Send blind carbon copy to me also</label>
                    </div>
                  </div>
               
  
                    
                      <div class="mb-3 col-md-4 email-suggest-wrapper">
                        <label class="form-label">Email To:</label>
                        <input type="email" class="form-control email-input" placeholder="Type name or email">
                        <div class="suggestion-box"></div>
                      </div>
                    
                      <div class="mb-3 col-md-4 email-suggest-wrapper">
                        <label class="form-label">Email CC:</label>
                        <input type="email" class="form-control email-input" placeholder="Type name or email">
                        <div class="suggestion-box"></div>
                      </div>
                    
                      <div class="mb-3 col-md-4 email-suggest-wrapper">
                        <label class="form-label">Email BCC:</label>
                        <input type="email" class="form-control email-input" placeholder="Type name or email">
                        <div class="suggestion-box"></div>
                      </div>
                    
                  
                    
                    
               
                    
                  <div class="mb-3 col-md-8"><label class="form-label">Subject:</label><input type="text"
                      class="form-control" value="Vehicle Brochure"></div>
  
                      <div class="col-md-12 mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                          <label class="form-label">Body</label>
                          <div class="d-flex gap-2 flex-wrap button-group">
                            <button type="button" class="btn-primary btn" id="btnAIAssistant">
                              <i class="bi bi-stars"></i>
                              <span>AI Assistant</span>
                            </button>
  
                          </div>
                        </div>
  
                        <div class="app container-fluid py-2">
  
  
                          <div class="row g-4">
                            <div class="col-12 col-lg-8">
  
  
                              <div class="card p-0 mb-4">
                                <div class="outlook-toolbar">
                                  <!-- Font Family -->
                                  <select class="toolbar-select" id="fontFamily" title="Font family">
                                    <option value="Arial">Arial</option>
                                    <option value="Times New Roman">Times New Roman</option>
                                    <option value="Helvetica">Helvetica</option>
                                    <option value="Georgia">Georgia</option>
                                    <option value="Verdana">Verdana</option>
                                    <option value="Courier New">Courier New</option>
                                  </select>
  
                                  <!-- Font Size -->
                                  <select class="toolbar-select" id="fontSize" title="Font size">
                                    <option value="8px">8</option>
                                    <option value="10px">10</option>
                                    <option value="12px">12</option>
                                    <option value="14px" selected>14</option>
                                    <option value="16px">16</option>
                                    <option value="18px">18</option>
                                    <option value="24px">24</option>
                                    <option value="32px">32</option>
                                  </select>
  
                                  <div class="toolbar-separator"></div>
  
                                  <!-- Basic Formatting -->
                                  <button type="button" class="toolbar-btn" data-cmd="bold" title="Bold (Ctrl+B)">
                                    <i class="bi bi-type-bold"></i>
                                  </button>
                                  <button type="button" class="toolbar-btn" data-cmd="italic" title="Italic (Ctrl+I)">
                                    <i class="bi bi-type-italic"></i>
                                  </button>
                                  <button type="button" class="toolbar-btn" data-cmd="underline"
                                    title="Underline (Ctrl+U)">
                                    <i class="bi bi-type-underline"></i>
                                  </button>
                                  <button type="button" class="toolbar-btn" data-cmd="strikeThrough"
                                    title="Strikethrough">
                                    <i class="bi bi-type-strikethrough"></i>
                                  </button>
  
                                  <div class="toolbar-separator"></div>
  
                                  <!-- Text Color -->
                                  <div class="color-picker-wrapper">
                                    <button type="button" class="color-picker-btn" id="textColorBtn" title="Text color">
                                      <i class="bi bi-fonts" style="font-size: 18px;"></i>
                                      <div class="color-underline" id="textColorIndicator" style="background: #000000;">
                                      </div>
                                    </button>
                                    <div class="color-dropdown" id="textColorDropdown"></div>
                                  </div>
  
                                  <!-- Highlight Color -->
                                  <div class="color-picker-wrapper">
                                    <button type="button" class="color-picker-btn" id="highlightColorBtn"
                                      title="Highlight color">
                                      <i class="bi bi-highlighter"></i>
                                      <div class="color-underline" id="highlightColorIndicator"
                                        style="background: #ffff00;"></div>
                                    </button>
                                    <div class="color-dropdown" id="highlightColorDropdown"></div>
                                  </div>
  
                                  <div class="toolbar-separator"></div>
  
                                  <!-- Alignment -->
                                  <button type="button" class="toolbar-btn" data-cmd="justifyLeft" title="Align left">
                                    <i class="bi bi-text-left"></i>
                                  </button>
                                  <button type="button" class="toolbar-btn" data-cmd="justifyCenter"
                                    title="Align center">
                                    <i class="bi bi-text-center"></i>
                                  </button>
                                  <button type="button" class="toolbar-btn" data-cmd="justifyRight" title="Align right">
                                    <i class="bi bi-text-right"></i>
                                  </button>
                                  <button type="button" class="toolbar-btn" data-cmd="justifyFull" title="Justify">
                                    <i class="bi bi-justify"></i>
                                  </button>
  
                                  <div class="toolbar-separator"></div>
  
                                  <!-- Lists and Indentation -->
                                  <button type="button" class="toolbar-btn" data-cmd="insertUnorderedList"
                                    title="Bullet list">
                                    <i class="bi bi-list-ul"></i>
                                  </button>
                                  <button type="button" class="toolbar-btn" data-cmd="insertOrderedList"
                                    title="Numbered list">
                                    <i class="bi bi-list-ol"></i>
                                  </button>
                                  <button type="button" class="toolbar-btn" data-cmd="indent" title="Increase indent">
                                    <i class="bi bi-indent"></i>
                                  </button>
                                  <button type="button" class="toolbar-btn" data-cmd="outdent" title="Decrease indent">
                                    <i class="bi bi-unindent"></i>
                                  </button>
  
                                  <div class="toolbar-separator"></div>
  
                                  <!-- Insert Options -->
                                  <div class="color-picker-wrapper">
                                    <button type="button" class="toolbar-btn" id="btnTable" title="Insert table">
                                      <i class="bi bi-table"></i>
                                    </button>
                                    <div class="table-grid-popup" id="tableGridPopup">
                                      <div class="table-grid" id="tableGrid"></div>
                                      <div class="table-size-label" id="tableSizeLabel">1 x 1 Table</div>
                                    </div>
                                  </div>
  
                                  <button type="button" class="toolbar-btn" id="btnImage" title="Insert image">
                                    <i class="bi bi-image"></i>
                                  </button>
  
                                  <button type="button" class="toolbar-btn" id="btnLink" title="Insert link">
                                    <i class="bi bi-link-45deg"></i>
                                  </button>
  
                                  <button type="button" class="toolbar-btn" id="btnAttach" title="Attach file">
                                    <i class="bi bi-paperclip"></i>
                                  </button>
  
                                  <button type="button" class="toolbar-btn" id="btnClearFormat"
                                    title="Clear formatting">
                                    <i class="bi bi-eraser"></i>
                                  </button>
  
                                  <div class="toolbar-separator"></div>
  
                                  <!-- Smart Text -->
                                  <button type="button" class="toolbar-btn" id="btnSmartText"
                                    title="Smart Text - Enhance with AI">
                                    <i class="bi bi-magic"></i>
                                  </button>
  
                                  <div class="toolbar-separator"></div>
  
                                  <!-- HTML Edit Mode -->
                                  <button type="button" class="toolbar-btn" id="btnHtmlMode"
                                    title="Edit HTML / Switch to HTML mode">
                                    <i class="bi bi-code-slash"></i>
                                  </button>
  
                                  <!-- Voice Input -->
                                  <button type="button" class="voice-btn" id="btnVoice" title="Voice to text">
                                    <i class="bi bi-mic-fill"></i>
                                  </button>
                                </div>
  
                                <!-- HTML Textarea (Hidden by default) -->
                                <textarea class="html-textarea" id="htmlTextarea"
                                  style="display:none; width:100%; height:400px; padding:12px; font-family:monospace; font-size:12px; border:2px solid #002140; background:#f8f9fa;"></textarea>
  
                                <div class="editor-wrapper">
                                  <div class="editor-container">
                                    <div class="editor" id="editor" contenteditable="true">
                                      <p>Hi <span class="token">@{{first_name}}</span>,</p>
                                      <p>Welcome to <span class="token">@{{dealer_name}}</span>! We're excited to help
                                        you find your perfect
                                        vehicle.</p>
                                      <p>If you have any questions, please don't hesitate to contact me.</p>
                                      <p>Best regards,<br><br>
                                        <span class="token">@{{advisor_name}}</span><br>
                                        <span class="token">@{{dealer_name}}</span><br>
                                        Phone: <span class="token">@{{dealer_phone}}</span>
                                      </p>
                                    </div>
                                  </div>
                                </div>
                              </div>
  
                              <div class="preview-container">
                                <div class="preview-header d-flex justify-content-between flex-wrap">
                                  <h6 class="mb-0 text-white">Live Preview</h6>
                                  <div class="device-toggle">
                                    <button type="button" id="mobileBtn" class="active "><i
                                        class="bi bi-phone"></i></button>
                                    <button type="button" id="desktopBtn"><i class="bi bi-display"></i></button>
                                  </div>
                                </div>
                                <div class="preview-content" id="preview">
                                  <div class="template-preview">
                                    <h3>Sample Template</h3>
                                    <p>This is a sample template preview. When you click the mobile button, you'll see
                                      how this template looks
                                      on a mobile device.</p>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor
                                      incididunt ut labore et
                                      dolore magna aliqua.</p>
                                    <button class="btn">Call to Action</button>
                                  </div>
                                </div>
                              </div>
  
                              <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                  const mobileBtn = document.getElementById('mobileBtn');
                                  const desktopBtn = document.getElementById('desktopBtn');
                                  const preview = document.getElementById('preview');
  
                                  // Set default to desktop
                                  desktopBtn.classList.add('active');
                                  preview.classList.remove('mobile');
  
                                  mobileBtn.addEventListener('click', function () {
                                    mobileBtn.classList.add('active');
                                    desktopBtn.classList.remove('active');
                                    preview.classList.add('mobile');
                                  });
  
                                  desktopBtn.addEventListener('click', function () {
                                    desktopBtn.classList.add('active');
                                    mobileBtn.classList.remove('active');
                                    preview.classList.remove('mobile');
                                  });
                                });
                              </script>
  
                              <script>
                                // HTML Mode Toggle Functionality
                                document.addEventListener('DOMContentLoaded', function () {
                                  const btnHtmlMode = document.getElementById('btnHtmlMode');
                                  const editor = document.getElementById('editor');
                                  const htmlTextarea = document.getElementById('htmlTextarea');
                                  const editorWrapper = document.querySelector('.editor-wrapper');
                                  const previewContainer = document.querySelector('.preview-container');
                                  let isHtmlMode = false;
  
                                  btnHtmlMode.addEventListener('click', function (e) {
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
                                document.addEventListener('DOMContentLoaded', function () {
                                  const btnSigHtmlMode = document.getElementById('btnSigHtmlMode');
                                  const signatureEditor = document.getElementById('signatureEditor');
                                  const sigHtmlTextarea = document.getElementById('sigHtmlTextarea');
                                  const signaturePreview = document.getElementById('signaturePreview');
                                  const sigEditorWrapper = document.querySelector('.signature-editor-wrapper');
                                  let isSigHtmlMode = false;
  
                                  btnSigHtmlMode.addEventListener('click', function (e) {
                                    e.preventDefault();
                                    isSigHtmlMode = !isSigHtmlMode;
  
                                    if (isSigHtmlMode) {
                                      // Switch to HTML mode
                                      const currentHTML = signatureEditor.innerHTML;
                                      sigHtmlTextarea.value = currentHTML;
  
                                      // Hide editor and preview, show textarea
                                      sigEditorWrapper.style.display = 'none';
                                      signaturePreview.parentElement.style.display = 'none';
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
                                      signaturePreview.parentElement.style.display = 'block';
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
  
                                  // Formatting buttons for signature
                                  document.getElementById('sigBold').addEventListener('click', function (e) {
                                    e.preventDefault();
                                    document.execCommand('bold', false, null);
                                    signatureEditor.focus();
                                  });
  
                                  document.getElementById('sigItalic').addEventListener('click', function (e) {
                                    e.preventDefault();
                                    document.execCommand('italic', false, null);
                                    signatureEditor.focus();
                                  });
  
                                  document.getElementById('sigUnderline').addEventListener('click', function (e) {
                                    e.preventDefault();
                                    document.execCommand('underline', false, null);
                                    signatureEditor.focus();
                                  });
  
                                  document.getElementById('sigFontFamily').addEventListener('change', function () {
                                    document.execCommand('fontName', false, this.value);
                                    signatureEditor.focus();
                                  });
  
                                  document.getElementById('sigFontSize').addEventListener('change', function () {
                                    document.execCommand('fontSize', false, this.value);
                                    signatureEditor.focus();
                                  });
                                });
                              </script>
                            </div>
  
                            <div class="col-12 col-lg-4">
                              <div class="merge-fields-container">
                                <div class="merge-fields-header">
                                  Customer Fields
                                </div>
  
                                <div class="category-container">
                                  <div class="category-header" data-category="customer">
                                    <span><i class="bi bi-person me-2"></i>Customer Information</span>
                                    <i class="bi bi-chevron-down"></i>
                                  </div>
                                  <div class="category-body " id="customerFields">
                                    <div class="field-item" data-token="first_name">
                                      <span class="field-label">First Name</span>
                                      <span class="field-tag">@{{first_name}}</span>
                                    </div>
                                    <div class="field-item" data-token="last_name">
                                      <span class="field-label">Last Name</span>
                                      <span class="field-tag">@{{last_name}}</span>
                                    </div>
                                    <div class="field-item" data-token="email">
                                      <span class="field-label">Email</span>
                                      <span class="field-tag">@{{email}}</span>
                                    </div>
                                    <div class="field-item" data-token="alt_email">
                                      <span class="field-label">Alternative Email</span>
                                      <span class="field-tag">@{{alt_email}}</span>
                                    </div>
                                    <div class="field-item" data-token="cell_phone">
                                      <span class="field-label">Cell Phone</span>
                                      <span class="field-tag">@{{cell_phone}}</span>
                                    </div>
                                    <div class="field-item" data-token="work_phone">
                                      <span class="field-label">Work Phone</span>
                                      <span class="field-tag">@{{work_phone}}</span>
                                    </div>
                                    <div class="field-item" data-token="home_phone">
                                      <span class="field-label">Home Phone</span>
                                      <span class="field-tag">@{{home_phone}}</span>
                                    </div>
                                    <div class="field-item" data-token="street_address">
                                      <span class="field-label">Street Address</span>
                                      <span class="field-tag">@{{street_address}}</span>
                                    </div>
                                    <div class="field-item" data-token="city">
                                      <span class="field-label">City</span>
                                      <span class="field-tag">@{{city}}</span>
                                    </div>
                                    <div class="field-item" data-token="province">
                                      <span class="field-label">Province</span>
                                      <span class="field-tag">@{{province}}</span>
                                    </div>
                                    <div class="field-item" data-token="postal_code">
                                      <span class="field-label">Postal Code</span>
                                      <span class="field-tag">@{{postal_code}}</span>
                                    </div>
                                    <div class="field-item" data-token="country">
                                      <span class="field-label">Country</span>
                                      <span class="field-tag">@{{country}}</span>
                                    </div>
                                  </div>
                                </div>
                                <div class="category-container">
                                  <div class="category-header" data-category="vehicle">
                                    <span><i class="bi bi-car-front me-2"></i>Vehicle Information</span>
                                    <i class="bi bi-chevron-down"></i>
                                  </div>
                                  <div class="category-body" id="vehicleFields">
                                    <div class="field-item" data-token="year">
                                      <span class="field-label">Year</span>
                                      <span class="field-tag">@{{year}}</span>
                                    </div>
                                    <div class="field-item" data-token="make">
                                      <span class="field-label">Make</span>
                                      <span class="field-tag">@{{make}}</span>
                                    </div>
                                    <div class="field-item" data-token="model">
                                      <span class="field-label">Model</span>
                                      <span class="field-tag">@{{model}}</span>
                                    </div>
                                    <div class="field-item" data-token="vin">
                                      <span class="field-label">VIN</span>
                                      <span class="field-tag">@{{vin}}</span>
                                    </div>
                                    <div class="field-item" data-token="stock_number">
                                      <span class="field-label">Stock Number</span>
                                      <span class="field-tag">@{{stock_number}}</span>
                                    </div>
                                    <div class="field-item" data-token="selling_price">
                                      <span class="field-label">Selling Price</span>
                                      <span class="field-tag">@{{selling_price}}</span>
                                    </div>
                                    <div class="field-item" data-token="internet_price">
                                      <span class="field-label">Internet Price</span>
                                      <span class="field-tag">@{{internet_price}}</span>
                                    </div>
                                    <div class="field-item" data-token="kms">
                                      <span class="field-label">KMs</span>
                                      <span class="field-tag">@{{kms}}</span>
                                    </div>
                                  </div>
                                </div>
  
                                <div class="category-container">
                                  <div class="category-header" data-category="dealership">
                                    <span><i class="bi bi-building me-2"></i>Dealership</span>
                                    <i class="bi bi-chevron-down"></i>
                                  </div>
                                  <div class="category-body" id="dealershipFields">
                                    <div class="field-item" data-token="dealer_name">
                                      <span class="field-label">Dealership Name</span>
                                      <span class="field-tag">@{{dealer_name}}</span>
                                    </div>
                                    <div class="field-item" data-token="dealer_phone">
                                      <span class="field-label">Dealership Phone</span>
                                      <span class="field-tag">@{{dealer_phone}}</span>
                                    </div>
                                    <div class="field-item" data-token="dealer_address">
                                      <span class="field-label">Dealership Address</span>
                                      <span class="field-tag">@{{dealer_address}}</span>
                                    </div>
                                    <div class="field-item" data-token="dealer_email">
                                      <span class="field-label">Dealership Email</span>
                                      <span class="field-tag">@{{dealer_email}}</span>
                                    </div>
                                    <div class="field-item" data-token="dealer_website">
                                      <span class="field-label">Dealership Website</span>
                                      <span class="field-tag">@{{dealer_website}}</span>
                                    </div>
                                  </div>
                                </div>
                                <div class="category-container">
                                  <div class="category-header" data-category="tradein">
                                    <span><i class="bi bi-arrow-left-right me-2"></i>Trade-In Information</span>
                                    <i class="bi bi-chevron-down"></i>
                                  </div>
                                  <div class="category-body" id="tradeinFields">
                                    <div class="field-item" data-token="tradein_year">
                                      <span class="field-label">Trade-In Year</span>
                                      <span class="field-tag">@{{tradein_year}}</span>
                                    </div>
                                    <div class="field-item" data-token="tradein_make">
                                      <span class="field-label">Trade-In Make</span>
                                      <span class="field-tag">@{{tradein_make}}</span>
                                    </div>
                                    <div class="field-item" data-token="tradein_model">
                                      <span class="field-label">Trade-In Model</span>
                                      <span class="field-tag">@{{tradein_model}}</span>
                                    </div>
                                    <div class="field-item" data-token="tradein_vin">
                                      <span class="field-label">Trade-In VIN</span>
                                      <span class="field-tag">@{{tradein_vin}}</span>
                                    </div>
                                    <div class="field-item" data-token="tradein_kms">
                                      <span class="field-label">Trade-In KMs</span>
                                      <span class="field-tag">@{{tradein_kms}}</span>
                                    </div>
                                    <div class="field-item" data-token="tradein_price">
                                      <span class="field-label">Trade-In Selling Price</span>
                                      <span class="field-tag">@{{tradein_price}}</span>
                                    </div>
                                  </div>
                                </div>
                                <div class="category-container">
                                  <div class="category-header" data-category="deal">
                                    <span><i class="bi bi-file-earmark-text me-2"></i>Deal Information</span>
                                    <i class="bi bi-chevron-down"></i>
                                  </div>
                                  <div class="category-body" id="dealFields">
                                    <div class="field-item" data-token="finance_manager">
                                      <span class="field-label">Finance Manager</span>
                                      <span class="field-tag">@{{finance_manager}}</span>
                                    </div>
                                    <div class="field-item" data-token="assigned_to">
                                      <span class="field-label">Assigned To</span>
                                      <span class="field-tag">@{{assigned_to}}</span>
                                    </div>
                                    <div class="field-item" data-token="assigned_manager">
                                      <span class="field-label">Assigned Manager</span>
                                      <span class="field-tag">@{{assigned_manager}}</span>
                                    </div>
                                    <div class="field-item" data-token="secondary_assigned">
                                      <span class="field-label">Secondary Assigned</span>
                                      <span class="field-tag">@{{secondary_assigned}}</span>
                                    </div>
                                    <div class="field-item" data-token="bdc_agent">
                                      <span class="field-label">BDC Agent</span>
                                      <span class="field-tag">@{{bdc_agent}}</span>
                                    </div>
                                    <div class="field-item" data-token="bdc_manager">
                                      <span class="field-label">BDC Manager</span>
                                      <span class="field-tag">@{{bdc_manager}}</span>
                                    </div>
                                    <div class="field-item" data-token="general_manager">
                                      <span class="field-label">General Manager</span>
                                      <span class="field-tag">@{{general_manager}}</span>
                                    </div>
                                    <div class="field-item" data-token="sales_manager">
                                      <span class="field-label">Sales Manager</span>
                                      <span class="field-tag">@{{sales_manager}}</span>
                                    </div>
                                    <div class="field-item" data-token="advisor_name">
                                      <span class="field-label">Advisor Name</span>
                                      <span class="field-tag">@{{advisor_name}}</span>
                                    </div>
                                    <div class="field-item" data-token="service_advisor">
                                      <span class="field-label">Service Advisor</span>
                                      <span class="field-tag">@{{service_advisor}}</span>
                                    </div>
                                    <div class="field-item" data-token="source">
                                      <span class="field-label">Source</span>
                                      <span class="field-tag">@{{source}}</span>
                                    </div>
                                    <div class="field-item" data-token="appointment_datetime">
                                      <span class="field-label">Appointment Date/Time</span>
                                      <span class="field-tag">@{{appointment_datetime}}</span>
                                    </div>
                                    <div class="field-item" data-token="inventory_manager">
                                      <span class="field-label">Inventory Manager</span>
                                      <span class="field-tag">@{{inventory_manager}}</span>
                                    </div>
                                    <div class="field-item" data-token="warranty_expiration">
                                      <span class="field-label">Warranty Expiration Date</span>
                                      <span class="field-tag">@{{warranty_expiration}}</span>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
  
  
  
                        <div class="ai-modal" id="aiModal">
                          <div class="ai-modal-content">
                            <div class="ai-modal-header">
                              <div>
                                <h5 class="mb-1 d-flex align-items-center gap-2 text-white">
                                  <i class="bi bi-stars"></i>
                                  AI Assistant
                                </h5>
                                <small class="opacity-75">Create professional content in seconds</small>
                              </div>
                              <button class="btn-close btn-close-white" id="closeAIModal"></button>
                            </div>
  
                            <div class="ai-modal-body">
                              <div id="aiOptions">
                                <div class="ai-option-card" data-action="generate-email">
                                  <div class="ai-option-icon">
                                    <i class="bi bi-envelope-fill"></i>
                                  </div>
                                  <h6 class="mb-1">Generate Complete Email</h6>
                                  <p class="text-muted small mb-0">Describe what you need and AI will create a full
                                    email template</p>
                                </div>
  
                                <!-- <div class="ai-option-card" data-action="use-template">
                                  <div class="ai-option-icon">
                                    <i class="bi bi-layout-text-window-reverse"></i>
                                  </div>
                                  <h6 class="mb-1">Use Pre-built Template</h6>
                                  <p class="text-muted small mb-0">Choose from professionally designed templates</p>
                                </div> -->
  
                                <div class="ai-option-card" data-action="generate-subject">
                                  <div class="ai-option-icon">
                                    <i class="bi bi-cursor-text"></i>
                                  </div>
                                  <h6 class="mb-1">Generate Subject Line</h6>
                                  <p class="text-muted small mb-0">Create compelling subject lines</p>
                                </div>
  
                                <div class="ai-option-card" data-action="generate-image">
                                  <div class="ai-option-icon">
                                    <i class="bi bi-image-fill"></i>
                                  </div>
                                  <h6 class="mb-1">Generate Image</h6>
                                  <p class="text-muted small mb-0">Describe an image and AI will create it</p>
                                </div>
                              </div>
  
                              <div class="ai-input-section" id="aiInputSection">
                                <button class="btn btn-sm btn-outline-secondary mb-3" id="btnBackToOptions">
                                  <i class="bi bi-arrow-left me-1"></i> Back
                                </button>
  
                                <div id="aiInputContent"></div>
                              </div>
  
                              <div class="ai-generating" id="aiGenerating">
                                <div class="ai-spinner"></div>
                                <h6>AI is working its magic...</h6>
                                <p class="text-muted small">Creating your content with professional formatting</p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="image-controls" id="imageControls">
                          <div class="image-control-section">
                            <span class="image-control-label">Alignment</span>
                            <div class="image-align-btns">
                              <button class="image-align-btn btn btn-light border-1 border" data-align="left"><i
                                  class="bi bi-align-start"></i></button>
                              <button class="image-align-btn btn btn-light border-1 border" data-align="center"><i
                                  class="bi bi-align-center"></i></button>
                              <button class="image-align-btn btn btn-light border-1 border" data-align="right"><i
                                  class="bi bi-align-end"></i></button>
                            </div>
                          </div>
                          <div class="image-control-section">
                            <span class="image-control-label form-label">Size</span>
                            <div class="image-size-inputs">
                              <div class="image-size-group mb-2">
                                <span class="image-size-label form-label">Width (px)</span>
                                <input type="number" class="image-size-input form-control" id="imageWidth" min="50"
                                  step="10">
                              </div>
                              <div class="image-size-group mb-2">
                                <span class="image-size-label form-label">Height (px)</span>
                                <input type="number" class="image-size-input form-control" id="imageHeight" min="50"
                                  step="10">
                              </div>
                            </div>
                            <label class="image-lock-aspect mb-2">
                              <input type="checkbox" id="lockAspectRatio" checked>
                              <span class="form-label">Lock aspect ratio</span>
                            </label>
                          </div>
                          <div class="image-control-actions mb-2">
                            <button class="image-control-btn btn btn-light border border-1" id="resetImageSize"><i
                                class="bi bi-arrow-counterclockwise me-1"></i>Reset</button>
                            <button class="image-control-btn danger btn btn-danger" id="deleteImage"><i
                                class="bi bi-trash me-1"></i>Delete</button>
                          </div>
                        </div>
                      
                        <script>
                          const SAMPLE_DATA = {
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
  
                            // Deal Information
                            finance_manager: 'Robert Wilson',
                            bdc_agent: 'Emily Davis',
                            bdc_manager: 'David Brown',
                            general_manager: 'Jennifer Martinez',
                            sales_manager: 'Kevin Anderson',
                            service_advisor: 'Lisa Thompson',
                            advisor_name: 'Ben Dover',
                            source: 'Website Inquiry',
                            appointment_datetime: 'Oct 14, 2025 10:00AM',
                            inventory_manager: 'Mark Robinson',
                            warranty_expiration: 'Oct 14, 2025'
                          };
  
                          const OUTLOOK_COLORS = ['#000000', '#444444', '#666666', '#999999', '#CCCCCC', '#EEEEEE', '#F3F3F3', '#FFFFFF',
                            '#FF0000', '#FF9900', '#FFFF00', '#00FF00', '#00FFFF', '#4A86E8', '#0000FF', '#9900FF', '#FF00FF', '#C00000',
                            '#E26B0A', '#F1C232', '#6AA84F', '#45818E', '#3C78D8', '#3D85C6', '#674EA7', '#A64D79', '#85200C', '#990000',
                            '#B45F06', '#BF9000', '#38761D', '#134F5C', '#1155CC', '#0B5394', '#351C75', '#741B47'];
  
                          const EMAIL_TEMPLATES = {
                            welcome: {
                              name: 'Welcome Email', subject: 'Welcome to @{{dealer_name}}, @{{first_name}}!',
                              body: '<h2 style="color: #002140;">Welcome to @{{dealer_name}}!</h2><p>Dear <span class="token">@{{first_name}}</span>,</p><p>Thank you for choosing us!</p><div style="text-align: center; margin: 20px 0;"><a href="#" class="cta-button">View Our Inventory</a></div><p><strong>Best regards,</strong><br><span class="token">@{{advisor_name}}</span></p>'
                            },
                            promotional: {
                              name: 'Promotional Offer', subject: 'Exclusive Offer for You!',
                              body: '<div style="background: linear-gradient(135deg, #002140 0%, #001a33 100%); color: white; padding: 30px; text-align: center; border-radius: 8px; margin-bottom: 20px;"><h1 style="color: white; margin: 0;">Special Offer!</h1></div><p>Dear <span class="token">@{{first_name}}</span>,</p><div style="text-align: center; margin: 30px 0;"><a href="#" class="cta-button">Claim Your Offer</a></div>'
                            }
                          };
  
                          class TemplateBuilder {
                            constructor() {
                              this.currentTextColor = '#000000';
                              this.currentHighlightColor = '#ffff00';
                              this.selectedTableSize = { rows: 1, cols: 1 };
                              this.recognition = null;
                              this.currentAIAction = null;
                              this.selectedImage = null;
                              this.originalImageDimensions = { width: 0, height: 0 };
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
                              document.querySelector('[data-cmd="strikeThrough"]').classList.remove('active');
                            }
  
                            setupImageControls() {
                              // Alignment buttons
                              document.querySelectorAll('.image-align-btn').forEach(btn => {
                                btn.addEventListener('click', () => {
                                  if (!this.selectedImage) return;
                                  const align = btn.dataset.align;
                                  document.querySelectorAll('.image-align-btn').forEach(b => b.classList.remove('active'));
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
  
                              widthInput.addEventListener('input', () => {
                                if (!this.selectedImage) return;
                                const width = parseInt(widthInput.value);
                                if (width && width > 0) {
                                  this.selectedImage.style.width = width + 'px';
                                  if (lockAspect.checked && this.originalImageDimensions.width > 0) {
                                    const ratio = this.originalImageDimensions.height / this.originalImageDimensions.width;
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
                                    const ratio = this.originalImageDimensions.width / this.originalImageDimensions.height;
                                    const width = Math.round(height * ratio);
                                    this.selectedImage.style.width = width + 'px';
                                    widthInput.value = width;
                                  }
                                  this.renderPreview();
                                }
                              });
  
                              // Reset button
                              document.getElementById('resetImageSize').addEventListener('click', () => {
                                if (!this.selectedImage) return;
                                const origWidth = parseInt(this.selectedImage.dataset.originalWidth) || this.originalImageDimensions.width;
                                const origHeight = parseInt(this.selectedImage.dataset.originalHeight) || this.originalImageDimensions.height;
                                let width = origWidth;
                                let height = origHeight;
                                if (width > 600) {
                                  height = (height * 600) / width;
                                  width = 600;
                                }
                                this.selectedImage.style.width = width + 'px';
                                this.selectedImage.style.height = height + 'px';
                                widthInput.value = Math.round(width);
                                heightInput.value = Math.round(height);
                                this.renderPreview();
                              });
  
                              // Delete button
                              document.getElementById('deleteImage').addEventListener('click', () => {
                                if (this.selectedImage && confirm('Delete this image?')) {
                                  this.selectedImage.remove();
                                  this.deselectImage();
                                  this.renderPreview();
                                }
                              });
  
                              // Close controls when clicking outside
                              document.addEventListener('click', (e) => {
                                if (!e.target.closest('.image-controls') && !e.target.closest('img') && e.target.id !== 'btnImage') {
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
                                  if (['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'].includes(cmd)) {
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
                                  else if (['insertUnorderedList', 'insertOrderedList', 'strikeThrough'].includes(cmd)) {
                                    // Execute the command directly for lists and strikethrough
                                    document.execCommand(cmd, false, null);
  
                                    // For strikethrough, update the button state
                                    if (cmd === 'strikeThrough') {
                                      const isActive = document.queryCommandState('strikeThrough');
                                      btn.classList.toggle('active', isActive);
                                      this.currentFormatting.strikeThrough = isActive;
                                    }
                                  }
                                  else {
                                    // For bold, italic, underline - use our tracked state
                                    if (cmd === 'bold') {
                                      this.currentFormatting.bold = !this.currentFormatting.bold;
                                      btn.classList.toggle('active', this.currentFormatting.bold);
                                      document.execCommand('bold', false, null);
                                    }
                                    else if (cmd === 'italic') {
                                      this.currentFormatting.italic = !this.currentFormatting.italic;
                                      btn.classList.toggle('active', this.currentFormatting.italic);
                                      document.execCommand('italic', false, null);
                                    }
                                    else if (cmd === 'underline') {
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
                                          const imgHtml = `<img src="${event.target.result}" style="max-width:600px;width:${width}px;height:${height}px;display:block;margin:10px auto;border-radius:8px;" data-original-width="${img.width}" data-original-height="${img.height}">`;
                                          document.execCommand('insertHTML', false, imgHtml);
                                          this.renderPreview();
                                          setTimeout(() => {
                                            const editor = document.getElementById('editor');
                                            const images = editor.querySelectorAll('img');
                                            const newImage = images[images.length - 1];
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
                                document.querySelector('[data-cmd="italic"]').classList.toggle('active', this.currentFormatting.italic);
                                document.querySelector('[data-cmd="underline"]').classList.toggle('active', this.currentFormatting.underline);
                                document.querySelector('[data-cmd="strikeThrough"]').classList.toggle('active', this.currentFormatting.strikeThrough);
                                return;
                              }
  
                              const selection = window.getSelection();
                              if (!selection.rangeCount) {
                                return;
                              }
  
                              // For empty editor or new line, use our tracked formatting state
                              if (selection.isCollapsed && editor.innerHTML.trim() === '') {
                                document.querySelector('[data-cmd="bold"]').classList.toggle('active', this.currentFormatting.bold);
                                document.querySelector('[data-cmd="italic"]').classList.toggle('active', this.currentFormatting.italic);
                                document.querySelector('[data-cmd="underline"]').classList.toggle('active', this.currentFormatting.underline);
                                document.querySelector('[data-cmd="strikeThrough"]').classList.toggle('active', this.currentFormatting.strikeThrough);
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
                              const isUnderline = domFormatting.underline !== undefined ? domFormatting.underline : isUnderlineCommand;
                              const isStrikeThrough = domFormatting.strikeThrough !== undefined ? domFormatting.strikeThrough : isStrikeThroughCommand;
  
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
                                  if (style.textDecoration.includes('line-through') || current.tagName === 'STRIKE' || current.tagName === 'S') {
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
                                      const enhanced = `<span style="opacity:0; transition:opacity 0.4s;"><p style="margin:0; line-height:1.6;">${originalText}</p></span>`;
                                      span.outerHTML = enhanced;
                                      const newEl = document.querySelector('span[style*="opacity:0"]');
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
                                content.innerHTML = '<h6 class="mb-3">Describe Your Email</h6><textarea class="ai-textarea" id="emailDesc" placeholder="Example: Create a welcome email for new customers..."></textarea><div class="mt-3"><button class="btn btn-primary" id="genEmail"><i class="bi bi-stars me-2"></i>Generate Email</button></div>';
                                document.getElementById('aiInputSection').classList.add('show');
                                document.getElementById('genEmail').addEventListener('click', () => {
                                  const desc = document.getElementById('emailDesc').value;
                                  if (desc.trim()) this.generateEmail(desc);
                                });
                              } else if (action === 'use-template') {
                                content.innerHTML = '<h6 class="mb-3">Choose a Template</h6><div class="template-gallery">' +
                                  Object.keys(EMAIL_TEMPLATES).map(key => `<div class="template-card" data-template="${key}"><div class="template-preview"><i class="bi bi-file-earmark-text"></i></div><h6 class="small mb-0">${EMAIL_TEMPLATES[key].name}</h6></div>`).join('') + '</div>';
                                document.getElementById('aiInputSection').classList.add('show');
                                document.querySelectorAll('.template-card').forEach(card => {
                                  card.addEventListener('click', () => {
                                    this.applyTemplate(card.dataset.template);
                                  });
                                });
                              } else if (action === 'generate-subject') {
                                content.innerHTML = '<h6 class="mb-3">Generate Subject Line</h6><textarea class="ai-textarea" id="subjectDesc" placeholder="Describe your email content..."></textarea><div class="mt-3"><button class="btn btn-primary" id="genSubject"><i class="bi bi-stars me-2"></i>Generate Subjects</button></div>';
                                document.getElementById('aiInputSection').classList.add('show');
                                document.getElementById('genSubject').addEventListener('click', () => {
                                  const desc = document.getElementById('subjectDesc').value;
                                  if (desc.trim()) this.generateSubjects(desc);
                                });
                              } else if (action === 'generate-image') {
                                content.innerHTML = '<h6 class="mb-3">Generate Image</h6><textarea class="ai-textarea" id="imageDesc" placeholder="Example: Modern dealership showroom..."></textarea><div class="mt-3"><button class="btn btn-primary" id="genImage"><i class="bi bi-stars me-2"></i>Generate Image</button></div>';
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
                                const template = /promo|sale|offer/i.test(desc) ? EMAIL_TEMPLATES.promotional : EMAIL_TEMPLATES.welcome;
                                this.applyGeneratedContent(template);
                              }, 2000);
                            }
  
  
  
                            generateImage(desc) {
                              this.showGenerating();
                              setTimeout(() => {
                                const img = `<img src="https://placehold.co/600x400/002140/white?text=${encodeURIComponent(desc.split(' ').slice(0, 3).join('+'))}" style="max-width: 600px; border-radius: 8px; margin: 20px auto; display: block;">`;
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
                              toast.innerHTML = `<div class="toast show align-items-center text-bg-success"><div class="d-flex"><div class="toast-body"><i class="bi bi-check-circle me-2"></i>${msg}</div></div></div>`;
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
                                  document.querySelectorAll('.color-dropdown, .table-grid-popup').forEach(d => d.classList.remove('show'));
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
                              this.selectedTableSize = { rows, cols };
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
                                html += `<th style="border: 1px solid #d1d5db; padding: 12px; text-align: left;  color: #000;font-weight:400 !important ;">Header ${c + 1}</th>`;
                              }
  
                              html += `</tr>
                                  </thead>
                                  <tbody>`;
  
                              for (let r = 0; r < rows - 1; r++) {
                                html += `<tr>`;
                                for (let c = 0; c < cols; c++) {
                                  html += `<td style="border: 1px solid #d1d5db; padding: 12px; text-align: left; color: #000;">Cell ${r + 1}-${c + 1}</td>`;
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
                              token.textContent = `@{{${tokenName}}}`;
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
                              html = html.replace(/<table/g, '<table style="border-collapse: collapse; width: 100%; margin: 15px 0;"');
                              html = html.replace(/<th/g, '<th style="border: 1px solid #d1d5db; padding: 12px; text-align: left;font-weight:400 !important;color:#000 "');
                              html = html.replace(/<td/g, '<td style="border: 1px solid #d1d5db; padding: 12px; text-align: left;color:#000"');
  
                              // Replace tokens with sample data
                              html = html.replace(/\{\{([^}]+)\}\}/g, (match, token) => {
                                return SAMPLE_DATA[token.trim()] || match;
                              });
  
                              document.getElementById('preview').innerHTML = html;
                            }
  
  
                          }
  
                          new TemplateBuilder();
                        </script>
                      </div>
  
  
                </div>
  
            
             
  
       
            </div>
  
            <div class="modal-footer d-flex justify-content-between">
            
              <button class="btn btn-primary" >Send Email</button>
            </div>
          </div>
        </div>
      </div>
      <style>
        .email-suggest-wrapper {
          position: relative;
        }
        
        .suggestion-box {
          position: absolute;
          width: 100%;
          background: #ffffff;
          border: 1px solid #ddd;
          max-height: 180px;
          overflow-y: auto;
          z-index: 9999;
          display: none;
        }
        
        .suggestion-item {
          padding: 8px 10px;
          cursor: pointer;
          border-bottom: 1px solid #f1f1f1;
        }
        
     
        </style>
      <script>
        // Sample user data A-J
        const users = [
          { name: "Alice Johnson", email: "alice.j@gmail.com" },
          { name: "Andrew Miller", email: "andrew.m@gmail.com" },
          { name: "Brian Adams", email: "brian.a@gmail.com" },
          { name: "Bella Green", email: "bella.g@gmail.com" },
          { name: "Chris Taylor", email: "chris.t@gmail.com" },
          { name: "Catherine Moore", email: "catherine.m@gmail.com" },
          { name: "David Parker", email: "david.p@gmail.com" },
          { name: "Daniel White", email: "daniel.w@gmail.com" },
          { name: "Emily Brown", email: "emily.b@gmail.com" },
          { name: "James Anderson", email: "james.a@gmail.com" }
        ];
        
        // Apply to all email inputs
        document.querySelectorAll('.email-suggest-wrapper').forEach(wrapper => {
        
          const input = wrapper.querySelector('.email-input');
          const suggestionBox = wrapper.querySelector('.suggestion-box');
        
          input.addEventListener('input', () => {
            const query = input.value.toLowerCase();
            suggestionBox.innerHTML = "";
        
            if (query.length === 0) {
              suggestionBox.style.display = "none";
              return;
            }
        
            const filtered = users.filter(user =>
              user.name.toLowerCase().includes(query) ||
              user.email.toLowerCase().includes(query)
            );
        
            if (filtered.length === 0) {
              suggestionBox.style.display = "none";
              return;
            }
        
            filtered.forEach(user => {
              const div = document.createElement('div');
              div.classList.add('suggestion-item');
              div.innerHTML = `<strong>${user.name}</strong><br><small>${user.email}</small>`;
        
              div.addEventListener('click', () => {
                input.value = user.email;
                suggestionBox.style.display = "none";
              });
        
              suggestionBox.appendChild(div);
            });
        
            suggestionBox.style.display = "block";
          });
        
          // Hide suggestions when clicking outside
          document.addEventListener('click', (e) => {
            if (!wrapper.contains(e.target)) {
              suggestionBox.style.display = "none";
            }
          });
        
        });
        </script>
  <!-- Save Changes Alert (Fixed position at top) -->
  <div id="saveAlert" class="alert alert-light d-none" style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999; min-width: 350px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
    <div class="d-flex justify-content-between align-items-center">
      <span><i class="isax isax-warning-2"></i> <strong>Unsaved changes</strong></span>
      <button id="topSaveBtn" class="btn btn-sm btn-primary ms-3">Save Now</button>
    </div>
  </div>

  
<!-- Main Modal -->
<div id="availabilityModal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="crm-header model-crm-header d-flex justify-content-between align-items-center">
          Vehicle Inventory Details
          <button type="button" data-bs-dismiss="modal">
            <i class="isax isax-close-circle"></i>
          </button>
        </div>
  
        <div class="modal-body pt-1">
          <form class="row g-2">
            <!-- Vehicle Info -->
            <div class="col-md-12 mb-2">
              <div class="card bg-light border">
                <div class="card-body py-2 px-3">
                  <div class="row g-2">
                    <div class="col-md-6">
                      <small class="text-muted">Vehicle</small>
                      <div class="fw-semibold">2024 Toyota Camry XLE</div>
                    </div>
                    <div class="col-md-3">
                      <small class="text-muted">Stock #</small>
                      <div class="fw-semibold">TC-2024-1523</div>
                    </div>
                    <div class="col-md-3">
                      <small class="text-muted">VIN</small>
                      <div class="fw-semibold">4T1B11HK...</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
  
            <!-- Customers List -->
            <div class="col-md-12 mb-2">
              <label class="form-label fw-semibold">
                Interested Customers (<span id="customerCount">0</span>)
              </label>
              <div id="customersList" class="border rounded p-2" style="max-height: 280px; overflow-y: auto; background: #fafafa;">
                <!-- Customers will be loaded here -->
              </div>
            </div>
  
  
  
          
          </form>
        </div>
  
       
      </div>
    </div>
  </div>
  
  
  <!-- Exit Confirmation Modal -->
  <div id="confirmExitModal" class="modal fade" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-body text-center py-4">
          <i class="isax isax-warning-2 text-warning" style="font-size: 3rem;"></i>
          <h5 class="mt-3 mb-2">Unsaved Changes</h5>
          <p class="text-muted">Are you sure you want to exit without saving?</p>
          <div class="d-flex gap-2 justify-content-center mt-3">
            <button id="confirmExitNo" class="btn btn-sm btn-secondary">No, Go Back</button>
            <button id="confirmExitYes" class="btn btn-sm btn-danger">Yes, Exit</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <style>
  .customer-item {
    padding: 10px;
    background: white;
    border-radius: 4px;
    margin-bottom: 8px;
    border: 1px solid #dee2e6;
    cursor: pointer;
    transition: all 0.2s;
  }
  .customer-item:hover {
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    border-color: var(--cf-primary);
  }
  .customer-name {
    color:var(--cf-primary);
    font-weight: 700;
    text-decoration: none;
  }
  .customer-name:hover {
    text-decoration: underline;
  }
  </style>
  
  <script>
    // Sample customer data
    const customers = [
    { 
      id: 1, 
      name: "John Miller", 
      assignedTo: "Sarah Smith", 
      phone: "+1 (555) 123-4567", 
      email: "john.m@email.com", 
      interest: "High", 
      date: "Oct 15, 2025", 
      time: "12:00 AM" 
    },
    { 
      id: 2, 
      name: "Emily Roberts", 
      assignedTo: "Mike Johnson", 
      phone: "+1 (555) 234-5678", 
      email: "emily.r@email.com", 
      interest: "Medium", 
      date: "Oct 16, 2025", 
      time: "09:30 AM" 
    },
    { 
      id: 3, 
      name: "David Chen", 
      assignedTo: "Sarah Smith", 
      phone: "+1 (555) 345-6789", 
      email: "david.c@email.com", 
      interest: "High", 
      date: "Oct 17, 2025", 
      time: "01:15 PM" 
    },
    { 
      id: 4, 
      name: "Maria Garcia", 
      assignedTo: "Tom Wilson", 
      phone: "+1 (555) 456-7890", 
      email: "maria.g@email.com", 
      interest: "Low", 
      date: "Oct 18, 2025", 
      time: "03:45 PM" 
    },
    { 
      id: 5, 
      name: "James Anderson", 
      assignedTo: "Sarah Smith", 
      phone: "+1 (555) 567-8901", 
      email: "james.a@email.com", 
      interest: "Medium", 
      date: "Oct 19, 2025", 
      time: "06:00 PM" 
    },
    { 
      id: 6, 
      name: "Lisa Thompson", 
      assignedTo: "Mike Johnson", 
      phone: "+1 (555) 678-9012", 
      email: "lisa.t@email.com", 
      interest: "High", 
      date: "Oct 20, 2025", 
      time: "10:30 AM" 
    }
  ];
  
    
    // ================================
    // SORT NEWEST TO OLDEST BY DATE
    // ================================
    customers.sort((a, b) => {
      return new Date(b.date) - new Date(a.date);
    });
    
    // Render customers list
    function renderCustomers() {
      const container = document.getElementById("customersList");
    
      container.innerHTML = customers.map(c => `
        <div class="customer-item" data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <a href="javascript:void(0)" class="customer-name">${c.name}</a>
              <div class="small text-muted mt-1">Assigned: ${c.assignedTo}</div>
            </div>
          </div>
          <div class="small text-muted mt-1">
            Hold Date & Time: ${c.date} ${c.time}
          </div>
        </div>
      `).join("");
    
      document.getElementById("customerCount").textContent = customers.length;
    }
    
    // Initialize
    renderCustomers();
    </script>
  
      <!-- ===== INVENTORY PRICE MODAL ===== -->
      <div id="priceAdjustmentModal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
  
            <div class="crm-header model-crm-header d-flex justify-content-between align-items-center">
              Inventory Price
              <button type="button" data-bs-dismiss="modal" aria-label="Close">
                <i class="isax isax-close-circle"></i>
              </button>
            </div>
  
            <div class="modal-body pt-1">
              <form id="inventoryPriceForm">
                <!-- Default Visible Fields -->
                <div class="row mb-2 align-items-center">
                  <label class="col-5 col-form-label">MSRP:</label>
                  <div class="col-7">
                    <input type="text" value="$0.00"  class="form-control">
                  </div>
                </div>
  
                <div class="row mb-2 align-items-center">
                  <label class="col-5 col-form-label">Selling Price:</label>
                  <div class="col-7">
                    <input type="text" value="$40,268.00" class="form-control">
                  </div>
                </div>
  
                <div class="row mb-2 align-items-center">
                  <label class="col-5 col-form-label">Internet Price:</label>
                  <div class="col-7">
                    <input type="text" value="$45,000.00" class="form-control">
                  </div>
                </div>
  
                <!-- Show More / Filter Toggle -->
                <div class="text-end mb-3">
                  <button type="button" class="btn btn-sm btn-light border border-1" id="toggleMoreFields">
                    Show More
                  </button>
                </div>
  
                <!-- Hidden Advanced Price Fields -->
                <div id="morePriceFields" style="display:none;">
  
                  <!-- Vehicle Cost -->
                  
  
                  <!-- Expiration Date -->
                 
  
                  <!-- Advertised Price -->
                  <div class="row mb-2 align-items-center">
                    <label class="col-5 col-form-label">Advertised Price:</label>
                    <div class="col-7">
                      <input type="text" value="$43,000.00" class="form-control">
                    </div>
                  </div>
  
                  <!-- Start Date -->
                  <div class="row mb-2 align-items-center">
                    <label class="col-5 col-form-label">Start Date:</label>
                    <div class="col-7">
                      <input type="text" class="form-control cf-datepicker" 
                      id="fromDate" readonly>
                    </div>
                  </div>
                  <div class="row mb-2 align-items-center">
                    <label class="col-5 col-form-label">Expiration Date:</label>
                    <div class="col-7">
                      <input type="text" class="form-control cf-datepicker" 
                       id="toDate" readonly>
                    </div>
                  </div>
                
                  <!-- Lot Location -->
                  <div class="row mb-2 align-items-center">
                    <label class="col-5 col-form-label">Lot Location:</label>
                    <div class="col-7">
                      <select class="form-select">
                        <option value="" hidden>Select Location</option>
                        <option>Main Lot</option>
                        <option>Offsite</option>
                        <option>Service</option>
                      </select>
                    </div>
                  </div>
  
                  <!-- Vehicle Type (to show/hide used section) -->
                  <div class="row mb-2 align-items-center">
                    <label class="col-5 col-form-label">Inventory Type:</label>
                    <div class="col-7">
                      <select id="vehicleType" class="form-select">
                        <option value="" hidden>Select Type</option>
                        <option>New</option>
                        <option>Pre-Owned</option>
                    
                        <option>CPO</option>
                        <option>Demo</option>
                        <option>Wholesale</option>
                       
                        <option>Unknown</option>
                      </select>
                    </div>
                  </div>
                  <div class="row mb-2 align-items-center">
                    <label class="col-5 col-form-label">Vehicle Cost:</label>
                    <div class="col-7">
                      <input type="number" class="form-control" placeholder="Enter internal cost">
                    </div>
                  </div>
                  <!-- Conditional Fields for Used/CPO -->
                  <div id="usedCpoFields"
                    style="display:none; border-top:1px dashed #ccc; margin-top:10px; padding-top:10px;">
                    <h6 class="fw-bold mb-2">Used / CPO Vehicle Details</h6>
  
                    <!-- Book Value -->
                    <div class="row mb-2 align-items-center">
                      <label class="col-5 col-form-label">Book Value (via vAuto):</label>
                      <div class="col-7 d-flex gap-2">
                        <input type="text" class="form-control" id="bookValue" placeholder="Fetching from vAuto..."
                          readonly>
                        <button type="button" id="fetchBookValue" class="btn btn-light border border-1 btn-sm">GET</button>
                      </div>
                    </div>
  
                    <!-- Rebate Amount -->
                    <div class="row mb-2 align-items-center">
                      <label class="col-5 col-form-label">Rebate Amount:</label>
                      <div class="col-7">
                        <input type="number" class="form-control" id="rebateAmount" placeholder="Enter rebate amount">
                      </div>
                    </div>
  
                    <!-- Recon Cost -->
                    <div class="row mb-2 align-items-center">
                      <label class="col-5 col-form-label">Recon Cost:</label>
                      <div class="col-7">
                        <input type="number" class="form-control" id="reconCost" placeholder="Enter reconditioning cost">
                      </div>
                    </div>
  
                    <!-- Acquisition Source -->
                    <div class="row mb-2 align-items-center">
                      <label class="col-5 col-form-label">Acquisition Source:</label>
                      <div class="col-7">
                        <select id="acquisitionSource" class="form-select">
                          <option value="" hidden>Select Source</option>
                          <option>Trade-in</option>
                          <option>Auction</option>
                          <option>Lease Return</option>
                          <option>Other</option>
                        </select>
                      </div>
                    </div>
  
                    <!-- Appraisal Value -->
                    <div class="row mb-2 align-items-center">
                      <label class="col-5 col-form-label">Appraisal Value:</label>
                      <div class="col-7">
                        <input type="number" class="form-control" id="appraisalValue" placeholder="Enter appraisal value">
                      </div>
                    </div>
                  </div>
  
                  <!-- Last Modified By Dropdown -->
                  <div class="row mb-2 align-items-center border-top pt-2">
                    <label class="col-5 col-form-label">Last Modified By:</label>
                    <div class="col-7">
                      <select class="form-select">
                        <option hidden>View Modification History</option>
                        <option>John Smith – Oct 27, 2025 01:33:02 PM</option>
                        <option>Sarah Khan – Oct 25, 2025 11:12:45 AM</option>
                      </select>
                    </div>
                  </div>
  
                </div>
              </form>
            </div>
  
            <div class="modal-footer">
              <button class="btn btn-light border border-1" data-bs-dismiss="modal">Cancel</button>
              <button class="btn btn-primary">Save</button>
            </div>
  
          </div>
        </div>
      </div>
      <script>
        // Toggle Show More fields
        document.getElementById("toggleMoreFields").addEventListener("click", function () {
          const moreFields = document.getElementById("morePriceFields");
          const visible = moreFields.style.display === "block";
          moreFields.style.display = visible ? "none" : "block";
          this.textContent = visible ? "Show More" : "Show Less";
        });
  
        // Show/Hide Used/CPO section
        document.getElementById("vehicleType").addEventListener("change", function () {
          const section = document.getElementById("usedCpoFields");
          section.style.display = (this.value === "Pre-Owned" || this.value === "CPO") ? "block" : "none";
        });
  
        // Flatpickr Initialization
        document.addEventListener("DOMContentLoaded", function () {
          flatpickr(".modern-datepicker", {
            enableTime: true,
            enableSeconds: true,
            time_24hr: false,
            dateFormat: "M d, Y h:i:S K",
            allowInput: false,
          });
        });
  
        // Placeholder for vAuto API Integration
        document.getElementById("fetchBookValue").addEventListener("click", function () {
          const bookField = document.getElementById("bookValue");
          bookField.value = "Fetching...";
          // Example: simulate API call
          setTimeout(() => {
            // In real code, send VIN or model info to your backend and fetch from vAuto
            const simulatedValue = "$25,430";
            bookField.value = simulatedValue;
          }, 1500);
        });
      </script>
  
      <style>
        /* Modern Flatpickr Look */
        .flatpickr-input,
        .modern-datepicker {
          background-color: #fff !important;
          border: 1px solid #ddd !important;
          color: #333;
          border-radius: 6px;
          padding: .45rem .6rem;
        }
  
        .flatpickr-calendar {
          box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
          border-radius: 8px;
        }
      </style>

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
          <div class="row g-3" id="imageContainer">
            <div class="col-md-3 image-box">
              <div class="image-wrapper">
                <img src="assets/img/car-detail/1.jpg" alt="">
                <button class="delete-btn">&times;</button>
              </div>
            </div>
            <div class="col-md-3 image-box">
              <div class="image-wrapper">
                <img src="assets/img/car-detail/2.jpg" alt="">
                <button class="delete-btn">&times;</button>
              </div>
            </div>
            <div class="col-md-3 image-box">
              <div class="image-wrapper">
                <img src="assets/img/car-detail/3.jpg" alt="">
                <button class="delete-btn">&times;</button>
              </div>
            </div>
            <div class="col-md-3 image-box">
              <div class="image-wrapper">
                <img src="assets/img/car-detail/4.jpg" alt="">
                <button class="delete-btn">&times;</button>
              </div>
            </div>
            <div class="col-md-3 image-box">
              <div class="image-wrapper">
                <img src="assets/img/car-detail/5.jpg" alt="">
                <button class="delete-btn">&times;</button>
              </div>
            </div>
            <div class="col-md-3 image-box">
              <div class="image-wrapper">
                <img src="assets/img/car-detail/6.jpg" alt="">
                <button class="delete-btn">&times;</button>
              </div>
            </div>
            <div class="col-md-3 image-box">
              <div class="image-wrapper">
                <img src="assets/img/car-detail/7.jpg" alt="">
                <button class="delete-btn">&times;</button>
              </div>
            </div>
            <div class="col-md-3 image-box">
              <div class="image-wrapper">
                <img src="assets/img/car-detail/8.jpg" alt="">
                <button class="delete-btn">&times;</button>
              </div>
            </div>
            <div class="col-md-3 image-box">
              <div class="image-wrapper">
                <img src="assets/img/car-detail/9.jpg" alt="">
                <button class="delete-btn">&times;</button>
              </div>
            </div>
            <div class="col-md-3 image-box">
              <div class="image-wrapper">
                <img src="assets/img/car-detail/10.jpg" alt="">
                <button class="delete-btn">&times;</button>
              </div>
            </div>

            <!-- Upload Placeholder -->
            <div class="col-md-3">
              <div class="place-holder-box" id="uploadBox">
                <i class="ti ti-upload"></i>
              </div>
              <input type="file" id="uploadInput" multiple accept="image/*" style="display: none;">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button class="btn btn-light border border-1" data-bs-dismiss="modal">Cancel</button>
          <button class="btn btn-primary">Save</button>
        </div>
      </div>
    </div>
  </div>

  <style>
    .image-wrapper {
      position: relative;
      width: 100%;
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
  </style>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const uploadBox = document.getElementById('uploadBox');
      const uploadInput = document.getElementById('uploadInput');
      const imageContainer = document.getElementById('imageContainer');

      // Open file dialog
      uploadBox.addEventListener('click', () => uploadInput.click());

      // Handle uploads
      uploadInput.addEventListener('change', function () {
        for (let file of this.files) {
          const reader = new FileReader();
          reader.onload = function (e) {
            const col = document.createElement('div');
            col.classList.add('col-md-3', 'image-box');
            col.innerHTML = `
            <div class="image-wrapper">
              <img src="${e.target.result}" alt="">
              <button class="delete-btn">&times;</button>
            </div>
          `;
            imageContainer.insertBefore(col, uploadBox.parentElement);
            attachDeleteEvent(col.querySelector('.delete-btn'));
          };
          reader.readAsDataURL(file);
        }
        this.value = '';
      });

      // Delete function
      function attachDeleteEvent(button) {
        button.addEventListener('click', function () {
          this.closest('.image-box').remove();
        });
      }

      // Attach delete to existing buttons
      document.querySelectorAll('.delete-btn').forEach(btn => attachDeleteEvent(btn));
    });
  </script>

<div id="minimizedBar"
class="d-none position-fixed bottom-0 end-0 m-3 bg-primary text-white px-3 py-2 shadow"
style="cursor:pointer;border-radius:50%;">
Brochure
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

const modalEl = document.getElementById("emailModal");
const minimizeBtn = document.getElementById("minimizeModalBtn");
const minimizedBar = document.getElementById("minimizedBar");

if (!modalEl || !minimizeBtn || !minimizedBar) {
console.error("❌ Required modal elements not found");
return;
}

const form = modalEl.querySelector("form");
const bsModal = new bootstrap.Modal(modalEl);

console.log("✅ Modal minimization system initialized");

/* =========================
RESTORE MODAL STATE
========================== */
const modalState = localStorage.getItem("modalState");

if (modalState === "minimized") {
minimizedBar.classList.remove("d-none");
console.log("🔄 Modal restored as minimized");
} 
else if (modalState === "open") {
bsModal.show();
console.log("🔄 Modal restored as open");
}

/* =========================
RESTORE FORM DATA
========================== */
if (form) {
const savedData = JSON.parse(localStorage.getItem("modalFormData") || "{}");
for (let [name, value] of Object.entries(savedData)) {
 const input = form.querySelector(`[name="${name}"]`);
 if (input) input.value = value;
}
}

/* =========================
MINIMIZE CLICK
========================== */
minimizeBtn.addEventListener("click", function (e) {
e.preventDefault();
e.stopPropagation();
document.querySelectorAll(".modal-backdrop").forEach(el => el.remove());

console.log("⬇️ Modal minimized");
localStorage.setItem("modalState", "minimized");
bsModal.hide();
minimizedBar.classList.remove("d-none");
});

/* =========================
RESTORE FROM FLOAT BAR
========================== */
minimizedBar.addEventListener("click", function () {
console.log("⬆️ Modal restored");
localStorage.setItem("modalState", "open");
minimizedBar.classList.add("d-none");
bsModal.show();
});

/* =========================
MODAL CLOSED NORMALLY
========================== */
modalEl.addEventListener("hidden.bs.modal", function () {
if (localStorage.getItem("modalState") !== "minimized") {
 console.log("❎ Modal fully closed");
 localStorage.setItem("modalState", "closed");
 document.querySelectorAll(".modal-backdrop").forEach(el => el.remove());

 minimizedBar.classList.add("d-none");
}
});

/* =========================
AUTO-SAVE FORM DATA
========================== */
if (form) {
form.addEventListener("input", function () {
 const formData = {};
 form.querySelectorAll("input, textarea, select").forEach(el => {
   if (el.name) formData[el.name] = el.value;
 });
 localStorage.setItem("modalFormData", JSON.stringify(formData));
});
}

});
</script>

<script>
    document.getElementById("showCountCheckbox").addEventListener("change", function () {
      const overlays = document.querySelectorAll(".image-count-overlay");
      overlays.forEach(function (overlay) {
        overlay.classList.toggle("d-none", !event.target.checked);
      });
    });
  </script>
@endsection


@push('styles')
<style>
    .editor img.selected {
     outline: 3px solid #8b5cf6;
     outline-offset: 2px
   }

   .device-toggle button i {
     font-size: 16px
   }


   .device-toggle button {
     border-radius: 6px;
     padding: 2px 6px;
     border: none;
     background: #fff;
     outline: none;

   }

   /* Mobile view */
   .preview-content.mobile {
     max-width: 375px;
     margin: 0 auto;
     border-left: 1px solid #e1e5eb;
     border-right: 1px solid #e1e5eb;
     box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
   }

   .image-controls {
     position: fixed;
     background: #fff;
     border: 1px solid #d1d5db;
     border-radius: 8px;
     padding: 12px;
     box-shadow: 0 4px 12px rgba(0, 0, 0, .15);
     z-index: 1000;
     display: none;
     min-width: 280px
   }

   .image-controls.show {
     display: block
   }

   /* ... rest of image control styles ... */
   :root {
     --primary-color: rgb(0, 33, 64);
     --primary-light: rgba(0, 33, 64, 0.1);
     --primary-dark: rgb(0, 25, 48);
     --surface: #ffffff;
     --muted: #6b7280;
     --ring: #e5e7eb;
     --bg: #f8fafc;
   }

   .toolbar-btn.active {
     background-color: #e9ecef !important;
     border-color: #6c757d !important;
     color: #495057 !important;
   }

   .toolbar-btn.active:hover {
     background-color: #dee2e6 !important;
   }

   .button-group button {
     font-size: 12px !important;
     padding: 6px 10px !important;
   }

   * {
     box-sizing: border-box;
   }

   html,
   body {
     height: 100%;

     font-family: "Inter";
   }

   .app {
     min-height: 100vh;
   }

   .card {
     border: none;
     box-shadow: none;
     background: white;
   }

   .template-header {
     position: static;
     top: 0;
     background: var(--surface);
     z-index: 30;
     border-bottom: 1px solid var(--ring);
   }

   .btn-primary {
     background-color: var(--primary-color) !important;
     border-color: var(--primary-color) !important;
     color: white !important;
   }

   .btn-primary:hover {
     background-color: var(--primary-dark) !important;
     border-color: var(--primary-dark) !important;
   }

   .btn-ai {
     background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
     border: none;
     color: white;
     padding: 8px 16px;
     border-radius: 6px;
     font-weight: 600;
     display: inline-flex;
     align-items: center;
     gap: 8px;
     transition: all 0.2s ease;
     cursor: pointer;
   }

   .btn-ai:hover {
     transform: translateY(-1px);
     box-shadow: 0 4px 12px rgba(139, 92, 246, 0.4);
   }

   .outlook-toolbar {
     background: #f3f4f6;
     border: 1px solid #d1d5db;
     border-radius: 6px 6px 0 0;
     padding: 8px 12px;
     display: flex;
     align-items: center;
     gap: 4px;
     flex-wrap: wrap;
   }

   .toolbar-separator {
     width: 1px;
     height: 24px;
     background: #d1d5db;
     margin: 0 4px;
   }

   p {
     margin-bottom: 0px !important;
   }

   .toolbar-btn {
     width: 32px;
     height: 32px;
     border: 1px solid transparent;
     background: transparent;
     border-radius: 4px;
     display: flex;
     align-items: center;
     justify-content: center;
     cursor: pointer;
     transition: all 0.15s ease;
     font-size: 16px;
     color: #374151;
     position: relative;
   }

   /* .toolbar-btn:hover {
   background: #e5e7eb;
   border-color: #d1d5db;
 }
 .toolbar-btn.active {
   background: #dbeafe;
   border-color: #3b82f6;
   color: #1e40af;
 }
  */
   .toolbar-select {
     height: 32px;
     border: 1px solid #d1d5db;
     background: white;
     border-radius: 4px;
     padding: 4px 8px;
     font-size: 13px;
     min-width: 80px;
     cursor: pointer;
   }

   .btn-smart-text {
     height: 32px;
     padding: 0 12px;
     border: 1px solid #8b5cf6;
     background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
     color: white;
     border-radius: 4px;
     font-size: 12px;
     font-weight: 600;
     cursor: pointer;
     display: flex;
     align-items: center;
     gap: 6px;
     transition: all 0.2s ease;
     white-space: nowrap;
   }

   .btn-smart-text:hover {
     transform: translateY(-1px);
     box-shadow: 0 4px 12px rgba(139, 92, 246, 0.4);
   }

   .color-picker-wrapper {
     position: relative;
   }

   .color-picker-btn {
     width: 32px;
     height: 32px;
     border: 1px solid transparent;
     background: transparent;
     border-radius: 4px;
     cursor: pointer;
     transition: all 0.15s ease;
     position: relative;
     display: flex;
     align-items: center;
     justify-content: center;
   }

   .color-picker-btn:hover {
     background: #e5e7eb;
     border-color: #d1d5db;
   }

   .color-underline {
     position: absolute;
     bottom: 4px;
     left: 8px;
     right: 8px;
     height: 3px;
     border-radius: 1px;
   }

   .color-dropdown {
     position: absolute;
     top: 100%;
     left: 0;
     background: white;
     border: 1px solid #d1d5db;
     border-radius: 6px;
     box-shadow: 0 4px 12px rgba(0, 0, 0, .15);
     padding: 12px;
     display: none;
     z-index: 1000;
     min-width: 220px;
   }

   .color-dropdown.show {
     display: block;
   }

   .color-grid {
     display: grid;
     grid-template-columns: repeat(10, 1fr);
     gap: 4px;
     margin-bottom: 8px;
   }

   .color-swatch {
     width: 20px;
     height: 20px;
     border: 1px solid #d1d5db;
     border-radius: 3px;
     cursor: pointer;
     transition: all 0.15s ease;
   }

   .color-swatch:hover {
     transform: scale(1.15);
     border-color: #374151;
   }

   .custom-color-section {
     border-top: 1px solid #e5e7eb;
     padding-top: 8px;
     margin-top: 8px;
   }

   .custom-color-btn {
     width: 100%;
     padding: 6px 12px;
     border: 1px solid #d1d5db;
     background: white;
     border-radius: 4px;
     cursor: pointer;
     font-size: 13px;
     display: flex;
     align-items: center;
     gap: 8px;
     transition: all 0.15s ease;
   }

   .custom-color-btn:hover {
     background: #f9fafb;
     border-color: #9ca3af;
   }

   .custom-color-inputs {
     display: none;
     margin-top: 8px;
     padding: 8px;
     background: #f9fafb;
     border-radius: 4px;
   }

   .custom-color-inputs.show {
     display: block;
   }

   .color-input-row {
     display: flex;
     gap: 8px;
     align-items: center;
     margin-bottom: 8px;
   }

   .color-input-row:last-child {
     margin-bottom: 0;
   }

   .color-input-group {
     display: flex;
     align-items: center;
     gap: 4px;
   }

   .color-input-label {
     font-size: 11px;
     color: #6b7280;
     min-width: 30px;
   }

   .color-input {
     width: 60px;
     height: 28px;
     border: 1px solid #d1d5db;
     border-radius: 3px;
     padding: 2px 6px;
     font-size: 12px;
     font-family: 'Courier New', monospace;
   }

   .color-preview-box {
     width: 40px;
     height: 28px;
     border: 1px solid #d1d5db;
     border-radius: 3px;
   }

   .table-grid-popup {
     position: absolute;
     top: 100%;
     left: 0;
     background: white;
     border: 1px solid #d1d5db;
     border-radius: 6px;
     box-shadow: 0 4px 12px rgba(0, 0, 0, .15);
     padding: 12px;
     display: none;
     z-index: 1000;
   }

   .table-grid-popup.show {
     display: block;
   }

   .table-grid {
     display: grid;
     grid-template-columns: repeat(10, 20px);
     gap: 2px;
     margin-bottom: 8px;
   }

   .table-cell {
     width: 20px;
     height: 20px;
     border: 1px solid #d1d5db;
     border-radius: 2px;
     cursor: pointer;
     transition: all 0.1s ease;
   }

   .table-cell:hover,
   .table-cell.selected {
     background: #3b82f6;
     border-color: #2563eb;
   }

   .table-size-label {
     font-size: 12px;
     color: #6b7280;
     text-align: center;
   }

   .editor-wrapper {
     border: 1px solid #d1d5db;
     border-radius: 0 0 6px 6px;
     border-top: none;
     background: white;
     position: relative;
   }

   .editor-container {
     height: 500px;
     overflow-y: auto;
     overflow-x: hidden;
   }

   .editor {
     min-height: 100%;
     outline: none;
     padding: 20px;
     background: white;
     font-family: Arial, sans-serif;
     font-size: 14px;
     line-height: 1.6;
     word-wrap: break-word;
   }

   .editor img {
     max-width: 100%;
     height: auto;
     display: block;
     margin: 10px 0;
     border-radius: 4px;
     cursor: pointer;
   }

   .editor table {
     width: 100%;
     border-collapse: collapse;
     margin: 15px 0;
     border: 1px solid #d1d5db;
   }

   .editor table th,
   .editor table td {
     border: 1px solid #d1d5db;
     padding: 8px 12px;
     text-align: left;
   }

   .editor table th {
     /* background-color: #f3f4f6; */
     /* font-weight: 600; */
   }

   .token {

     display: inline-block;
     
   }

   .cta-button {
     display: inline-block;
     padding: 12px 24px;
     background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
     color: white;
     text-decoration: none;
     border-radius: 6px;
     font-weight: 600;
     margin: 10px 0;
     text-align: center;
     transition: all 0.2s ease;
   }

   .cta-button:hover {
     transform: translateY(-2px);
     box-shadow: 0 4px 12px rgba(0, 33, 64, 0.3);
   }

   .voice-btn {
     width: 32px;
     height: 32px;
     border: 1px solid transparent;
     background: transparent;
     border-radius: 4px;
     display: flex;
     align-items: center;
     justify-content: center;
     cursor: pointer;
     transition: all 0.15s ease;
     color: #dc2626;
   }

   .voice-btn:hover {
     background: #fee2e2;
     border-color: #fecaca;
   }

   .voice-btn.recording {
     background: #dc2626;
     color: white;
     animation: pulse 1.5s infinite;
   }

   @keyframes pulse {

     0%,
     100% {
       opacity: 1;
     }

     50% {
       opacity: 0.7;
     }
   }

   .ai-modal {
     position: fixed;
     top: 0;
     left: 0;
     right: 0;
     bottom: 0;
     background: rgba(0, 0, 0, 0.5);
     display: none;
     align-items: center;
     justify-content: center;
     z-index: 9999;
     padding: 20px;
   }

   .ai-modal.show {
     display: flex;
   }

   .ai-modal-content {
     background: white;
     border-radius: 12px;
     max-width: 700px;
     width: 100%;
     max-height: 90vh;
     overflow-y: auto;
     box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
   }

   .ai-modal-header {
     background: rgb(0, 33, 64);
     color: white;
     padding: 20px;
     border-radius: 12px 12px 0 0;
     display: flex;
     align-items: center;
     justify-content: space-between;
   }

   .ai-modal-body {
     padding: 24px;
   }

   .preview-content .token {
     background: transparent;
     color: #000;
     padding: 0 !important;
     border-radius: 0;
     font-size: inherit !important;
     border: none !important;
     display: inline-block;
     margin: 0 0px;
     cursor: text;
   }

   .ai-option-card {
     border: 2px solid #e5e7eb;
     border-radius: 8px;
     padding: 16px;
     margin-bottom: 16px;
     cursor: pointer;
     transition: all 0.2s ease;
   }

   .ai-option-card:hover {
     border-color: rgb(0, 33, 64);
     background: #f5f5f5;
     transform: translateY(-2px);
   }

   .ai-option-icon {
     width: 48px;
     height: 48px;
     background: rgb(0, 33, 64);
     border-radius: 12px;
     display: flex;
     align-items: center;
     justify-content: center;
     color: white;
     font-size: 24px;
     margin-bottom: 12px;
   }

   .ai-input-section {
     display: none;
   }

   .ai-input-section.show {
     display: block;
   }

   .ai-textarea {
     width: 100%;
     min-height: 120px;
     border: 2px solid #e5e7eb;
     border-radius: 8px;
     padding: 12px;
     font-size: 14px;
     resize: vertical;
     transition: all 0.2s ease;
   }

   .ai-textarea:focus {
     outline: none;
     border-color: rgb(0, 33, 64);
     box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
   }

   .ai-generating {
     text-align: center;
     padding: 40px 20px;
     display: none;
   }

   .ai-generating.show {
     display: block;
   }

   .ai-spinner {
     width: 60px;
     height: 60px;
     border: 4px solid #ede9fe;
     border-top-color: rgb(0, 33, 64);
     border-radius: 50%;
     animation: spin 1s linear infinite;
     margin: 0 auto 20px;
   }

   @keyframes spin {
     to {
       transform: rotate(360deg);
     }
   }

   .template-gallery {
     display: grid;
     grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
     gap: 16px;
     margin-top: 20px;
   }

   .template-card {
     border: 2px solid #e5e7eb;
     border-radius: 8px;
     padding: 12px;
     cursor: pointer;
     transition: all 0.2s ease;
     text-align: center;
   }

   .template-card:hover {
     border-color: rgb(0, 33, 64);
     transform: translateY(-2px);
     box-shadow: 0 4px 12px rgba(139, 92, 246, 0.2);
   }

   .template-preview {
     width: 100%;
     height: 120px;
     background: #f3f4f6;
     border-radius: 6px;
     margin-bottom: 8px;
     display: flex;
     align-items: center;
     justify-content: center;
     font-size: 32px;
     color: rgb(0, 33, 64);
   }

   .merge-fields-container {
     background: white;
     border: 1px solid #d1d5db;
     border-radius: 6px;
     overflow: hidden;
   }

   .merge-fields-header {
     background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
     color: white;
     padding: 16px;
     font-weight: 600;
     font-size: 15px;
   }

   .category-header {
     background: #f9fafb;
     padding: 10px 16px;
     border-bottom: 1px solid #e5e7eb;
     cursor: pointer;
     font-weight: 600;
     font-size: 13px;
     color: #374151;
     display: flex;
     align-items: center;
     justify-content: space-between;
     transition: all 0.15s ease;
   }

   .category-header:hover {
     background: #f3f4f6;
   }

   .category-body {
     max-height: 0;
     overflow: hidden;
     transition: max-height 0.3s ease;
   }

   .category-body.show {
     max-height: 2000px;
   }

   .field-item {
     display: flex;
     align-items: center;
     justify-content: space-between;
     padding: 10px 16px;
     border-bottom: 1px solid #f3f4f6;
     cursor: pointer;
     transition: all 0.15s ease;
   }

   .field-item:hover {
     background: #f9fafb;
     padding-left: 20px;
   }

   .field-label {
     font-size: 13px;
     color: #374151;
   }

   .field-tag {
     background: var(--primary-color);
     color: white;
     padding: 3px 8px;
     border-radius: 4px;
     font-size: 11px;
     font-family: 'Courier New', monospace;
   }

   .preview-container {
     background: white;
     border: 1px solid #d1d5db;
     border-radius: 6px;
     overflow: hidden;
   }

   .preview-header {
     background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
     color: white;
     padding: 16px;
   }

   .preview-content {
     padding: 20px;
     min-height: 400px;
     font-family: Arial, sans-serif;
   }

   @media (max-width: 768px) {
     .outlook-toolbar {
       overflow-x: auto;
     }
   }
 </style>    
@endpush

@push('scripts')
<script src="{{ asset('assets/js/inventory.js') }}"></script>
@endpush
