@extends('layouts.app')

@php
    // Determine the source user for pre-filling (edit or duplicate)
    $sourceUser = $user ?? $duplicateUser ?? null;
    $isEdit = isset($user);
    $isDuplicate = isset($duplicateUser);
    
    // Permission checks - only restrict if user lacks permission
    $isSelfEdit = $isEdit && auth()->id() === $user->id;
    $hasEditPermission = auth()->user()->hasPermissionTo('Access To Users');
    
    // Read-only mode only for users without permission
    $isReadOnly = $isEdit && !$hasEditPermission;
@endphp

@section('title', $isEdit ? 'Edit User' : ($isDuplicate ? 'Duplicate User' : 'Add User'))


@section('content')

<div class="content content-two p-0 ps-3 pe-3" id="showroom-page">

    <!-- Page Header -->
    <div class="position-relative d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3" style="min-height: 80px;">
        <!-- Title aligned left -->
        <div>
            <h6 class="mb-0">{{ $isEdit ? 'Edit User' : ($isDuplicate ? 'Duplicate User' : 'Add User') }}</h6>
        </div>
    
        <!-- Image centered - Different markup for edit mode -->
        @if($isEdit)
        <div id="edit-mode-logo" style="position: absolute !important; left: 50% !important; top: 50% !important; transform: translate(-50%, -50%) !important; z-index: 9999 !important;">
            <img src="{{ asset('assets/light_logo.png') }}" alt="Logo" 
                 style="max-width: 80px !important; height: auto !important; display: block !important; visibility: visible !important; opacity: 1 !important;">
        </div>
        @else
        <img id="page-header-logo" class="logo-img" src="{{ asset('assets/light_logo.png') }}" alt="Logo" 
             style="position: absolute !important; left: 50% !important; top: 50% !important; transform: translate(-50%, -50%) !important; max-width: 80px !important; height: auto !important; display: block !important; visibility: visible !important; opacity: 1 !important;">
        @endif
        
        <!-- Right side placeholder for layout consistency -->
        <div></div>
    </div>
    <!-- End Page Header -->

    <div class="split-container">
      <div class="split-view">
        <ul class="nav nav-tabs mb-3">
          <li class="nav-item">
              <a href="#personalinformation" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                  Personal Information
              </a>
          </li>
          <li class="nav-item">
              <a href="#permissions" data-bs-toggle="tab" aria-expanded="false" class="nav-link ">
                  Permissions
              </a>
          </li>
          <li class="nav-item">
              <a href="#alertSettings" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                Settings
              </a>
          </li>
         
        
      </ul>
      <div class="tab-content">
        @if($isDuplicate)
        <div class="alert alert-info alert-dismissible fade show" role="alert">
          <i class="isax isax-info-circle me-2"></i>
          <strong>Duplicating User:</strong> You are creating a new user based on <strong>{{ $duplicateUser->name }}</strong>. Please enter a new email address and password.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        
        @if($isReadOnly)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="isax isax-lock me-2"></i>
          <strong>Read-Only Mode:</strong> You do not have permission to edit users. You can view this profile but cannot make any changes.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        
        <div class="tab-pane show active" id="personalinformation">
          <div class="crm-box">
            <div class="crm-header mb-2">Personal Information<i class="ms-1 isax isax-info-circle bold"></i></div>
            <form action="{{ $isEdit ? route('users.update', $user->id) : route('users.store') }}" method="POST" enctype="multipart/form-data" class="row g-2" id="profileForm">
              @csrf
              @if($isEdit)
                @method('PUT')
              @endif
              <div class="col-md-2 mb-2 d-flex flex-column align-items-start">
                <label class="form-label">Profile Photo</label>
                <div class="profile-pic-wrapper">
                  <img src="{{ isset($user) && $user->profile_photo ? asset($user->profile_photo) : 'https://img.freepik.com/premium-vector/user-profile-icon-circle_1256048-12499.jpg?semt=ais_hybrid&w=740&q=80' }}" id="preview-img" alt="Profile Photo">
                  <div class="edit-icon" onclick="document.getElementById('photo-input').click()">
                    <i class="isax isax-edit"></i>
                  </div>
                </div>
                <input type="file" name="profile_photo" accept="image/*" id="photo-input" onchange="previewPhoto(event)">
              </div>
              
            
              
           
              
              <div class="col-md-3 mb-2">
                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" id="firstName" placeholder="e.g. John" value="{{ old('name', $sourceUser->name ?? '') }}" required>
              </div>
              
            
              
              <div class="col-md-3 mb-2">
                <label class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" id="email" placeholder="e.g. johndoe@gmail.com" value="{{ old('email', $isEdit ? $user->email : '') }}" required>
              </div>
              <div class="col-md-3 mb-2">
                <label class="form-label">Password @if(!$isEdit)<span class="text-danger">*</span>@endif</label>
                <div class="input-group">
                  <input type="password" name="password" class="form-control" id="password" placeholder="{{ $isEdit ? 'Leave blank to keep current' : 'Enter your password' }}" {{ !$isEdit ? 'required' : '' }}>
                  <button class="btn btn-outline-secondary" type="button" id="togglePassword" onclick="togglePasswordVisibility()">
                    <i class="ti ti-eye" id="passwordIcon"></i>
                  </button>
                </div>
              </div>
              <div class="mb-2 col-md-4">
                <label class="form-label">Work Phone</label>
                <input type="text" name="work_phone" class="form-control" id="workPhone" placeholder="e.g. (123) 456-7890" value="{{ old('work_phone', $sourceUser->work_phone ?? '') }}">
              </div>
              
              <div class="mb-2 col-md-4">
                <label class="form-label">Cell Phone</label>
                <input type="text" name="cell_phone" class="form-control" id="cellPhone" placeholder="e.g. (321) 654-0987" value="{{ old('cell_phone', $sourceUser->cell_phone ?? '') }}">
              </div>
              
              <div class="mb-2 col-md-4">
                <label class="form-label">Home Phone</label>
                <input type="text" name="home_phone" class="form-control" id="homePhone" placeholder="e.g. (111) 222-3333" value="{{ old('home_phone', $sourceUser->home_phone ?? '') }}">
              </div>
              
              <div class="mb-2 col-md-4">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" id="title" value="{{ old('title', $sourceUser->title ?? '') }}">
              </div>
              
              <div class="mb-2 col-md-4">
                <label class="form-label">Sales Team <span class="text-danger">*</span></label>
                <select name="sales_team" class="form-select" id="salesTeam" required {{ $isReadOnly ? 'disabled' : '' }}>
                  <option value="">-- Select Team --</option>
                  @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ ($sourceUser && $sourceUser->roles->pluck('name')->contains($role->name)) ? 'selected' : '' }}>{{ $role->name }}</option>
                  @endforeach
                </select>
              </div>
            
<div class="mb-2 col-md-4">
<label class="form-label">Dealership Franchise</label>
<select name="dealership_franchises[]" class="form-select" id="dealershipFranchise" multiple>

