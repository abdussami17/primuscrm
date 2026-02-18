@extends('layouts.app')


@section('title','Smart Sequence')


@section('content')
<div class="content content-two pt-0">
    <!-- Page Header -->
    <div class="position-relative d-flex align-items-center justify-content-between flex-wrap gap-3 mb-2"
      style="min-height: 80px;">
      <!-- Left: Title -->
      <div>
        <h6 class="mb-0">Smart Sequence</h6>
      </div>

      <!-- Center: Logo -->
      <img src="assets/light_logo.png" alt="Logo" class="mobile-logo-no logo-img"
        style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); max-width: 80px; height: auto;">

      <!-- Right: Buttons -->
      <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
        <!-- Trigger Button -->
        <button class="btn btn-light border border-1">
          <i class="isax isax-printer me-1"></i>
          Print
        </button>
        <div class="dropdown">
          <a href="javascript:void(0);" class="btn btn-outline-white d-inline-flex align-items-center"
            data-bs-toggle="dropdown">
            <i class="isax isax-export-1 me-1"></i>Export
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">PDF</a></li>
            <li><a class="dropdown-item" href="#">Excel (XLSX)</a></li>
            <li><a class="dropdown-item" href="#">Excel (CSV)</a></li>
          </ul>
        </div>

        <div>
          <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#addSmartSequenceModal"
            class="btn btn-primary d-flex align-items-center">
            <i class="isax isax-add-circle me-2"></i>Create Sequence
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
          
        </div>
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
            <th>Sequence Name</th>
            <th>Status</th>
            <th>Created By</th>
            <th>Created On</th>
            <th>Last Sent</th>
            <th>Sent</th>
            <th>Bounced</th>
            <th>Invalid</th>
            <th>CASL Restricted</th>
            <th>Appointments</th>
            <th>Unsubscribed</th>
            <th>Delivered</th>
            <th>Opened</th>
            <th>Clicked</th>
            <th>Replied</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <div class="form-check form-check-md">
                <input class="form-check-input" type="checkbox">
              </div>
            </td>
            <td>Test campaign</td>
            <td>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="toggle-1"
                  data-bs-toggle="tooltip" data-bs-title="Inactive" title="Inactive">
              </div>
            </td>
            <td>Alexandre Pizon</td>
            <td>Jan 29, 2024 1:03 PM</td>
            <td>Jan 30, 2024</td>
            <td>2</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>1</td>
            <td>0</td>
            <td>2</td>
            <td>1</td>
            <td>0</td>
            <td>0</td>
          </tr>
          <tr>
            <td>
              <div class="form-check form-check-md">
                <input class="form-check-input" type="checkbox">
              </div>
            </td>
            <td>1st Year Anniversary</td>
            <td>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="toggle-2"
                  data-bs-toggle="tooltip" data-bs-title="Active" title="Active" checked>
              </div>
            </td>
            <td>Primus CRM</td>
            <td>Sept 5, 2025 3:03 PM</td>
            <td>Sept 10, 2025</td>
            <td>12</td>
            <td>0</td>
            <td>1</td>
            <td>2</td>
            <td>1</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
          </tr>
        </tbody>
      </table>
    </div>
    

    <script>
      document.addEventListener('DOMContentLoaded', function () {
        // Initialize Bootstrap tooltips for toggle switches
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('.form-check-input[type="checkbox"][data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Update tooltip text on toggle change
        document.querySelectorAll('.form-check-input[type="checkbox"][data-bs-toggle="tooltip"]').forEach(function (toggle) {
          toggle.addEventListener('change', function () {
            const isActive = this.checked;
            const newTitle = isActive ? 'Active' : 'Inactive';

            // Update both data-bs-title and title attributes
            this.setAttribute('data-bs-title', newTitle);
            this.setAttribute('title', newTitle);

            // Get the tooltip instance and update it
            const tooltip = bootstrap.Tooltip.getInstance(this);
            if (tooltip) {
              // Update tooltip content
              tooltip.setContent({ '.tooltip-inner': newTitle });
            }
          });
        });
      });
    </script>
  </div>




  
  <!-- Email Modal -->
  <div id="addSmartSequenceModal" class="modal fade">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="crm-header model-crm-header d-flex justify-content-between align-items-center">
          Create Smart Sequence
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
                    <input type="text" id="sequence-title" class="form-control">
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
                <div id="criteria-container"></div>
                <div class="mt-3">
                  <button class="add-criteria-button" id="addCriteriaBtn">+ Criteria</button>
                  <button class="add-criteria-button" id="addOrGroupBtn">+ OR Criteria</button>
                </div>
              </div>
            </div>

            <!-- Action & Delay Section -->
            <div class="group_area-box mb-3 shadow-sm">
              <div class="crm-header">
                <i class="ti ti-repeat me-1 text-white"></i> Smart Action & Smart Delay
              </div>
              <div class="p-3">
                <button class="add-action-button" id="addActionBtn">+ Action</button>
                <div class="action-delay-container" id="actionContainer"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer d-flex justify-content-end gap-1">
          <button class="btn btn-light border border-1" data-bs-dismiss="modal">Cancel</button>
          <button class="btn btn-primary" id="saveSequenceBtn">Save Sequence</button>
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

    .add-or-button {
      background: #ffc107;
      color: #000;
      border: none;
      padding: 8px 15px;
      border-radius: 4px;
      font-size: 14px;
      cursor: pointer;
    }

    .add-or-button:hover {
      background: #e0a800;
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

    .delete-btn {
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
    }

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
  </style>

<script>
  (function () {
    // Field Configuration with proper operators
    const FIELD_CONFIG = {
      text: {
        fields: ['firstname', 'middlename', 'lastname', 'customername', 'cobuyer', 'email', 'alternateemail',
          'cellphone', 'workphone', 'homephone', 'address', 'streetaddress', 'city', 'province',
          'postalcode', 'country', 'make', 'model', 'bodystyle', 'exteriorcolor', 'interiorcolor',
          'fueltype', 'engine', 'drivetype', 'transmission', 'franchise', 'lotlocation',
          'dealershipname', 'dealershipphone', 'dealershipaddress', 'dealershipwebsite',
          'lost', 'sold', 'notes', 'csi', 'consent',
          'optout', 'businessname', 'trim', 'wishlist'],
        operators: ['is', 'is_not', 'is_blank', 'is_not_blank'],
        inputType: 'text'
      },
      identifier: {
        fields: ['vin', 'stocknumber'],
        operators: ['is_blank', 'is_not_blank'],
        inputType: null
      },
      year: {
        fields: ['year', 'tradeinyear'],
        operators: ['is', 'is_between', 'is_greater_equal', 'is_less_equal', 'is_blank', 'is_not_blank'],
        inputType: 'number'
      },
      number: {
        fields: ['odometer', 'doors', 'saleprice', 'sellingprice', 'internetprice', 'equity',
          'tradeinsellingprice', 'buyout'],
        operators: ['is', 'is_not', 'is_between', 'is_not_between', 'is_greater_equal', 'is_less_equal', 'is_blank', 'is_not_blank'],
        inputType: 'number'
      },
      date: {
        fields: ['appointmentcreationdate', 'appointmentdate', 'createddate', 'deliverydate',
          'demodate', 'lastcontacteddate', 'leasematuritydate', 'solddate', 'taskcompleteddate',
          'taskduedate', 'financematuritydate', 'firstcontactdate', 'financestartdate',
          'leasestartdate', 'warrantyexpiration', 'assigneddate', 'date', 'birthday', 'updated', 'showroomvisitdate'],
        operators: ['is', 'is_between', 'is_greater_equal', 'is_less_equal', 'is_not', 'is_not_between', 'is_blank', 'is_not_blank', 'is_within_the_last', 'is_not_within_the_last'],
        inputType: 'date'
      },
      dropdown: {
        fields: ['leadtype', 'salestatus', 'statustype', 'tasktype', 'dealtype', 'salestype',
          'source', 'priority', 'leadsource'],
        operators: ['is', 'is_not', 'is_blank', 'is_not_blank'],
        inputType: 'dropdown'
      },
      user: {
        fields: ['createdby', 'assignedby', 'assignedto', 'assignedmanager', 'bdcagent', 'bdcmanager',
          'financemanager', 'generalmanger', 'inventorymanager', 'salesmanager', 'secondaryassigned',
          'serviceadvisor', 'updatedby'],
        operators: ['is', 'is_not', 'is_blank', 'is_not_blank'],
        inputType: 'user'
      },
      language: {
        fields: ['language'],
        operators: ['is', 'is_not', 'is_blank', 'is_not_blank'],
        inputType: 'language'
      },
      showroomvisit: {
        fields: ['showroomvisit'],
        operators: ['is_blank', 'is_not_blank'],
        inputType: 'showroomvisit'
      },
      interestrate: {
        fields: ['interestrate'],
        operators: ['is', 'is_between', 'is_greater_equal', 'is_less_equal', 'is_not', 'is_not_between', 'is_blank', 'is_not_blank'],
        inputType: 'number'
      }
    };

    const DROPDOWN_OPTIONS = {
      leadtype: ['Internet', 'Walk-In', 'Phone Up', 'Text Up', 'Website Chat', 'Service', 'Import', 'Wholesale', 'Lease Renewal', 'Unknown', 'None'],
      salestatus: ['Uncontacted', 'Contacted', 'Appointment Set', 'Showed', 'Lost', 'Sold', 'None'],
      statustype: ['Open', 'Confirmed', 'Cancelled', 'Completed', 'Rescheduled', 'None'],
      tasktype: ['Call', 'Email', 'Follow Up', 'Meeting', 'Demo', 'None'],
      dealtype: ['New', 'Used', 'Lease', 'Finance', 'Cash', 'None'],
      salestype: ['Retail', 'Fleet', 'Wholesale', 'None'],
      source: ['Website', 'Referral', 'Walk-in', 'Phone', 'Email', 'Social Media', 'None'],
      priority: ['Low', 'Medium', 'High', 'Urgent', 'None'],
      leadsource: ['Website', 'Referral', 'Advertisement', 'Social Media', 'Event', 'None'],
      language: ['English', 'French', 'Spanish']
    };

    const USER_FIELDS = ['createdby', 'assignedby', 'assignedto', 'assignedmanager', 'bdcagent', 'bdcmanager',
      'financemanager', 'generalmanger', 'inventorymanager', 'salesmanager', 'secondaryassigned',
      'serviceadvisor', 'updatedby'];

    const DATE_FIELDS_WITHIN_LAST = ['appointmentcreationdate', 'createddate', 'appointmentdate',
      'assigneddate', 'birthday', 'deliverydate', 'demodate', 'financematuritydate',
      'financestartdate', 'firstcontactdate', 'lastcontacteddate', 'leasematuritydate',
      'leasestartdate', 'solddate', 'taskcompleteddate', 'taskduedate', 'updated', 'showroomvisitdate'];

    const DEMO_USERS = [
      'James Miller',
      'Michael Johnson',
      'Robert Smith',
      'William Brown',
      'David Wilson',
      'John Anderson',
      'Christopher Taylor',
      'Daniel Thomas',
      'Matthew Moore',
      'Joseph Jackson'
    ];

    const ALL_FIELDS = [
      { value: 'firstname', text: 'First Name' },
      { value: 'middlename', text: 'Middle Name' },
      { value: 'lastname', text: 'Last Name' },
      { value: 'customername', text: 'Customer Name' },
      { value: 'cobuyer', text: 'Co-Buyer' },
      { value: 'email', text: 'Email' },
      { value: 'alternateemail', text: 'Alternative Email' },
      { value: 'cellphone', text: 'Cell Phone' },
      { value: 'workphone', text: 'Work Phone' },
      { value: 'homephone', text: 'Home Phone' },
      { value: 'address', text: 'Full Address' },
      { value: 'streetaddress', text: 'Street Address' },
      { value: 'city', text: 'City' },
      { value: 'province', text: 'Province' },
      { value: 'postalcode', text: 'Postal Code' },
      { value: 'country', text: 'Country' },
      { value: 'year', text: 'Year' },
      { value: 'make', text: 'Make' },
      { value: 'model', text: 'Model' },
      { value: 'vin', text: 'VIN' },
      { value: 'stocknumber', text: 'Stock Number' },
      { value: 'odometer', text: 'Odometer' },
      { value: 'bodystyle', text: 'Body Style' },
      { value: 'exteriorcolor', text: 'Exterior Color' },
      { value: 'interiorcolor', text: 'Interior Color' },
      { value: 'fueltype', text: 'Fuel Type' },
      { value: 'engine', text: 'Engine' },
      { value: 'drivetype', text: 'Drive Type' },
      { value: 'doors', text: 'Doors' },
      { value: 'transmission', text: 'Transmission' },
      { value: 'franchise', text: 'Franchise' },
      { value: 'lotlocation', text: 'Lot Location' },
      { value: 'saleprice', text: 'Sale Price' },
      { value: 'sellingprice', text: 'Selling Price' },
      { value: 'internetprice', text: 'Internet Price' },
      { value: 'interestrate', text: 'Interest Rate' },
      { value: 'equity', text: 'Equity' },
      { value: 'dealershipname', text: 'Dealership Name' },
      { value: 'dealershipphone', text: 'Dealership Phone' },
      { value: 'dealershipaddress', text: 'Dealership Address' },
      { value: 'dealershipwebsite', text: 'Dealership Website' },
      { value: 'tradeinyear', text: 'Trade-in Year' },
      { value: 'tradeinsellingprice', text: 'Trade-in Selling Price' },
      { value: 'assignedto', text: 'Assigned To' },
      { value: 'assignedby', text: 'Assigned By' },
      { value: 'assignedmanager', text: 'Assigned Manager' },
      { value: 'secondaryassigned', text: 'Secondary Assigned' },
      { value: 'financemanager', text: 'Finance Manager' },
      { value: 'bdcagent', text: 'BDC Agent' },
      { value: 'bdcmanager', text: 'BDC Manager' },
      { value: 'generalmanger', text: 'General Manager' },
      { value: 'salesmanager', text: 'Sales Manager' },
      { value: 'serviceadvisor', text: 'Service Advisor' },
      { value: 'inventorymanager', text: 'Inventory Manager' },
      { value: 'createdby', text: 'Created By' },
      { value: 'appointmentcreationdate', text: 'Appointment Creation Date' },
      { value: 'appointmentdate', text: 'Appointment Date' },
      { value: 'createddate', text: 'Created Date' },
      { value: 'deliverydate', text: 'Delivery Date' },
      { value: 'demodate', text: 'Demo Date' },
      { value: 'lastcontacteddate', text: 'Last Contacted Date' },
      { value: 'leasematuritydate', text: 'Lease Maturity Date' },
      { value: 'solddate', text: 'Sold Date' },
      { value: 'taskcompleteddate', text: 'Task Completed Date' },
      { value: 'taskduedate', text: 'Task Due Date' },
      { value: 'financematuritydate', text: 'Finance Maturity Date' },
      { value: 'firstcontactdate', text: 'First Contact Date' },
      { value: 'financestartdate', text: 'Finance Start Date' },
      { value: 'leasestartdate', text: 'Lease Start Date' },
      { value: 'warrantyexpiration', text: 'Warranty Expiration' },
      { value: 'assigneddate', text: 'Assigned Date' },
      { value: 'birthday', text: 'Birthday' },
      { value: 'updated', text: 'Updated' },
      { value: 'leadtype', text: 'Lead Type' },
      { value: 'salestatus', text: 'Sales Status' },
      { value: 'statustype', text: 'Status Type' },
      { value: 'tasktype', text: 'Task Type' },
      { value: 'dealtype', text: 'Deal Type' },
      { value: 'salestype', text: 'Sales Type' },
      { value: 'source', text: 'Source' },
      { value: 'priority', text: 'Priority' },
      { value: 'leadsource', text: 'Lead Source' },
      { value: 'lost', text: 'Lost' },
      { value: 'sold', text: 'Sold' },
      { value: 'notes', text: 'Notes' },
      { value: 'csi', text: 'CSI' },
      { value: 'consent', text: 'Consent' },
      { value: 'optout', text: 'Opt-Out' },
      { value: 'language', text: 'Language' },
      { value: 'businessname', text: 'Business Name' },
      { value: 'buyout', text: 'Buyout' },
      { value: 'wishlist', text: 'Wishlist' },
      { value: 'updatedby', text: 'Updated By' },
      { value: 'trim', text: 'Trim' },
      { value: 'showroomvisit', text: 'Showroom Visit' },
      { value: 'showroomvisitdate', text: 'Showroom Visit Date' }
    ].sort((a, b) => a.text.localeCompare(b.text));

    const OPERATOR_LABELS = {
      'is': 'is',
      'is_not': 'is not',
      'is_between': 'is between',
      'is_not_between': 'is not between',
      'is_greater_equal': 'is greater than or equal to',
      'is_less_equal': 'is less than or equal to',
      'is_blank': 'is blank',
      'is_not_blank': 'is not blank',
      'is_within_the_last': 'is within the last',
      'is_not_within_the_last': 'is not within the last'
    };

    let groupCounter = 0;
    let actionCounter = 0;
    let tomSelectInstances = [];
    let isInitialized = false;

    function waitForTomSelect(callback) {
      if (typeof TomSelect !== 'undefined') {
        callback();
      } else {
        setTimeout(() => waitForTomSelect(callback), 100);
      }
    }

    function getFieldType(fieldName) {
      for (let type in FIELD_CONFIG) {
        if (FIELD_CONFIG[type].fields.includes(fieldName)) {
          return type;
        }
      }
      return 'text';
    }

    function addCriteriaGroup(isOrGroup = false, criteriaCount = 1) {
      groupCounter++;
      const groupId = `group-${groupCounter}`;

      const group = document.createElement('div');
      group.className = `criteria-group ${isOrGroup ? 'or-group' : ''}`;
      group.id = groupId;
      group.dataset.isOr = isOrGroup;

      group.innerHTML = `
        <span class="criteria-group-label">${isOrGroup ? 'OR' : 'AND'}</span>
        <button class="remove-group-btn" data-group-id="${groupId}"><i class="ti ti-x"></i></button>
        <div class="criteria-rows-container"></div>
      `;

      document.getElementById('criteria-container').appendChild(group);

      group.querySelector('.remove-group-btn').addEventListener('click', function () {
        removeGroup(this.dataset.groupId);
      });

      for (let i = 0; i < criteriaCount; i++) {
        addCriteriaToGroup(groupId);
      }

      return groupId;
    }

    function addCriteriaToGroup(groupId) {
      const group = document.getElementById(groupId);
      if (!group) return;

      const container = group.querySelector('.criteria-rows-container');

      const rowId = `criteria-${Date.now()}-${Math.random()}`;
      const row = document.createElement('div');
      row.className = 'criteria-row row align-items-end';
      row.id = rowId;

      row.innerHTML = `
        <div class="col-md-4">
            <label class="form-label small">Field</label>
            <select class="form-select field-select"></select>
        </div>
        <div class="col-md-4 operator-col" style="display: none;">
            <label class="form-label small">Operator</label>
            <select class="form-select operator-select"></select>
        </div>
        <div class="col-md-4 value-col" style="display: none;">
            <label class="form-label small">Value</label>
            <div class="value-input-container"></div>
        </div>
      `;

      container.appendChild(row);

      const fieldSelect = row.querySelector('.field-select');
      const fieldTs = new TomSelect(fieldSelect, {
        options: ALL_FIELDS,
        valueField: 'value',
        labelField: 'text',
        searchField: ['text', 'value'],
        create: false,
        maxOptions: null,
        placeholder: '-- Select Field --',
        load: function (query, callback) {
          if (!query.length) return callback(ALL_FIELDS);
          const results = ALL_FIELDS.filter(item =>
            item.text.toLowerCase().includes(query.toLowerCase()) ||
            item.value.toLowerCase().includes(query.toLowerCase())
          );
          callback(results);
        },
        render: {
          option: function (item, escape) {
            return `<div>${escape(item.text)}</div>`;
          },
          item: function (item, escape) {
            return `<div>${escape(item.text)}</div>`;
          },
          no_results: function () {
            return '<div class="no-results">No fields found</div>';
          }
        },
        onChange: function (value) {
          handleFieldChange(rowId, value);
        }
      });
      tomSelectInstances.push(fieldTs);
    }

    function handleFieldChange(rowId, fieldValue) {
      const row = document.getElementById(rowId);
      if (!row) return;

      const operatorCol = row.querySelector('.operator-col');
      const operatorSelect = row.querySelector('.operator-select');
      const valueCol = row.querySelector('.value-col');

      if (!fieldValue) {
        operatorCol.style.display = 'none';
        valueCol.style.display = 'none';
        return;
      }

      const fieldType = getFieldType(fieldValue);
      const config = FIELD_CONFIG[fieldType];

      operatorCol.style.display = 'block';

      if (operatorSelect.tomselect) {
        operatorSelect.tomselect.destroy();
      }

      operatorSelect.innerHTML = '<option value="">-- Select Operator --</option>';
      config.operators.forEach(op => {
        const option = document.createElement('option');
        option.value = op;
        option.textContent = OPERATOR_LABELS[op];
        operatorSelect.appendChild(option);
      });

      const operatorTs = new TomSelect(operatorSelect, {
        create: false,
        onChange: function (value) {
          handleOperatorChange(rowId, fieldValue, value);
        }
      });
      tomSelectInstances.push(operatorTs);
    }

    function handleOperatorChange(rowId, fieldValue, operatorValue) {
      const row = document.getElementById(rowId);
      if (!row) return;

      const valueCol = row.querySelector('.value-col');
      const valueContainer = row.querySelector('.value-input-container');

      if (!operatorValue) {
        valueCol.style.display = 'none';
        valueContainer.innerHTML = '';
        return;
      }

      const fieldType = getFieldType(fieldValue);
      const config = FIELD_CONFIG[fieldType];

      if (fieldValue === 'showroomvisit') {
        valueCol.style.display = 'block';
        valueContainer.innerHTML = '';
        
        const radioContainer = document.createElement('div');
        radioContainer.className = 'd-flex gap-3 align-items-center';
        radioContainer.innerHTML = `
          <div class="form-check">
            <input class="form-check-input" type="radio" name="showroomvisit-${rowId}" id="showroom-yes-${rowId}" value="yes" checked>
            <label class="form-check-label small" for="showroom-yes-${rowId}">Yes</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="showroomvisit-${rowId}" id="showroom-no-${rowId}" value="no">
            <label class="form-check-label small" for="showroom-no-${rowId}">No</label>
          </div>
        `;
        valueContainer.appendChild(radioContainer);
        return;
      }

      if (operatorValue === 'is_blank' || operatorValue === 'is_not_blank') {
        valueCol.style.display = 'none';
        valueContainer.innerHTML = '';
        return;
      }

      valueCol.style.display = 'block';
      valueContainer.innerHTML = '';

      if (operatorValue === 'is_within_the_last' && DATE_FIELDS_WITHIN_LAST.includes(fieldValue)) {
        const container = document.createElement('div');
        container.className = 'd-flex align-items-center gap-2';
        container.innerHTML = `
          <input type="number" min="0" class="form-control within-last-number" placeholder="0" style="width: 80px;">
          <select class="form-select within-last-unit" style="width: 120px;">
            <option value="minutes">Minutes</option>
            <option value="hours">Hours</option>
            <option value="days" selected>Days</option>
            <option value="months">Months</option>
            <option value="years">Years</option>
          </select>
        `;
        valueContainer.appendChild(container);
      } else if (operatorValue === 'is_not_within_the_last' && DATE_FIELDS_WITHIN_LAST.includes(fieldValue)) {
        const container = document.createElement('div');
        container.className = 'd-flex align-items-center gap-2';
        container.innerHTML = `
          <input type="number" min="0" class="form-control within-last-number" placeholder="0" style="width: 80px;">
          <select class="form-select within-last-unit" style="width: 120px;">
            <option value="minutes">Minutes</option>
            <option value="hours">Hours</option>
            <option value="days" selected>Days</option>
            <option value="months">Months</option>
            <option value="years">Years</option>
          </select>
        `;
        valueContainer.appendChild(container);
      } else if (USER_FIELDS.includes(fieldValue) && (operatorValue === 'is' || operatorValue === 'is_not')) {
        const select = document.createElement('select');
        select.className = 'form-select user-multi-select';
        select.multiple = true;

        DEMO_USERS.forEach(user => {
          const option = document.createElement('option');
          option.value = user;
          option.textContent = user;
          select.appendChild(option);
        });

        valueContainer.appendChild(select);
        const userTs = new TomSelect(select, {
          plugins: ['remove_button'],
          create: false,
          placeholder: 'Select users...',
          onChange: function (value) {
            console.log('Selected users:', value);
          }
        });
        tomSelectInstances.push(userTs);
      } else if (fieldValue === 'language' && (operatorValue === 'is' || operatorValue === 'is_not')) {
        const select = document.createElement('select');
        select.className = 'form-select language-select';

        DROPDOWN_OPTIONS.language.forEach(lang => {
          const option = document.createElement('option');
          option.value = lang;
          option.textContent = lang;
          select.appendChild(option);
        });

        valueContainer.appendChild(select);
        const langTs = new TomSelect(select, {
          create: false,
          placeholder: '-- Select Language --'
        });
        tomSelectInstances.push(langTs);
      } else if (operatorValue === 'is_between' || operatorValue === 'is_not_between') {
        if (config.inputType === 'date') {
          valueContainer.innerHTML = `
            <div class="date-input-container">
              <input type="date" class="form-control" placeholder="Start">
              <span>to</span>
              <input type="date" class="form-control" placeholder="End">
            </div>
          `;
        } else if (config.inputType === 'number') {
          valueContainer.innerHTML = `
            <div class="date-input-container">
              <input type="number" class="form-control" placeholder="From">
              <span>to</span>
              <input type="number" class="form-control" placeholder="To">
            </div>
          `;
        }
      } else if (operatorValue === 'is' || operatorValue === 'is_not') {
        if (config.inputType === 'dropdown') {
          const select = document.createElement('select');
          select.className = 'form-select';
          const options = DROPDOWN_OPTIONS[fieldValue] || ['None'];
          options.forEach(opt => {
            const option = document.createElement('option');
            option.value = opt;
            option.textContent = opt;
            select.appendChild(option);
          });
          valueContainer.appendChild(select);
          const dropdownTs = new TomSelect(select, {
            create: false,
            placeholder: '-- Select Option --'
          });
          tomSelectInstances.push(dropdownTs);
        } else if (config.inputType === 'date') {
          valueContainer.innerHTML = '<input type="date" class="form-control">';
        } else if (config.inputType === 'number' || config.inputType === 'text') {
          valueContainer.innerHTML = `<input type="${config.inputType}" class="form-control" placeholder="Enter value">`;
        }
      } else if (operatorValue === 'is_greater_equal' || operatorValue === 'is_less_equal') {
        if (config.inputType === 'date') {
          valueContainer.innerHTML = '<input type="date" class="form-control">';
        } else {
          valueContainer.innerHTML = '<input type="number" class="form-control" placeholder="Enter value">';
        }
      }
    }

    function removeCriteria(rowId) {
      const row = document.getElementById(rowId);
      if (!row) return;

      const container = row.closest('.criteria-rows-container');
      row.remove();

      if (container.children.length === 0) {
        const group = container.closest('.criteria-group');
        if (group) {
          group.remove();
        }
      }
    }

    function removeGroup(groupId) {
      const group = document.getElementById(groupId);
      if (group) group.remove();
    }

    function resetModal() {
      tomSelectInstances.forEach(ts => {
        if (ts && ts.destroy) {
          try {
            ts.destroy();
          } catch (e) {
            console.error('Error destroying TomSelect:', e);
          }
        }
      });
      tomSelectInstances = [];

      groupCounter = 0;
      actionCounter = 0;

      const criteriaContainer = document.getElementById('criteria-container');
      if (criteriaContainer) {
        criteriaContainer.innerHTML = '';
      }

      const actionContainer = document.getElementById('actionContainer');
      if (actionContainer) {
        actionContainer.innerHTML = '';
      }

      const titleInput = document.getElementById('sequence-title');
      if (titleInput) {
        titleInput.value = '';
      }
    }

    function initializeCriteriaButton() {
      const addCriteriaBtn = document.getElementById('addCriteriaBtn');
      const newAddCriteriaBtn = addCriteriaBtn.cloneNode(true);
      addCriteriaBtn.parentNode.replaceChild(newAddCriteriaBtn, addCriteriaBtn);
      newAddCriteriaBtn.addEventListener('click', () => {
        addCriteriaGroup(false, 1);
      });
    }

    function initializeOrButton() {
      const addOrGroupBtn = document.getElementById('addOrGroupBtn');
      const newAddOrGroupBtn = addOrGroupBtn.cloneNode(true);
      addOrGroupBtn.parentNode.replaceChild(newAddOrGroupBtn, addOrGroupBtn);
      newAddOrGroupBtn.addEventListener('click', () => {
        addCriteriaGroup(true, 2);
      });
    }

    function createDefaultCriteriaStructure() {
      const criteriaContainer = document.getElementById('criteria-container');
      criteriaContainer.innerHTML = '';
      addCriteriaGroup(false, 1);
      addCriteriaGroup(true, 2);
    }

    function initializeActionButton() {
      const addActionBtn = document.getElementById('addActionBtn');
      const newAddActionBtn = addActionBtn.cloneNode(true);
      addActionBtn.parentNode.replaceChild(newAddActionBtn, addActionBtn);
      newAddActionBtn.addEventListener('click', addAction);
    }

    function addAction() {
      actionCounter++;
      const actionId = `action-${actionCounter}`;

      const actionRow = document.createElement('div');
      actionRow.className = 'action-delay-container-row row g-2 p-3 mb-3';
      actionRow.id = actionId;

      actionRow.innerHTML = `
        <div class="col-md-11 rounded-3 border border-1 p-3 position-relative d-flex align-items-center flex-wrap gap-2">
            <span class="badge bg-primary action-sequence position-absolute" style="top: -10px; left: -10px;">${actionCounter}</span>
            
            <div class="me-2">
              <select class="form-select action-type bg-white" required>
                <option value="" hidden>-- Select Action --</option>
                <option value="ai-draft-email">AI Draft Email</option>
                <option value="ai-draft-text">AI Draft Text</option>
                <option value="change-assigned-to">Change Assigned To</option>
                <option value="change-assigned-manager">Change Assigned Manager</option>
                <option value="change-bdc-agent">Change BDC Agent</option>
                <option value="change-finance-manager">Change Finance Manager</option>
                <option value="change-lead-status">Change Lead Status</option>
                <option value="change-lead-type">Change Lead Type</option>
                <option value="change-sales-status">Change Sales Status</option>
                <option value="change-secondary-assigned-to">Change Secondary Assigned To</option>
                <option value="change-status-lost">Change Status to Lost</option>
                <option value="change-status-type">Change Status Type</option>
                <option value="task">Create Task</option>
                <option value="email">Send Automated Email to Customer</option>
                <option value="text">Send Automated Text to Customer</option>
                <option value="notify">Send Notification</option>
                <option value="reassign-lead">Reassign Lead</option>
              </select>
            </div>
            
            <div class="d-flex align-items-center me-2">
              <label class="me-1 small">Delay:</label>
              <input 
                type="number" 
                min="0" 
                class="form-control bg-white me-1 delay-value" 
                style="width:90px;" 
                placeholder="0"
              />
              <select class="form-select bg-white delay-unit" style="width:120px;">
                <option value="minutes">Minutes</option>
                <option value="hours">Hours</option>
                <option value="days">Days</option>
                <option value="months">Months</option>
                <option value="years">Years</option>
              </select>
            </div>
            
            <div class="dynamic-fields d-flex flex-wrap gap-2 flex-grow-1"></div>
        </div>
        
        <div class="col-md-1 text-center d-flex flex-column gap-0">
            <button type="button" class="check-btn invalid"><i class="ti ti-circle-check-filled"></i></button>
            <button type="button" class="delete-btn">Delete</button>
        </div>
      `;

      document.getElementById('actionContainer').appendChild(actionRow);

      const actionSelect = actionRow.querySelector('.action-type');
      actionSelect.addEventListener('change', function () {
        handleActionTypeChange(actionId, this.value);
      });

      const checkBtn = actionRow.querySelector('.check-btn');
      checkBtn.addEventListener('click', () => validateAction(actionId));

      const deleteBtn = actionRow.querySelector('.delete-btn');
      deleteBtn.addEventListener('click', () => {
        actionRow.remove();
        updateActionNumbers();
      });
    }

    function createEmailPreviewModal() {
      if (!document.getElementById('emailPreviewModal')) {
        const modalHTML = `
          <div class="modal fade" id="emailPreviewModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Email Template </h5>
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
        `;
        document.body.insertAdjacentHTML('beforeend', modalHTML);
      }
    }

    function showTemplatePreview(templateName, actionType) {
      createEmailPreviewModal();
      const modal = new bootstrap.Modal(document.getElementById('emailPreviewModal'));
      const previewContent = document.getElementById('emailPreviewContent');
      
      let previewHTML = '';
      if (actionType === 'email') {
        switch(templateName) {
          case 'Book Dream Car':
            previewHTML = `
              <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                <h2 style="color: #0d6efd;">Book Your Dream Car Today!</h2>
                <p>Dear [Customer Name],</p>
                <p>We noticed you were interested in our vehicles. We'd love to help you book a test drive for your dream car!</p>
                <p>Contact us to schedule your appointment.</p>
                <p>Best regards,<br>The Dealership Team</p>
              </div>
            `;
            break;
          case 'Marketing Email':
            previewHTML = `
              <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                <h2 style="color: #0d6efd;">Special Offer Just For You!</h2>
                <p>Hello [Customer Name],</p>
                <p>Check out our latest special offers and promotions on new and pre-owned vehicles!</p>
                <p>Don't miss this opportunity to get the best deal in town.</p>
                <p>Sincerely,<br>Marketing Team</p>
              </div>
            `;
            break;
          case 'New Year':
            previewHTML = `
              <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                <h2 style="color: #0d6efd;">Happy New Year!</h2>
                <p>Dear [Customer Name],</p>
                <p>Wishing you a wonderful New Year! Start the year right with a new vehicle from our dealership.</p>
                <p>We have exclusive New Year promotions waiting for you.</p>
                <p>Happy New Year!<br>Your Dealership Family</p>
              </div>
            `;
            break;
          case 'Follow Up':
            previewHTML = `
              <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                <h2 style="color: #0d6efd;">Just Following Up</h2>
                <p>Hi [Customer Name],</p>
                <p>I wanted to follow up on our previous conversation about your vehicle needs.</p>
                <p>Please let me know if you have any questions or would like to schedule another visit.</p>
                <p>Best regards,<br>[Salesperson Name]</p>
              </div>
            `;
            break;
          default:
            previewHTML = `<p>Preview for "${templateName}" template</p>`;
        }
      } else if (actionType === 'text') {
        switch(templateName) {
          case 'Book Dream Car':
            previewHTML = `
              <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                <h4>Text Message Preview:</h4>
                <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; border: 1px solid #dee2e6;">
                  <p>Hi [Customer Name], ready to book your dream car? Schedule a test drive today! Reply STOP to opt out.</p>
                </div>
              </div>
            `;
            break;
          case 'Marketing Email':
            previewHTML = `
              <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                <h4>Text Message Preview:</h4>
                <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; border: 1px solid #dee2e6;">
                  <p>Special offer just for you! Limited time deals on our best vehicles. Visit us today! Reply STOP to opt out.</p>
                </div>
              </div>
            `;
            break;
          case 'New Year':
            previewHTML = `
              <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                <h4>Text Message Preview:</h4>
                <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; border: 1px solid #dee2e6;">
                  <p>Happy New Year! Start 2024 with a new vehicle. Exclusive New Year promotions available! Reply STOP to opt out.</p>
                </div>
              </div>
            `;
            break;
          case 'Follow Up':
            previewHTML = `
              <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                <h4>Text Message Preview:</h4>
                <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; border: 1px solid #dee2e6;">
                  <p>Just following up on your recent inquiry. Are you still interested in test driving? Reply STOP to opt out.</p>
                </div>
              </div>
            `;
            break;
          default:
            previewHTML = `<div style="background: #f8f9fa; padding: 15px; border-radius: 10px;"><p>Text preview for "${templateName}"</p></div>`;
        }
      }
      
      previewContent.innerHTML = previewHTML;
      modal.show();
    }

    function handleActionTypeChange(actionId, actionType) {
      const actionRow = document.getElementById(actionId);
      if (!actionRow) return;

      const dynamicFields = actionRow.querySelector('.dynamic-fields');
      const checkBtn = actionRow.querySelector('.check-btn');

      checkBtn.classList.remove('valid', 'invalid');
      dynamicFields.innerHTML = '';

      if (!actionType) return;

      switch (actionType) {
        case 'task':
          dynamicFields.innerHTML = `
            <select class="mt-2 form-select bg-white task-type-select" required style="min-width: 150px;">
              <option value="" hidden>-- Select Task --</option>
              <option>Appointment</option>
              <option>CSI</option>
              <option>Inbound Call</option>
              <option>Inbound Email</option>
              <option>Inbound Text</option>
              <option>Other</option>
              <option>Outbound Call</option>
              <option>Outbound Email</option>
              <option>Outbound Text</option>
            </select>
            <select class="form-select bg-white mt-2 assigned-to-select" required style="min-width: 200px;">
              <option value="" hidden>-- Select Assigned To --</option>
              <option value="">Assigned To</option>
              <option value="auto-primary">Secondary Assigned To</option>
              <option value="finance-manager">Assigned To Finance Manager</option>
              <option value="bdc-agent">Assigned To BDC Agent</option>
              <option value="assigned-manager">Assigned Manager</option>
              <optgroup label="Individual Users">
                <option value="user-1">John Smith</option>
                <option value="user-2">Emma Johnson</option>
                <option value="user-3">Michael Brown</option>
                <option value="user-4">Sarah Williams</option>
                <option value="user-5">David Lee</option>
              </optgroup>
            </select>
            <select class="form-select bg-white mt-2 fallback-select" required style="min-width: 200px;">
              <option value="" hidden>-- Fallback Manager --</option>
              <option value="user-1">John Smith</option>
              <option value="user-2">Emma Johnson</option>
              <option value="user-3">Michael Brown</option>
              <option value="user-4">Sarah Williams</option>
              <option value="user-5">David Lee</option>
            </select>
            <input type="text" 
              class="form-control bg-white mt-2 description-input" 
              placeholder="Description..." 
              required 
              style="min-width: 200px;">
          `;
          break;

        case 'ai-draft-email':
        case 'ai-draft-text':
          dynamicFields.innerHTML = `
            <select class="mt-2 form-select bg-white ai-task-type" required style="min-width: 150px;">
              <option value="" hidden>-- Select Task Type --</option>
              <option>Appointment</option>
              <option>CSI</option>
              <option>Inbound Call</option>
              <option>Inbound Email</option>
              <option>Inbound Text</option>
              <option>Other</option>
              <option>Outbound Call</option>
              <option>Outbound Email</option>
              <option>Outbound Text</option>
            </select>
            <select class="form-select bg-white mt-2 ai-assigned-to" required style="min-width: 200px;">
              <option value="" hidden>-- Select Assigned To --</option>
              <option value="">Assigned To</option>
              <option value="auto-primary">Secondary Assigned To</option>
              <option value="finance-manager">Assigned To Finance Manager</option>
              <option value="bdc-agent">Assigned To BDC Agent</option>
              <option value="assigned-manager">Assigned Manager</option>
              <optgroup label="Individual Users">
                <option value="user-1">John Smith</option>
                <option value="user-2">Emma Johnson</option>
                <option value="user-3">Michael Brown</option>
                <option value="user-4">Sarah Williams</option>
                <option value="user-5">David Lee</option>
              </optgroup>
            </select>
            <select class="form-select bg-white mt-2 ai-fallback" required style="min-width: 200px;">
              <option value="" hidden>-- Fallback Manager --</option>
              <option value="user-1">John Smith</option>
              <option value="user-2">Emma Johnson</option>
              <option value="user-3">Michael Brown</option>
              <option value="user-4">Sarah Williams</option>
              <option value="user-5">David Lee</option>
            </select>
            <input type="text" 
              class="form-control bg-white mt-2 ai-description" 
              placeholder="AI will generate description when lead re-engages" 
              readonly 
              style="min-width: 200px; background-color: #f8f9fa !important;">
          `;
          break;

        case 'notify':
          dynamicFields.innerHTML = `
            <select class="form-select bg-white" required style="min-width: 150px;">
              <option value="" hidden>-- Select User --</option>
              <option>John Anderson</option>
              <option>Michael Harris</option>
              <option>Emily Clark</option>
              <option>David Thompson</option>
              <option>Sarah Mitchell</option>
              <option>James Walker</option>
              <option>Olivia Turner</option>
              <option>Robert Collins</option>
              <option>Jessica Brooks</option>
              <option>William Parker</option>
            </select>
            <input type="text" class="form-control bg-white" placeholder="Type Notification Here.." required style="min-width: 250px;">
          `;
          break;

        case 'change-status-lost':
          dynamicFields.innerHTML = `
            <select class="form-select bg-white" required style="min-width: 150px;">
              <option value="" hidden>-- Select Status --</option>
              <option selected>Lost</option>
            </select>
            <select class="form-select bg-white" required style="min-width: 150px;">
              <option value="" hidden>-- Select Sub-Lost Reason --</option>
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
          `;
          break;

        case 'email':
          const emailContainer = document.createElement('div');
          emailContainer.className = 'd-flex align-items-start gap-2 flex-wrap';
          emailContainer.innerHTML = `
            <div class="d-flex align-items-center gap-2">
              <select class="form-select bg-white template-select" required style="min-width: 150px;">
                <option value="">-- Select Template --</option>
                <option>Book Dream Car</option>
                <option>Marketing Email</option>
                <option>New Year</option>
                <option>Follow Up</option>
              </select>
              <button type="button" class="btn btn-sm btn-light border border-1 preview-btn" style="height: 38px;">
                <i class="ti ti-eye"></i>
              </button>
            </div>
            <select class="form-select bg-white" required style="min-width: 150px;">
              <option value="" hidden>-- From Address --</option>
              <option value="">Assigned To</option>
              <option value="auto-primary">Secondary Assigned To</option>
              <option value="finance-manager">Assigned To Finance Manager</option>
              <option value="bdc-agent">Assigned To BDC Agent</option>
              <option value="assigned-manager">Assigned Manager</option>
              <optgroup label="Individual Users">
                <option value="user-1">John Smith</option>
                <option value="user-2">Emma Johnson</option>
                <option value="user-3">Michael Brown</option>
                <option value="user-4">Sarah Williams</option>
                <option value="user-5">David Lee</option>
              </optgroup>
            </select>
            <select class="form-select bg-white" required style="min-width: 150px;">
              <option value="" hidden>-- Fallback --</option>
              <option>Manager</option>
              <option>Assistant</option>
            </select>
          `;
          dynamicFields.appendChild(emailContainer);
          
          const emailPreviewBtn = emailContainer.querySelector('.preview-btn');
          const emailTemplateSelect = emailContainer.querySelector('.template-select');
          emailPreviewBtn.addEventListener('click', () => {
            const selectedTemplate = emailTemplateSelect.value;
            if (selectedTemplate) {
              showTemplatePreview(selectedTemplate, 'email');
            } else {
              alert('Please select a template first');
            }
          });
          break;

        case 'text':
          const textContainer = document.createElement('div');
          textContainer.className = 'd-flex align-items-start gap-2 flex-wrap';
          textContainer.innerHTML = `
            <div class="d-flex align-items-center gap-2">
              <select class="form-select bg-white template-select" required style="min-width: 150px;">
                <option value="">-- Select Template --</option>
                <option>Book Dream Car</option>
                <option>Marketing Email</option>
                <option>New Year</option>
                <option>Follow Up</option>
              </select>
              <button type="button" class="btn btn-sm btn-light border border-1 preview-btn" style="height: 38px;">
                <i class="ti ti-eye"></i>
              </button>
            </div>
            <select class="form-select bg-white" required style="min-width: 150px;">
              <option value="" hidden>-- From Address --</option>
              <option value="">Assigned To</option>
              
              <option value="auto-primary">Secondary Assigned To</option>
              <option value="finance-manager">Assigned To Finance Manager</option>
              <option value="bdc-agent">Assigned To BDC Agent</option>
              <option value="assigned-manager">Assigned Manager</option>
              <optgroup label="Individual Users">
                <option value="user-1">John Smith</option>
                <option value="user-2">Emma Johnson</option>
                <option value="user-3">Michael Brown</option>
                <option value="user-4">Sarah Williams</option>
                <option value="user-5">David Lee</option>
              </optgroup>
            </select>
            <select class="form-select bg-white" required style="min-width: 150px;">
              <option value="" hidden>-- Fallback --</option>
              <option>Manager</option>
              <option>Assistant</option>
            </select>
            <textarea class="form-control bg-white" placeholder="Message text..." required rows="3" style="min-width: 250px;"></textarea>
          `;
          dynamicFields.appendChild(textContainer);
          
          const textPreviewBtn = textContainer.querySelector('.preview-btn');
          const textTemplateSelect = textContainer.querySelector('.template-select');
          textPreviewBtn.addEventListener('click', () => {
            const selectedTemplate = textTemplateSelect.value;
            if (selectedTemplate) {
              showTemplatePreview(selectedTemplate, 'text');
            } else {
              alert('Please select a template first');
            }
          });
          break;

        case 'change-sales-status':
        case 'change-lead-status':
        case 'change-status-type':
          const statusOptions =
            actionType === 'change-sales-status'
              ? ['Uncontacted', 'Attempted', 'Contacted', 'Dealer Visit', 'Demo', 'Write-Up', 'Pending F&I', 'Delivered', 'Sold']
              : actionType === 'change-status-type'
                ? ['Open', 'Confirmed', 'Completed', 'Missed', 'Cancelled', 'Walk-In', 'No Response', 'No Show']
                : actionType === 'change-lead-status'
                  ? ['Active', 'Duplicate', 'Invalid', 'Lost', 'Sold', 'Wishlist', 'Buy-In']
                  : [];

          dynamicFields.innerHTML = `
            <select class="form-select bg-white" required style="min-width: 200px;">
              <option value="">-- Select Status --</option>
              ${statusOptions.map(opt => `<option value="${opt}">${opt}</option>`).join('')}
            </select>
          `;
          break;

        case 'change-lead-type':
          dynamicFields.innerHTML = `
            <select class="form-select bg-white" required style="min-width: 200px;">
              <option value="">-- Select Lead Type --</option>
              <option value="Internet">Internet</option>
              <option value="Walk-In" selected>Walk-In</option>
              <option value="Phone Up">Phone Up</option>
              <option value="Text Up">Text Up</option>
              <option value="Website Chat">Website Chat</option>
              <option value="Import">Import</option>
              <option value="Wholesale">Wholesale</option>
              <option value="Lease Renewal">Lease Renewal</option>
            </select>
          `;
          break;

        case 'reassign-lead':
        case 'change-assigned-to':
        case 'change-assigned-manager':
        case 'change-secondary-assigned-to':
        case 'change-finance-manager':
        case 'change-bdc-agent':
          dynamicFields.innerHTML = `
            <select class="form-select bg-white" required style="min-width: 200px;">
              <option value="">-- Select User --</option>
              <option>John Smith</option>
              <option>Emma Johnson</option>
              <option>Michael Brown</option>
              <option>Sarah Davis</option>
              <option>James Wilson</option>
            </select>
          `;
          break;
      }

      dynamicFields.querySelectorAll('select, input, textarea').forEach(field => {
        field.addEventListener('change', () => validateAction(actionId));
        field.addEventListener('input', () => validateAction(actionId));
      });

      validateAction(actionId);
    }

    function validateAction(actionId) {
      const actionRow = document.getElementById(actionId);
      if (!actionRow) return false;

      const actionType = actionRow.querySelector('.action-type').value;
      const checkBtn = actionRow.querySelector('.check-btn');
      const dynamicFields = actionRow.querySelector('.dynamic-fields');

      if (!actionType) {
        checkBtn.classList.remove('valid');
        checkBtn.classList.add('invalid');
        return false;
      }

      if (actionType === 'ai-draft-email' || actionType === 'ai-draft-text') {
        const taskType = dynamicFields.querySelector('.ai-task-type');
        const assignedTo = dynamicFields.querySelector('.ai-assigned-to');
        const fallback = dynamicFields.querySelector('.ai-fallback');
        
        if (taskType && taskType.value && assignedTo && assignedTo.value && fallback && fallback.value) {
          checkBtn.classList.remove('invalid');
          checkBtn.classList.add('valid');
          return true;
        } else {
          checkBtn.classList.remove('valid');
          checkBtn.classList.add('invalid');
          return false;
        }
      }

      const requiredFields = dynamicFields.querySelectorAll('[required]');
      let allValid = true;

      requiredFields.forEach(field => {
        if (field.tagName === 'SELECT' && (!field.value || field.value === '')) {
          allValid = false;
        } else if ((field.tagName === 'INPUT' || field.tagName === 'TEXTAREA') && !field.value.trim()) {
          allValid = false;
        }
      });

      if (allValid) {
        checkBtn.classList.remove('invalid');
        checkBtn.classList.add('valid');
        return true;
      } else {
        checkBtn.classList.remove('valid');
        checkBtn.classList.add('invalid');
        return false;
      }
    }

    function updateActionNumbers() {
      const actions = document.querySelectorAll('.action-delay-container-row');
      actionCounter = 0;
      actions.forEach((action, index) => {
        actionCounter = index + 1;
        const sequenceBadge = action.querySelector('.action-sequence');
        if (sequenceBadge) {
          sequenceBadge.textContent = actionCounter;
        }
      });
    }

    function saveSequence() {
      const title = document.getElementById('sequence-title').value;

      if (!title.trim()) {
        alert('Please enter a sequence title');
        return;
      }

      const criteriaData = [];
      document.querySelectorAll('.criteria-group').forEach(group => {
        const groupType = group.dataset.isOr === 'true' ? 'OR' : 'AND';
        const criteria = [];

        group.querySelectorAll('.criteria-row').forEach(row => {
          const fieldSelect = row.querySelector('.field-select');
          const operatorSelect = row.querySelector('.operator-select');
          const valueContainer = row.querySelector('.value-input-container');

          if (fieldSelect && fieldSelect.tomselect && operatorSelect && operatorSelect.tomselect) {
            const fieldValue = fieldSelect.tomselect.getValue();
            const operatorValue = operatorSelect.tomselect.getValue();

            if (fieldValue && operatorValue) {
              let values = [];

              if (operatorValue === 'is_within_the_last' || operatorValue === 'is_not_within_the_last') {
                const numberInput = valueContainer.querySelector('.within-last-number');
                const unitSelect = valueContainer.querySelector('.within-last-unit');
                if (numberInput && unitSelect) {
                  values = [numberInput.value, unitSelect.value];
                }
              } else if (USER_FIELDS.includes(fieldValue) && (operatorValue === 'is' || operatorValue === 'is_not')) {
                const multiSelect = valueContainer.querySelector('.user-multi-select');
                if (multiSelect && multiSelect.tomselect) {
                  values = multiSelect.tomselect.getValue();
                }
              } else if (fieldValue === 'language' && (operatorValue === 'is' || operatorValue === 'is_not')) {
                const langSelect = valueContainer.querySelector('.language-select');
                if (langSelect && langSelect.tomselect) {
                  values = [langSelect.tomselect.getValue()];
                }
              } else if (fieldValue === 'showroomvisit') {
                const radio = valueContainer.querySelector('input[type="radio"]:checked');
                if (radio) {
                  values = [radio.value];
                }
              } else {
                const inputs = valueContainer.querySelectorAll('input, select');
                Array.from(inputs).forEach(input => {
                  if (input.tomselect) {
                    values.push(input.tomselect.getValue());
                  } else {
                    values.push(input.value);
                  }
                });
              }

              const criteriaItem = {
                field: fieldValue,
                operator: operatorValue,
                values: values.filter(v => v !== null && v !== undefined && v !== '')
              };
              criteria.push(criteriaItem);
            }
          }
        });

        if (criteria.length > 0) {
          criteriaData.push({
            type: groupType,
            criteria: criteria
          });
        }
      });

      const actionsData = [];
      document.querySelectorAll('.action-delay-container-row').forEach(action => {
        const actionType = action.querySelector('.action-type').value;
        const delayValue = action.querySelector('.delay-value').value;
        const delayUnit = action.querySelector('.delay-unit').value;
        const dynamicInputs = action.querySelectorAll('.dynamic-fields select, .dynamic-fields input, .dynamic-fields textarea');

        if (actionType) {
          actionsData.push({
            type: actionType,
            delay: {
              value: parseInt(delayValue) || 0,
              unit: delayUnit
            },
            parameters: Array.from(dynamicInputs).map(input => input.value).filter(v => v)
          });
        }
      });

      const sequenceData = {
        title: title,
        criteria: criteriaData,
        actions: actionsData,
        createdAt: new Date().toISOString()
      };

      console.log('Sequence Data:', JSON.stringify(sequenceData, null, 2));
      alert('Sequence saved successfully! Check console for data.');

      const modalEl = document.getElementById('addSmartSequenceModal');
      if (modalEl && typeof bootstrap !== 'undefined') {
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
      }
    }

    function initializeModal() {
      resetModal();
      initializeCriteriaButton();
      initializeOrButton();
      createDefaultCriteriaStructure();
      initializeActionButton();

      const saveBtn = document.getElementById('saveSequenceBtn');
      if (saveBtn) {
        const newSaveBtn = saveBtn.cloneNode(true);
        saveBtn.parentNode.replaceChild(newSaveBtn, saveBtn);
        newSaveBtn.addEventListener('click', saveSequence);
      }

      isInitialized = true;
    }

    document.addEventListener('DOMContentLoaded', function () {
      const modal = document.getElementById('addSmartSequenceModal');
      if (modal) {
        modal.addEventListener('show.bs.modal', function () {
          waitForTomSelect(initializeModal);
        });

        modal.addEventListener('hidden.bs.modal', function () {
          resetModal();
          isInitialized = false;
        });
      }
    });

  })();
</script>

  <div class="modal fade" id="executionModal" tabindex="-1" aria-labelledby="executionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title" id="executionModalLabel">Execution Parameters</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body p-4">

          <!-- Sequence Number (Top Left) -->
          <div class="mb-3">
            <div class="d-flex align-items-center">
              <i class="ti ti-list-numbers me-2"></i>
              <input type="number" class="form-control" id="sequenceNumber" value="1" min="1" style="width:100px;">
            </div>
          </div>

          <!-- No recurrence -->
          <div class="mb-3">
            <div class="d-flex align-items-center">
              <i class="ti ti-repeat me-2"></i>
              <select class="form-select">
                <option selected>No recurrence</option>
                <option>Daily</option>
                <option>Weekly</option>
                <option>Monthly</option>
              </select>
            </div>
          </div>

          <!-- Time period -->
          <div class="mb-3">
            <div class="d-flex align-items-center">
              <i class="ti ti-clock me-2"></i>
              <select class="form-select me-2" id="timePeriodSelect">
                <option>Days</option>
                <option>Weeks</option>
                <option>Months</option>
                <option>Years</option>
              </select>
              <input type="number" class="form-control" value="1" min="1" style="width: 80px;">
            </div>
          </div>

          <!-- After -->
          <div class="mb-3">
            <div class="d-flex align-items-center">
              <i class="ti ti-plus me-2"></i>
              <select class="form-select">
                <option selected>After</option>
                <option>Before</option>
              </select>
            </div>
          </div>

          <!-- When all criteria is met (Label only, grey) -->
          <div class="mb-3 text-muted small">
            <i class="ti ti-check me-2"></i>
            <span>When all criteria is met</span>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-light border border-1" data-bs-dismiss="modal" data-bs-toggle="modal"
            data-bs-target="#addSmartSequenceModal">Cancel</button>
          <button type="button" class="btn btn-primary" id="applyExecution" data-bs-dismiss="modal"
            data-bs-toggle="modal" data-bs-target="#addSmartSequenceModal">Apply</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const sequenceInput = document.getElementById('sequenceNumber');
      const applyBtn = document.getElementById('applyExecution');

      applyBtn.addEventListener('click', function () {
        // Example: Reorder sequence numbers automatically
        // (In real case, backend logic should handle reordering)

        console.log("Sequence Number set to:", sequenceInput.value);

        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('executionModal'));
        modal.hide();
      });
    });
  </script>

