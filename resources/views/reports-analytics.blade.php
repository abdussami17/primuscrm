@extends('layouts.app')


@section('title','Reports & Analytics')


@section('content')

<div class="content content-two pt-0">
    <!-- Page Header -->
    <div class="position-relative d-flex align-items-center justify-content-between flex-wrap gap-3 mb-2"
      style="min-height: 80px;">
      <!-- Left: Title -->
      <div>
        <h6 class="mb-0">Reports & Analytics</h6>
      </div>

      <!-- Center: Logo -->
      <img src="assets/light_logo.png" alt="Logo" class="mobile-logo-no logo-img"
        style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); max-width: 80px; height: auto;">
      <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
        <div>
          <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#leadFilterModal" class="btn btn-primary d-flex align-items-center">
                    <i class="isax isax-add-circle5 me-1"></i>Create Report
                  </a>
        </div>
      </div>

    </div>


  
    <div class="table-responsive table-nowrap">
        <table class="table border shadow-sm">
            <thead style="background: linear-gradient(135deg, rgb(0, 33, 64) 0%, rgb(0, 50, 96) 100%);">
                <tr>
                    <th class="no-sort" style="width: 50px; padding: 16px 12px;">
                        <div class="form-check form-check-md">
                            <input class="form-check-input" type="checkbox" id="select-all">
                        </div>
                    </th>
                    <th style="font-size: 15px; font-weight: 600; color: #ffffff; padding: 16px 12px;">
                        <i class="ti ti-file-text me-2" style="color: #fff;"></i>Title
                    </th>
                    <th style="font-size: 15px; font-weight: 600; color: #ffffff; padding: 16px 12px;">
                        <i class="ti ti-user me-2" style="color: #fff;"></i>Created By
                    </th>
                    <th class="no-sort text-end" style="font-size: 15px; font-weight: 600; color: #ffffff; padding: 16px 12px;">
                        <i class="ti ti-settings me-2" style="color: #fff;"></i>Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr style="border-bottom: 1px solid #e9ecef; transition: all 0.3s ease;">
                    <td style="vertical-align: middle; padding: 16px 12px;">
                        <div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>
                    </td>
                    <td style="padding: 16px 12px; vertical-align: middle;">
                        <a href="{{ route('reports.show', 'activity-report_new') }}" class="text-decoration-underline" style="font-weight: 600; font-size: 14px; color: var(--name-change);" target="_blank">Activity Report</a>
                        <div style="font-size: 12px; color: #6c757d; margin-top: 3px;">View detailed activity metrics</div>
                    </td>
                    <td style="padding: 16px 12px; vertical-align: middle;">
                        <span style="font-size: 13px; color: var(--name-change); font-weight: 500;">Armanda Roiz</span>
                    </td>
                    <td class="action-item text-end" style="padding: 16px 12px; vertical-align: middle;">
                        <div class="reports-action">
                            <a href="#modalDownload" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-download" data-bs-toggle="tooltip" title="Download as PDF or Excel"></i>
                            </a>
                            <a href="#modalStar" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-star" data-bs-toggle="tooltip" title="Add To Favourites"></i>
                            </a>
                            <a href="javascript:void(0)" data-bs-target="#modalExport" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-package-export" data-bs-toggle="tooltip" title="Schedule Delivery or Edit Schedule"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                
                <tr style="border-bottom: 1px solid #e9ecef; transition: all 0.3s ease;">
                    <td style="vertical-align: middle; padding: 16px 12px;">
                        <div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>
                    </td>
                    <td style="padding: 16px 12px; vertical-align: middle;">
                        <a href="{{ route('reports.show', 'sold_deals-report') }}" class="text-decoration-underline" style="font-weight: 600; font-size: 14px; color: var(--name-change);" target="_blank">Sold Deals Report</a>
                        <div style="font-size: 12px; color: #6c757d; margin-top: 3px;">Track completed deals and transactions</div>
                    </td>
                    <td style="padding: 16px 12px; vertical-align: middle;">
                        <span style="font-size: 13px; color: var(--name-change); font-weight: 500;">Armanda Roiz</span>
                    </td>
                    <td class="action-item text-end" style="padding: 16px 12px; vertical-align: middle;">
                        <div class="reports-action">
                            <a href="#modalDownload" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-download" data-bs-toggle="tooltip" title="Download as PDF or Excel"></i>
                            </a>
                            <a href="#modalStar" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-star" data-bs-toggle="tooltip" title="Add To Favourites"></i>
                            </a>
                            <a href="javascript:void(0)" data-bs-target="#modalExport" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-package-export" data-bs-toggle="tooltip" title="Schedule Delivery or Edit Schedule"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                
                <tr style="border-bottom: 1px solid #e9ecef; transition: all 0.3s ease;">
                    <td style="vertical-align: middle; padding: 16px 12px;">
                        <div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>
                    </td>
                    <td style="padding: 16px 12px; vertical-align: middle;">
                        <a href="{{ route('reports.show', 'Internet-roi-report_new') }}" class="text-decoration-underline" style="font-weight: 600; font-size: 14px; color: var(--name-change);" target="_blank">Internet ROI Report</a>
                        <div style="font-size: 12px; color: #6c757d; margin-top: 3px;">Analyze return on investment metrics</div>
                    </td>
                    <td style="padding: 16px 12px; vertical-align: middle;">
                        <span style="font-size: 13px; color: var(--name-change); font-weight: 500;">Armanda Roiz</span>
                    </td>
                    <td class="action-item text-end" style="padding: 16px 12px; vertical-align: middle;">
                        <div class="reports-action">
                            <a href="#modalDownload" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-download" data-bs-toggle="tooltip" title="Download as PDF or Excel"></i>
                            </a>
                            <a href="#modalStar" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-star" data-bs-toggle="tooltip" title="Add To Favourites"></i>
                            </a>
                            <a href="javascript:void(0)" data-bs-target="#modalExport" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-package-export" data-bs-toggle="tooltip" title="Schedule Delivery or Edit Schedule"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                
                <tr style="border-bottom: 1px solid #e9ecef; transition: all 0.3s ease;">
                    <td style="vertical-align: middle; padding: 16px 12px;">
                        <div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>
                    </td>
                    <td style="padding: 16px 12px; vertical-align: middle;">
                        <a href="{{ route('reports.show', 'campaigns-report') }}" class="text-decoration-underline" style="font-weight: 600; font-size: 14px; color: var(--name-change);" target="_blank">Campaigns Report</a>
                        <div style="font-size: 12px; color: #6c757d; margin-top: 3px;">Monitor campaign performance data</div>
                    </td>
                    <td style="padding: 16px 12px; vertical-align: middle;">
                        <span style="font-size: 13px; color: var(--name-change); font-weight: 500;">Armanda Roiz</span>
                    </td>
                    <td class="action-item text-end" style="padding: 16px 12px; vertical-align: middle;">
                        <div class="reports-action">
                            <a href="#modalDownload" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-download" data-bs-toggle="tooltip" title="Download as PDF or Excel"></i>
                            </a>
                            <a href="#modalStar" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-star" data-bs-toggle="tooltip" title="Add To Favourites"></i>
                            </a>
                            <a href="javascript:void(0)" data-bs-target="#modalExport" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-package-export" data-bs-toggle="tooltip" title="Schedule Delivery or Edit Schedule"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                
                <tr style="border-bottom: 1px solid #e9ecef; transition: all 0.3s ease;">
                    <td style="vertical-align: middle; padding: 16px 12px;">
                        <div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>
                    </td>
                    <td style="padding: 16px 12px; vertical-align: middle;">
                        <a href="{{ route('reports.show', 'dms-success-fail-report_new') }}" class="text-decoration-underline" style="font-weight: 600; font-size: 14px; color: var(--name-change);" target="_blank">DMS Success/Fail Report</a>
                        <div style="font-size: 12px; color: #6c757d; margin-top: 3px;">System integration status overview</div>
                    </td>
                    <td style="padding: 16px 12px; vertical-align: middle;">
                        <span style="font-size: 13px; color: var(--name-change); font-weight: 500;">Primus CRM</span>
                    </td>
                    <td class="action-item text-end" style="padding: 16px 12px; vertical-align: middle;">
                        <div class="reports-action">
                            <a href="#modalDownload" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-download" data-bs-toggle="tooltip" title="Download as PDF or Excel"></i>
                            </a>
                            <a href="#modalStar" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-star" data-bs-toggle="tooltip" title="Add To Favourites"></i>
                            </a>
                            <a href="javascript:void(0)" data-bs-target="#modalExport" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-package-export" data-bs-toggle="tooltip" title="Schedule Delivery or Edit Schedule"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                
                <tr style="border-bottom: 1px solid #e9ecef; transition: all 0.3s ease;">
                    <td style="vertical-align: middle; padding: 16px 12px;">
                        <div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>
                    </td>
                    <td style="padding: 16px 12px; vertical-align: middle;">
                        <a href="{{ route('reports.show', 'new-lead-by-rep-report_new') }}" class="text-decoration-underline" style="font-weight: 600; font-size: 14px; color: var(--name-change);" target="_blank">New Lead By Rep Report</a>
                        <div style="font-size: 12px; color: #6c757d; margin-top: 3px;">Track leads by sales representative</div>
                    </td>
                    <td style="padding: 16px 12px; vertical-align: middle;">
                        <span style="font-size: 13px; color: var(--name-change); font-weight: 500;">Primus CRM</span>
                    </td>
                    <td class="action-item text-end" style="padding: 16px 12px; vertical-align: middle;">
                        <div class="reports-action">
                            <a href="#modalDownload" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-download" data-bs-toggle="tooltip" title="Download as PDF or Excel"></i>
                            </a>
                            <a href="#modalStar" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-star" data-bs-toggle="tooltip" title="Add To Favourites"></i>
                            </a>
                            <a href="javascript:void(0)" data-bs-target="#modalExport" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-package-export" data-bs-toggle="tooltip" title="Schedule Delivery or Edit Schedule"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                
                <tr style="border-bottom: 1px solid #e9ecef; transition: all 0.3s ease;">
                    <td style="vertical-align: middle; padding: 16px 12px;">
                        <div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>
                    </td>
                    <td style="padding: 16px 12px; vertical-align: middle;">
                        <a href="{{ route('reports.show', 'service-appointment-report') }}" class="text-decoration-underline" style="font-weight: 600; font-size: 14px; color: var(--name-change);" target="_blank">Service Appointment Report</a>
                        <div style="font-size: 12px; color: #6c757d; margin-top: 3px;">Service scheduling and completion data</div>
                    </td>
                    <td style="padding: 16px 12px; vertical-align: middle;">
                        <span style="font-size: 13px; color: var(--name-change); font-weight: 500;">Primus CRM</span>
                    </td>
                    <td class="action-item text-end" style="padding: 16px 12px; vertical-align: middle;">
                        <div class="reports-action">
                            <a href="#modalDownload" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-download" data-bs-toggle="tooltip" title="Download as PDF or Excel"></i>
                            </a>
                            <a href="#modalStar" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-star" data-bs-toggle="tooltip" title="Add To Favourites"></i>
                            </a>
                            <a href="javascript:void(0)" data-bs-target="#modalExport" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-package-export" data-bs-toggle="tooltip" title="Schedule Delivery or Edit Schedule"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                
                <tr style="border-bottom: 1px solid #e9ecef; transition: all 0.3s ease;">
                    <td style="vertical-align: middle; padding: 16px 12px;">
                        <div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>
                    </td>
                    <td style="padding: 16px 12px; vertical-align: middle;">
                        <a href="{{ route('reports.show', 'lead-type&tracking-report') }}" class="text-decoration-underline" style="font-weight: 600; font-size: 14px; color: var(--name-change);" target="_blank">Lead Type & Tracking Code Report</a>
                        <div style="font-size: 12px; color: #6c757d; margin-top: 3px;">Lead source and tracking analysis</div>
                    </td>
                    <td style="padding: 16px 12px; vertical-align: middle;">
                        <span style="font-size: 13px; color: var(--name-change); font-weight: 500;">Primus CRM</span>
                    </td>
                    <td class="action-item text-end" style="padding: 16px 12px; vertical-align: middle;">
                        <div class="reports-action">
                            <a href="#modalDownload" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-download" data-bs-toggle="tooltip" title="Download as PDF or Excel"></i>
                            </a>
                            <a href="#modalStar" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-star" data-bs-toggle="tooltip" title="Add To Favourites"></i>
                            </a>
                            <a href="javascript:void(0)" data-bs-target="#modalExport" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-package-export" data-bs-toggle="tooltip" title="Schedule Delivery or Edit Schedule"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                
                <tr style="border-bottom: 1px solid #e9ecef; transition: all 0.3s ease;">
                    <td style="vertical-align: middle; padding: 16px 12px;">
                        <div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>
                    </td>
                    <td style="padding: 16px 12px; vertical-align: middle;">
                        <a href="{{ route('reports.show', 'sales-tracking-report') }}" class="text-decoration-underline" style="font-weight: 600; font-size: 14px; color: var(--name-change);" target="_blank">Sales Tracking Report</a>
                        <div style="font-size: 12px; color: #6c757d; margin-top: 3px;">Comprehensive sales pipeline tracking</div>
                    </td>
                    <td style="padding: 16px 12px; vertical-align: middle;">
                        <span style="font-size: 13px; color: var(--name-change); font-weight: 500;">Primus CRM</span>
                    </td>
                    <td class="action-item text-end" style="padding: 16px 12px; vertical-align: middle;">
                        <div class="reports-action">
                            <a href="#modalDownload" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-download" data-bs-toggle="tooltip" title="Download as PDF or Excel"></i>
                            </a>
                            <a href="#modalStar" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-star" data-bs-toggle="tooltip" title="Add To Favourites"></i>
                            </a>
                            <a href="javascript:void(0)" data-bs-target="#modalExport" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-package-export" data-bs-toggle="tooltip" title="Schedule Delivery or Edit Schedule"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                
                <tr style="border-bottom: 1px solid #e9ecef; transition: all 0.3s ease;">
                    <td style="vertical-align: middle; padding: 16px 12px;">
                        <div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>
                    </td>
                    <td style="padding: 16px 12px; vertical-align: middle;">
                        <a href="{{ route('reports.show', 'trade-in-report') }}" class="text-decoration-underline" style="font-weight: 600; font-size: 14px; color: var(--name-change);" target="_blank">Trade-In Report</a>
                        <div style="font-size: 12px; color: #6c757d; margin-top: 3px;">Vehicle trade-in transaction details</div>
                    </td>
                    <td style="padding: 16px 12px; vertical-align: middle;">
                        <span style="font-size: 13px; color: var(--name-change); font-weight: 500;">Primus CRM</span>
                    </td>
                    <td class="action-item text-end" style="padding: 16px 12px; vertical-align: middle;">
                        <div class="reports-action">
                            <a href="#modalDownload" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-download" data-bs-toggle="tooltip" title="Download as PDF or Excel"></i>
                            </a>
                            <a href="#modalStar" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-star" data-bs-toggle="tooltip" title="Add To Favourites"></i>
                            </a>
                            <a href="javascript:void(0)" data-bs-target="#modalExport" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-package-export" data-bs-toggle="tooltip" title="Schedule Delivery or Edit Schedule"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                
                <tr style="border-bottom: 1px solid #e9ecef; transition: all 0.3s ease;">
                    <td style="vertical-align: middle; padding: 16px 12px;">
                        <div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>
                    </td>
                    <td style="padding: 16px 12px; vertical-align: middle;">
                        <a href="{{ route('reports.show', 'customer-email-collection-report') }}" class="text-decoration-underline" style="font-weight: 600; font-size: 14px; color: var(--name-change);" target="_blank">Customer Email Collection Report</a>
                        <div style="font-size: 12px; color: #6c757d; margin-top: 3px;">Email database growth metrics</div>
                    </td>
                    <td style="padding: 16px 12px; vertical-align: middle;">
                        <span style="font-size: 13px; color: var(--name-change); font-weight: 500;">Primus CRM</span>
                    </td>
                    <td class="action-item text-end" style="padding: 16px 12px; vertical-align: middle;">
                        <div class="reports-action">
                            <a href="#modalDownload" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-download" data-bs-toggle="tooltip" title="Download as PDF or Excel"></i>
                            </a>
                            <a href="#modalStar" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-star" data-bs-toggle="tooltip" title="Add To Favourites"></i>
                            </a>
                            <a href="javascript:void(0)" data-bs-target="#modalExport" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-package-export" data-bs-toggle="tooltip" title="Schedule Delivery or Edit Schedule"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                
                <tr style="border-bottom: 1px solid #e9ecef; transition: all 0.3s ease;">
                    <td style="vertical-align: middle; padding: 16px 12px;">
                        <div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>
                    </td>
                    <td style="padding: 16px 12px; vertical-align: middle;">
                        <a href="{{ route('reports.show', 'invalid-email-report') }}" class="text-decoration-underline" style="font-weight: 600; font-size: 14px; color: var(--name-change);" target="_blank">Invalid Email Report</a>
                        <div style="font-size: 12px; color: #6c757d; margin-top: 3px;">Identify and clean invalid contacts</div>
                    </td>
                    <td style="padding: 16px 12px; vertical-align: middle;">
                        <span style="font-size: 13px; color: var(--name-change); font-weight: 500;">Primus CRM</span>
                    </td>
                    <td class="action-item text-end" style="padding: 16px 12px; vertical-align: middle;">
                        <div class="reports-action">
                            <a href="#modalDownload" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-download" data-bs-toggle="tooltip" title="Download as PDF or Excel"></i>
                            </a>
                            <a href="#modalStar" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-star" data-bs-toggle="tooltip" title="Add To Favourites"></i>
                            </a>
                            <a href="javascript:void(0)" data-bs-target="#modalExport" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-package-export" data-bs-toggle="tooltip" title="Schedule Delivery or Edit Schedule"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                
                <tr style="border-bottom: 1px solid #e9ecef; transition: all 0.3s ease;">
                    <td style="vertical-align: middle; padding: 16px 12px;">
                        <div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>
                    </td>
                    <td style="padding: 16px 12px; vertical-align: middle;">
                        <a href="{{ route('reports.show', 'appointment-capture-report') }}" class="text-decoration-underline" style="font-weight: 600; font-size: 14px; color: var(--name-change);" target="_blank">Appointment Capture Report</a>
                        <div style="font-size: 12px; color: #6c757d; margin-top: 3px;">Appointment booking effectiveness</div>
                    </td>
                    <td style="padding: 16px 12px; vertical-align: middle;">
                        <span style="font-size: 13px; color: var(--name-change); font-weight: 500;">Primus CRM</span>
                    </td>
                    <td class="action-item text-end" style="padding: 16px 12px; vertical-align: middle;">
                        <div class="reports-action">
                            <a href="#modalDownload" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                                <i class="ti ti-download" data-bs-toggle="tooltip" title="Download as PDF or Excel"></i>
                            </a>
                            <a href="#modalStar" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                              <i class="ti ti-star" data-bs-toggle="tooltip" title="Add To Favourites"></i>
                          </a>
                          <a href="javascript:void(0)" data-bs-target="#modalExport" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                              <i class="ti ti-package-export" data-bs-toggle="tooltip" title="Schedule Delivery or Edit Schedule"></i>
                          </a>
                      </div>
                  </td>
              </tr>
              
              <tr style="border-bottom: 1px solid #e9ecef; transition: all 0.3s ease;">
                  <td style="vertical-align: middle; padding: 16px 12px;">
                      <div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>
                  </td>
                  <td style="padding: 16px 12px; vertical-align: middle;">
                      <a href="{{ route('reports.show', 'text-sent-received-report') }}" class="text-decoration-underline" style="font-weight: 600; font-size: 14px; color: var(--name-change);" target="_blank">Text Send / Received Report</a>
                      <div style="font-size: 12px; color: #6c757d; margin-top: 3px;">SMS communication analytics</div>
                  </td>
                  <td style="padding: 16px 12px; vertical-align: middle;">
                      <span style="font-size: 13px; color: var(--name-change); font-weight: 500;">Primus CRM</span>
                  </td>
                  <td class="action-item text-end" style="padding: 16px 12px; vertical-align: middle;">
                      <div class="reports-action">
                          <a href="#modalDownload" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                              <i class="ti ti-download" data-bs-toggle="tooltip" title="Download as PDF or Excel"></i>
                          </a>
                          <a href="#modalStar" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                              <i class="ti ti-star" data-bs-toggle="tooltip" title="Add To Favourites"></i>
                          </a>
                          <a href="javascript:void(0)" data-bs-target="#modalExport" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                              <i class="ti ti-package-export" data-bs-toggle="tooltip" title="Schedule Delivery or Edit Schedule"></i>
                          </a>
                      </div>
                  </td>
              </tr>
              
              <tr style="border-bottom: 1px solid #e9ecef; transition: all 0.3s ease;">
                  <td style="vertical-align: middle; padding: 16px 12px;">
                      <div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>
                  </td>
                  <td style="padding: 16px 12px; vertical-align: middle;">
                      <a href="{{ route('reports.show', 'email-sent-received-report') }}" class="text-decoration-underline" style="font-weight: 600; font-size: 14px; color: var(--name-change);" target="_blank">Email Send / Received Report</a>
                      <div style="font-size: 12px; color: #6c757d; margin-top: 3px;">Email campaign performance metrics</div>
                  </td>
                  <td style="padding: 16px 12px; vertical-align: middle;">
                      <span style="font-size: 13px; color: var(--name-change); font-weight: 500;">Primus CRM</span>
                  </td>
                  <td class="action-item text-end" style="padding: 16px 12px; vertical-align: middle;">
                      <div class="reports-action">
                          <a href="#modalDownload" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                              <i class="ti ti-download" data-bs-toggle="tooltip" title="Download as PDF or Excel"></i>
                          </a>
                          <a href="#modalStar" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                              <i class="ti ti-star" data-bs-toggle="tooltip" title="Add To Favourites"></i>
                          </a>
                          <a href="javascript:void(0)" data-bs-target="#modalExport" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                              <i class="ti ti-package-export" data-bs-toggle="tooltip" title="Schedule Delivery or Edit Schedule"></i>
                          </a>
                      </div>
                  </td>
              </tr>
              
              <tr style="border-bottom: 1px solid #e9ecef; transition: all 0.3s ease;">
                  <td style="vertical-align: middle; padding: 16px 12px;">
                      <div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>
                  </td>
                  <td style="padding: 16px 12px; vertical-align: middle;">
                      <a href="{{ route('reports.show', 'user-activity-report') }}" class="text-decoration-underline" style="font-weight: 600; font-size: 14px; color: var(--name-change);" target="_blank">User Activity Report</a>
                      <div style="font-size: 12px; color: #6c757d; margin-top: 3px;">System user engagement tracking</div>
                  </td>
                  <td style="padding: 16px 12px; vertical-align: middle;">
                      <span style="font-size: 13px; color: var(--name-change); font-weight: 500;">Primus CRM</span>
                  </td>
                  <td class="action-item text-end" style="padding: 16px 12px; vertical-align: middle;">
                      <div class="reports-action">
                          <a href="#modalDownload" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                              <i class="ti ti-download" data-bs-toggle="tooltip" title="Download as PDF or Excel"></i>
                          </a>
                          <a href="#modalStar" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                              <i class="ti ti-star" data-bs-toggle="tooltip" title="Add To Favourites"></i>
                          </a>
                          <a href="javascript:void(0)" data-bs-target="#modalExport" data-bs-toggle="modal" style="margin: 0 6px; color: var(--name-change); font-size: 18px;">
                              <i class="ti ti-package-export" data-bs-toggle="tooltip" title="Schedule Delivery or Edit Schedule"></i>
                          </a>
                      </div>
                  </td>
              </tr>
          </tbody>
      </table>
  </div>
  
  <style>
      /* Hover effect for table rows */
      tbody tr:hover {
          background-color: rgba(0, 33, 64, 0.03);
          box-shadow: 0 2px 8px rgba(0, 33, 64, 0.08);
          transform: translateY(-1px);
      }
      
      /* Icon hover effects */
      .reports-action a:hover i {
          transform: scale(1.15);
          transition: transform 0.2s ease;
      }
      
      /* Table border radius */
      .table {
          border-radius: 8px;
          overflow: hidden;
      }
      
      /* Smooth transitions */
      tbody tr {
          transition: all 0.3s ease;
      }
      
      .reports-action a {
          transition: all 0.2s ease;
      }
      
      /* Action icons spacing and alignment */
      .reports-action {
          display: inline-flex;
          gap: 4px;
          align-items: center;
      }
  </style>
  </div>


