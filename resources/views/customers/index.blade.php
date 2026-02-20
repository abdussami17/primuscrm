@extends('layouts.app')


@section('title', 'Customers')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/customer/css/style.css') }}">

    <style>
        #customerTable .name-cell {
            display: flex;
            align-items: center;
            gap: 10px;
            /* ensure hover box can overflow */
            overflow: visible;
            position: relative;
        }

        .custom-hover-box .hover-line { margin-bottom: 4px; } */
        .custom-hover-box .muted { color: #6b7280; }


    </style>

    @endpush
    <div class="content content-two pt-0">
        <div id="alert-box-container">

        </div>
        <!-- Page Header -->
        <div class="position-relative d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3"
            style="min-height: 80px;">
            <div>
                   @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                <h6 class="mb-0">Customers</h6>
            </div>
            <img src="assets/light_logo.png" alt="Logo" class="mobile-logo-no logo-img"
                style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); max-width: 80px; height: auto;">
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                <button id="printBtn" class="btn btn-light border  border-1"><i
                        class="isax isax-printer me-1"></i>Print</button>
                <div class="dropdown">
                    <a href="javascript:void(0);" class="btn btn-outline-white d-inline-flex align-items-center"
                        data-bs-toggle="dropdown">
                        <i class="isax isax-export-1 me-1"></i>Export
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" id="exportPDF">PDF</a></li>
                        <li><a class="dropdown-item" href="#" id="exportExcel">Excel (XLSX)</a></li>
                        <li><a class="dropdown-item" href="#" id="exportCSV">Excel (CSV)</a></li>
                    </ul>
                </div>
                <div>
                    <a href="javascript:void(0);" class="btn btn-primary d-flex align-items-center"
                         data-size="lg" data-url="{{ route('customers.create') }}" data-ajax-popup="true"  data-title="{{__('New Customers')}}">
                        <i class="isax isax-add-circle5 me-1"></i>New Customers
                    </a>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center flex-wrap gap-2">


                    <a class="btn btn-outline-white fw-normal d-inline-flex align-items-center" href="javascript:void(0);"
                        data-bs-toggle="modal" data-bs-target="#filterModal">
                        <i class="isax isax-filter me-1"></i>Filter by Date
                    </a>
                    <button id="btnSendCampaign" class="btn fw-normal d-inline-flex align-items-center btn-secondary"
                        data-bs-toggle="modal" data-bs-target="#emailModal" disabled="">
                        <i class="isax isax-send-2 me-1"></i>Send Campaign
                    </button>
                    <button id="btnBulkDelete" class="btn fw-normal d-inline-flex align-items-center btn-danger"
                        style="display: none;">
                        <i class="isax isax-trash me-1"></i>Delete Selected (<span id="selectedCount">0</span>)
                    </button>

                    @if(auth()->user()->email === 'admin@primuscrm.com')
                    <a class="btn btn-outline-white fw-normal d-inline-flex align-items-center" 
                       href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#customerImport">
                        <i class="ti ti-copy me-1"></i>Import
                    </a>
                @endif
                
                    <a class="btn btn-outline-white fw-normal d-inline-flex align-items-center" href="javascript:void(0);"
                        data-bs-toggle="modal" data-bs-target="#duplicateModal">
                        <i class="ti ti-copy me-1"></i>Merge Customers
                    </a>
                </div>
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <div class="dropdown">
                        <a href="javascript:void(0);"
                            class="dropdown-toggle btn btn-outline-white d-inline-flex align-items-center"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            More Columns
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" style="max-height: 300px; overflow-y: auto;">
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Address</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Alternative Email</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Appointment Date/Time</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Assigned By</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Assigned Date</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Assigned Manager</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Assigned To</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>BDC Agent</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>BDC Manager</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Be-Back</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Birthday</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Body Style</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Business Name</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Buyout</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>CSI</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Cell Phone</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>City</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Co-Buyer</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Consent</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Consent End</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Country</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Created By</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Created Date</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Customer Name</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Date</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Deal Type</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Dealership Address</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Dealership Name</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Dealership Phone</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Dealership Website</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Delivered</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Delivery Date</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Doors</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Drive Type</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Due Date/Time</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Email</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Engine</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Equity</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Exterior Color</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Finance Manager</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>First Name</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Franchise</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Fuel Type</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>General Manager</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Home Phone</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Interior Color</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Internet Price</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Inventory Manager</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>KMs</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Language</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Last Name</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Lead Source</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Lead Type</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Lost</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Lot Location</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Make</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Middle Name</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Model</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Odometer</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Opt-Out</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Postal Code</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Priority</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Province</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Sale Price</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Sales Manager</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Sales Status</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Sales Type</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Secondary Assigned</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Selling Price</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Service Advisor</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Showroom Visit</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Sold</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Source</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Status Type</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Stock Number</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Street Address</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Task Type</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Trade-in KMs</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Trade-in Make</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Trade-in Model</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Trade-in Selling Price</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Trade-in VIN</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Trade-in Year</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Transmission</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Trim</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Updated</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Updated By</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>VIN</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Warranty Expiration Date</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Wishlist</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Work Phone</span></label></li>
                            <li><label class="dropdown-item d-flex align-items-center form-check form-check-inline"><input class="form-check-input m-0 me-2" type="checkbox"><span>Year</span></label></li>
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

        @if(request('search'))
        <div class="alert alert-success">
            Showing results for: <strong>{{ request('search') }}</strong>
        </div>
        @endif
        
        <!-- Customer Table -->
        <div class="table-responsive">
            <table id="customerTable" class="table table-hover table-nowrap ">
                <thead class="thead-light">
                    <tr>
                        <th class="no-sort" style="padding: 0;padding-left: 5px;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="select-all">
                            </div>
                        </th>
                        <th><span class="header-text">Customer Name <i class="bi bi-arrows-move drag-handle"
                                    data-bs-toggle="tooltip" data-bs-title="Move Column"></i></span></th>
                        <th><span class="header-text">Email <i class="bi bi-arrows-move drag-handle"
                                    data-bs-toggle="tooltip" data-bs-title="Move Column"></i></span></th>
                        <th><span class="header-text">City <i class="bi bi-arrows-move drag-handle"
                                    data-bs-toggle="tooltip" data-bs-title="Move Column"></i></span></th>
                        <th><span class="header-text">Postal Code <i class="bi bi-arrows-move drag-handle"
                                    data-bs-toggle="tooltip" data-bs-title="Move Column"></i></span></th>
                        <th><span class="header-text">Province <i class="bi bi-arrows-move drag-handle"
                                    data-bs-toggle="tooltip" data-bs-title="Move Column"></i></span></th>
                        <th><span class="header-text">Home Phone <i class="bi bi-arrows-move drag-handle"
                                    data-bs-toggle="tooltip" data-bs-title="Move Column"></i></span></th>
                        <th><span class="header-text">Cell Phone <i class="bi bi-arrows-move drag-handle"
                                    data-bs-toggle="tooltip" data-bs-title="Move Column"></i></span></th>
                        <th><span class="header-text">Work Phone <i class="bi bi-arrows-move drag-handle"
                                    data-bs-toggle="tooltip" data-bs-title="Move Column"></i></span></th>
                        <th><span class="header-text">Assigned To <i class="bi bi-arrows-move drag-handle"
                                    data-bs-toggle="tooltip" data-bs-title="Move Column"></i></span></th>
                        <th><span class="header-text">Secondary Assigned To <i class="bi bi-arrows-move drag-handle"
                                    data-bs-toggle="tooltip" data-bs-title="Move Column"></i></span></th>
                        <th><span class="header-text">Finance Manager <i class="bi bi-arrows-move drag-handle"
                                    data-bs-toggle="tooltip" data-bs-title="Move Column"></i></span></th>
                        <th><span class="header-text">BDC Agent <i class="bi bi-arrows-move drag-handle"
                                    data-bs-toggle="tooltip" data-bs-title="Move Column"></i></span></th>
                        <th><span class="header-text">Source <i class="bi bi-arrows-move drag-handle"
                                    data-bs-toggle="tooltip" data-bs-title="Move Column"></i></span></th>
                        <th><span class="header-text">Lead Type <i class="bi bi-arrows-move drag-handle"
                                    data-bs-toggle="tooltip" data-bs-title="Move Column"></i></span></th>
                        <th><span class="header-text">Lead Status <i class="bi bi-arrows-move drag-handle"
                                    data-bs-toggle="tooltip" data-bs-title="Move Column"></i></span></th>
                        <th><span class="header-text">Visits <i class="bi bi-arrows-move drag-handle"
                                    data-bs-toggle="tooltip" data-bs-title="Move Column"></i></span></th>
                        <th><span class="header-text">Inventory Type <i class="bi bi-arrows-move drag-handle"
                                    data-bs-toggle="tooltip" data-bs-title="Move Column"></i></span></th>
                        <th><span class="header-text">Dealership <i class="bi bi-arrows-move drag-handle"
                                    data-bs-toggle="tooltip" data-bs-title="Move Column"></i></span></th>
                        <th><span class="header-text">Sales Status <i class="bi bi-arrows-move drag-handle"
                                    data-bs-toggle="tooltip" data-bs-title="Move Column"></i></span></th>
                        <th><span class="header-text">Sales Type <i class="bi bi-arrows-move drag-handle"
                                    data-bs-toggle="tooltip" data-bs-title="Move Column"></i></span></th>
                        <th><span class="header-text">Deal Type <i class="bi bi-arrows-move drag-handle"
                                    data-bs-toggle="tooltip" data-bs-title="Move Column"></i></span></th>
                        <th><span class="header-text">Lead Status Type <i class="bi bi-arrows-move drag-handle"
                                    data-bs-toggle="tooltip" data-bs-title="Move Column"></i></span></th>
                        <th><span class="header-text">Appt Status Type</span></th>
                        <!-- New Columns Added -->
                        <th><span class="header-text">Original Assigned By <i class="bi bi-arrows-move drag-handle"
                                    data-bs-toggle="tooltip" data-bs-title="Move Column"></i></span></th>
                        <th><span class="header-text">Original Assigned Date <i class="bi bi-arrows-move drag-handle"
                                    data-bs-toggle="tooltip" data-bs-title="Move Column"></i></span></th>
                        <th><span class="header-text">Original Assigned To <i class="bi bi-arrows-move drag-handle"
                                    data-bs-toggle="tooltip" data-bs-title="Move Column"></i></span></th>
                        <th><span class="header-text">Sold By <i class="bi bi-arrows-move drag-handle"
                                    data-bs-toggle="tooltip" data-bs-title="Move Column"></i></span></th>
                        <!-- End New Columns -->
                        <th class="no-sort"><span class="header-text">Status</span></th>
                        <th ><span class="header-text">Created Date</span></th>
                        <th ><span class="header-text">Sold Date</span></th>
                        <th ><span class="header-text">Delivery Date</span></th>
                        <th ><span class="header-text">Appointment Date</span></th>
                        <th ><span class="header-text">Last Contacted Date</span></th>
                        <th class="no-sort"><span class="header-text">Action</span></th>
                    </tr>
                    <tr id="filtersRow" class="filter-row">
                        <th class="no-sort"></th>
                        <th>
                            <div class="filter-wrapper" data-col="1"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="2"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="3"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="4"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="5"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="6"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="7"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="8"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="9"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="10"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="11"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="12"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="13"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="14"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="15"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="16"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="17"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="18"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="19"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="20"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="21"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="22"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="23"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="24"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="25"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="26"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="27"></div>
                        </th>
                        <th class="no-sort"></th>
                        <th>
                            <div class="filter-wrapper" data-col="29"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="30"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="31"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="32"></div>
                        </th>
                        <th>
                            <div class="filter-wrapper" data-col="33"></div>
                        </th>
                        <th class="no-sort"></th>
                    </tr>
                </thead>
                <tbody>
                        @foreach ($customers as $customer)
                        <tr 
                            data-full-name="{{ $customer->full_name }}"
                            data-email="{{ $customer->email ?? '' }}"
                            data-city="{{ $customer->city ?? '' }}"
                            data-zip-code="{{ $customer->zip_code ?? '' }}"
                            data-state="{{ $customer->state ?? '' }}"
                            data-phone="{{ $customer->phone ?? '' }}"
                            data-cell-phone="{{ $customer->cell_phone ?? '' }}"
                            data-work-phone="{{ $customer->work_phone ?? '' }}"
                            data-assigned-to="{{ $customer->assignedUser->name ?? '' }}"
                            data-secondary-assigned-to="{{ $customer->secondaryAssignedUser->name ?? '' }}"
                            data-assigned-manager="{{ $customer->assignedManagerUser->name ?? '' }}"
                            data-bdc-agent="{{ $customer->bdcAgentUser->name ?? '' }}"
                            data-lead-source="{{ $customer->lead_source ?? '' }}"
                            data-lead-type="{{ $customer->lead_type ?? '' }}"
                            data-status="{{ $customer->status ?? '' }}"
                            data-interested-make="{{ $customer->interested_make ?? '' }}"
                            data-dealership-franchises="{{ is_array($customer->dealership_franchises) ? implode(', ', $customer->dealership_franchises) : $customer->dealership_franchises ?? '' }}"
                            data-sales-status="{{ $customer->sales_status ?? '' }}"
                            data-sales-type="{{ $customer->sales_type ?? '' }}"
                            data-deal-type="{{ $customer->deal_type ?? '' }}"
                            data-lead-status-type="{{ $customer->lead_status_type ?? '' }}"
                            data-appointment-status="{{ $customer->appointment_status ?? '' }}"
                            data-assigned-by="{{ $customer->assigned_by ?? '' }}"
                            data-assigned-date="{{ $customer->assigned_date ? $customer->assigned_date->format('Y-m-d') : '' }}"
                            data-sold-by="{{ $customer->sold_by ?? '' }}"
                            data-created-date="{{ $customer->created_at ? $customer->created_at->format('Y-m-d') : '' }}"
                            data-sold-date="{{ $customer->sold_date ? $customer->sold_date->format('Y-m-d') : '' }}"
                            data-delivery-date="{{ $customer->delivery_date ? $customer->delivery_date->format('Y-m-d') : '' }}"
                            data-appointment-date="{{ $customer->appointment_date ? $customer->appointment_date->format('Y-m-d') : '' }}"
                            data-last-contacted-date="{{ $customer->last_contacted_at ? $customer->last_contacted_at->format('Y-m-d') : '' }}"
                        >
                            <td style="padding: 0;padding-left: 5px;">
                                <div class="form-check"><input class="form-check-input customer-checkbox" type="checkbox"
                                    data-customer-id="{{ $customer->id }}" value="{{ $customer->id }}"></div>
                            </td>
                            <td>
                                <div class="custom-hover-container name-cell">
                                  <a href="#" class="customer-link" data-url="{{ route('customers.edit',$customer->id) }}" data-ajax-popup="true" data-title="{{__('Customer Profile')}}">
                                    {{ $customer->full_name }}
                                  </a>
                              
                                  <div class="custom-hover-box" aria-hidden="true">
                                    <div class="hover-inner">
                                      <div class="hover-img-wrap">
                                        <img src="{{ asset($customer->profile_image ?? 'assets/img/default-avatar.png') }}" alt="Customer Photo">
                                        <span class="status-dot {{ $customer->is_online ? 'online' : '' }}" title="{{ $customer->is_online ? 'Online' : '' }}"></span>
                                      </div>
                                      <div class="hover-details">
                                        <strong class="hover-name">{{ $customer->full_name }}</strong>
                                        <div class="hover-line">{{ $customer->street_address }}{{ $customer->city }}, {{ $customer->state }} {{ $customer->zip_code }}</div>
                                        <div class="hover-line">Cell: {{ $customer->cell_phone ?? ($customer->phone ?? '-') }}</div>
                                        <div class="hover-line">Email: {{ $customer->email ?? '-' }}</div>
                                        <div class="hover-line">Sales Rep: {{ $customer->assignedUser->name ?? '-' }}</div>
                                        <div class="hover-line muted small">Last Updated: {{ $customer->updated_at ? $customer->updated_at->format('n/j/y g:ia') : '-' }}</div>
                                      </div>
                                    </div>
                                  </div>
                                  <span class="badge bg-primary" style="cursor: pointer;"
                                        onclick="showDealsModal('{{ $customer->full_name }}', 'customer-{{ $customer->id }}')"
                                        title="View Deals">{{ $customer->deals_count ?? 0 }}</span>
                                    <i class="ti ti-caret-right-filled" style="margin-left:-10px;cursor:pointer"
                                        onclick="showDealsModal('{{ $customer->full_name }}', 'customer-{{ $customer->id }}')"
                                        title="View Deals"></i>
                                  
                                </div>
                              </td>
                              

                            <td>{{ $customer->email ?? '-' }}</td>
                            <td>{{ $customer->city ?? '-' }}</td>
                            <td>{{ $customer->zip_code ?? '-' }}</td>
                            <td>{{ $customer->state ?? '-' }}</td>
                            <td>{{ $customer->phone ?? '-' }}</td>
                            <td>{{ $customer->cell_phone ?? '-' }}</td>
                            <td>{{ $customer->work_phone ?? '-' }}</td>
                            <td>{{ $customer->assignedUser->name ?? '-' }}</td>
                            <td>{{ $customer->secondaryAssignedUser->name ?? '-' }}</td>
                            <td>{{ $customer->assignedManagerUser->name ?? '-' }}</td>
                            <td>{{ $customer->bdcAgentUser->name ?? '-' }}</td>
                            <td>{{ $customer->lead_source ?? '-' }}</td>
                            <td>{{ $customer->lead_type ?? '-' }}</td>
                            <td>{{ $customer->status ?? '-' }}</td>
                            <td>
                                <span class="badge bg-primary rounded-pill">{{ 0 }}</span>
                            </td>
                            <td>{{ $customer->interested_make ?? '-' }}</td>
                            <td>{{ is_array($customer->dealership_franchises) ? implode(', ', $customer->dealership_franchises) : $customer->dealership_franchises ?? '-' }}
                            </td>
                            <td>{{ $customer->sales_status ?? '-' }}</td>
                            <td>{{ $customer->sales_type ?? '-' }}</td>
                            <td>{{ $customer->deal_type ?? '-' }}</td>
                            <td>{{ $customer->lead_status_type ?? '-' }}</td>
                            <td>{{ $customer->appointment_status ?? '-' }}</td>
                            <!-- New Data Columns -->
                            <td>{{ $customer->assigned_by ?? '-' }}</td>
                            <td>{{ $customer->assigned_date ? $customer->assigned_date->format('Y-m-d') : '-' }}</td>
                            <td>{{ $customer->assignedUser->name ?? '-' }}</td>
                            <td>{{ $customer->sold_by ?? '-' }}</td>
                            <!-- End New Data Columns -->
                            <td>
                                @if ($customer->status == 'Completed')
                                    <span class="badge bg-success">Completed</span>
                                @elseif($customer->status == 'Pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($customer->status == 'In Progress')
                                    <span class="badge bg-info">In Progress</span>
                                @elseif($customer->status == 'Scheduled')
                                    <span class="badge bg-primary">Scheduled</span>
                                @elseif($customer->status == 'No Show')
                                    <span class="badge bg-danger">No Show</span>
                                @else
                                    <span class="badge bg-secondary">{{ $customer->status ?? 'New' }}</span>
                                @endif
                            </td>   
                            <td>
                                {{ $customer->created_at ? $customer->created_at->format('Y-m-d') : '-' }}</td>
                            <td>
                                {{ $customer->sold_date ? $customer->sold_date->format('Y-m-d') : '-' }}</td>
                            <td>
                                {{ $customer->delivery_date ? $customer->delivery_date->format('Y-m-d') : '-' }}</td>
                            <td>
                                {{ $customer->appointment_date ? $customer->appointment_date->format('Y-m-d') : '-' }}</td>
                            <td>
                                {{ $customer->last_contacted_at ? $customer->last_contacted_at->format('Y-m-d') : '-' }}
                            </td>
                            <td>
                                <div class="dropdown">
                                    <a href="#" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#"
                                             data-url="{{ route('customers.edit',$customer->id) }}" data-ajax-popup="true"  data-title="{{__('Customer Details')}}"
                                              >Edit</a>
                                        </li>
                                        <li><a class="dropdown-item delete-customer" href="#"
                                                data-id="{{ $customer->id }}">Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>




        <!-- Customer Deals Modal -->
        <div class="modal fade" id="customerDealsModal" tabindex="-1" aria-labelledby="customerDealsModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title text-white" id="customerDealsModalLabel">
                            <i class="ti ti-file-invoice me-2"></i>Events for <span id="modalCustomerName"></span>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-0">
                        <!-- Deals Table -->
                        <div class="table-responsive table-nowrap">
                            <table class="table border mb-0">
                                <thead class="table-light sticky-top">
                                    <tr>
                                        <th style="width: 80px;">Add Task</th>
                                        <th>Email</th>
                                        <th>City</th>
                                        <th>Deal Number</th>
                                        <th>Lead Type</th>
                                        <th>Status</th>
                                        <th>Inventory Type</th>
                                        <th>Vehicle</th>
                                        <th>Price</th>
                                        <th>Created Date</th>
                                        <th>Sold Date</th>
                                    </tr>
                                </thead>
                                <tbody id="dealsTableBody">
                                    <!-- Deals will be dynamically loaded here -->
                                </tbody>
                            </table>
                        </div>

                        <!-- No Results Message -->
                        <div id="noDealsMessage" class="text-center p-5 d-none">
                            <i class="ti ti-file-off" style="font-size: 48px; color: #ccc;"></i>
                            <p class="text-muted mt-2">No deals found for this customer</p>
                        </div>
                    </div>

                    <div class="modal-footer bg-light">
                        <div class="me-auto">
                            <span class="text-muted small">Showing <strong id="visibleDealsCount">0</strong> of <strong
                                    id="totalDealsCount">0</strong> deals</span>
                        </div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Add Task Modal --}}
        @include('customers.modals.add-task')
    </div>


    {{-- Modal --}}

    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="crm-header model-crm-header d-flex justify-content-between align-items-center">
                    Filter By Date
                    <button type="button" data-bs-dismiss="modal" aria-label="Close"><i
                            class="isax isax-close-circle"></i></button>
                </div>
                <div class="modal-body">
                    <div class="filter-box">
                        <div class="mb-3">
                            <label for="dateField" class="form-label">Date Field:</label>
                            <select id="dateField" class="form-select">

                                <option>Appointment Creation Date</option>
                                <option>Appointment Date</option>

                                <option selected>Created Date</option>
                                <option>Delivery Date</option>
                                <option>Demo Date</option>
                                <option>Last Contacted Date</option>
                                <option>Lease Maturity Date</option>

                                <option>Sold Date</option>

                                <option>Task Completed Date</option>
                                <option>Task Due Date</option>
                                <option value="">Finance Maturity Date</option>
                                <option value="">First Contact Date</option>
                                <option value="">Finance Start Date</option>
                                <option value="">Lease Start Date</option>
                                <option value="">Lease Start Date</option>


                            </select>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col">
                                <!-- <label for="fromDate" class="form-label">From</label> -->
                                <input type="text" id="fromDate" class="form-control d-none"
                                    placeholder="Select start date" readonly />
                            </div>
                            <div class="col">
                                <!-- <label for="toDate" class="form-label">To</label> -->
                                <input type="text" id="toDate" class="form-control d-none"
                                    placeholder="Select end date" readonly />
                            </div>
                        </div>

                        <div class="calendar-container mb-3">
                            <div><input id="fromCalendar" type="text" class="form-control" /></div>
                            <div><input id="toCalendar" type="text" class="form-control" /></div>
                        </div>

                        <div class="d-flex flex-wrap justify-content-center gap-2 mb-3">
                            <button id="beginningbtn" class="btn btn-light border border-1">Beginning Of Time</button>

                            <button id="yesterdayBtn" class="btn btn-light border border-1">Yesterday</button>
                            <button id="todayBtn" class="btn btn-light border border-1">Today</button>
                            <button id="last7Btn" class="btn btn-light border border-1">Last 7 Days</button>
                            <button id="next7Btn" class="btn btn-light border border-1">Next 7 Days</button>

                            <button id="thisMonthBtn" class="btn btn-light border border-1">This Month</button>
                            <button id="lastMonthBtn" class="btn btn-light border border-1">Last Month</button>
                            <button id="lastQuarterBtn" class="btn btn-light border border-1">Last Quarter</button>
                            <button id="thisYearBtn" class="btn btn-light border border-1">This Year</button>
                            <button id="lastYearBtn" class="btn btn-light border border-1">Last Year</button>
                        </div>

                        <div class="modal-footer justify-content-end gap-1">
                            <button id="resetBtn" class="btn btn-light border border-1" data-bs-dismiss="modal">Cancel</button>
                            <button id="applyBtn" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <!-- Email Modal -->
    <div id="emailModal" class="modal fade">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div id="modalTitle"
                    class="crm-header model-crm-header d-flex justify-content-between align-items-center">
                    Send Campaign
                    <button type="button" data-bs-dismiss="modal" aria-label="Close"><i
                            class="isax isax-close-circle"></i></button>
                </div>

                <div class="modal-body pt-1">
                    <form id="campaignWizard">
                        <div id="progressbarwizard">
                            <ul class="nav nav-pills nav-justified form-wizard-header mb-3" id="wizardTabs">
                                <li class="nav-item">
                                    <a href="#account-2" data-bs-toggle="tab" class="nav-link rounded-0 py-2 active">
                                        <i class="bi bi-person-circle fs-18 align-middle me-1"></i>
                                        <span class="d-none d-sm-inline">Compose Email</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#profile-tab-2" data-bs-toggle="tab" class="nav-link rounded-0 py-2">
                                        <i class="bi bi-emoji-smile fs-18 align-middle me-1"></i>
                                        <span class="d-none d-sm-inline">Campaign Setting</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#finish-2" data-bs-toggle="tab" class="nav-link rounded-0 py-2">
                                        <i class="bi bi-check2-circle fs-18 align-middle me-1"></i>
                                        <span class="d-none d-sm-inline">Review & Confirm</span>
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content b-0 mb-0">
                                <div id="bar" class="progress mb-3" style="height: 10px;">
                                    <div class="bar progress-bar progress-bar-striped progress-bar-animated"
                                        style="background-color: var(--cf-primary);width: 33.33%;"></div>
                                </div>

                                <!-- Step 1 -->
                                <div class="tab-pane active" id="account-2">

                                    <div class="row g-3">


                                        <!-- Template -->
                                        <div class="col-md-4 mb-2"> <label class="form-label">Template</label> <select
                                                id="templateSelect" class="w-100">
                                                <option value="" hidden>No selection</option>
                                            </select> </div>

                                        <!-- Sender (Team or Individual) -->
                                        <div class="col-md-4 mb-2">
                                            <label class="form-label">Sender</label>
                                            <select id="senderSelect" class="form-select">
                                                <option value="" hidden>--Select Sender--</option>
                                                <optgroup label="Teams">
                                                    <option value="sales_team" data-type="team">Sales Team</option>
                                                    <option value="service_team" data-type="team">Service Team</option>
                                                </optgroup>
                                                <optgroup label="Individuals">
                                                    <option value="sunny_bonnard" data-type="individual">Sunny Bonnard
                                                        (Me)</option>
                                                    <option value="associate" data-type="individual">Associate</option>
                                                    <option value="advisor" data-type="individual">Service Advisor
                                                    </option>
                                                </optgroup>
                                            </select>
                                        </div>

                                        <!-- Assigned To (only visible if sender is a team) -->
                                        <div class="col-md-4 mb-2" id="assignedToContainer" style="display:none;">
                                            <label class="form-label">Assigned To (Team Member)</label>
                                            <select id="assignedToSelect" class="form-select">
                                                <option hidden>--Select Member--</option>
                                                <option>John Doe</option>
                                                <option>Sara Ali</option>
                                                <option>William Crooks</option>
                                            </select>
                                        </div>

                                        <!-- Backup Sender (Only individuals allowed) -->
                                        <div class="col-md-4 mb-2">
                                            <label class="form-label">Backup Sender</label>
                                            <select id="backupSender" class="form-select">
                                                <option value="" hidden>--Select Backup Sender--</option>
                                                <option>Sunny Bonnard (Me)</option>
                                                <option>Associate</option>
                                                <option>Service Advisor</option>
                                            </select>
                                        </div>

                                        <!-- Language -->
                                        <div class="col-md-4 mb-2">
                                            <label class="form-label">Language</label>
                                                <select id="languageSelect" class="form-select">
                                                    <option value="" hidden>Lead Language</option>
                                                    <option value="en">English</option>
                                                    <option value="fr">French</option>
                                                </select>
                                        </div>

                                        <!-- Subject -->
                                        <div class="col-md-12 mb-2">
                                            <label class="form-label">Subject</label>
                                            <input type="text" class="form-control" id="subjectField">
                                        </div>

                                        <!-- Body -->
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
                                                                <select class="toolbar-select" id="fontFamily"
                                                                    title="Font family">
                                                                    <option value="Arial">Arial</option>
                                                                    <option value="Times New Roman">Times New Roman
                                                                    </option>
                                                                    <option value="Helvetica">Helvetica</option>
                                                                    <option value="Georgia">Georgia</option>
                                                                    <option value="Verdana">Verdana</option>
                                                                    <option value="Courier New">Courier New</option>
                                                                </select>

                                                                <!-- Font Size -->
                                                                <select class="toolbar-select" id="fontSize"
                                                                    title="Font size">
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
                                                                <button type="button" class="toolbar-btn"
                                                                    data-cmd="bold" title="Bold (Ctrl+B)">
                                                                    <i class="bi bi-type-bold"></i>
                                                                </button>
                                                                <button type="button" class="toolbar-btn"
                                                                    data-cmd="italic" title="Italic (Ctrl+I)">
                                                                    <i class="bi bi-type-italic"></i>
                                                                </button>
                                                                <button type="button" class="toolbar-btn"
                                                                    data-cmd="underline" title="Underline (Ctrl+U)">
                                                                    <i class="bi bi-type-underline"></i>
                                                                </button>
                                                                <button type="button" class="toolbar-btn"
                                                                    data-cmd="strikeThrough" title="Strikethrough">
                                                                    <i class="bi bi-type-strikethrough"></i>
                                                                </button>

                                                                <div class="toolbar-separator"></div>

                                                                <!-- Text Color -->
                                                                <div class="color-picker-wrapper">
                                                                    <button type="button" class="color-picker-btn"
                                                                        id="textColorBtn" title="Text color">
                                                                        <i class="bi bi-fonts"
                                                                            style="font-size: 18px;"></i>
                                                                        <div class="color-underline"
                                                                            id="textColorIndicator"
                                                                            style="background: #000000;">
                                                                        </div>
                                                                    </button>
                                                                    <div class="color-dropdown" id="textColorDropdown">
                                                                    </div>
                                                                </div>

                                                                <!-- Highlight Color -->
                                                                <div class="color-picker-wrapper">
                                                                    <button type="button" class="color-picker-btn"
                                                                        id="highlightColorBtn" title="Highlight color">
                                                                        <i class="bi bi-highlighter"></i>
                                                                        <div class="color-underline"
                                                                            id="highlightColorIndicator"
                                                                            style="background: #ffff00;"></div>
                                                                    </button>
                                                                    <div class="color-dropdown"
                                                                        id="highlightColorDropdown"></div>
                                                                </div>

                                                                <div class="toolbar-separator"></div>

                                                                <!-- Alignment -->
                                                                <button type="button" class="toolbar-btn"
                                                                    data-cmd="justifyLeft" title="Align left">
                                                                    <i class="bi bi-text-left"></i>
                                                                </button>
                                                                <button type="button" class="toolbar-btn"
                                                                    data-cmd="justifyCenter" title="Align center">
                                                                    <i class="bi bi-text-center"></i>
                                                                </button>
                                                                <button type="button" class="toolbar-btn"
                                                                    data-cmd="justifyRight" title="Align right">
                                                                    <i class="bi bi-text-right"></i>
                                                                </button>
                                                                <button type="button" class="toolbar-btn"
                                                                    data-cmd="justifyFull" title="Justify">
                                                                    <i class="bi bi-justify"></i>
                                                                </button>

                                                                <div class="toolbar-separator"></div>

                                                                <!-- Lists and Indentation -->
                                                                <button type="button" class="toolbar-btn"
                                                                    data-cmd="insertUnorderedList" title="Bullet list">
                                                                    <i class="bi bi-list-ul"></i>
                                                                </button>
                                                                <button type="button" class="toolbar-btn"
                                                                    data-cmd="insertOrderedList" title="Numbered list">
                                                                    <i class="bi bi-list-ol"></i>
                                                                </button>
                                                                <button type="button" class="toolbar-btn"
                                                                    data-cmd="indent" title="Increase indent">
                                                                    <i class="bi bi-indent"></i>
                                                                </button>
                                                                <button type="button" class="toolbar-btn"
                                                                    data-cmd="outdent" title="Decrease indent">
                                                                    <i class="bi bi-unindent"></i>
                                                                </button>

                                                                <div class="toolbar-separator"></div>

                                                                <!-- Insert Options -->
                                                                <div class="color-picker-wrapper">
                                                                    <button type="button" class="toolbar-btn"
                                                                        id="btnTable" title="Insert table">
                                                                        <i class="bi bi-table"></i>
                                                                    </button>
                                                                    <div class="table-grid-popup" id="tableGridPopup">
                                                                        <div class="table-grid" id="tableGrid"></div>
                                                                        <div class="table-size-label" id="tableSizeLabel">
                                                                            1 x 1 Table</div>
                                                                    </div>
                                                                </div>

                                                                <button type="button" class="toolbar-btn" id="btnImage"
                                                                    title="Insert image">
                                                                    <i class="bi bi-image"></i>
                                                                </button>

                                                                <button type="button" class="toolbar-btn" id="btnLink"
                                                                    title="Insert link">
                                                                    <i class="bi bi-link-45deg"></i>
                                                                </button>

                                                                <button type="button" class="toolbar-btn" id="btnAttach"
                                                                    title="Attach file">
                                                                    <i class="bi bi-paperclip"></i>
                                                                </button>

                                                                <button type="button" class="toolbar-btn"
                                                                    id="btnClearFormat" title="Clear formatting">
                                                                    <i class="bi bi-eraser"></i>
                                                                </button>

                                                                <div class="toolbar-separator"></div>

                                                                <!-- Smart Text -->
                                                                <button type="button" class="toolbar-btn"
                                                                    id="btnSmartText"
                                                                    title="Smart Text - Enhance with AI">
                                                                    <i class="bi bi-magic"></i>
                                                                </button>

                                                                <div class="toolbar-separator"></div>

                                                                <!-- HTML Edit Mode -->
                                                                <button type="button" class="toolbar-btn"
                                                                    id="btnHtmlMode"
                                                                    title="Edit HTML / Switch to HTML mode">
                                                                    <i class="bi bi-code-slash"></i>
                                                                </button>

                                                                <!-- Voice Input -->
                                                                <button type="button" class="voice-btn" id="btnVoice"
                                                                    title="Voice to text">
                                                                    <i class="bi bi-mic-fill"></i>
                                                                </button>
                                                            </div>

                                                            <!-- HTML Textarea (Hidden by default) -->
                                                            <textarea class="html-textarea" id="htmlTextarea"
                                                                style="display:none; width:100%; height:400px; padding:12px; font-family:monospace; font-size:12px; border:2px solid #002140; background:#f8f9fa;"></textarea>

                                                            <div class="editor-wrapper">
                                                                <div class="editor-container">
                                                                    <div class="editor" id="editor"
                                                                        contenteditable="true">
                                                                        <p>Hi <span
                                                                                class="token">@{{ first_name }}</span>,
                                                                        </p>
                                                                        <p>Welcome to <span
                                                                                class="token">@{{ dealer_name }}</span>!
                                                                            We're excited to help
                                                                            you find your perfect
                                                                            vehicle.</p>
                                                                        <p>If you have any questions, please don't hesitate
                                                                            to contact me.</p>
                                                                        <p><strong>Best regards,</strong><br>
                                                                            <span
                                                                                class="token">@{{ advisor_name }}</span><br>
                                                                            <span
                                                                                class="token">@{{ dealer_name }}</span><br>
                                                                            Phone: <span
                                                                                class="token">@{{ dealer_phone }}</span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <script>
                                                        (function(){
                                                            const editor = document.getElementById('editor');
                                                            const preview = document.getElementById('preview');
                                                            const htmlTextarea = document.getElementById('htmlTextarea');
                                                            const mobileBtn = document.getElementById('mobileBtn');
                                                            const desktopBtn = document.getElementById('desktopBtn');
                                                            let updateTimer = null;

                                                            function getEditorContent(){
                                                                try{
                                                                    if (htmlTextarea && htmlTextarea.style.display !== 'none') return htmlTextarea.value;
                                                                    return editor ? editor.innerHTML : '';
                                                                }catch(e){ return ''; }
                                                            }

                                                            function ensurePreviewBody(){
                                                                if (!preview) return null;
                                                                let body = preview.querySelector('.template-preview');
                                                                if (!body){
                                                                    body = document.createElement('div');
                                                                    body.className = 'template-preview';
                                                                    preview.appendChild(body);
                                                                }
                                                                return body;
                                                            }

                                                            function updateLivePreview(){
                                                                const body = ensurePreviewBody();
                                                                if (!body) return;
                                                                // Mirror the editor HTML into the preview
                                                                body.innerHTML = getEditorContent();
                                                            }

                                                            function scheduleUpdate(){
                                                                clearTimeout(updateTimer);
                                                                updateTimer = setTimeout(updateLivePreview, 120);
                                                            }

                                                            // Bind events
                                                            if (editor) {
                                                                ['input','keyup','paste'].forEach(evt => editor.addEventListener(evt, scheduleUpdate));
                                                                // also update when toolbar actions change content via execCommand
                                                                document.addEventListener('selectionchange', scheduleUpdate);
                                                            }
                                                            if (htmlTextarea) htmlTextarea.addEventListener('input', scheduleUpdate);

                                                            // Device toggle
                                                            if (mobileBtn && desktopBtn && preview){
                                                                mobileBtn.addEventListener('click', function(){
                                                                    mobileBtn.classList.add('active');
                                                                    desktopBtn.classList.remove('active');
                                                                    preview.classList.add('preview-mobile');
                                                                });
                                                                desktopBtn.addEventListener('click', function(){
                                                                    desktopBtn.classList.add('active');
                                                                    mobileBtn.classList.remove('active');
                                                                    preview.classList.remove('preview-mobile');
                                                                });
                                                            }

                                                            // Initial render
                                                            document.addEventListener('DOMContentLoaded', function(){ scheduleUpdate(); });
                                                        })();
                                                        </script>

                                                        <div class="preview-container">
                                                            <div
                                                                class="preview-header d-flex justify-content-between flex-wrap">
                                                                <h6 class="mb-0 text-white">Live Preview</h6>
                                                                <div class="device-toggle">
                                                                    <button type="button" id="mobileBtn"
                                                                        class="active "><i
                                                                            class="bi bi-phone"></i></button>
                                                                    <button type="button" id="desktopBtn"><i
                                                                            class="bi bi-display"></i></button>
                                                                </div>
                                                            </div>
                                                            <div class="preview-content" id="preview">
                                                                <div class="template-preview">
                                                                    <h3>Sample Template</h3>
                                                                    <p>This is a sample template preview. When you click the
                                                                        mobile button, you'll see
                                                                        how this template looks
                                                                        on a mobile device.</p>
                                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing
                                                                        elit. Sed do eiusmod tempor
                                                                        incididunt ut labore et
                                                                        dolore magna aliqua.</p>
                                                                    <button class="btn">Call to Action</button>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>

                                                    <div class="col-12 col-lg-4">
                                                        @include('components.merge-fields')
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
                                                            <small class="opacity-75">Create professional content in
                                                                seconds</small>
                                                        </div>
                                                        <button class="btn-close btn-close-white"
                                                            id="closeAIModal"></button>
                                                    </div>

                                                    <div class="ai-modal-body">
                                                        <div id="aiOptions">
                                                            <div class="ai-option-card" data-action="generate-email">
                                                                <div class="ai-option-icon">
                                                                    <i class="bi bi-envelope-fill"></i>
                                                                </div>
                                                                <h6 class="mb-1">Generate Complete Email</h6>
                                                                <p class="text-muted small mb-0">Describe what you need
                                                                    and AI will create a full
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
                                                                <p class="text-muted small mb-0">Create compelling subject
                                                                    lines</p>
                                                            </div>

                                                            <div class="ai-option-card" data-action="generate-image">
                                                                <div class="ai-option-icon">
                                                                    <i class="bi bi-image-fill"></i>
                                                                </div>
                                                                <h6 class="mb-1">Generate Image</h6>
                                                                <p class="text-muted small mb-0">Describe an image and AI
                                                                    will create it</p>
                                                            </div>
                                                        </div>

                                                        <div class="ai-input-section" id="aiInputSection">
                                                            <button class="btn btn-sm btn-outline-secondary mb-3"
                                                                id="btnBackToOptions">
                                                                <i class="bi bi-arrow-left me-1"></i> Back
                                                            </button>

                                                            <div id="aiInputContent"></div>
                                                        </div>

                                                        <div class="ai-generating" id="aiGenerating">
                                                            <div class="ai-spinner"></div>
                                                            <h6>AI is working its magic...</h6>
                                                            <p class="text-muted small">Creating your content with
                                                                professional formatting</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="image-controls" id="imageControls">
                                                <div class="image-control-section">
                                                    <span class="image-control-label">Alignment</span>
                                                    <div class="image-align-btns">
                                                        <button class="image-align-btn btn btn-light border-1 border"
                                                            data-align="left"><i class="bi bi-align-start"></i></button>
                                                        <button class="image-align-btn btn btn-light border-1 border"
                                                            data-align="center"><i
                                                                class="bi bi-align-center"></i></button>
                                                        <button class="image-align-btn btn btn-light border-1 border"
                                                            data-align="right"><i class="bi bi-align-end"></i></button>
                                                    </div>
                                                </div>
                                                <div class="image-control-section">
                                                    <span class="image-control-label form-label">Size</span>
                                                    <div class="image-size-inputs">
                                                        <div class="image-size-group mb-2">
                                                            <span class="image-size-label form-label">Width (px)</span>
                                                            <input type="number" class="image-size-input form-control"
                                                                id="imageWidth" min="50" step="10">
                                                        </div>
                                                        <div class="image-size-group mb-2">
                                                            <span class="image-size-label form-label">Height (px)</span>
                                                            <input type="number" class="image-size-input form-control"
                                                                id="imageHeight" min="50" step="10">
                                                        </div>
                                                    </div>
                                                    <label class="image-lock-aspect mb-2">
                                                        <input type="checkbox" id="lockAspectRatio" checked>
                                                        <span class="form-label">Lock aspect ratio</span>
                                                    </label>
                                                </div>
                                                <div class="image-control-actions mb-2">
                                                    <button class="image-control-btn btn btn-light border border-1"
                                                        id="resetImageSize"><i
                                                            class="bi bi-arrow-counterclockwise me-1"></i>Reset</button>
                                                    <button class="image-control-btn danger btn btn-danger"
                                                        id="deleteImage"><i class="bi bi-trash me-1"></i>Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <!-- Step 2 -->
                                <div class="tab-pane" id="profile-tab-2">
                                    <div class="row g-2">
                                        <div class="col-md-4 mb-2">
                                            <label class="form-label">Campaign Name</label>
                                            <input type="text" class="form-control" id="campaignNameField">
                                        </div>

                                        <div class="col-md-4 mb-2" id="startDateCol">
                                            <label class="form-label">Start Date</label>
                                            <input type="datetime-local" class="form-control" id="startDate">
                                        </div>
                                        <div class="col-md-4 mb-3" id="endDateCol">
                                            <label class="form-label">End Date</label>
                                            <input type="datetime-local" class="form-control" id="endDate">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Set Type</label>
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" id="massSend" name="customRadio1"
                                                        class="form-check-input">
                                                    <label class="form-check-label" for="massSend">One-time Mass
                                                        Send</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" id="dripFunction" name="customRadio1"
                                                        class="form-check-input" checked>
                                                    <label class="form-check-label" for="dripFunction">Dripping
                                                        Function</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="bg-light p-2 text-center" id="mass-box"
                                                style="display: block;">
                                                <i>This campaign will send 75 messages on June 28, 2025 at 8:15 PM</i>
                                            </div>
                                            <div class="bg-light p-2 text-center" id="dripping-box"
                                                style="display: none;">
                                                <div class="row g-2">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Initial receipt count</label>
                                                        <input type="text" id="dripInitialCount" class="bg-white form-control">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Sent the remaining over</label>
                                                        <input type="number" id="dripDays" class="bg-white form-control">
                                                        <span>(days)</span>
                                                    </div>
                                                </div>
                                                <p class="fst-italic mt-2">
                                                    You have to put at least one day or select the One-time Mass Send
                                                    dripping function.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 3 -->
                                <div class="tab-pane" id="finish-2">
                                    <div class="row g-4">
                                        <div class="col-12">

                                            <div class="p-4 rounded border  bg-white">

                                                <!-- Section 1: Email Details -->
                                                <h6 class="border-bottom pb-2 mb-3 text-primary">Email Details</h6>
                                                <div class="row g-3">

                                                    <div class="col-md-6"><strong>Template:</strong> <span
                                                            id="summaryTemplate">Book Dream
                                                            Car</span></div>

                                                    <div class="col-md-6"><strong>Sender:</strong> <span
                                                            id="summarySender">Sunny Bonnard
                                                            (me)</span></div>
                                                    <div class="col-md-6"><strong>Backup Sender:</strong> <span
                                                            id="summaryFallbackSender">Sunny
                                                            Bonnard (me)</span></div>
                                                    <div class="col-md-6"><strong>Assigned To:</strong> <span
                                                            id="summaryAssignedTo">Sunny
                                                            Bonnard (me)</span></div>

                                                    <div class="col-md-6"><strong>Language:</strong> <span
                                                            id="summaryLanguage">EN</span></div>
                                                    <div class="col-md-6"><strong>Subject:</strong> <span
                                                            id="summarySubject">Exclusive Offer
                                                            Inside</span></div>
                                                    <div class="col-md-12">
                                                        <strong>Body:</strong>
                                                        <div class="bg-light border p-3 rounded mt-1" id="summaryBody">
                                                            Hello, this is a sample email body preview shown here...
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Section 2: Campaign Settings -->
                                                <h6 class="border-bottom pb-2 my-4 text-primary">Campaign Settings</h6>
                                                <div class="row g-3">
                                                    <div class="col-md-6"><strong>Campaign Name:</strong> <span
                                                            id="summaryCampaignName">July
                                                            Sale Blast</span></div>

                                                    <div class="col-md-6"><strong>Start Date:</strong> <span
                                                            id="summaryStartDate">2025-07-15
                                                            10:00 AM</span></div>
                                                    <div class="col-md-6"><strong>End Date:</strong> <span
                                                            id="summaryEndDate">2025-07-20 6:00
                                                            PM</span></div>

                                                    <div class="col-md-6"><strong>Set Type:</strong> <span
                                                            id="summarySetType">One-time Mass
                                                            Send</span></div>
                                                </div>

                                                <!-- Section 3: Drip & Stats -->
                                                <h6 class="border-bottom pb-2 my-4 text-primary">Drip & Delivery Stats
                                                </h6>
                                                <div class="row g-3">
                                                    <div class="col-md-6"><strong>Total Recipients:</strong> <span
                                                            id="summaryRecipients">75
                                                            selected</span></div>
                                                    <div class="col-md-6"><strong>Excluded:</strong> <span
                                                            id="summaryExcluded">5
                                                            unsubscribed</span></div>
                                                    <div class="col-md-6"><strong>Drip Schedule:</strong> <span
                                                            id="summaryDripSchedule">25 per
                                                            day</span></div>
                                                    <div class="col-md-6"><strong>Total Messages:</strong> <span
                                                            id="summaryDripTotal">75
                                                            messages</span></div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Wizard Navigation -->
                                <div class="d-flex wizard justify-content-between flex-wrap gap-2 mt-3">
                                    <div class="first">
                                        <a href="javascript:void(0);" class="btn btn-light border border-1"
                                            id="firstStep">First</a>
                                    </div>
                                    <div class="d-flex flex-wrap gap-2">
                                        <div class="previous">
                                            <a href="javascript:void(0);" class="btn btn-light border border-1"
                                                id="prevStep">
                                                <i class="ti ti-arrow-left me-2"></i>Back To Previous
                                            </a>
                                        </div>
                                        <div class="next">
                                            <a href="javascript:void(0);" class="btn btn-primary mt-3 mt-md-0"
                                                id="nextStep">
                                                Next Step<i class="ti ti-arrow-right ms-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="last">
                                        <a href="javascript:void(0);" class="btn btn-primary mt-3 mt-md-0"
                                            id="finishStep">
                                            Confirm & Send Campaign <i class="ti ti-send ms-1"></i>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!---- Duplicate Customer Modal -->
   @include('customers.merge_customer')
   @include('customers.import')

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content text-center">
                <div class="modal-body p-4">
                    <i class="fas fa-check-circle text-success mb-3" style="font-size: 48px;"></i>
                    <h5>Records Merged Successfully!</h5>
                    <p class="text-muted">The duplicate customer record has been merged with the main record.</p>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<!-- Delete Customer Modal -->
<div class="modal fade" id="delete_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="mb-3">
                    <img src="assets/img/icons/delete.svg" alt="img">
                </div>
                <h6 class="mb-1">Delete Customer</h6>
                <p class="mb-3" id="delete_modal_text">Are you sure you want to delete this customer?</p>
                <div class="d-flex justify-content-center align-items-center gap-2">
                    <button type="button" class="btn btn-light border border-1 " data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirm_delete_btn">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

    {{-- Customer Profile Offcanvas --}}


      
 
@endsection

<!-- Send To DMS Modal (added) -->
<!-- sendToDmsModal is provided globally in layouts/app.blade.php; no local duplicate here -->

@push('scripts')
    @include('customers.customer_script');
    @include('customers.script');
@endpush

@push('styles')
    {{-- Flatpickr CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@prepend('scripts')
    {{-- Required Libraries - Load First --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
@endprepend