<option value="18874">#18874 Bannister GM Vernon</option>
<option value="Twin">Twin Motors Thompson</option>
<option value="19234">#19234 Bannister Ford</option>
<option value="19345">#19345 Bannister Nissan</option>
</select>
</div>


              
              <div class="col-md-7 mb-2">
                <label class="form-label">Email Signature</label>
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
                    <button type="button" class="toolbar-btn" data-cmd="underline" title="Underline (Ctrl+U)">
                      <i class="bi bi-type-underline"></i>
                    </button>
                    <button type="button" class="toolbar-btn" data-cmd="strikeThrough" title="Strikethrough">
                      <i class="bi bi-type-strikethrough"></i>
                    </button>
        
                    <div class="toolbar-separator"></div>
        
                    <!-- Text Color -->
                    <!-- <div class="color-picker-wrapper">
                      <button type="button" class="color-picker-btn" id="textColorBtn" title="Text color">
                        <i class="bi bi-fonts" style="font-size: 18px;"></i>
                        <div class="color-underline" id="textColorIndicator" style="background: #000000;"></div>
                      </button>
                      <div class="color-dropdown" id="textColorDropdown"></div>
                    </div> -->
        
                    <!-- Highlight Color -->
                    <!-- <div class="color-picker-wrapper">
                      <button type="button" class="color-picker-btn" id="highlightColorBtn" title="Highlight color">
                        <i class="bi bi-highlighter"></i>
                        <div class="color-underline" id="highlightColorIndicator" style="background: #ffff00;"></div>
                      </button>
                      <div class="color-dropdown" id="highlightColorDropdown"></div>
                    </div> -->
        
             
        
                    <!-- Alignment -->
                    <button type="button" class="toolbar-btn" data-cmd="justifyLeft" title="Align left">
                      <i class="bi bi-text-left"></i>
                    </button>
                    <button type="button" class="toolbar-btn" data-cmd="justifyCenter" title="Align center">
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
                    <button type="button" class="toolbar-btn" data-cmd="insertUnorderedList" title="Bullet list">
                      <i class="bi bi-list-ul"></i>
                    </button>
                    <button type="button" class="toolbar-btn" data-cmd="insertOrderedList" title="Numbered list">
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
                   
                    <button type="button" class="toolbar-btn" id="btnImage" title="Insert image">
                      <i class="bi bi-image"></i>
                    </button>
                    <button type="button" class="toolbar-btn" id="btnHtmlMode" title="Edit HTML / Switch to HTML mode">
                      <i class="bi bi-code-slash"></i>
                    </button>
                    <!-- <button type="button" class="toolbar-btn" id="btnLink" title="Insert link">
                      <i class="bi bi-link-45deg"></i>
                    </button>
        
                    <button type="button" class="toolbar-btn" id="btnAttach" title="Attach file">
                      <i class="bi bi-paperclip"></i>
                    </button> -->
        
                    <!-- <button type="button" class="toolbar-btn" id="btnClearFormat" title="Clear formatting">
                      <i class="bi bi-eraser"></i>
                    </button> -->
        
        

                  </div>
                  <textarea class="html-textarea" id="htmlTextarea" style="display:none;"></textarea>
                  <div class="editor-wrapper">
                    <div class="editor-container">
                      <div class="editor" id="editor" contenteditable="true">
                        <p>Hi <span class="token">@{{first_name}}</span>,</p>
                        <p>Welcome to <span class="token">@{{dealer_name}}</span>! We're excited to help you find your perfect
                          vehicle.</p>
                        <p>If you have any questions, please don't hesitate to contact me.</p>
                        <br>
                          
                        <p>Best regards,<br>
                          <span class="token">@{{advisor_name}}</span><br>
                          <span class="token">@{{dealer_name}}</span><br>
                          Phone: <span class="token">@{{dealer_phone}}</span>
                        </p>
                      </div>
                  <!-- HTML Edit Textarea for Signature -->
                  <textarea class="html-edit-textarea" id="sigHtmlEditor" placeholder="Paste your HTML signature here..."></textarea>
                    </div>
                  </div>
                </div>
                <!-- <textarea id="email-signature">Hello, World!</textarea> -->
            </div>
            <div class="col-md-5 mt-4">
                <div class="merge-fields-container">
                    <div class="merge-fields-header">
                      Customer Fields
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
                        <div class="field-item" data-token="assigned_manager_email">
                          <span class="field-label">Assigned Manager Email</span>
                          <span class="field-tag">@{{assigned_manager_email}}</span>
                        </div>
                        <div class="field-item" data-token="assigned_manager_work_number">
                          <span class="field-label">Assigned Manager Work Number</span>
                          <span class="field-tag">@{{assigned_manager_work_number}}</span>
                        </div>
                        <div class="field-item" data-token="assigned_manager_cell_number">
                          <span class="field-label">Assigned Manager Cell Number</span>
                          <span class="field-tag">@{{assigned_manager_cell_number}}</span>
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
                        <div class="field-item" data-token="service_advisor">
                          <span class="field-label">Service Advisor</span>
                          <span class="field-tag">@{{service_advisor}}</span>
                        </div>
                      
                        <div class="field-item" data-token="inventory_manager">
                          <span class="field-label">Inventory Manager</span>
                          <span class="field-tag">@{{inventory_manager}}</span>
                        </div>
                      
                      </div>
                    </div>
                  </div>
            </div>
          
              <div class="col-md-7 mb-2 ps-3">
                <div class="working-hours-box">
                  <h6 class="mb-2">Working Hours</h6>
                  <!-- <button type="button" class="btn btn-sm btn-outline-secondary" id="copy-all-timings">
                    <i class="isax isax-copy me-1"></i>Copy All Timings
                  </button> -->
                  <div id="working-hours-container"></div>
                </div>
                
                <template id="working-hours-template">
                  <div class="working-hours-row">
                    <div class="day-label"></div>
                    <div class="form-check">
                      <input class="form-check-input off-toggle" type="checkbox">
                      <label class="form-check-label">Off</label>
                    </div>
                    <div class="time-wrapper">
                      <i class="isax isax-clock"></i>
                      <select class="form-select from-time"></select>
                    </div>
                    <div class="time-wrapper">
                      <i class="isax isax-clock"></i>
                      <select class="form-select to-time"></select>
                    </div>
                    <button type="button" class="btn btn-sm btn-icon copy-day-timings" title="Copy time to all">
                      <i class="isax isax-copy"></i>
                    </button>
                  </div>
                </template>
              </div>
          </div>
        </div>
        <div class="tab-pane fade" id="permissions">
          <div class="crm-box">
            <div class="crm-header mb-4">Permissions <i class="ms-1 isax isax-book-1"></i>
              @if($isSelfEdit)
                <span class="badge bg-secondary ms-2">Read-Only</span>
              @endif
            </div>
            
            @php
            // Define permission categories with their exact names from the database
            $permissionCategories = [
                'Lead & Customer Management' => [
                    'View All Dealer Deals/Customer Info',
                    'Edit All Dealer Deals/Customer Info',
                    'Reassign Deals',
                    'Merge Deals',
                    'Duplicate Deals',
                    'Delete Deals',
                    'Delete Customer',
                ],
                'Tasks, Notes & Communication' => [
                    'Create Tasks',
                    'Edit Tasks',
                    'Delete Tasks',
                    'Assign Tasks',
                    'Send Text',
                    'Send Email',
                ],
                'Privacy, Legal & Compliance' => [
                    'View CASL Opt-In Status',
                    'Edit CASL Opt-In Status',
                    'Mark Customers As "Do Not Contact"',
                    'Edit "Do Not Contact" Status',
                    'Export Notes',
                    'Export Task / Appointment',
                ],
                'Group-Level Controls' => [
                    'Access All Rooftops',
                    'Group-Wide Reporting',
                ],
                'Appointments & Calendar' => [
                    'Create Own Appointments',
                    'Edit Own Appointments',
                    'Delete Own Appointments',
                    'Create Appointments For Others',
                    'Edit Appointments For Others',
                    'Delete Appointments For Others',
                    'Access Calendar',
                ],
                'Sales Pipeline' => [
                    'Post To DMS',
                    'Mark Deal As Sold',
                    'Mark Deal As Delivered',
                    'Reopen Deal',
                    'Add Showroom Visit',
                    'Delete Showroom Visit',
                ],
                'Reports & Analytics' => [
                    'Access Reports & Analytics',
                    'Ability To Print And Export Reports',
                    'Schedule Reports',
                    'Delete Schedule Reports',
                ],
                'CRM Configuration' => [
                    'Access To Users',
                    'Reset Password',
                    'Impersonate Users',
                    'Email Required On Lead Creation',
                    'Cell Phone Number Required On Lead Creation',
                    'Work Number Required On Lead Creation',
                    'Phone Number Required On Lead Creation',
                    'Full Name Required On Lead Creation',
                    'Last Name Required On Lead Creation',
                    'Source Required On Lead Creation',
                    'Ability To Export / Print',
                    'Access To Manager\'s Desk Log',
                    'Access To Showroom',
                    'Access To Smart Sequences',
                    'Access To Campaigns & Templates',
                    'Access To Dealership Settings',
                ],
                'Campaigns & Smart Sequences' => [
                    'Access To Campaigns',
                    'Access To Smart Sequence',
                    'Edit Smart Sequences',
                    'Delete Smart Sequences',
                ],
            ];
            
            // Split categories into 3 columns
            $column1 = ['Lead & Customer Management', 'Tasks, Notes & Communication', 'Privacy, Legal & Compliance', 'Group-Level Controls'];
            $column2 = ['Appointments & Calendar', 'Sales Pipeline', 'Reports & Analytics'];
            $column3 = ['CRM Configuration', 'Campaigns & Smart Sequences'];
            @endphp
            
            <div class="row">
              <!-- Column 1 -->
              <div class="col-lg-4 col-md-6 mb-4">
                @foreach($column1 as $categoryName)
                  @if(isset($permissionCategories[$categoryName]))
                    <div class="permission-section mb-4">
                      <h5 class="section-header mb-3">{{ $categoryName }}</h5>
                      @foreach($permissionCategories[$categoryName] as $permissionName)
                        @php
                          $permission = $permissions->firstWhere('name', $permissionName);
                          $safeId = 'perm_' . str_replace([' ', '/', '"', "'", '&'], ['_', '_', '', '', '_'], $permissionName);
                          // Check if editing and user has this permission
                          $isChecked = false;
                          if (isset($user)) {
                              // For editing: check if user has this permission directly
                              $isChecked = $user->hasPermissionTo($permissionName);
                          }
                        @endphp
                        @if($permission)
                          <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="{{ $safeId }}" {{ $isChecked ? 'checked' : '' }} {{ $isReadOnly ? 'disabled' : '' }}>
                            <label class="form-check-label {{ $isReadOnly ? 'text-muted' : '' }}" for="{{ $safeId }}">{{ $permission->name }}</label>
                          </div>
                        @endif
                      @endforeach
                    </div>
                  @endif
                @endforeach
              </div>
        
              <!-- Column 2 -->
              <div class="col-lg-4 col-md-6 mb-4">
                @foreach($column2 as $categoryName)
                  @if(isset($permissionCategories[$categoryName]))
                    <div class="permission-section mb-4">
                      <h5 class="section-header mb-3">{{ $categoryName }}</h5>
                      @foreach($permissionCategories[$categoryName] as $permissionName)
                        @php
                          $permission = $permissions->firstWhere('name', $permissionName);
                          $safeId = 'perm_' . str_replace([' ', '/', '"', "'", '&'], ['_', '_', '', '', '_'], $permissionName);
                          // Check if editing and user has this permission
                          $isChecked = false;
                          if (isset($user)) {
                              // For editing: check if user has this permission directly
                              $isChecked = $user->hasPermissionTo($permissionName);
                          }
                        @endphp
                        @if($permission)
                          <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="{{ $safeId }}" {{ $isChecked ? 'checked' : '' }} {{ $isReadOnly ? 'disabled' : '' }}>
                            <label class="form-check-label {{ $isReadOnly ? 'text-muted' : '' }}" for="{{ $safeId }}">{{ $permission->name }}</label>
                          </div>
                        @endif
                      @endforeach
                    </div>
                  @endif
                @endforeach
              </div>
        
              <!-- Column 3 -->
              <div class="col-lg-4 col-md-12 mb-4">
                @foreach($column3 as $categoryName)
                  @if(isset($permissionCategories[$categoryName]))
                    <div class="permission-section mb-4">
                      <h5 class="section-header mb-3">{{ $categoryName }}</h5>
                      @foreach($permissionCategories[$categoryName] as $permissionName)
                        @php
                          $permission = $permissions->firstWhere('name', $permissionName);
                          $safeId = 'perm_' . str_replace([' ', '/', '"', "'", '&'], ['_', '_', '', '', '_'], $permissionName);
                          // Check if editing and user has this permission
                          $isChecked = false;
                          if (isset($user)) {
                              // For editing: check if user has this permission directly
                              $isChecked = $user->hasPermissionTo($permissionName);
                          }
                        @endphp
                        @if($permission)
                          <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="{{ $safeId }}" {{ $isChecked ? 'checked' : '' }} {{ $isReadOnly ? 'disabled' : '' }}>
                            <label class="form-check-label {{ $isReadOnly ? 'text-muted' : '' }}" for="{{ $safeId }}">{{ $permission->name }}</label>
                          </div>
                        @endif
                      @endforeach
                    </div>
                  @endif
                @endforeach
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="alertSettings">
          <div class="crm-box">
            <div class="crm-header mb-2">Alert Settings<i class="ms-1 isax isax-notification-bing5"></i></div>
            <div class="row">
             
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-check-label">Assigned Manager</label>
                  <select name="assigned_manager" class="form-select" id="assignedManager">
                    <option value="">-- Select Manager --</option>
                    @foreach($allUsers as $manager)
                      <option value="{{ $manager->id }}" {{ isset($user) && $user->assigned_manager == $manager->id ? 'selected' : '' }}>
                        {{ $manager->name }}{{ $manager->title ? ' - ' . $manager->title : '' }}
                      </option>
                    @endforeach
                  </select>
                </div>

                <div class="mb-3">
                  <label class="form-check-label">Assigned BDC Agent</label>
                  <select name="assigned_bdc_agent" class="form-select" id="assignedBDAgent">
                    <option value="">-- Select BDC Agent --</option>
                    @foreach($bdcAgents as $agent)
                      <option value="{{ $agent->id }}" {{ isset($user) && $user->assigned_bdc_agent == $agent->id ? 'selected' : '' }}>
                        {{ $agent->name }}{{ $agent->title ? ' - ' . $agent->title : '' }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <!-- Assigned Service Agent removed per request -->
                <div class="mb-3">
                  <label class="form-check-label">Assigned Finance Manager</label>
                  <select name="assigned_finance_manager" class="form-select" id="assignedFinanceManager">
                    <option value="">-- Select Finance Manager --</option>
                    @foreach($financeManagers as $fm)
                      <option value="{{ $fm->id }}" {{ isset($user) && ($user->assigned_finance_manager ?? null) == $fm->id ? 'selected' : '' }}>
                        {{ $fm->name }}{{ $fm->title ? ' - ' . $fm->title : '' }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-check-label">Employee # in DMS</label>
                  <input type="text" name="employee_number" class="form-control" id="employeeNumber" value="{{ isset($user) ? $user->employee_number : '' }}" placeholder="Enter Employee DMS ID Number Here">
                </div>
                <div class="mb-3">
                  <div class="form-check form-switch">
                    <label class="form-check-label">Receive Internet Lead Or Not:</label>

                    <input name="receive_internet_lead" class="form-check-input" type="checkbox" value="1" {{ isset($user) && $user->receive_internet_lead ? 'checked' : '' }}>
                  </div>
                </div>
               
                <div class="form-check mb-3">
                  <input name="receive_off_hours" type="checkbox" class="form-check-input" id="receiveOffHours" value="1" {{ isset($user) && $user->receive_off_hours ? 'checked' : '' }}>
                  <label class="form-check-label" for="receiveOffHours">Receive during off hours</label>
                </div>
                
               
              </div>
            </div>
          </div>
        </div>
     
      </div>
      
        <!-- Hidden inputs for JavaScript-captured data -->
        <input type="hidden" name="email_signature" id="emailSignatureHidden">
        <input type="hidden" name="working_hours" id="workingHoursHidden">
  
        <div class="d-flex justify-content-between mt-4 mb-4">
          <button type="submit" class="btn btn-primary" id="saveProfile" {{ $isReadOnly ? 'disabled' : '' }}>
            {{ $isSelfEdit ? 'Update My Profile' : 'Save' }}
          </button>
          @if($isEdit)
          <button class="btn btn-light border border-1" type="button" onclick="duplicateCurrentUser()">
            <i class="isax isax-copy me-1"></i>Duplicate This User
          </button>
          @else
          <button class="btn btn-light border border-1" type="button" data-bs-toggle="modal" data-bs-target="#duplicate_modal">Duplicate from Existing</button>
          @endif
        </div>
      </form>
      </div>
    </div>
    
    <div class="modal fade" id="duplicate_modal" tabindex="-1" aria-hidden="true" aria-labelledby="duplicateModalLabel">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="duplicateModalLabel">Duplicate from Existing User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <label for="userSelect" class="form-label">Select User</label>
            <select id="userSelect" class="form-select">
              <option value="" disabled selected>Select a user</option>
              <option value="1">Simon O'Reilly</option>
              <option value="2">Jane Doe</option>
            </select>
          </div>
          <div class="modal-footer">
            <button class="btn btn-light border border-1" data-bs-dismiss="modal" type="button">Cancel</button>
            <button class="btn btn-primary" onclick="performDuplication()" type="button">Duplicate</button>
          </div>
        </div>
      </div>
    </div>

</div>



@endsection




@push('scripts')

<script>
    // Pass current user data to JavaScript for editing
    @if($isEdit && $user)
    const currentUserData = {
        id: {{ $user->id }},
        workingHours: {!! $user->working_hours ? json_encode($user->working_hours) : 'null' !!}
    };
    @else
    const currentUserData = null;
    @endif

    const SAMPLE_DATA = {
                           // Customer Information (Updated as per client request)
                          
                     
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
   assigned_manager_email:'sarahjohnson@gmail.com',
   assigned_manager_work_number:'555-555-6666',
   assigned_manager_cell_number:'555-555-6666',
   
   
   
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
     if (e.key === 'Enter') {
       e.preventDefault();
   
       if (e.shiftKey) {
         this.handleShiftEnter();   // line break (br)
       } else {
         this.handleEnter();        // normal Enter
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
         document.getElementById('btnSave').addEventListener('click', () => this.saveTemplate());
         document.getElementById('btnCancel').addEventListener('click', () => {
           if (confirm('Discard changes?')) window.history.back();
         });
   
         // Initialize toolbar state
         this.updateToolbarState();
       }
   
       handleEnter() {
     // Save formatting state
     const wasBold = this.currentFormatting.bold;
     const wasItalic = this.currentFormatting.italic;
     const wasUnderline = this.currentFormatting.underline;
   
     // Insert a normal block break (behaves like Word)
     document.execCommand('insertHTML', false, '<br><br>');
   
     // Restore formatting
     setTimeout(() => {
       this.currentFormatting.bold = wasBold;
       this.currentFormatting.italic = wasItalic;
       this.currentFormatting.underline = wasUnderline;
   
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
         document.execCommand('insertHTML', true, '<br>');
   
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
   
       generateSubjects(desc) {
         this.showGenerating();
         setTimeout(() => {
           const subjects = [
             `${desc.split(' ').slice(0, 5).join(' ')} - @{{dealer_name}}`,
             `@{{first_name}}, Special Message`,
             `Important Update from @{{dealer_name}}`
           ];
           const content = document.getElementById('aiInputContent');
           content.innerHTML = '<h6 class="mb-3">Generated Subject Lines</h6>' + subjects.map((s, i) =>
             `<div class="ai-option-card" onclick="document.getElementById('tplSubject').value = '${s}'; document.getElementById('aiModal').classList.remove('show');"><div class="d-flex gap-3"><div style="font-size: 24px; color: #8b5cf6;">${i + 1}</div><p class="mb-0">${s}</p></div></div>`
           ).join('');
           document.getElementById('aiGenerating').classList.remove('show');
           document.getElementById('aiInputSection').classList.add('show');
         }, 1500);
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
         document.getElementById('tplSubject').value = template.subject;
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
         let html = `<table style="width: 100%; border-collapse: collapse; margin: 15px 0; border: 1px solid #d1d5db; font-family: Arial, sans-serif;">
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
         document.getElementById('tplSubject').addEventListener('input', () => this.renderPreview());
   
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
   
       saveTemplate() {
         const name = document.getElementById('tplName').value.trim();
         const subject = document.getElementById('tplSubject').value.trim();
         const body = document.getElementById('editor').innerHTML;
         if (!name || !subject) {
           alert('Please fill in all required fields');
           return;
         }
         console.log('Saving:', { name, subject, body });
         this.showToast('Template saved successfully!');
       }
     }
   
     new TemplateBuilder();
   </script>
   
   <script>
     function previewPhoto(event) {
       const input = event.target;
       if (input.files && input.files[0]) {
         const reader = new FileReader();
         reader.onload = function(e) {
           document.getElementById('preview-img').src = e.target.result;
         }
         reader.readAsDataURL(input.files[0]);
       }
     }
     
     const days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
     
     function generateTimeOptions() {
       const times = [];
       const hours = [12, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
   
       hours.forEach(hour => {
         const h = hour.toString().padStart(2, "0");
         times.push(`${h}:00 AM`);
         times.push(`${h}:00 PM`);
         times.push(`${h}:30 AM`);
         times.push(`${h}:30 PM`);
       });
   
       return times;
     }
   
     const timeOptions = generateTimeOptions();
     
     // Password toggle function (global)
     function togglePasswordVisibility() {
       const passwordField = document.getElementById('password');
       const passwordIcon = document.getElementById('passwordIcon');
       
       if (passwordField && passwordIcon) {
         if (passwordField.type === 'password') {
           passwordField.type = 'text';
           passwordIcon.classList.remove('ti-eye');
           passwordIcon.classList.add('ti-eye-off');
         } else {
           passwordField.type = 'password';
           passwordIcon.classList.remove('ti-eye-off');
           passwordIcon.classList.add('ti-eye');
         }
       }
     }
     
     function createWorkingHoursRow(day, containerEl, templateEl) {
       const clone = templateEl.content.cloneNode(true);
       const row = clone.querySelector(".working-hours-row");
       const from = row.querySelector(".from-time");
       const to = row.querySelector(".to-time");
       const dayLabel = row.querySelector(".day-label");
       const copyBtn = row.querySelector(".copy-day-timings");
       
       dayLabel.textContent = day;
       
       timeOptions.forEach(time => {
         const option1 = document.createElement("option");
         option1.textContent = time;
         option1.value = time;
         from.appendChild(option1);
   
         const option2 = document.createElement("option");
         option2.textContent = time;
         option2.value = time;
         to.appendChild(option2);
       });
   
       const offToggle = row.querySelector(".off-toggle");
       if (day === "Sunday") {
         offToggle.checked = true;
         from.disabled = true;
         to.disabled = true;
       }
       
       offToggle.addEventListener("change", function() {
         const disabled = this.checked;
         from.disabled = disabled;
         to.disabled = disabled;
         if (disabled) {
           from.value = "";
           to.value = "";
         }
       });
       
       copyBtn.addEventListener("click", function() {
         const fromTime = from.value;
         const toTime = to.value;
         const isOff = offToggle.checked;
         
         const rows = containerEl.querySelectorAll(".working-hours-row");
         rows.forEach(otherRow => {
           if (otherRow === row) return;
           
           const otherOffToggle = otherRow.querySelector(".off-toggle");
           const otherFrom = otherRow.querySelector(".from-time");
           const otherTo = otherRow.querySelector(".to-time");
           
           otherOffToggle.checked = isOff;
           const changeEvent = new Event('change');
           otherOffToggle.dispatchEvent(changeEvent);
           
           if (!isOff) {
             otherFrom.value = fromTime;
             otherTo.value = toTime;
           }
         });
       });
   
       containerEl.appendChild(clone);
     }
     
     // Initialize CKEditor and working hours when page loads
     document.addEventListener('DOMContentLoaded', function() {
       // Initialize CKEditor
       if (typeof CKEDITOR !== 'undefined') {
         CKEDITOR.replace('email-signature');
       }
       
       // Initialize working hours rows
       const container = document.getElementById("working-hours-container");
       const template = document.getElementById("working-hours-template");
       
       if (container && template && container.children.length === 0) {
         days.forEach(day => createWorkingHoursRow(day, container, template));
         
         // Populate with current user data if editing
         if (typeof currentUserData !== 'undefined' && currentUserData && currentUserData.workingHours) {
           setTimeout(() => {
             const rows = document.querySelectorAll(".working-hours-row");
             const workingHoursArray = currentUserData.workingHours;
             
             rows.forEach(row => {
               const dayLabel = row.querySelector(".day-label")?.textContent;
               const matchingHours = workingHoursArray.find(h => h.day === dayLabel);
               
               if (matchingHours) {
                 const offToggle = row.querySelector(".off-toggle");
                 const fromSelect = row.querySelector(".from-time");
                 const toSelect = row.querySelector(".to-time");
                 
                 if (offToggle && fromSelect && toSelect) {
                   offToggle.checked = matchingHours.off;
                   
                   // Trigger change event
                   const changeEvent = new Event('change');
                   offToggle.dispatchEvent(changeEvent);
                   
                   // Set time values if not off
                   if (!matchingHours.off) {
                     if (matchingHours.from) fromSelect.value = matchingHours.from;
                     if (matchingHours.to) toSelect.value = matchingHours.to;
                   }
                 }
               }
             });
             console.log("Working hours populated from database");
           }, 200);
         }
       }
     });
     
     window.usersData = {
       1: {
           firstName: "Simon",
           lastName: "O'Reilly",
           email: "simon@example.com",
           workPhone: "(123) 456-7890",
           cellPhone: "(987) 654-3210",
           homePhone: "(111) 222-3333",
           photo: "https://randomuser.me/api/portraits/men/75.jpg",
           workingHours: [
               { day: "Monday", off: false, from: "9:00 AM", to: "5:00 PM" },
               { day: "Tuesday", off: false, from: "9:00 AM", to: "5:00 PM" },
               { day: "Wednesday", off: true, from: "", to: "" },
               { day: "Thursday", off: false, from: "9:00 AM", to: "5:00 PM" },
               { day: "Friday", off: false, from: "9:00 AM", to: "3:00 PM" },
               { day: "Saturday", off: true, from: "", to: "" },
               { day: "Sunday", off: true, from: "", to: "" }
           ],
           emailSignature: "<p>Thanks,<br>Simon O'Reilly<br>Sales Manager</p>",
           skipSecurity: true,
           canDeskDeals: true,
           canPushCRM: true,
           noLockout: true,
           markDealsSold: true,
           canUnwindSales: true,
           completeShowroom: true,
           deleteShowroom: true,
           canCopyCustomers: true,
           canEditTasks: true,
           canDismissTasks: true,
           tradeAppraisal: true,
           title: "Sales Manager",
           inventoryAccess: "Account Manager",
           crmAccess: "Admin",
           receiveSalesLeads: true,
           
           // Additional fields that match your HTML
           password: "password123", // Adding password field
           salesTeam: "sales-manager", // Matching sales team
           dealershipFranchise: ["18874", "Twin"], // Multi-select franchise
           viewAllLeadsToggle: true,
           editAllLeadsToggle: true,
           reassignLeads: true,
           mergeLeads: true,
           duplicateLeads: true,
           deleteLead: true,
           deleteCustomer: true,
           createTasks: true,
           editTasks: true,
           deleteTasks: true,
           assignTasks: true,
           sendSMS: true,
           sendEmail: true,
           viewCASL: true,
           editCASL: true,
           markDoNotContact: true,
           editDoNotContact: true,
           exportNotes: true,
           exportTaskAppointment: true,
           accessAllRooftopsToggle: true,
           groupWideReporting: true,
           createOwnAppointments: true,
           editOwnAppointments: true,
           deleteOwnAppointments: true,
           createOthersAppointments: true,
           editOthersAppointments: true,
           deleteOthersAppointments: true,
           viewTeamCalendarToggle: true,
           postToDMS: true,
           markDealSold: true,
           markDealDelivered: true,
           reopenDeal: true,
           showroomVisitAdd: true,
           showroomVisitDelete: true,
           accessReports: true,
           exportReports: true,
           scheduleAutoReports: true,
           deleteScheduleReports: true,
           manageUsers: true,
           resetPasswords: true,
           impersonateUsers: true,
           emailRequired: true,
           cellPhoneRequired: true,
           workPhoneRequired: true,
           phoneRequired: true,
           fullNameRequired: true,
           lastNameRequired: true,
           abilityToExportPrint: true,
           accessManagersDeskLog: true,
           accessToShowroom: true,
           accessToSmartSequences: true,
           accessToCampaignsTemplates: true,
           accessToDealershipSettings: true,
           sourcerequiredsettings:true,
           viewCampaigns: true,
           accessToSmartSequence: true,
           editSmartSequences: true,
           deleteSmartSequences: true,
           assignedManager: "Sticky Round Robin",
           assignedBDAgent: "Sticky Round Robin",
           assignedServiceAgent: "Sticky Round Robin",
           employeeNumber: "EMP001",
           
           receiveOffHours: true
       },
       2: {
           firstName: "Jane",
           lastName: "Doe",
           email: "jane@example.com",
           workPhone: "(555) 123-4567",
           cellPhone: "(555) 987-6543",
           homePhone: "(555) 111-2222",
           photo: "https://randomuser.me/api/portraits/women/65.jpg",
           workingHours: [
               { day: "Monday", off: false, from: "10:00 AM", to: "6:00 PM" },
               { day: "Tuesday", off: false, from: "12:00 PM", to: "6:00 PM" },
               { day: "Wednesday", off: false, from: "1:00 PM", to: "6:00 PM" },
               { day: "Thursday", off: true, from: "", to: "" },
               { day: "Friday", off: false, from: "2:00 PM", to: "5:00 PM" },
               { day: "Saturday", off: true, from: "", to: "" },
               { day: "Sunday", off: true, from: "", to: "" }
           ],
           emailSignature: "<p>Regards,<br>Jane Doe<br>Support Team</p>",
           skipSecurity: true,
           canDeskDeals: false,
           canPushCRM: false,
           noLockout: true,
           markDealsSold: false,
           canUnwindSales: false,
           completeShowroom: true,
           deleteShowroom: false,
           canCopyCustomers: true,
           canEditTasks: true,
           canDismissTasks: true,
           tradeAppraisal: false,
           title: "Support Specialist",
           inventoryAccess: "Limited",
           crmAccess: "Standard",
           receiveSalesLeads: false,
           
           // Additional fields
           password: "password456",
           salesTeam: "support-team",
           dealershipFranchise: ["19345"],
           viewAllLeadsToggle: false,
           editAllLeadsToggle: false,
           reassignLeads: false,
           mergeLeads: false,
           duplicateLeads: false,
           deleteLead: false,
           deleteCustomer: false,
           createTasks: true,
           editTasks: true,
           deleteTasks: false,
           assignTasks: false,
           sendSMS: false,
           sendEmail: true,
           viewCASL: true,
           editCASL: false,
           markDoNotContact: false,
           editDoNotContact: false,
           exportNotes: false,
           exportTaskAppointment: false,
           accessAllRooftopsToggle: false,
           groupWideReporting: false,
           createOwnAppointments: true,
           editOwnAppointments: true,
           deleteOwnAppointments: false,
           createOthersAppointments: false,
           editOthersAppointments: false,
           deleteOthersAppointments: false,
           viewTeamCalendarToggle: true,
           postToDMS: false,
           markDealSold: false,
           markDealDelivered: false,
           reopenDeal: false,
           showroomVisitAdd: true,
           showroomVisitDelete: false,
           accessReports: false,
           exportReports: false,
           scheduleAutoReports: false,
           deleteScheduleReports: false,
           manageUsers: false,
           resetPasswords: false,
           impersonateUsers: false,
           emailRequired: false,
           cellPhoneRequired: false,
           workPhoneRequired: false,
           phoneRequired: false,
           fullNameRequired: true,
           lastNameRequired: true,
           abilityToExportPrint: false,
           accessManagersDeskLog: false,
           accessToShowroom: true,
           accessToSmartSequences: false,
           accessToCampaignsTemplates: false,
           accessToDealershipSettings: false,
           sourcerequiredsettings:true,
           viewCampaigns: false,
           accessToSmartSequence: false,
           editSmartSequences: false,
           deleteSmartSequences: false,
           assignedManager: "Sticky Round Robin",
           assignedBDAgent: "Sticky Round Robin",
           assignedServiceAgent: "Sticky Round Robin",
           employeeNumber: "EMP002",
          
           receiveOffHours: false
       }
   };
   
   function performDuplication() {
       console.log("DEBUG: performDuplication() triggered.");
   
       // Validate userSelect
       const selectEl = document.getElementById("userSelect");
       if (!selectEl) {
           console.error("ERROR: #userSelect not found in DOM.");
           alert("User selection element not found!");
           return;
       }
   
       const userId = selectEl.value;
       console.log("DEBUG: Selected user ID =", userId);
   
       if (!userId) {
           console.warn("WARN: No user selected.");
           alert("Please select a user to duplicate from.");
           return;
       }
   
       if (!window.usersData) {
           console.error("ERROR: usersData object not found.");
           alert("User data not available!");
           return;
       }
   
       if (!usersData[userId]) {
           console.error("ERROR: usersData[userId] undefined for ID:", userId);
           alert("Selected user data not found!");
           return;
       }
   
       const user = usersData[userId];
       console.log("DEBUG: Loaded user object:", user);
   
       try {
           // 1. PERSONAL INFORMATION TAB
           // Basic info fields
           const personalInfoFields = [
               { id: "firstName", value: user.firstName || "" },
               { id: "lastName", value: user.lastName || "" },
               { id: "email", value: user.email || "" },
               { id: "password", value: user.password || "" },
               { id: "workPhone", value: user.workPhone || "" },
               { id: "cellPhone", value: user.cellPhone || "" },
               { id: "homePhone", value: user.homePhone || "" },
               { id: "title", value: user.title || "" }
           ];
   
           personalInfoFields.forEach(field => {
               const el = document.getElementById(field.id);
               if (el) {
                   el.value = field.value;
                   console.log(`DEBUG: Set ${field.id} = ${field.value}`);
               } else {
                   console.warn(`WARN: Field #${field.id} not found in DOM`);
               }
           });
   
           // Sales Team dropdown
           const salesTeamEl = document.getElementById("salesTeam");
           if (salesTeamEl && user.salesTeam) {
               salesTeamEl.value = user.salesTeam;
               console.log(`DEBUG: Set salesTeam = ${user.salesTeam}`);
           }
   
           // Dealership Franchise (multi-select)
           const franchiseEl = document.getElementById("dealershipFranchise");
           if (franchiseEl && user.dealershipFranchise) {
               // Clear existing selections
               Array.from(franchiseEl.options).forEach(option => {
                   option.selected = false;
               });
               
               // Set new selections
               user.dealershipFranchise.forEach(value => {
                   const option = Array.from(franchiseEl.options).find(opt => opt.value === value);
                   if (option) {
                       option.selected = true;
                   }
               });
               console.log(`DEBUG: Set dealershipFranchise = ${user.dealershipFranchise}`);
           }
   
           // Profile Photo
           const imgPreview = document.getElementById("preview-img");
           if (imgPreview && user.photo) {
               imgPreview.src = user.photo;
               console.log("DEBUG: Set profile photo");
           }
   
           // Email Signature - handle both textarea and CKEditor
           const emailSignatureTextarea = document.getElementById("email-signature");
           if (emailSignatureTextarea && user.emailSignature) {
               emailSignatureTextarea.value = user.emailSignature;
               console.log("DEBUG: Set email signature in textarea");
           }
   
           // Handle CKEditor if available
           if (user.emailSignature) {
               setTimeout(() => {
                   try {
                       const editor = CKEDITOR?.instances['email-signature'];
                       if (editor) {
                           editor.setData(user.emailSignature);
                           console.log("DEBUG: Set email signature in CKEditor");
                       } else if (window.CKEDITOR) {
                           // Try to find by other means
                           for (let key in CKEDITOR.instances) {
                               if (CKEDITOR.instances[key]) {
                                   CKEDITOR.instances[key].setData(user.emailSignature);
                                   console.log("DEBUG: Set email signature in CKEditor instance:", key);
                                   break;
                               }
                           }
                       }
                   } catch (e) {
                       console.error("ERROR: Failed to set CKEditor data:", e);
                   }
               }, 300);
           }
   
           // 2. WORKING HOURS
           if (user.workingHours) {
               // Set working hours for each day (rows already created on page load)
               setTimeout(() => {
                   const rows = document.querySelectorAll(".working-hours-row");
                   rows.forEach(row => {
                       const dayLabel = row.querySelector(".day-label")?.textContent;
                       const matchingHours = user.workingHours.find(h => h.day === dayLabel);
                       
                       if (matchingHours) {
                           const offToggle = row.querySelector(".off-toggle");
                           const fromSelect = row.querySelector(".from-time");
                           const toSelect = row.querySelector(".to-time");
                           
                           if (offToggle && fromSelect && toSelect) {
                               // Set off toggle
                               offToggle.checked = matchingHours.off;
                               
                               // Trigger change event to show/hide time selects
                               const changeEvent = new Event('change');
                               offToggle.dispatchEvent(changeEvent);
                               
                               // Set time values if not off
                               if (!matchingHours.off) {
                                   if (matchingHours.from) {
                                       const fromOption = Array.from(fromSelect.options)
                                           .find(opt => opt.text === matchingHours.from || opt.value === matchingHours.from);
                                       if (fromOption) fromSelect.value = fromOption.value;
                                   }
                                   if (matchingHours.to) {
                                       const toOption = Array.from(toSelect.options)
                                           .find(opt => opt.text === matchingHours.to || opt.value === matchingHours.to);
                                       if (toOption) toSelect.value = toOption.value;
                                   }
                               }
                           }
                       }
                   });
                   console.log("DEBUG: Working hours set");
               }, 200);
           }
   
           // 3. PERMISSIONS TAB
           // Define all permission checkboxes
           const permissionCheckboxes = [
               "skipSecurity", "canDeskDeals", "canPushCRM", "noLockout", "markDealsSold",
               "canUnwindSales", "completeShowroom", "deleteShowroom", "canCopyCustomers",
               "canEditTasks", "canDismissTasks", "tradeAppraisal", "receiveSalesLeads",
               "viewAllLeadsToggle", "editAllLeadsToggle", "reassignLeads", "mergeLeads",
               "duplicateLeads", "deleteLead", "deleteCustomer", "createTasks", "editTasks",
               "deleteTasks", "assignTasks", "sendSMS", "sendEmail", "viewCASL", "editCASL",
               "markDoNotContact", "editDoNotContact", "exportNotes", "exportTaskAppointment",
               "accessAllRooftopsToggle", "groupWideReporting", "createOwnAppointments",
               "editOwnAppointments", "deleteOwnAppointments", "createOthersAppointments",
               "editOthersAppointments", "deleteOthersAppointments", "viewTeamCalendarToggle",
               "postToDMS", "markDealSold", "markDealDelivered", "reopenDeal", "showroomVisitAdd",
               "showroomVisitDelete", "accessReports", "exportReports", "scheduleAutoReports",
               "deleteScheduleReports", "manageUsers", "resetPasswords", "impersonateUsers",
               "emailRequired", "cellPhoneRequired", "workPhoneRequired", "phoneRequired",
               "fullNameRequired", "lastNameRequired", "abilityToExportPrint", "accessManagersDeskLog",
               "accessToShowroom", "accessToSmartSequences", "accessToCampaignsTemplates",
               "accessToDealershipSettings","sourcerequiredsettings", "viewCampaigns", "accessToSmartSequence",
               "editSmartSequences", "deleteSmartSequences"
           ];
   
           permissionCheckboxes.forEach(id => {
               const el = document.getElementById(id);
               if (el && el.type === "checkbox") {
                   el.checked = !!user[id];
                   console.log("DEBUG: Set " + id + " = " + !!user[id]);
               }
           });
   
           // Dropdown permissions
           const inventoryEl = document.getElementById("inventoryAccess");
           if (inventoryEl && user.inventoryAccess) {
               inventoryEl.value = user.inventoryAccess;
           }
   
           const crmEl = document.getElementById("crmAccess");
           if (crmEl && user.crmAccess) {
               crmEl.value = user.crmAccess;
           }
   
           // 4. ALERT SETTINGS TAB
           const alertFields = [
               { id: "assignedManager", value: user.assignedManager || "" },
               { id: "assignedBDAgent", value: user.assignedBDAgent || "" },
               { id: "assignedServiceAgent", value: user.assignedServiceAgent || "" },
               { id: "employeeNumber", value: user.employeeNumber || "" }
              
           ];
   
           alertFields.forEach(field => {
               const el = document.getElementById(field.id);
               if (el) {
                   el.value = field.value;
                   console.log(`DEBUG: Set ${field.id} = ${field.value}`);
               }
           });
   
           // Receive off hours checkbox
           const receiveOffHoursEl = document.getElementById("receiveOffHours");
           if (receiveOffHoursEl) {
               receiveOffHoursEl.checked = !!user.receiveOffHours;
           }
   
           // 5. Close modal
           setTimeout(() => {
               try {
                   const modalElement = document.getElementById('duplicate_modal');
                   if (modalElement) {
                       const modal = bootstrap.Modal.getInstance(modalElement);
                       if (modal) {
                           modal.hide();
                           console.log("DEBUG: Modal closed successfully");
                       } else {
                           // Create new instance if not exists
                           const bsModal = new bootstrap.Modal(modalElement);
                           bsModal.hide();
                       }
                   }
               } catch (e) {
                   console.error("ERROR: Failed to close modal:", e);
               }
           }, 500);
   
           // Show success message
           alert(`Successfully duplicated settings from ${user.firstName} ${user.lastName}`);
           console.log("DEBUG: performDuplication() completed successfully");
   
       } catch (error) {
           console.error("ERROR: Exception in performDuplication:", error);
           alert("An error occurred while duplicating user settings. Please check console for details.");
       }
   }
   
     document.getElementById("saveProfile").addEventListener("click", function(e) {
       e.preventDefault();
       
       // Capture email signature HTML from the editor
       const editor = document.getElementById("editor");
       if (editor) {
         document.getElementById("emailSignatureHidden").value = editor.innerHTML;
       }
       
       // Capture working hours data
       const workingHoursData = getWorkingHoursData();
       if (workingHoursData) {
         document.getElementById("workingHoursHidden").value = JSON.stringify(workingHoursData);
       }
       
       // Get the form
       const form = document.getElementById("profileForm");
       const formData = new FormData(form);
       
       // Show loading
       const saveBtn = document.getElementById("saveProfile");
       const originalText = saveBtn.innerHTML;
       saveBtn.disabled = true;
       saveBtn.innerHTML = '<i class="fa fa-spinner fa-spin me-2"></i>Saving...';
       
       // Submit via AJAX
       fetch(form.action, {
         method: 'POST',
         body: formData,
         headers: {
           'X-Requested-With': 'XMLHttpRequest'
         }
       })
       .then(response => {
         if (!response.ok && response.status === 422) {
           // Validation errors
           return response.json().then(err => {
             throw { validation: true, errors: err.errors };
           });
         }
         return response.json();
       })
       .then(data => {
         saveBtn.disabled = false;
         saveBtn.innerHTML = originalText;
         
         if (data.success) {
           Swal.fire({
             icon: 'success',
             title: 'Success!',
             text: data.message,
             timer: 2000,
             showConfirmButton: false,
             toast: true,
             position: 'top-end'
           }).then(() => {
             window.location.href = data.redirect || '{{ route("users") }}';
           });
         } else {
           Swal.fire({
             icon: 'error',
             title: 'Error!',
             text: data.message || 'Failed to save user',
             confirmButtonColor: 'rgb(0, 33, 64)'
           });
         }
       })
       .catch(error => {
         saveBtn.disabled = false;
         saveBtn.innerHTML = originalText;
         
         if (error.validation) {
           // Show validation errors
           let errorMsg = 'Please fix the following errors:\\n\\n';
           for (let field in error.errors) {
             errorMsg += '• ' + error.errors[field].join(', ') + '\\n';
           }
           Swal.fire({
             icon: 'error',
             title: 'Validation Error!',
             text: errorMsg,
             confirmButtonColor: 'rgb(0, 33, 64)'
           });
         } else {
           Swal.fire({
             icon: 'error',
             title: 'Error!',
             text: 'An error occurred. Please try again.',
             confirmButtonColor: 'rgb(0, 33, 64)'
           });
         }
       });
     });
     
     function getWorkingHoursData() {
       const container = document.getElementById("working-hours-container");
       if (!container) return null;
       
       const rows = container.querySelectorAll(".working-hours-row");
       const hoursData = [];
       
       rows.forEach(row => {
         const dayLabel = row.querySelector(".day-label");
         const offToggle = row.querySelector(".off-toggle");
         const fromTime = row.querySelector(".from-time");
         const toTime = row.querySelector(".to-time");
         
         if (dayLabel && offToggle && fromTime && toTime) {
           hoursData.push({
             day: dayLabel.textContent,
             off: offToggle.checked,
             from: fromTime.value,
             to: toTime.value
           });
         }
       });
       
       return hoursData;
     }
     
     // Function to duplicate the current user being edited
     function duplicateCurrentUser() {
       @if($isEdit && $user)
       Swal.fire({
         title: 'Duplicate User?',
         text: "You're about to duplicate {{ $user->name }}. This will create a new user with the same details before saving.",
         icon: 'info',
         showCancelButton: true,
         confirmButtonText: 'Yes, duplicate it!',
         cancelButtonText: 'Cancel',
         confirmButtonColor: 'rgb(0, 33, 64)',
         reverseButtons: true
       }).then((result) => {
         if (result.isConfirmed) {
           window.location.href = "{{ route('add-user') }}?duplicate={{ $user->id }}";
         }
       });
       @endif
     }
   </script>
   
   <script>
   
         // Initialize CKEditor only once
         if (typeof CKEDITOR !== 'undefined' && !CKEDITOR.instances.mytextarea) {
           CKEDITOR.replace('email-signature', {
               toolbar: [
                   { name: 'document', items: ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates'] },
                   { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'] },
                   { name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt'] },
                   { name: 'forms', items: ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'] },
                   '/',
                   { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat'] },
                   { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language'] },
                   { name: 'links', items: ['Link', 'Unlink', 'Anchor'] },
                   { name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe'] },
                   '/',
                   { name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
                   { name: 'colors', items: ['TextColor', 'BGColor'] },
                   { name: 'tools', items: ['Maximize', 'ShowBlocks'] },
                   { name: 'about', items: ['About'] }
               ],
               extraPlugins: 'uploadimage',
               uploadUrl: '/upload-image',
               filebrowserUploadUrl: '/upload-image',
               filebrowserImageUploadUrl: '/upload-image',
               image_previewText: ' ',
               removeDialogTabs: 'image:advanced;image:Link',
               extraAllowedContent: 'img[width,height,alt,src]{max-width,responsive}'
           });
       }
   
   </script>


<script>
  
    // ===== EMAIL SIGNATURE EDITOR WITH HTML TOGGLE =====
    class EmailSignatureEditor {
      constructor() {
        const sigHtmlToggle = document.getElementById('sigHtmlToggle');
        const emailSigEditor = document.getElementById('emailSignatureEditor');
        const sigHtmlEditor = document.getElementById('sigHtmlEditor');
        const sigEditorWrapper = document.getElementById('sigEditorWrapper');
        
        this.isHtmlMode = false;
        
        if (!sigHtmlToggle || !emailSigEditor) return; // Skip if elements don't exist
        
        this.htmlToggleBtn = sigHtmlToggle;
        this.editor = emailSigEditor;
        this.htmlEditor = sigHtmlEditor;
        this.editorWrapper = sigEditorWrapper;
        
        this.init();
      }
  
      init() {
        this.htmlToggleBtn.addEventListener('click', () => this.toggleHtmlMode());
  
        // Field items for token insertion in signature
        document.querySelectorAll('.field-item').forEach(item => {
          item.addEventListener('click', () => {
            if (this.isHtmlMode && this.htmlEditor) {
              const token = `@{{${item.dataset.token}}}`;
              this.htmlEditor.value += ' ' + token;
              this.htmlEditor.focus();
            } else {
              this.insertTokenToSignature(item.dataset.token);
            }
          });
        });
      }
  
      toggleHtmlMode() {
        if (!this.isHtmlMode) {
          this.htmlEditor.value = this.editor.innerHTML;
          this.editorWrapper.classList.add('html-mode');
          this.htmlEditor.classList.add('show');
          this.htmlToggleBtn.classList.add('active');
          this.isHtmlMode = true;
        } else {
          this.editor.innerHTML = this.htmlEditor.value;
          this.editorWrapper.classList.remove('html-mode');
          this.htmlEditor.classList.remove('show');
          this.htmlToggleBtn.classList.remove('active');
          this.isHtmlMode = false;
        }
      }
  
      insertTokenToSignature(tokenName) {
        this.editor.focus();
        const token = document.createElement('span');
        token.className = 'token';
        token.textContent = `@{{${tokenName}}}`;
        
        const selection = window.getSelection();
        if (selection.rangeCount > 0) {
          const range = selection.getRangeAt(0);
          range.insertNode(token);
          range.setStartAfter(token);
          range.collapse(true);
          selection.removeAllRanges();
          selection.addRange(range);
        }
      }
    }
  
    document.addEventListener('DOMContentLoaded', () => {
      new EmailSignatureEditor();
    });
    // ===== END EMAIL SIGNATURE EDITOR =====
  
    new TomSelect("#dealershipFranchise", {
      plugins: ['remove_button'],
      placeholder: "Select Dealership Franchise(s)",
      maxItems: null, // allow multiple
      render: {
        option: function(data, escape) {
          return `
            <div class="d-flex align-items-center">
              <input type="checkbox" class="form-check-input me-2" />
              <span>${escape(data.text)}</span>
            </div>
          `;
        },
        item: function(data, escape) {
          return `<div>${escape(data.text)}</div>`;
        }
      },
      onItemAdd: function(value, item) {
        let optionEl = this.getOption(value).querySelector('input[type="checkbox"]');
        if(optionEl) optionEl.checked = true;
      },
      onItemRemove: function(value) {
        let optionEl = this.getOption(value).querySelector('input[type="checkbox"]');
        if(optionEl) optionEl.checked = false;
      }
    });
    // ===== EMAIL SIGNATURE COMPLETE FIX V2 =====
    
    // Store last cursor position globally
    let lastCursorPosition = null;
    let lastEditorElement = null;
    
    // Save cursor position function
    function saveCursorPosition() {
      const editor = document.getElementById("editor");
      if (!editor) return;
      
      const selection = window.getSelection();
      if (selection.rangeCount > 0) {
        lastCursorPosition = selection.getRangeAt(0).cloneRange();
        lastEditorElement = selection.anchorNode;
      }
    }
    
    // Category Toggle Functionality - FIXED for all dropdowns
    function initCategoryToggles() {
      document.querySelectorAll(".category-header").forEach(header => {
        header.style.cursor = "pointer";
        
        // Remove any existing event listeners first
        const newHeader = header.cloneNode(true);
        header.parentNode.replaceChild(newHeader, header);
        
        newHeader.addEventListener("click", function(e) {
          e.preventDefault();
          e.stopPropagation();
          
          const categoryBody = this.nextElementSibling;
          const chevron = this.querySelector(".bi-chevron-down, .bi-chevron-up");
          
          // Check if this category is currently open
          const isCurrentlyOpen = categoryBody && categoryBody.style.display === "block";
          
          // Close all categories first
          document.querySelectorAll(".category-body").forEach(body => {
            body.style.display = "none";
            body.classList.remove("show");
          });
          
          // Reset all chevrons to down
          document.querySelectorAll(".category-header .bi").forEach(icon => {
            if (icon.classList.contains("bi-chevron-up")) {
              icon.classList.remove("bi-chevron-up");
              icon.classList.add("bi-chevron-down");
            }
          });
          
          // If the clicked category was closed, open it
          if (!isCurrentlyOpen && categoryBody) {
            categoryBody.style.display = "block";
            categoryBody.classList.add("show");
            if (chevron) {
              chevron.classList.remove("bi-chevron-down");
              chevron.classList.add("bi-chevron-up");
            }
          }
        });
      });
      
      // Open first category by default
      // const firstCategoryBody = document.querySelector(".category-body");
      // if (firstCategoryBody) {
      //   firstCategoryBody.style.display = "block";
      //   firstCategoryBody.classList.add("show");
      //   const firstChevron = firstCategoryBody.previousElementSibling?.querySelector(".bi-chevron-down");
      //   if (firstChevron) {
      //     firstChevron.classList.remove("bi-chevron-down");
      //     firstChevron.classList.add("bi-chevron-up");
      //   }
      // }
    }
  
    // Field Item Insertion - FIXED to insert at cursor position and prevent duplicates
    function initFieldInsertion() {
      // Save cursor position when editor changes
      const editor = document.getElementById("editor");
      if (editor) {
        // Track cursor position
        editor.addEventListener("click", saveCursorPosition);
        editor.addEventListener("keyup", saveCursorPosition);
        editor.addEventListener("focus", saveCursorPosition);
        
        // Prevent losing focus when clicking field items
        editor.addEventListener("blur", function(e) {
          // Save position before blur
          saveCursorPosition();
        });
      }
      
      document.querySelectorAll(".field-item").forEach(item => {
        item.style.cursor = "pointer";
        
        // Remove any existing event listeners by cloning the node
        const newItem = item.cloneNode(true);
        item.parentNode.replaceChild(newItem, item);
        
        // Add a flag to prevent double execution
        let isProcessing = false;
        
        newItem.addEventListener("mousedown", function(e) {
          // Prevent default to not lose editor focus
          e.preventDefault();
          e.stopPropagation();
        });
        
        newItem.addEventListener("click", function(e) {
          e.preventDefault();
          e.stopPropagation();
          e.stopImmediatePropagation();
          
          // Prevent double execution
          if (isProcessing) return;
          isProcessing = true;
          
          const token = this.dataset.token;
          const editor = document.getElementById("editor");
          
          if (editor && token) {
            // Focus back on editor
            editor.focus();
            
            const selection = window.getSelection();
            let range;
            
            // Try to use saved position
            if (lastCursorPosition && lastEditorElement) {
              try {
                selection.removeAllRanges();
                selection.addRange(lastCursorPosition);
                range = lastCursorPosition;
              } catch (e) {
                // If saved position fails, get current position
                if (selection.rangeCount > 0) {
                  range = selection.getRangeAt(0);
                } else {
                  range = document.createRange();
                  range.selectNodeContents(editor);
                  range.collapse(false);
                }
              }
            } else if (selection.rangeCount > 0) {
              range = selection.getRangeAt(0);
            } else {
              // Default to end of editor
              range = document.createRange();
              range.selectNodeContents(editor);
              range.collapse(false);
            }
            
            // Insert the token as plain text with formatting
            const tokenText = "{{" + token + "}} ";
            
            // Use execCommand for better compatibility - only once
            document.execCommand("insertText", false, tokenText);
            
            // Update preview
            updateLivePreview();
            
            // Visual feedback
            this.style.backgroundColor = "#8b5cf6";
            this.style.color = "white";
            this.style.transform = "scale(0.95)";
            setTimeout(() => {
              this.style.backgroundColor = "";
              this.style.color = "";
              this.style.transform = "";
              // Reset the processing flag after animation
              isProcessing = false;
            }, 200);
            
            // Save new position
            saveCursorPosition();
          } else {
            // Reset flag if no token
            isProcessing = false;
          }
        });
      });
    }
  
    // Update Live Preview - FIXED to show proper text without green styling
    function updateLivePreview() {
      const editor = document.getElementById("editor");
      const preview = document.getElementById("liveSignaturePreview");
      
      if (!editor || !preview) return;
      
      // Get the HTML content
      let content = editor.innerHTML;
      
      // Complete sample data for all fields
      const sampleData = {
        "first_name": "John",
        "last_name": "Doe",
        "email": "john.doe@example.com",
        "alt_email": "johndoe@gmail.com",
        "cell_phone": "(555) 123-4567",
        "work_phone": "(555) 987-6543",
        "home_phone": "(555) 555-5555",
        "street_address": "123 Main Street",
        "city": "Toronto",
        "province": "Ontario",
        "postal_code": "M5V 3A8",
        "country": "Canada",
        "year": "2024",
        "make": "Toyota",
        "model": "Camry",
        "vin": "1HGBH41JXMN109186",
        "stock_number": "STK-2024-001",
        "selling_price": "$35,999",
        "internet_price": "$34,499",
        "kms": "15,000",
        "dealer_name": "Primus Motors",
        "dealer_phone": "1-800-PRIMUS-1",
        "dealer_address": "456 Dealership Ave, Toronto, ON",
        "dealer_email": "info@primusmotors.com",
        "dealer_website": "www.primusmotors.com",
        "tradein_year": "2020",
        "tradein_make": "Honda",
        "tradein_model": "Civic",
        "tradein_vin": "2HGFC2F59LH123456",
        "tradein_allowance": "$15,000",
        "tradein_kms": "60,000",
        "advisor_name": "Michael Smith",
        "advisor_email": "msmith@primusmotors.com",
        "advisor_phone": "(555) 123-7890",
        "advisor_title": "Sales Manager",
        "today_date": new Date().toLocaleDateString("en-US", { month: "long", day: "numeric", year: "numeric" }),
        "appointment_date": new Date(Date.now() + 7*24*60*60*1000).toLocaleDateString("en-US", { month: "long", day: "numeric", year: "numeric" }),
        "appointment_time": "2:00 PM"
      };
      
      content = content.replace(
        /<span[^>]*class="[^"]*\btoken\b[^"]*"[^>]*>\s*(@{{[\s\S]+?}})\s*<\/span>/gi,
        function(match, p1) {
            // remove the @ used to escape Blade
            return p1.replace(/^@/, '');
        }
    );

    // Then replace all tokens with actual values (no green styling)
    content = content.replace(/@{{([^}]+)}}/g, function(match, token) {
        var key = token.trim();
        var value = sampleData[key];
        return value || "";
    });
      
      // Set the preview content
      preview.innerHTML = content;
      
      // Copy any formatting styles from editor
      preview.style.fontSize = window.getComputedStyle(editor).fontSize;
      preview.style.fontFamily = window.getComputedStyle(editor).fontFamily;
      preview.style.lineHeight = window.getComputedStyle(editor).lineHeight;
    }
  
    // Create preview section
    function createLivePreview() {
      const editorContainer = document.querySelector(".editor-container");
      if (!editorContainer || document.getElementById("liveSignaturePreview")) return;
      
      const previewHtml = `<div style="margin-top: 20px; border: 1px solid #e1e5eb; border-radius: 8px; overflow: hidden;"><div style="background: var(--cf-primary); padding: 12px 16px; display: flex; justify-content: space-between; align-items: center;"><div style="color: white; font-weight: 600; font-size: 14px;"><i class="bi bi-eye me-2"></i>Live Email Signature Preview</div><div class="device-toggle"><button class="desktop-btn active" type="button" onclick="setPreviewMode('desktop')" style="background: white; color: #667eea; padding: 6px 10px; margin-left: 4px; border-radius: 4px; border: none; cursor: pointer;"><i class="bi bi-laptop"></i></button><button type="button" class="mobile-btn" onclick="setPreviewMode('mobile')" style="padding: 6px 10px; margin-left: 4px; border-radius: 4px; border: 1px solid rgba(255,255,255,0.3); background: rgba(255,255,255,0.2); color: white; cursor: pointer;"><i class="bi bi-phone"></i></button></div></div><div style="background: #f8f9fa; padding: 20px; min-height: 200px;"><div id="previewContent" style="background: white; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); transition: all 0.3s ease;"><div id="liveSignaturePreview" style="font-family: Arial, sans-serif; font-size: 14px; line-height: 1.6; color: #333;"></div></div></div></div>`;
      
      const previewContainer = document.createElement("div");
      previewContainer.innerHTML = previewHtml;
      editorContainer.parentNode.insertBefore(previewContainer, editorContainer.nextSibling);
      
      updateLivePreview();
    }
  
    window.setPreviewMode = function(mode) {
      const previewContent = document.getElementById("previewContent");
      const desktopBtn = document.querySelector(".desktop-btn");
      const mobileBtn = document.querySelector(".mobile-btn");
      
      if (mode === "mobile") {
        previewContent.style.maxWidth = "375px";
        previewContent.style.margin = "0 auto";
        mobileBtn.style.background = "white";
        mobileBtn.style.color = "#667eea";
        desktopBtn.style.background = "rgba(255,255,255,0.2)";
        desktopBtn.style.color = "white";
      } else {
        previewContent.style.maxWidth = "";
        previewContent.style.margin = "";
        desktopBtn.style.background = "white";
        desktopBtn.style.color = "#667eea";
        mobileBtn.style.background = "rgba(255,255,255,0.2)";
        mobileBtn.style.color = "white";
      }
    };
  
    // Initialize on DOM ready
    function initEmailSignature() {
      initCategoryToggles();
      initFieldInsertion();
      createLivePreview();
      
      const editor = document.getElementById("editor");
      if (editor) {
        editor.addEventListener("input", updateLivePreview);
        editor.addEventListener("keyup", updateLivePreview);
        editor.addEventListener("paste", () => setTimeout(updateLivePreview, 100));
        
        // Load user's email signature when editing
        @if($isEdit && $user && $user->email_signature)
        setTimeout(function() {
          editor.innerHTML = {!! json_encode($user->email_signature) !!};
          updateLivePreview();
        }, 150);
        @endif
      }
    }
  
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", initEmailSignature);
    } else {
      setTimeout(initEmailSignature, 100);
    }
    // ===== END EMAIL SIGNATURE FIX =====
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
      document.getElementById('sigBold').addEventListener('click', function(e) {
        e.preventDefault();
        document.execCommand('bold', false, null);
        signatureEditor.focus();
      });
  
      document.getElementById('sigItalic').addEventListener('click', function(e) {
        e.preventDefault();
        document.execCommand('italic', false, null);
        signatureEditor.focus();
      });
  
      document.getElementById('sigUnderline').addEventListener('click', function(e) {
        e.preventDefault();
        document.execCommand('underline', false, null);
        signatureEditor.focus();
      });
  
      document.getElementById('sigFontFamily').addEventListener('change', function() {
        document.execCommand('fontName', false, this.value);
        signatureEditor.focus();
      });
  
      document.getElementById('sigFontSize').addEventListener('change', function() {
        document.execCommand('fontSize', false, this.value);
        signatureEditor.focus();
      });
    });
  </script>
  <script>
    // Add this to your TemplateBuilder class or as a standalone script
  document.addEventListener('DOMContentLoaded', function() {
    const btnHtmlMode = document.getElementById('btnHtmlMode');
    const editor = document.getElementById('editor');
    const htmlTextarea = document.getElementById('htmlTextarea');
    const editorWrapper = document.querySelector('.editor-wrapper');
    
    if (!btnHtmlMode || !editor || !htmlTextarea || !editorWrapper) {
      console.error('Required elements not found');
      return;
    }
  
    let isHtmlMode = false;
  
    btnHtmlMode.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      
      isHtmlMode = !isHtmlMode;
  
      if (isHtmlMode) {
        // Switch TO HTML mode
        console.log('Switching to HTML mode');
        
        // Copy current content to textarea
        htmlTextarea.value = editor.innerHTML;
        
        // Hide visual editor
        editorWrapper.style.display = 'none';
        
        // Show HTML textarea
        htmlTextarea.style.display = 'block';
        
        // Update button state
        btnHtmlMode.classList.add('active');
        btnHtmlMode.title = 'Switch to Visual Editor';
        
      } else {
        // Switch BACK to visual mode
        console.log('Switching to Visual mode');
        
        // Update editor with HTML from textarea
        editor.innerHTML = htmlTextarea.value;
        
        // Show visual editor
        editorWrapper.style.display = 'block';
        
        // Hide HTML textarea
        htmlTextarea.style.display = 'none';
        
        // Update button state
        btnHtmlMode.classList.remove('active');
        btnHtmlMode.title = 'Edit HTML / Switch to HTML mode';
        
        // Trigger preview update if you have one
        if (typeof window.templateBuilder !== 'undefined' && window.templateBuilder.renderPreview) {
          window.templateBuilder.renderPreview();
        }
      }
    });
  });
  </script>
    
@endpush


@push('styles')
<style>
    .editor img.selected {
      outline: 3px solid #8b5cf6;
      outline-offset: 2px
    }

    .device-toggle button i {
      font-size: 16px
    }

    input[type="text"] {
      font-size: 11px;
      border-width: 1.5px !important;
      padding: 4px 6px;
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
.page-wrapper{
  background-color: #fff;
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
      background: var(--bg);
      font-family: "Inter";
    }

    .app {
      min-height: 100vh;
    }

    .card {
      border: 1px solid var(--ring);
      box-shadow: 0 2px 8px rgba(0, 0, 0, .08);
      background: white;
    }

    .template-header {
      position: sticky;
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
p{
margin-bottom:0px !important;}
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
  /* HTML Mode Styles */
  .html-textarea {
display: none;
width: 100%;
min-height: 500px;
padding: 12px;
font-family: 'Courier New', monospace;
font-size: 12px;
border: 2px solid #002140;
background: #f8f9fa;
border-radius: 4px;
resize: vertical;
}

.html-textarea.active,
.html-textarea[style*="display: block"] {
display: block !important;
}

#btnHtmlMode.active {
background: #002140;
color: white;
border-color: #001a2e;
}
                    #btnHtmlMode {
                      color: #002140;
                      position: relative;
                    }

                    #btnHtmlMode:hover {
                      background: #002140;
                      color: white;
                      border-color: #001a2e;
                    }

                    #btnHtmlMode.active {
                      background: #002140;
                      color: white;
                      border-color: #001a2e;
                    }

                    /* Hide editor when in HTML mode */
                    .editor-wrapper.html-mode {
                      display: none;
                    }

                    .html-textarea.active {
                      display: block !important;
                    }

                    .preview-container.html-mode {
                      display: none;
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

    /* HTML Toggle Feature - START */
    .html-toggle-btn {
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
      margin-left: 4px;
    }

    .html-toggle-btn:hover {
      background: #e5e7eb;
      border-color: #d1d5db;
    }

    .html-toggle-btn.active {
      background-color: #e9ecef;
      border-color: #6c757d;
      color: #495057;
    }

    .html-edit-textarea {
      display: none;
      width: 100%;
      min-height: 500px;
      border: 1px solid #d1d5db;
      border-radius: 0 0 6px 6px;
      font-family: 'Courier New', monospace;
      font-size: 13px;
      padding: 15px;
      background: #f8f9fa;
      resize: vertical;
      overflow-y: auto;
    }

    .html-edit-textarea.show {
      display: block;
    }

    .editor-wrapper.html-mode {
      display: none;
    }
    /* HTML Toggle Feature - END */

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
  <style>


.ts-wrapper.form-control, .ts-wrapper.form-select {
    box-shadow: none;
    display: flex;
    height: auto;
    padding: 0 !important;
}
.ts-wrapper.form-control:not(.disabled) .ts-control, .ts-wrapper.form-control:not(.disabled).single.input-active .ts-control, .ts-wrapper.form-select:not(.disabled) .ts-control, .ts-wrapper.form-select:not(.disabled).single.input-active .ts-control {
    background: transparent !important;
    border: none !important
}
</style>
@endpush