<!-- Schedule Delivery Modal -->
<div class="modal fade" id="modalExport" tabindex="-1" aria-labelledby="modalExportLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header border-0 pb-0">
                <div>
                    <h4 class="modal-title fw-bold mb-1" id="modalExportLabel" style="color: var(--name-change); font-size: 1.5rem;">
                        Schedule Report Delivery
                    </h4>
                    <p class="text-muted mb-0" style="font-size: 0.875rem;">Set up automated delivery for your reports</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
  
            <!-- Modal Body -->
            <div class="modal-body pt-4">
                <form id="scheduleForm">
                    <!-- Recipients Section -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold mb-2" style="color: var(--name-change); font-size: 1rem;">
                            <i class="ti ti-users me-2" style="color: rgb(0, 100, 180);"></i>Recipients
                        </label>
                        <select class="form-select" id="recipients" multiple style="min-height: 120px; border-color: #d1d5db;">
                            <option value="user1">Armanda Roiz (armanda@company.com)</option>
                            <option value="user2">John Smith (john@company.com)</option>
                            <option value="user3">Sarah Johnson (sarah@company.com)</option>
                            <option value="user4">Michael Brown (michael@company.com)</option>
                            <option value="user5">Emily Davis (emily@company.com)</option>
                        </select>
                        <small class="text-muted d-block mt-1" style="font-size: 0.8rem;">
                            Hold Ctrl/Cmd to select multiple recipients
                        </small>
                    </div>
  
                    <!-- Divider -->
                    <hr class="my-4" style="border-color: #e5e7eb;">
  
                    <!-- Email Subject -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold mb-2" style="color: var(--name-change); font-size: 1rem;">
                            <i class="ti ti-mail me-2" style="color: rgb(0, 100, 180);"></i>Subject Line
                        </label>
                        <input type="text" class="form-control" id="emailSubject" placeholder="e.g., Monthly Sales Report - October 2025" style="border-color: #d1d5db;">
                    </div>
  
                    <!-- Email Body -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold mb-2" style="color: var(--name-change); font-size: 1rem;">
                            <i class="ti ti-message-circle me-2" style="color: rgb(0, 100, 180);"></i>Message Body
                        </label>
                        <textarea class="form-control" id="emailBody" rows="5" placeholder="Enter your message here..." style="border-color: #d1d5db; resize: vertical;"></textarea>
                        <small class="text-muted d-block mt-1" style="font-size: 0.8rem;">
                            Optional: Add custom message to include with the report
                        </small>
                    </div>
  
                    <!-- Divider -->
                    <hr class="my-4" style="border-color: #e5e7eb;">
  
                    <!-- Schedule Settings -->
                    <div class="row g-3 mb-4">
                        <!-- Frequency -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold mb-2" style="color: var(--name-change); font-size: 1rem;">
                                <i class="ti ti-repeat me-2" style="color: rgb(0, 100, 180);"></i>Frequency
                            </label>
                            <select class="form-select" id="frequency" style="border-color: #d1d5db;">
                                <option value="once">One Time</option>
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option>
                                <option value="monthly">Monthly</option>
                                <option value="custom">Custom</option>
                            </select>
                        </div>
  
                        <!-- Format -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold mb-2" style="color: var(--name-change); font-size: 1rem;">
                                <i class="ti ti-file-type-pdf me-2" style="color: rgb(0, 100, 180);"></i>File Format
                            </label>
                            <select class="form-select" id="fileFormat" style="border-color: #d1d5db;">
                                <option value="pdf">PDF Document</option>
                                <option value="excel">Excel Spreadsheet</option>
                                <option value="csv">CSV File</option>
                            </select>
                        </div>
                    </div>
  
                    <!-- Date & Time Pickers -->
                    <div class="row g-3 mb-4">
                        <!-- Start Date -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold mb-2" style="color: var(--name-change); font-size: 1rem;">
                                <i class="ti ti-calendar me-2" style="color: rgb(0, 100, 180);"></i>Start Date
                            </label>
                            <input type="date" class="form-control" id="startDate" style="border-color: #d1d5db;">
                        </div>
  
                        <!-- Time -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold mb-2" style="color: var(--name-change); font-size: 1rem;">
                                <i class="ti ti-clock me-2" style="color: rgb(0, 100, 180);"></i>Delivery Time
                            </label>
                            <input type="time" class="form-control" id="deliveryTime" style="border-color: #d1d5db;">
                        </div>
                    </div>
  
                    <!-- Custom Frequency Options (Hidden by default) -->
                    <div class="custom-frequency-options d-none mb-4" id="customOptions">
                        <div class="p-3 rounded" style="background-color: #f9fafb; border: 1px solid #e5e7eb;">
                            <label class="form-label fw-semibold mb-3" style="color: var(--name-change); font-size: 0.95rem;">
                                Select Days of Week
                            </label>
                            <div class="d-flex flex-wrap gap-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="mon" value="monday">
                                    <label class="form-check-label" for="mon">Mon</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="tue" value="tuesday">
                                    <label class="form-check-label" for="tue">Tue</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="wed" value="wednesday">
                                    <label class="form-check-label" for="wed">Wed</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="thu" value="thursday">
                                    <label class="form-check-label" for="thu">Thu</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="fri" value="friday">
                                    <label class="form-check-label" for="fri">Fri</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="sat" value="saturday">
                                    <label class="form-check-label" for="sat">Sat</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="sun" value="sunday">
                                    <label class="form-check-label" for="sun">Sun</label>
                                </div>
                            </div>
                        </div>
                    </div>
  
                    <!-- Summary Card -->
                    <div class="alert d-flex align-items-start" role="alert" style="background-color: #eff6ff; border-left: 4px solid rgb(0, 100, 180); border-radius: 0.375rem;">
                        <i class="ti ti-info-circle me-3 mt-1" style="color: rgb(0, 100, 180); font-size: 1.25rem;"></i>
                        <div>
                            <strong class="d-block mb-1" style="color: var(--name-change); font-size: 0.95rem;">Schedule Summary</strong>
                            <p class="mb-0 text-muted" style="font-size: 0.85rem;" id="scheduleSummary">
                                Please fill in the form to see your delivery schedule summary
                            </p>
                        </div>
                    </div>
                </form>
            </div>
  
            <!-- Modal Footer -->
            <div class="modal-footer border-0 ">
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" style="border: 1px solid #d1d5db;">
                    Cancel
                </button>
                <button type="button" class="btn px-4" style="background-color: var(--name-change); color: white;" onclick="scheduleDelivery()">
                    <i class="ti ti-check me-2"></i>Schedule Delivery
                </button>
            </div>
        </div>
    </div>
  </div>

  <!-- JavaScript for Dynamic Functionality -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
      // Show/hide custom frequency options
      const frequencySelect = document.getElementById('frequency');
      const customOptions = document.getElementById('customOptions');
      
      frequencySelect.addEventListener('change', function() {
          if (this.value === 'custom') {
              customOptions.classList.remove('d-none');
          } else {
              customOptions.classList.add('d-none');
          }
          updateSummary();
      });
    
      // Update summary on any form change
      const formInputs = document.querySelectorAll('#scheduleForm input, #scheduleForm select, #scheduleForm textarea');
      formInputs.forEach(input => {
          input.addEventListener('change', updateSummary);
          input.addEventListener('input', updateSummary);
      });
    
      function updateSummary() {
          const recipients = document.getElementById('recipients');
          const frequency = document.getElementById('frequency');
          const startDate = document.getElementById('startDate');
          const deliveryTime = document.getElementById('deliveryTime');
          const fileFormat = document.getElementById('fileFormat');
          const summaryEl = document.getElementById('scheduleSummary');
    
          const selectedRecipients = Array.from(recipients.selectedOptions).length;
          const freqText = frequency.options[frequency.selectedIndex]?.text || '';
          const formatText = fileFormat.options[fileFormat.selectedIndex]?.text || '';
    
          if (selectedRecipients > 0 && startDate.value && deliveryTime.value) {
              const dateObj = new Date(startDate.value);
              const formattedDate = dateObj.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
              
              summaryEl.innerHTML = `Your report will be delivered as <strong>${formatText}</strong> to <strong>${selectedRecipients} recipient(s)</strong> starting <strong>${formattedDate}</strong> at <strong>${deliveryTime.value}</strong> on a <strong>${freqText.toLowerCase()}</strong> basis.`;
          } else {
              summaryEl.innerHTML = 'Please fill in the form to see your delivery schedule summary';
          }
      }
    
      // Set default date to today
      const today = new Date().toISOString().split('T')[0];
      document.getElementById('startDate').value = today;
      
      // Set default time to 9:00 AM
      document.getElementById('deliveryTime').value = '09:00';
      
      updateSummary();
    });
    
    function scheduleDelivery() {
      const recipients = document.getElementById('recipients');
      const subject = document.getElementById('emailSubject').value;
      const body = document.getElementById('emailBody').value;
      const frequency = document.getElementById('frequency').value;
      const startDate = document.getElementById('startDate').value;
      const deliveryTime = document.getElementById('deliveryTime').value;
      const fileFormat = document.getElementById('fileFormat').value;
    
      // Validation
      if (recipients.selectedOptions.length === 0) {
          alert('Please select at least one recipient');
          return;
      }
    
      if (!subject.trim()) {
          alert('Please enter a subject line');
          return;
      }
    
      if (!startDate || !deliveryTime) {
          alert('Please select date and time');
          return;
      }
    
      // Collect selected recipients
      const selectedRecipients = Array.from(recipients.selectedOptions).map(opt => opt.text);
    
      // Collect custom days if applicable
      let customDays = [];
      if (frequency === 'custom') {
          const dayCheckboxes = document.querySelectorAll('#customOptions input[type="checkbox"]:checked');
          customDays = Array.from(dayCheckboxes).map(cb => cb.value);
          
          if (customDays.length === 0) {
              alert('Please select at least one day for custom frequency');
              return;
          }
      }
    
      // Create schedule object
      const scheduleData = {
          recipients: selectedRecipients,
          subject: subject,
          body: body,
          frequency: frequency,
          customDays: customDays,
          startDate: startDate,
          deliveryTime: deliveryTime,
          fileFormat: fileFormat
      };
    
      console.log('Schedule Data:', scheduleData);
    
      // Here you would typically send this data to your backend
      // For now, show success message
      alert('✅ Report delivery scheduled successfully!\n\nRecipients: ' + selectedRecipients.length + '\nFrequency: ' + frequency + '\nStart Date: ' + startDate);
    
      // Close modal
      const modalElement = document.getElementById('modalExport');
      const modal = bootstrap.Modal.getInstance(modalElement);
      modal.hide();
    
      // Reset form
      document.getElementById('scheduleForm').reset();
      document.getElementById('scheduleSummary').innerHTML = 'Please fill in the form to see your delivery schedule summary';
    }
    </script><!-- Additional CSS for Enhanced Styling -->