<!-- Floating minimized bar -->
<div
  id="minimizedBar"
  class="d-none position-fixed bottom-0 end-0 m-3 bg-primary text-white px-3 py-2 shadow"
  style="cursor:pointer"
>
  Sequence
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

  const modalEl = document.getElementById("addSmartSequenceModal");
  const minimizeBtn = document.getElementById("minimizeModalBtn");
  const minimizedBar = document.getElementById("minimizedBar");

  if (!modalEl || !minimizeBtn || !minimizedBar) return;

  const form = modalEl.querySelector("form");
  const bsModal = bootstrap.Modal.getOrCreateInstance(modalEl, { backdrop: true });

  const storageKeyState = "sequenceModalState";
  const storageKeyForm  = "sequenceModalForm";

  /* ---------- Restore modal state ---------- */
  const modalState = localStorage.getItem(storageKeyState);

  if (modalState === "minimized") minimizedBar.classList.remove("d-none");
  else if (modalState === "open") bsModal.show();

  /* ---------- Restore form data ---------- */
  if (form) {
    const savedData = JSON.parse(localStorage.getItem(storageKeyForm) || "{}");
    Object.entries(savedData).forEach(([name, value]) => {
      const field = form.querySelector(`[name="${name}"]`);
      if (field) field.value = value;
    });
  }

  /* ---------- Minimize ---------- */
  minimizeBtn.addEventListener("click", function () {
    localStorage.setItem(storageKeyState, "minimized");

    // Listen for the modal to finish hiding
    const onHidden = function () {
      // Remove backdrop and restore scroll
      const backdrop = document.querySelector(".modal-backdrop");
      if (backdrop) backdrop.remove();
      document.body.classList.remove("modal-open");

      minimizedBar.classList.remove("d-none");

      // Clean up listener
      modalEl.removeEventListener("hidden.bs.modal", onHidden);
    };

    modalEl.addEventListener("hidden.bs.modal", onHidden);

    // Trigger hide
    bsModal.hide();
  });

  /* ---------- Restore ---------- */
  minimizedBar.addEventListener("click", function () {
    localStorage.setItem(storageKeyState, "open");
    minimizedBar.classList.add("d-none");
    bsModal.show();
  });

  /* ---------- Close / Cancel ---------- */
  modalEl.addEventListener("hidden.bs.modal", function () {
    if (localStorage.getItem(storageKeyState) !== "minimized") {
      localStorage.setItem(storageKeyState, "closed");
      minimizedBar.classList.add("d-none");
    }
  });

  /* ---------- Auto-save form data ---------- */
  if (form) {
    form.addEventListener("input", function () {
      const data = {};
      form.querySelectorAll("input, textarea, select").forEach(el => {
        if (el.name) data[el.name] = el.value;
      });
      localStorage.setItem(storageKeyForm, JSON.stringify(data));
    });
  }

});
</script>