<style>
/* Modal Enhancements */
#modalExport .modal-content {
  border: none;
  box-shadow: 0 10px 25px rgba(0, 33, 64, 0.15);
  border-radius: 0.75rem;
}


#modalExport .modal-header {
  padding: 1.5rem 1.75rem;
}

#modalExport .modal-body {
  padding: 0 1.75rem 1.5rem;
}

#modalExport .modal-footer {
  padding: 10px;
}

/* Form Controls */
#modalExport .form-control:focus,
#modalExport .form-select:focus {
  border-color: rgb(0, 100, 180);
  box-shadow: 0 0 0 0.2rem rgba(0, 100, 180, 0.15);
}

#modalExport .form-label {
  margin-bottom: 0.5rem;
}

#modalExport .form-label i {
  font-size: 1.1rem;
}

/* Select Multiple Styling */
#modalExport select[multiple] option {
  padding: 0.5rem;
  margin-bottom: 0.25rem;
}

#modalExport select[multiple] option:checked {
  background: linear-gradient(0deg, rgb(0, 100, 180) 0%, rgb(0, 100, 180) 100%);
  color: white;
}

/* Custom Checkboxes */
#modalExport .form-check-input:checked {
  background-color: rgb(0, 100, 180);
  border-color: rgb(0, 100, 180);
}

#modalExport .form-check-input:focus {
  border-color: rgb(0, 100, 180);
  box-shadow: 0 0 0 0.2rem rgba(0, 100, 180, 0.15);
}

/* Button Hover Effects */
#modalExport .btn:hover {
  transform: translateY(-1px);
  transition: all 0.2s ease;
}

#modalExport .btn[style*="background-color: rgb(0, 33, 64)"]:hover {
  background-color: rgb(0, 50, 90) !important;
  box-shadow: 0 4px 12px rgba(0, 33, 64, 0.3);
}

/* Responsive Design */
@media (max-width: 768px) {
  #modalExport .modal-dialog {
      margin: 0.5rem;
  }
  
  #modalExport .modal-header h4 {
      font-size: 1.25rem !important;
  }
  
  #modalExport .form-label {
      font-size: 0.9rem !important;
  }
}
</style>
<div class="modal fade" id="leadFilterModal" tabindex="-1" aria-labelledby="leadFilterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <!-- Modal Header with Minimize Button -->
            <div class="modal-header d-flex justify-content-between align-items-center">
              <h1 class="modal-title " id="addTemplateModal">Add Report</h1>
            <div>
              <button type="button"  id="minimizeModalBtn" class="btn btn-sm btn-light border-0">
                <i class="ti ti-minimize" data-bs-toggle="tooltip" data-bs-title="Minimze"></i>
              </button>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
              
            </div>
  
            <!-- Modal Body -->
            <div class="modal-body">
                <form id="leadFilterForm">
                    <!-- Dealer Information -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-store"></i>
                            Dealer Information
                        </h3>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="dealerSelect" class="form-label">
                                    Dealer <span class="required">*</span>
                                </label>
                                <select id="dealerSelect" class="form-select" multiple placeholder="Select dealers...">
                                  <option>#18874 Bannister GM Vernon</option>
                                  <option selected>Twin Motors Thompson</option>
                                  <option>#19234 Bannister Ford</option>
                                  <option>#19345 Bannister Nissan</option>
                                </select>
                                
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Display Options</label>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="useShortName">
                                    <label class="form-check-label" for="useShortName">
                                        Use dealer short names in reports
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
  
                    <!-- Sources (Combined Lead Source) -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-bullseye"></i>
                            Sources
                        </h3>
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="sources" class="form-label">Sources</label>
                                <select id="sources" class="form-select" multiple placeholder="Select sources...">
                                  <option>Facebook</option>
                                  <option>Google Ads</option>
                                  <option>WhatsApp</option>
                                  <option>Walk-In</option>
                                  <option>Phone Up</option>
                                  <option>Text</option>
                                  <option>Repeat Customer</option>
                                  <option>Referral</option>
                                  <option>Service to Sales</option>
                                  <option>Lease Renewal</option>
                                  <option>Drive By</option>
                                  <option>Dealer Website</option>
                                </select>
                                
                            </div>
                        </div>
                    </div>
  
                    <!-- Assigned To (Combined BDC Agent) -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-user-tie"></i>
                            Assigned To
                        </h3>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="assignedTo" class="form-label">Assigned To</label>
                                <select id="assignedTo" class="form-select" multiple placeholder="Select assigned agents...">
                                    <option value="agent1">John Smith</option>
                                    <option value="agent2">Sarah Johnson</option>
                                    <option value="agent3">Michael Brown</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="secondaryAssignedTo" class="form-label">Secondary Assigned To</label>
                                <select id="secondaryAssignedTo" class="form-select" multiple placeholder="Select secondary agents...">
                                    <option value="agent1">John Smith</option>
                                    <option value="agent2">Sarah Johnson</option>
                                    <option value="agent3">Michael Brown</option>
                                </select>
                            </div>
                        </div>
                    </div>
  
                    <!-- Team and BDC Agent -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-users"></i>
                            Team Information
                        </h3>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="team" class="form-label">Team</label>
                                <select id="team" class="form-select" multiple placeholder="Select teams...">
                                    <option value="team1">Sales Team A</option>
                                    <option value="team2">Sales Team B</option>
                                    <option value="team3">VIP Team</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="bdcAgent" class="form-label">BDC Agent</label>
                                <select id="bdcAgent" class="form-select" multiple placeholder="Select BDC agents...">
                                    <option value="bdc1">Agent Alpha</option>
                                    <option value="bdc2">Agent Beta</option>
                                    <option value="bdc3">Agent Gamma</option>
                                </select>
                            </div>
                        </div>
                    </div>
  
                    <!-- Lead Details -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-info-circle"></i>
                            Lead Details
                        </h3>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="dateRange" class="form-label">Date Range</label>
                                <select id="dateRange" class="form-select" multiple placeholder="Select date range...">
                                    <option value="today">Today</option>
                                    <option value="yesterday">Yesterday</option>
                                    <option value="last7">Last 7 Days</option>
                                    <option value="last30">Last 30 Days</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="leadType" class="form-label">Lead Type</label>
                                <select id="leadType" class="form-select" multiple placeholder="Select lead types...">
                                  <option value="Internet">Internet</option>
                                  <option value="Walk-In">Walk-In</option>
                                  <option value="Phone Up">Phone Up</option>
                                  <option value="Text Up">Text Up</option>
                                  <option value="Website Chat">Website Chat</option>
                                  <option value="Import">Import</option>
                                  <option value="Wholesale">Wholesale</option>
                                  <option value="Lease Renewal">Lease Renewal</option>
                                </select>
                                
                            </div>
                            <div class="col-md-6">
                                <label for="leadStatus" class="form-label">Lead Status</label>
                                <select id="leadStatus" class="form-select" multiple placeholder="Select status...">
                                  <option>All</option>
                                  
                                  <option>Active</option>
                                  <option>Duplicate</option>
                                  <option>Invalid</option>
                                  <option>Lost</option>
                                  <option>Sold</option>
                                  <option>Wishlist</option>
                                </select>
                                
                            </div>
                        </div>
                    </div>
  
                    <!-- Vehicle Information -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-car"></i>
                            Vehicle Information
                        </h3>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="inventoryType" class="form-label">Inventory Type</label>
                                <select id="inventoryType" class="form-select" multiple placeholder="Select inventory types...">
                                  <option>All</option>
                                  <option>New</option>
                                  <option>Pre-Owned</option>
                                  <option>CPO</option>
                                  <option>Demo</option>
                                  <option>Wholesale</option>
                                  <option>Unknown</option>
                                </select>
                                
                            </div>
                            <div class="col-md-6">
                                <label for="make" class="form-label">Make</label>
                                <select id="make" class="form-select" multiple placeholder="Select makes...">
                                    <option value="toyota">Toyota</option>
                                    <option value="honda">Honda</option>
                                    <option value="ford">Ford</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="model" class="form-label">Model</label>
                                <small class="text-muted d-block mb-1">Note: Please select Make first</small>
                                <select id="model" class="form-select" multiple placeholder="Select models..." disabled>
                                    <option value="">Select Make first</option>
                                </select>
                            </div>
                        </div>
                    </div>
  
                    <!-- Sales Information -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-dollar-sign"></i>
                            Sales Information
                        </h3>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="salesType" class="form-label">Sales Type</label>
                                <select id="salesType" class="form-select" name="salesType" required> multiple
                                 
                                  <option value="Sales">Sales</option>
                                  <option value="Service">Service</option>
                                  <option value="Parts">Parts</option>
                                </select>
                                
                            </div>
                            <div class="col-md-6">
                                <label for="salesStatus" class="form-label">Sales Status</label>
                                <select id="salesStatus" class="form-select" multiple placeholder="Select sales status...">
                                  <option selected>--ALL--</option>
                                  <option>Uncontacted</option>
                                  <option>Attempted</option>
                                  <option>Contacted</option>
                                  <option>Dealer Visit</option>
                                  <option>Demo</option>
                                  <option>Write-Up</option>
                                  <option>Pending F&I</option>
                                  <option>Sold</option>
                                  <option>Delivered</option>
                                  <option>Lost</option>
                                </select>
                                
                            </div>
                            <div class="col-md-6">
                                <label for="dealType" class="form-label">Deal Type</label>
                                <select id="dealType" class="form-select" multiple placeholder="Select deal types...">
                                    <option value="cash">Cash</option>
                                    <option value="finance">Finance</option>
                                    <option value="lease">Lease</option>
                                </select>
                            </div>
                        </div>
                    </div>
  
                    <!-- Status and Task Information -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-chart-line"></i>
                            Status and Task Information
                        </h3>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="statusType" class="form-label">Status Type</label>
                                <select id="statusType" class="form-select" multiple placeholder="Select status types...">
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
                            <div class="col-md-6">
                                <label for="taskType" class="form-label">Task Type</label>
                                <select id="taskType" class="form-select" multiple placeholder="Select task types...">
                                  <option value="call">Call</option>
                  <option value="text">Text</option>
                  <option value="email">Email</option>
                  <option value="csi">CSI</option>
                  <option value="appointment">Appointment</option>
                  <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
  
                    <!-- Report Structure Configuration -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-layer-group"></i>
                            Report Structure
                        </h3>
                        <p class="text-muted small mb-3">Configure multi-level report breakdown (e.g., Lead Type → Inventory Type → Team)</p>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="columnA" class="form-label">Column A (Primary)</label>
                                <select id="columnA" class="form-select">
                                    <option value="">Select...</option>
                                    <option value="leadType">Lead Type</option>
                                    <option value="inventoryType">Inventory Type</option>
                                    <option value="team">Team</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="columnB" class="form-label">Column B (Secondary)</label>
                                <select id="columnB" class="form-select">
                                    <option value="">Select...</option>
                                    <option value="leadType">Lead Type</option>
                                    <option value="inventoryType">Inventory Type</option>
                                    <option value="team">Team</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="columnC" class="form-label">Column C (Tertiary)</label>
                                <select id="columnC" class="form-select">
                                    <option value="">Select...</option>
                                    <option value="leadType">Lead Type</option>
                                    <option value="inventoryType">Inventory Type</option>
                                    <option value="team">Team</option>
                                </select>
                            </div>
                        </div>
                    </div>
  
                    <!-- Report Columns -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-columns"></i>
                            Report Columns
                        </h3>
                        <p class="text-muted small mb-3">Select which columns to display in the report</p>
                        <div class="row g-3">
                            <div class="col-12" style="margin-bottom: 120px;">
                                <label for="reportColumns" class="form-label">Available Columns</label>
                                <select id="reportColumns" class="form-select" multiple placeholder="Select columns to display...">
  
                                  <!-- ====================== DEALS ====================== -->
                                  <optgroup label="Deals">
                                    <option value="total_deals">Total Deals</option>
                                    <option value="active_deals">Active Deals</option>
                                    <option value="invalid_deals">Invalid Deals</option>
                                    <option value="duplicate_deals">Duplicate Deals</option>
                                    <option value="lost_deals">Lost Deals</option>
                                    <option value="sub_lost_deals">Sub-Lost Deals</option>
                                    <option value="wishlist_deals">Wishlist Deals</option>
                                    <option value="buy_in_deals">Buy-In Deals</option>
                                    <option value="high_priority">High Priority</option>
                                    <option value="hold_deals">Hold Deals</option>
                                    <option value="uncontacted_deals">Uncontacted Deals</option>
                                    <option value="attempted_deals">Attempted Deals</option>
                                    <option value="contacted_deals">Contacted Deals</option>
                                    <option value="contacted_deals_with_appt">Contacted Deals with Appt</option>
                                    <option value="contacted_deals_with_appt_pct">Contacted Deals with Appt %</option>
                                    <option value="dealer_visit_deals">Dealer Visit Deals</option>
                                    <option value="dealer_visit_deals_with_appt">Dealer Visit Deals with Appt</option>
                                    <option value="dealer_visit_deals_with_appt_pct">Dealer Visit Deals with Appt %</option>
                                    <option value="dealer_visit_deals_without_appt">Dealer Visit Deals w/o Appt</option>
                                    <option value="dealer_visit_deals_without_appt_pct">Dealer Visit Deals w/o Appt %</option>
                                
                                    <option value="demo_deals">Demo Deals</option>
                                    <option value="demo_deals_with_appt">Demo Deals with Appt</option>
                                    <option value="demo_deals_with_appt_pct">Demo Deals with Appt %</option>
                                    <option value="demo_deals_without_appt">Demo Deals w/o Appt</option>
                                    <option value="demo_deals_without_appt_pct">Demo Deals w/o Appt %</option>
                                
                                    <option value="writeup_deals">Write-Up Deals</option>
                                    <option value="writeup_deals_with_appt">Write-Up Deals with Appt</option>
                                    <option value="writeup_deals_with_appt_pct">Write-Up Deals with Appt %</option>
                                    <option value="writeup_deals_without_appt">Write-Up Deals w/o Appt</option>
                                    <option value="writeup_deals_without_appt_pct">Write-Up Deals w/o Appt %</option>
                                
                                    <option value="pending_fi_deals">Pending F&I Deals</option>
                                    <option value="pending_fi_deals_with_appt">Pending F&I Deals with Appt</option>
                                    <option value="pending_fi_deals_with_appt_pct">Pending F&I Deals with Appt %</option>
                                    <option value="pending_fi_deals_without_appt">Pending F&I Deals w/o Appt</option>
                                    <option value="pending_fi_deals_without_appt_pct">Pending F&I Deals w/o Appt %</option>
                                
                                    <option value="sold_deals">Sold Deals</option>
                                    <option value="sold_deals_pct">Sold Deals %</option>
                                    <option value="sold_deals_with_appt">Sold Deals with Appt</option>
                                    <option value="sold_deals_with_appt_pct">Sold Deals with Appt %</option>
                                    <option value="sold_deals_without_appt">Sold Deals w/o Appt</option>
                                    <option value="sold_deals_without_appt_pct">Sold Deals w/o Appt %</option>
                                
                                    <option value="delivered_deals">Delivered Deals</option>
                                    <option value="delivered_deals_pct">Delivered Deals %</option>
                                    <option value="delivered_deals_with_appt">Delivered Deals with Appt</option>
                                    <option value="delivered_deals_with_appt_pct">Delivered Deals with Appt %</option>
                                    <option value="delivered_deals_without_appt">Delivered Deals w/o Appt</option>
                                    <option value="delivered_deals_without_appt_pct">Delivered Deals w/o Appt %</option>
                                
                                    <option value="avg_days_to_sale">Avg Days to Sale</option>
                                    <option value="front_gross">Front Gross</option>
                                    <option value="back_gross">Back Gross</option>
                                    <option value="total_gross">Total Gross</option>
                                
                                    <!-- Newly included fields from Word file -->
                                    <option value="dms_id_number">DMS ID Number</option>
                                    <option value="push_datetime">Push Date/Time</option>
                                    <option value="current_odometer">Current Odometer</option>
                                
                                    <option value="sales_type">Sales Type</option>
                                    <option value="deal_type">Deal Type</option>
                                    <option value="inventory_type">Inventory Type</option>
                                    <option value="lead_type">Lead Type</option>
                                    <option value="lead_status">Lead Status</option>
                                  </optgroup>
                                
                                  <!-- ====================== WALK-IN DEALS ====================== -->
                                  <optgroup label="Walk-In Deals">
                                    <option value="walkin_deals">Walk-In Deals</option>
                                    <option value="walkin_demo_status">Walk-In Demo Sales Status</option>
                                    <option value="walkin_demo_status_pct">Walk-In Demo Sales Status %</option>
                                    <option value="walkin_writeup_status">Walk-In Write-Up Sales Status</option>
                                    <option value="walkin_writeup_status_pct">Walk-In Write-Up Sales Status %</option>
                                    <option value="walkin_pfi_status">Walk-In Pending F&I Sales Status</option>
                                    <option value="walkin_pfi_status_pct">Walk-In Pending F&I Sales Status %</option>
                                
                                    <option value="walkin_deals_sold">Walk-In Deals Sold</option>
                                    <option value="walkin_deals_sold_pct">Walk-In Deals Sold %</option>
                                    <option value="walkin_avg_days_writeup">Walk-In Avg Days to Write-Up</option>
                                    <option value="walkin_avg_days_pfi">Walk-In Avg Days to Pending F&I</option>
                                    <option value="walkin_avg_days_sold">Walk-In Avg Days to Sold</option>
                                    <option value="walkin_avg_days_delivered">Walk-In Avg Days to Delivered</option>
                                  </optgroup>
                                
                                  <!-- ====================== PHONE-UP DEALS ====================== -->
                                  <optgroup label="Phone-Up Deals">
                                    <option value="phoneup_deals">Phone-Up Deals</option>
                                    <option value="phoneup_uncontacted">Phone-Up Uncontacted Sales Status</option>
                                    <option value="phoneup_uncontacted_pct">Phone-Up Uncontacted Sales Status %</option>
                                    <option value="phoneup_attempted">Phone-Up Attempted Sales Status</option>
                                    <option value="phoneup_attempted_pct">Phone-Up Attempted Sales Status %</option>
                                    <option value="phoneup_contacted">Phone-Up Contacted Sales Status</option>
                                    <option value="phoneup_contacted_pct">Phone-Up Contacted Sales Status %</option>
                                    <option value="phoneup_dealer_visits">Phone-Up Dealer Visits Sales Status</option>
                                    <option value="phoneup_dealer_visits_pct">Phone-Up Dealer Visits Sales Status %</option>
                                    <option value="phoneup_demo">Phone-Up Demo Sales Status</option>
                                    <option value="phoneup_demo_pct">Phone-Up Demo Sales Status %</option>
                                    <option value="phoneup_writeup">Phone-Up Write-Up Sales Status</option>
                                    <option value="phoneup_writeup_pct">Phone-Up Write-Up Sales Status %</option>
                                    <option value="phoneup_pfi">Phone-Up Pending F&I Sales Status</option>
                                    <option value="phoneup_pfi_pct">Phone-Up Pending F&I Sales Status %</option>
                                    <option value="phoneup_sold">Phone-Up Deals Sold</option>
                                    <option value="phoneup_sold_pct">Phone-Up Deals Sold %</option>
                                    <option value="phoneup_avg_writeup">Phone-Up Avg Days to Write-Up</option>
                                    <option value="phoneup_avg_pfi">Phone-Up Avg Days to Pending F&I</option>
                                    <option value="phoneup_avg_sold">Phone-Up Avg Days to Sold</option>
                                    <option value="phoneup_avg_delivered">Phone-Up Avg Days to Delivered</option>
                                  </optgroup>
                                
                                  <!-- ====================== TEXT-UP DEALS ====================== -->
                                  <optgroup label="Text-Up Deals">
                                    <option value="textup_deals">Text-Up Deals</option>
                                    <option value="textup_uncontacted">Text-Up Uncontacted Sales Status</option>
                                    <option value="textup_uncontacted_pct">Text-Up Uncontacted Sales Status %</option>
                                    <option value="textup_attempted">Text-Up Attempted Sales Status</option>
                                    <option value="textup_attempted_pct">Text-Up Attempted Sales Status %</option>
                                    <option value="textup_contacted">Text-Up Contacted Sales Status</option>
                                    <option value="textup_contacted_pct">Text-Up Contacted Sales Status %</option>
                                    <option value="textup_dealer_visits">Text-Up Dealer Visits Sales Status</option>
                                    <option value="textup_dealer_visits_pct">Text-Up Dealer Visits Sales Status %</option>
                                    <option value="textup_demo">Text-Up Demo Sales Status</option>
                                    <option value="textup_demo_pct">Text-Up Demo Sales Status %</option>
                                    <option value="textup_writeup">Text-Up Write-Up Sales Status</option>
                                    <option value="textup_writeup_pct">Text-Up Write-Up Sales Status %</option>
                                    <option value="textup_pfi">Text-Up Pending F&I Sales Status</option>
                                    <option value="textup_pfi_pct">Text-Up Pending F&I Sales Status %</option>
                                    <option value="textup_sold">Text-Up Deals Sold</option>
                                    <option value="textup_sold_pct">Text-Up Deals Sold %</option>
                                    <option value="textup_avg_writeup">Text-Up Avg Days to Write-Up</option>
                                    <option value="textup_avg_pfi">Text-Up Avg Days to Pending F&I</option>
                                    <option value="textup_avg_sold">Text-Up Avg Days to Sold</option>
                                    <option value="textup_avg_delivered">Text-Up Avg Days to Delivered</option>
                                  </optgroup>
                                
                                  <!-- ====================== WEBSITE CHAT, SERVICE, IMPORT, WHOLESALE ====================== -->
                                  <optgroup label="Website Chat Deals">
                                    <option value="website_chat_deals">Website Chat Deals</option>
                                    <option value="website_chat_sold">Website Chat Deals Sold</option>
                                    <option value="website_chat_sold_pct">Website Chat Deals Sold %</option>
                                  </optgroup>
                                
                                  <optgroup label="Service Deals">
                                    <option value="service_deals">Service Deals</option>
                                    <option value="service_deals_sold">Service Deals Sold</option>
                                    <option value="service_deals_sold_pct">Service Deals Sold %</option>
                                
                                    <!-- Service-specific fields from Word file -->
                                    <option value="service_appt_and_time">Service Appt &amp; Time</option>
                                    <option value="service_type">Service Type</option>
                                    <option value="service_product">Service Product</option>
                                    <option value="service_advisor">Service Advisor</option>
                                    <option value="service_drive">Service Drive</option>
                                    <option value="condition">Condition</option>
                                    <option value="trade_in_value">Trade-In Value</option>
                                  </optgroup>
                                
                                  <optgroup label="Import Deals">
                                    <option value="import_deals">Import Deals</option>
                                    <option value="import_deals_sold">Import Deals Sold</option>
                                    <option value="import_deals_sold_pct">Import Deals Sold %</option>
                                  </optgroup>
                                
                                  <optgroup label="Wholesale Deals">
                                    <option value="wholesale_deals">Wholesale Deals</option>
                                    <option value="wholesale_deals_sold">Wholesale Deals Sold</option>
                                    <option value="wholesale_deals_sold_pct">Wholesale Deals Sold %</option>
                                  </optgroup>
                                
                                  <!-- ====================== INTERNET DEALS ====================== -->
                                  <optgroup label="Internet Deals">
                                    <option value="internet_leads">Internet Leads</option>
                                    <option value="internet_uncontacted">Internet Uncontacted Sales Status</option>
                                    <option value="internet_uncontacted_pct">Internet Uncontacted Sales Status %</option>
                                    <option value="internet_attempted">Internet Attempted Sales Status</option>
                                    <option value="internet_attempted_pct">Internet Attempted Sales Status %</option>
                                    <option value="internet_contacted">Internet Contacted Sales Status</option>
                                    <option value="internet_contacted_pct">Internet Contacted Sales Status %</option>
                                    <option value="internet_dealer_visits">Internet Dealer Visits Sales Status</option>
                                    <option value="internet_dealer_visits_pct">Internet Dealer Visits Sales Status %</option>
                                    <option value="internet_demo">Internet Demo Sales Status</option>
                                    <option value="internet_demo_pct">Internet Demo Sales Status %</option>
                                    <option value="internet_writeup">Internet Write-Up Sales Status</option>
                                    <option value="internet_writeup_pct">Internet Write-Up Sales Status %</option>
                                    <option value="internet_pfi">Internet Pending F&I Sales Status</option>
                                    <option value="internet_pfi_pct">Internet Pending F&I Sales Status %</option>
                                    <option value="internet_sold">Internet Deals Sold</option>
                                    <option value="internet_sold_pct">Internet Deals Sold %</option>
                                
                                    <option value="internet_avg_adj_resp_mins">Internet Avg Adj Resp (Mins)</option>
                                    <option value="internet_avg_actual_resp_mins">Internet Avg Actual Resp (Mins)</option>
                                    <option value="internet_avg_days_attempted">Internet Avg Days to Attempted</option>
                                    <option value="internet_avg_days_contacted">Internet Avg Days to Contacted</option>
                                    <option value="internet_avg_days_dealer_visit">Internet Avg Days to Dealer Visit</option>
                                    <option value="internet_avg_days_demo">Internet Avg Days to Demo</option>
                                    <option value="internet_avg_days_writeup">Internet Avg Days to Write-Up</option>
                                    <option value="internet_avg_days_pfi">Internet Avg Days to Pending F&I</option>
                                    <option value="internet_avg_days_sold">Internet Avg Days to Sold</option>
                                    <option value="internet_avg_days_delivered">Internet Avg Days to Delivered</option>
                                  </optgroup>
                                
                                  <!-- ====================== APPOINTMENTS ====================== -->
                                  <optgroup label="Appointments">
                                    <option value="total_appts">Total Appts</option>
                                    <option value="total_appts_sold">Total Appts Sold</option>
                                    <option value="total_appts_sold_pct">Total Appts Sold %</option>
                                    <option value="appts_open">Appts Open</option>
                                    <option value="appts_open_pct">Appts Open %</option>
                                    <option value="appts_confirmed">Appts Confirmed</option>
                                    <option value="appts_confirmed_pct">Appts Confirmed %</option>
                                    <option value="appts_completed">Appts Completed</option>
                                    <option value="appts_completed_pct">Appts Completed %</option>
                                    <option value="appts_missed">Appts Missed</option>
                                    <option value="appts_missed_pct">Appts Missed %</option>
                                    <option value="appts_cancelled">Appts Cancelled</option>
                                    <option value="appts_cancelled_pct">Appts Cancelled %</option>
                                    <option value="appts_walkin">Appts Walk-In</option>
                                    <option value="appts_walkin_pct">Appts Walk-In %</option>
                                    <option value="appts_no_response">Appts No Response</option>
                                    <option value="appts_no_response_pct">Appts No Response %</option>
                                    <option value="appts_no_show">Appts No Show</option>
                                    <option value="appts_no_show_pct">Appts No Show %</option>
                                    <option value="appts_completed_sold">Appts Completed Sold</option>
                                    <option value="appts_completed_sold_pct">Appts Completed Sold %</option>
                                    <option value="avg_days_to_appt_set">Avg Days to Appt Set</option>
                                
                                    <!-- Appointment metadata -->
                                    <option value="appointment_creation_date">Appointment Creation Date</option>
                                    <option value="appointment_creation_user">Appointment Creation User</option>
                                    <option value="appointment_date">Appointment Date</option>
                                    <option value="appointment_time">Appointment Time</option>
                                    <option value="appointment_type">Appointment Type</option>
                                    <option value="created_appointments_by_user">Created Appointments (by User)</option>
                                  </optgroup>
                                
                                  <!-- ====================== DEALER VISITS ====================== -->
                                  <optgroup label="Dealer Visits">
                                    <option value="total_dealer_visits">Total Dealer Visits</option>
                                    <option value="dealer_visits_sold">Dealer Visits Sold</option>
                                    <option value="dealer_visits_sold_pct">Dealer Visits Sold %</option>
                                    <option value="be_back_visits">Be Back Visits</option>
                                    <option value="be_back_visits_pct">Be Back Visits %</option>
                                    <option value="be_back_visits_sold">Be Back Visits Sold</option>
                                    <option value="be_back_visits_sold_pct">Be Back Visits Sold %</option>
                                    <option value="be_back_visits_unsold">Be Back Visits Unsold</option>
                                    <option value="be_back_visits_unsold_pct">Be Back Visits Unsold %</option>
                                    <option value="avg_days_dealer_visit">Avg Days to Dealer Visit</option>
                                    <option value="avg_dealer_visit_duration_mins">Avg Dealer Visit Duration (Mins)</option>
                                    <option value="demos">Demos</option>
                                    <option value="demo_pct">Demo %</option>
                                    <option value="writeups">Write Ups</option>
                                    <option value="writeup_pct">Write Up %</option>
                                    <option value="mgr_tos">Mgr TOs</option>
                                    <option value="mgr_to_pct">Mgr TO %</option>
                                
                                    <!-- Word file used the label "Avg Showroom Visit Duration (Mins)" — include as separate field -->
                                    <option value="avg_showroom_visit_duration_mins">Avg Showroom Visit Duration (Mins)</option>
                                  </optgroup>
                                
                                  <!-- ====================== COMMUNICATIONS ====================== -->
                                  <optgroup label="Communications">
                                    <option value="total_phone_calls">Total Phone Calls</option>
                                    <option value="inbound_phone_calls">Inbound Phone Calls</option>
                                    <option value="outbound_phone_calls">Outbound Phone Calls</option>
                                    <option value="outbound_phone_calls_contacted">Outbound Phone Calls Contacted</option>
                                    <option value="outbound_phone_calls_contacted_pct">Outbound Phone Calls Contacted %</option>
                                
                                    <option value="total_emails">Total Emails</option>
                                    <option value="inbound_emails">Inbound Emails</option>
                                    <option value="outbound_emails">Outbound Emails</option>
                                
                                    <option value="total_texts">Total Texts</option>
                                    <option value="inbound_texts">Inbound Texts</option>
                                    <option value="outbound_texts">Outbound Texts</option>
                                
                                    <option value="total_facebook">Total Facebook</option>
                                    <option value="facebook_inbound">Facebook Inbound</option>
                                    <option value="facebook_outbound">Facebook Outbound</option>
                                
                                    <option value="total_instagram">Total Instagram</option>
                                    <option value="instagram_inbound">Instagram Inbound</option>
                                    <option value="instagram_outbound">Instagram Outbound</option>
                                
                                    <option value="total_twitter">Total Twitter (X)</option>
                                    <option value="twitter_inbound">Twitter (X) Inbound</option>
                                    <option value="twitter_outbound">Twitter (X) Outbound</option>
                                
                                    <option value="total_youtube">Total YouTube</option>
                                    <option value="youtube_inbound">YouTube Inbound</option>
                                    <option value="youtube_outbound">YouTube Outbound</option>
                                
                                    <option value="total_reddit">Total Reddit</option>
                                    <option value="reddit_inbound">Reddit Inbound</option>
                                    <option value="reddit_outbound">Reddit Outbound</option>
                                
                                    <option value="total_communications">Total Communications</option>
                                    <option value="communications_inbound">Communications Inbound</option>
                                    <option value="communications_outbound">Communications Outbound</option>
                                
                                    <!-- Campaign / email metrics present in Word file -->
                                    <option value="campaign_opens">Campaign Opens</option>
                                    <option value="campaign_clicks">Campaign Clicks</option>
                                    <option value="campaign_replies">Campaign Replies</option>
                                    <option value="campaign_emails_delivered">Campaign Emails Delivered</option>
                                    <option value="emails_sent_bounced">Emails Sent Bounced</option>
                                    <option value="emails_sent_invalid">Emails Sent Invalid</option>
                                    <option value="customer_unsubscribes">Customer Unsubscribes</option>
                                    <option value="emails_unopened">Emails Unopened</option>
                                  </optgroup>
                                
                                  <!-- ====================== TASKS ====================== -->
                                  <optgroup label="Tasks">
                                    <option value="total_tasks">Total Tasks</option>
                                    <option value="task_type_overall">Task Type</option>
                                    <option value="status_type_overall">Status Type</option>
                                
                                    <option value="total_call_tasks">Total Call Tasks</option>
                                    <option value="open_outbound_call_tasks">Open Outbound Call Tasks</option>
                                    <option value="open_outbound_call_tasks_pct">Open Outbound Call Tasks %</option>
                                    <option value="completed_outbound_call_tasks">Completed Outbound Call Tasks</option>
                                    <option value="completed_outbound_call_tasks_pct">Completed Outbound Call Tasks %</option>
                                    <option value="completed_inbound_call_tasks">Completed Inbound Call Tasks</option>
                                    <option value="completed_inbound_call_tasks_pct">Completed Inbound Call Tasks %</option>
                                
                                    <option value="open_outbound_email_tasks">Open Outbound Email Tasks</option>
                                    <option value="open_outbound_email_tasks_pct">Open Outbound Email Tasks %</option>
                                    <option value="completed_outbound_email_tasks">Completed Outbound Email Tasks</option>
                                    <option value="completed_outbound_email_tasks_pct">Completed Outbound Email Tasks %</option>
                                    <option value="completed_inbound_email_tasks">Completed Inbound Email Tasks</option>
                                    <option value="completed_inbound_email_tasks_pct">Completed Inbound Email Tasks %</option>
                                
                                    <option value="open_outbound_text_tasks">Open Outbound Text Tasks</option>
                                    <option value="open_outbound_text_tasks_pct">Open Outbound Text Tasks %</option>
                                    <option value="completed_outbound_text_tasks">Completed Outbound Text Tasks</option>
                                    <option value="completed_outbound_text_tasks_pct">Completed Outbound Text Tasks %</option>
                                    <option value="completed_inbound_text_tasks">Completed Inbound Text Tasks</option>
                                    <option value="completed_inbound_text_tasks_pct">Completed Inbound Text Tasks %</option>
                                
                                    <option value="cancelled_tasks">Cancelled Tasks</option>
                                    <option value="cancelled_tasks_pct">Cancelled Tasks %</option>
                                    <option value="completed_tasks">Completed Tasks</option>
                                    <option value="completed_tasks_pct">Completed Tasks %</option>
                                    <option value="missed_tasks">Missed Tasks</option>
                                    <option value="missed_tasks_pct">Missed Tasks %</option>
                                    <option value="walkin_tasks">Walk-In Tasks</option>
                                    <option value="walkin_tasks_pct">Walk-In Tasks %</option>
                                    <option value="open_tasks">Open Tasks</option>
                                    <option value="open_tasks_pct">Open Tasks %</option>
                                    <option value="no_response_tasks">No Response Tasks</option>
                                    <option value="no_response_tasks_pct">No Response Tasks %</option>
                                    <option value="no_show_tasks">No Show Tasks</option>
                                    <option value="no_show_tasks_pct">No Show Tasks %</option>
                                  </optgroup>
                                
                                </select>
                                
                                
                            </div>
                        </div>
                    </div>
                </form>
            </div>
  
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveReport">Create Report</button>
            </div>
        </div>
    </div>
  </div>

  

  <script>
    let tomSelectInstances = {};
    let modalData = {};
    let modalInstance = null;
    
    // Wait for DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize modal instance
        const modalElement = document.getElementById('leadFilterModal');
        
        // Initialize Tom Select when modal is shown
        modalElement.addEventListener('shown.bs.modal', function () {
            if (Object.keys(tomSelectInstances).length === 0) {
                initializeTomSelect();
                setupMakeModelDependency();
            }
        });
    
        // Setup minimize button
      
    
        // Setup restore functionality
       
    
        // Setup save report button
        const saveReportBtn = document.getElementById('saveReport');
        if (saveReportBtn) {
            saveReportBtn.addEventListener('click', handleSaveReport);
        }
    });
    
    // Initialize Tom Select
    function initializeTomSelect() {
        const selectElements = document.querySelectorAll('select[multiple]');
        selectElements.forEach(select => {
            if (!tomSelectInstances[select.id]) {
                tomSelectInstances[select.id] = new TomSelect(select, {
                    plugins: ['remove_button'],
                    create: false,
                    maxItems: null,
                    maxOptions: 50000,
        loadThrottle: 0,
                    placeholder: select.getAttribute('placeholder') || 'Select options...',
                    onInitialize: function() {
                        console.log('TomSelect initialized for:', select.id);
                        this.settings.maxOptions = 999999;
                    }
                });
            }
        });
    }
    
    // Make-Model Dependency
    function setupMakeModelDependency() {
        const makeSelect = tomSelectInstances['make'];
        const modelSelect = document.getElementById('model');
        
        const modelsByMake = {
            'toyota': ['Camry', 'Corolla', 'RAV4', 'Highlander'],
            'honda': ['Civic', 'Accord', 'CR-V', 'Pilot'],
            'ford': ['F-150', 'Mustang', 'Explorer', 'Escape']
        };
        
        if (makeSelect) {
            makeSelect.on('change', function() {
                const selectedMakes = makeSelect.getValue();
                
                // Destroy existing model TomSelect if exists
                if (tomSelectInstances['model']) {
                    tomSelectInstances['model'].destroy();
                    delete tomSelectInstances['model'];
                }
                
                // Clear and populate model options
                modelSelect.innerHTML = '';
                
                if (selectedMakes.length > 0) {
                    modelSelect.disabled = false;
                    let allModels = [];
                    
                    selectedMakes.forEach(make => {
                        if (modelsByMake[make]) {
                            allModels = allModels.concat(modelsByMake[make]);
                        }
                    });
                    
                    // Remove duplicates
                    allModels = [...new Set(allModels)];
                    
                    allModels.forEach(model => {
                        const option = document.createElement('option');
                        option.value = model.toLowerCase().replace(/\s+/g, '-');
                        option.textContent = model;
                        modelSelect.appendChild(option);
                    });
                    
                    // Reinitialize TomSelect for model
                    tomSelectInstances['model'] = new TomSelect(modelSelect, {
                        plugins: ['remove_button'],
                        create: false,
                        maxItems: null,
                        placeholder: 'Select models...'
                    });
                } else {
                    modelSelect.disabled = true;
                    modelSelect.innerHTML = '<option value="">Select Make first</option>';
                }
            });
        }
    }
    
    
    // Collect Form Data
    function collectFormData() {
        const data = {};
        
        // Get all TomSelect values
        Object.keys(tomSelectInstances).forEach(key => {
            const values = tomSelectInstances[key].getValue();
            data[key] = Array.isArray(values) ? values : [values];
        });
        
        // Get regular select values
        ['columnA', 'columnB', 'columnC'].forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                data[id] = element.value;
            }
        });
        
        // Get checkbox values
        data.useShortName = document.getElementById('useShortName').checked;
        
        return data;
    }
    
    // Restore Form Data
    function restoreFormData(data) {
        console.log('Restoring form data:', data);
        
        // Restore TomSelect values
        Object.keys(data).forEach(key => {
            if (tomSelectInstances[key]) {
                const values = Array.isArray(data[key]) ? data[key] : [data[key]];
                tomSelectInstances[key].setValue(values, true);
            } else {
                const element = document.getElementById(key);
                if (element && element.tagName === 'SELECT') {
                    element.value = data[key];
                }
            }
        });
        
        // Restore checkbox
        if (data.useShortName !== undefined) {
            document.getElementById('useShortName').checked = data.useShortName;
        }
    }
    
    // Handle Save Report
    function handleSaveReport(e) {
        e.preventDefault();
        
        const formData = collectFormData();
        
        // Validate required fields
        if (!formData.dealerSelect || formData.dealerSelect.length === 0) {
            showAlert('Error', 'Please select at least one dealer', 'danger');
            return;
        }
        
        // Validate report structure
        const columnA = document.getElementById('columnA').value;
        const columnB = document.getElementById('columnB').value;
        const columnC = document.getElementById('columnC').value;
        
        if (columnA && columnB && columnA === columnB) {
            showAlert('Error', 'Column A and Column B cannot be the same', 'danger');
            return;
        }
        
        if (columnB && columnC && columnB === columnC) {
            showAlert('Error', 'Column B and Column C cannot be the same', 'danger');
            return;
        }
        
        if (columnA && columnC && columnA === columnC) {
            showAlert('Error', 'Column A and Column C cannot be the same', 'danger');
            return;
        }
        
        // Prepare report data
        const reportData = {
            ...formData,
            reportStructure: {
                primary: columnA,
                secondary: columnB,
                tertiary: columnC
            },
            createdAt: new Date().toISOString(),
            reportId: 'RPT-' + Date.now()
        };
        
        console.log('Creating report with data:', reportData);
        
        // Save to localStorage (simulating save to library)
        try {
            let reports = JSON.parse(localStorage.getItem('savedReports') || '[]');
            reports.push(reportData);
            localStorage.setItem('savedReports', JSON.stringify(reports));
            
    // Close modal and remove leftover backdrop properly
    const modalElement = document.getElementById('leadFilterModal');
    const modal = bootstrap.Modal.getInstance(modalElement);
    
    if (modal) {
        modal.hide();
    }
    
    // Force remove any lingering backdrop
    const backdrops = document.querySelectorAll('.modal-backdrop');
    backdrops.forEach(backdrop => backdrop.remove());
    
    // Restore body scroll (Bootstrap sometimes leaves it disabled)
    document.body.classList.remove('modal-open');
    document.body.style.removeProperty('overflow');
    document.body.style.removeProperty('padding-right');
      
            // Show success notification
            showToast();
            
            // Simulate opening report (redirect after 2 seconds)
            setTimeout(() => {
                // In production, this would redirect to the report view page
                console.log('Opening report:', reportData.reportId);
                // window.location.href = '/reports/view?id=' + reportData.reportId;
                
                // For demo, show alert
               
            }, 2000);
            
        } catch (error) {
            console.error('Error saving report:', error);
            showAlert('Error', 'Failed to save report. Please try again.', 'danger');
        }
    }
    
    // Show Toast Notification (only define if not present globally)
    if (typeof window.showToast !== 'function') {
        function showToast() {
            const toastElement = document.getElementById('reportToast');
            const toast = new bootstrap.Toast(toastElement, {
                autohide: true,
                delay: 3000
            });
            toast.show();
        }
    }
    
    // Show Alert (for errors)
    function showAlert(title, message, type = 'info') {
        // Create alert div
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3`;
        alertDiv.style.zIndex = '9999';
        alertDiv.innerHTML = `
            <strong>${title}:</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        document.body.appendChild(alertDiv);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
    </script>
    <div id="minimizedBar"
         class="d-none position-fixed bottom-0 end-0 m-3 bg-primary text-white px-3 py-2 shadow"
         style="cursor:pointer;border-radius:50%;">
       Report
    </div>
    
    <script>
    document.addEventListener("DOMContentLoaded", function () {
    
      const modalEl = document.getElementById("leadFilterModal");
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

@endsection





@push('styles')

<style>
    table  input[type="checkbox"]{
      border: 2px solid #ccc !important;
    }
    #leadFilterModal .modal-dialog {
        max-width:100%;
    }
    #leadFilterModal .modal-body  {
        max-height:100% !important;
    }
    #leadFilterModal .modal-content{max-height: 100% !important;}
    #leadFilterModal .modal-header {
        background-color: var(--cf-primary);
        color: white !important;
        border-bottom: none;
    }
    
    #leadFilterModal .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }
    
    #leadFilterModal .modal-title i {
        margin-right: 8px;
    }
    #leadFilterModal .modal-title{
      color: #fff;
    }
    
    #leadFilterModal .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 1.25rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e9ecef;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    #leadFilterModal .section-title i {
        color: var(--cf-primary);
        font-size: 1rem;
    }
    
    #leadFilterModal .form-section {
        margin-bottom: 2rem;
    }
    
    #leadFilterModal .form-section:last-child {
        margin-bottom: 0;
    }
    
    #leadFilterModal .form-label {
        font-weight: 500;
        color: #000;
        margin-bottom: 0.5rem;
    }
    
    #leadFilterModal .form-label .required {
        color: #dc3545;
        margin-left: 2px;
    }
    
    #leadFilterModal .form-text {
        font-size: 0.875rem;
        color: #6c757d;
    }
    
    #leadFilterModal .ts-wrapper .ts-control {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
    
    }
    
    #leadFilterModal .ts-wrapper.form-select.focus .ts-control {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    
    #leadFilterModal .ts-wrapper .ts-control .item {
        background-color: #ddd;
        color: #000;
        border: 1px solid #ddd;
        border-radius: 0.25rem;
        padding: 0.25rem 0.5rem;
    }
    
    #leadFilterModal .ts-dropdown {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
    }
    
    #leadFilterModal .ts-dropdown .option:hover {
        background-color: #f8f9fa;
    }
    
    #leadFilterModal .ts-dropdown .option.active {
        background-color: #e7f1ff;
        color: #084298;
    }
    
    #leadFilterModal .form-check-input:checked {
        background-color: var(--cf-primary);
        border-color: var(--cf-primary);
    }
    
    #leadFilterModal .radio-options {
        display: flex;
        gap: 1.5rem;
    }
    
    @media (max-width: 768px) {
        #leadFilterModal .modal-dialog {
            margin: 0.5rem;
        }
    
        #leadFilterModal .radio-options {
            flex-direction: column;
            gap: 0.75rem;
        }
    }
        </style>
    
@endpush