@endsection



@push('scripts')


<script>
    // Date Picker
    document.addEventListener("DOMContentLoaded", function () {
      const fromInput = document.getElementById("fromDate");
      const toInput = document.getElementById("toDate");

      let fromPicker, toPicker;

      fromPicker = flatpickr("#fromCalendar", {
        inline: true,
        dateFormat: "F j, Y",
        onChange: function (selectedDates) {
          if (selectedDates[0]) {
            const dateStr = fromPicker.formatDate(selectedDates[0], "F j, Y");
            fromInput.value = dateStr;
            toPicker.set("minDate", selectedDates[0]);

            if (toPicker.selectedDates[0] && toPicker.selectedDates[0] < selectedDates[0]) {
              toPicker.setDate(selectedDates[0], true);
            }
          }
        },
      });

      toPicker = flatpickr("#toCalendar", {
        inline: true,
        dateFormat: "F j, Y",
        onChange: function (selectedDates) {
          if (selectedDates[0]) {
            const dateStr = toPicker.formatDate(selectedDates[0], "F j, Y");
            toInput.value = dateStr;
            fromPicker.set("maxDate", selectedDates[0]);

            if (fromPicker.selectedDates[0] && fromPicker.selectedDates[0] > selectedDates[0]) {
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

      document.getElementById("yesterdayBtn").addEventListener("click", function () {
        const yesterday = new Date();
        yesterday.setDate(yesterday.getDate() - 1);
        setRange(yesterday, yesterday);
      });

      document.getElementById("todayBtn").addEventListener("click", function () {
        const today = new Date();
        setRange(today, today);
      });

      document.getElementById("last7Btn").addEventListener("click", function () {
        const end = new Date();
        const start = new Date();
        start.setDate(end.getDate() - 6);
        setRange(start, end);
      });

      document.getElementById("thisMonthBtn").addEventListener("click", function () {
        const now = new Date();
        const start = new Date(now.getFullYear(), now.getMonth(), 1);
        const end = new Date(now.getFullYear(), now.getMonth() + 1, 0);
        setRange(start, end);
      });

      // New button handlers
      document.getElementById("lastMonthBtn").addEventListener("click", function () {
        const now = new Date();
        const start = new Date(now.getFullYear(), now.getMonth() - 1, 1);
        const end = new Date(now.getFullYear(), now.getMonth(), 0);
        setRange(start, end);
      });

      document.getElementById("lastQuarterBtn").addEventListener("click", function () {
        const now = new Date();
        const currentQuarter = Math.floor(now.getMonth() / 3);
        const start = new Date(now.getFullYear(), (currentQuarter - 1) * 3, 1);
        const end = new Date(now.getFullYear(), currentQuarter * 3, 0);
        setRange(start, end);
      });

      document.getElementById("thisYearBtn").addEventListener("click", function () {
        const now = new Date();
        const start = new Date(now.getFullYear(), 0, 1);
        const end = new Date(now.getFullYear(), 11, 31);
        setRange(start, end);
      });

      document.getElementById("lastYearBtn").addEventListener("click", function () {
        const now = new Date();
        const start = new Date(now.getFullYear() - 1, 0, 1);
        const end = new Date(now.getFullYear() - 1, 11, 31);
        setRange(start, end);
      });

      document.getElementById("resetBtn").addEventListener("click", function () {
        fromPicker.clear();
        toPicker.clear();
        fromInput.value = "";
        toInput.value = "";
        fromPicker.set("maxDate", null);
        toPicker.set("minDate", null);
      });

      document.getElementById("applyBtn").addEventListener("click", function () {
        var field = document.getElementById("dateField").value;
        var fromDate = fromInput.value;
        var toDate = toInput.value;
        alert("Filtering by " + field + "\nFrom: " + fromDate + "\nTo: " + toDate);
      });

      const modal = document.getElementById("filterModal");
      if (modal) {
        modal.addEventListener("hidden.bs.modal", function () {
          document.getElementById("dateField").value = "Sold Date";
          fromPicker.clear();
          toPicker.clear();
          fromInput.value = "";
          toInput.value = "";
          fromPicker.set("maxDate", null);
          toPicker.set("minDate", null);
        });
      }
    });
  </script>  <script>
    new TomSelect("#whenSelect", {
      maxItems: 1,
      create: false,
      allowEmptyOption: true,
      controlInput: null
    });

    new TomSelect("#triggerFields", {
      maxItems: 1,
      create: false,
      allowEmptyOption: true,
      controlInput: null
    });
  </script>
    
@endpush



@push('styles')


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