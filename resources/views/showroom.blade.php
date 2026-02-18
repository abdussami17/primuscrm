@extends('layouts.app')


@section('title','Showroom')


@section('content')

<div class="content content-two p-0 ps-3 pe-3" id="showroom-page">

    <!-- Page Header -->
    <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 ">
        <div style="position: relative; width: 100%; height: 80px;">
            <!-- Title aligned left -->
            <h6 style="position: absolute; left: 0; top: 50%; transform: translateY(-50%); margin: 0;">
                Showroom
            </h6>

            <!-- Image centered -->
            <img class="logo-img" src="assets/light_logo.png" alt="Showroom"
                style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); max-width: 80px;">
        </div>


    </div>



    <div class="split-container">
        <!-- View 1 -->
        <div class="split-view">
            <div class="crm-box">
                <div class="crm-header">Showroom Visit Log (7)</div>
                <!-- End Page Header -->
                <form class="row g-2">
                    <!-- Date Range -->
                    <div class="col-md-3 mb-2">
                        <label class="form-label">From</label>
                   
                        <input type="text" class="form-control cf-datepicker" 
                         value="2001-01-01" placeholder="" readonly>
                      </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label">To</label>
                        <input type="text" class="form-control cf-datepicker" 
                         value="2025-09-26" readonly>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label class="form-label">Users</label>
                        <select class="form-select">
                            <option selected>--ALL--</option>
                            <option>Aaron Burgess</option>
                            <option>Brad Nakuckyj</option>
                            <option>Brandon Henderson</option>
                            <option>Emily Chan</option>
                            <option>Jake Thomson</option>
                        </select>
                    </div>

                    <!-- Teams -->
                    <div class="col-md-3 mb-2">
                        <label class="form-label">Teams</label>
                        <select class="form-select">
                            <option value="">--ALL--</option>
                            <option value="">-- Select Team --</option>
                            <option value="sales-rep">Sales Rep</option>
                            <option value="bdc-agent">BDC Agent</option>
                            <option value="fi">F&I</option>
                            <option value="sales-manager">Sales Manager</option>
                            <option value="bdc-manager">BDC Manager</option>
                            <option value="finance-director">Finance Director</option>
                            <option value="general-sales-manager">General Sales Manager</option>
                            <option value="general-manager">General Manager</option>
                            <option value="dealer-principal">Dealer Principal</option>
                            <option value="admin">Admin</option>
                            <option value="reception">Reception</option>
                            <option value="service-advisor">Service Advisor</option>
                            <option value="service-manager">Service Manager</option>
                            <option value="inventory-manager">Inventory Manager</option>
                            <option value="fixed-operations-manager">Fixed Operations Manager</option>
                        </select>
                    </div>

                    <!-- Date Shortcuts -->
                    <div class="col-md-5 dates-option">
                        <span class="me-2" style="cursor:pointer">YTD</span>
                        <span class="me-2" style="cursor:pointer">This Week</span>
                        <span class="me-2" style="cursor:pointer">Last Week</span>
                        <span class="me-2" style="cursor:pointer">LM</span>
                        <span class="me-2" style="cursor:pointer">MTD</span>
                        <span class="me-2" style="cursor:pointer">Last 7 Days</span>
                        <span class="me-2" style="cursor:pointer">Yesterday</span>
                        <span class="me-2" style="cursor:pointer">Today</span>
                    </div>

                    <div class="col-6 mt-2 d-flex gap-2 button-group mb-3">
                        <button type="button" class="btn btn-secondary">Refresh</button>
                        <button type="button" class="btn btn-outline-primary">Export</button>
                        <button type="button" class="btn btn-outline-dark">Print</button>
                    </div>

                    <div class="col-12" id="toggleFiltersBtn">
                        <button type="button"
                            class="float-end btn btn-sm btn-outline-primary border-2">View More
                            Filters</button>
                    </div>

                    <div class="extra-filters row" style="display: none;">
                        <!-- Lead Type -->
                        <div class="col-md-2 mb-2">
                            <label class="form-label">Lead Type</label>
                            <select class="form-select">
                                <option selected>--ALL--</option>
                                <option>Internet</option>
                                <option>Walk-In</option>
                                <option>Phone Up</option>
                                <option>Text Up</option>
                                <option>Website Chat</option>
                                <option>Import</option>
                                <option>Wholesale</option>
                                <option>Lease Renewal</option>
                            </select>
                        </div>

                        <!-- Lead Status -->
                        <div class="col-md-2 mb-2">
                            <label class="form-label">Lead Status</label>
                            <select class="form-select">
                                <option selected>--ALL--</option>
                                <option>Active</option>
                                <option>Duplicate</option>
                                <option>Invalid</option>
                                <option>Lost</option>
                                <option>Sold</option>
                                <option>Wishlist</option>
                            </select>
                        </div>

                        <!-- Source -->
                        <div class="col-md-2 mb-2">
                            <label class="form-label">Source</label>
                            <select class="form-select">
                                <option selected>--ALL--</option>
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

                        <!-- Visits -->
                        <div class="col-md-3 mb-2">
                            <label class="form-label">Visits</label>
                            <select class="form-select">
                                <option hidden>-- All --</option>
                                <option>Closed Visits</option>
                                <option>Open Visits</option>
                            </select>
                        </div>

                        <!-- Inventory Type -->
                        <div class="col-md-3 mb-2">
                            <label class="form-label">Inventory Type</label>
                            <select class="form-select">
                                <option>-- All --</option>
                                <option>New</option>
                                <option>Pre-Owned</option>
                                <option>CPO</option>
                                <option>Demo</option>
                                <option>Wholesale</option>
                                <option>Unknown</option>
                            </select>
                        </div>

                        <!-- Users and Sales Status -->
                        <div class="col-md-12">
                            <div class="row mt-0">
                                <!-- Dealership -->
                                <div class="col-md-3 mb-2">
                                    <label class="form-label">Dealership</label>
                                    <select class="form-select">
                                        <option value="">--ALL--</option>
                                        <option>#18874 Bannister GM Vernon</option>
                                        <option selected>Twin Motors Thompson</option>
                                        <option>#19234 Bannister Ford</option>
                                        <option>#19345 Bannister Nissan</option>
                                    </select>
                                </div>

                                <!-- Sales Status -->
                                <div class="col-md-3 mb-2">
                                    <label class="form-label">Sales Status</label>
                                    <select class="form-select">
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

                                <!-- Lead Status Type -->
                                <div class="col-md-3 mb-2">
                                    <label class="form-label">Deal Type</label>
                                    <select class="form-select">
                                    
                                        <option>Finance</option>
                                        <option>Lease</option>
                                        <option>Cash</option>
                                        <option selected>Unknown</option>
                                        
                                    </select>
                                </div>

                                <!-- Appt Status Type -->
                                <div class="col-md-3 mb-2">
                                    <label class="form-label">Appt Status Type</label>
                                    <select class="form-select">
                                        <option selected>--ALL--</option>
                                        <option>Open</option>
                                     
                                        <option>Completed</option>
                                        <option>Missed</option>
                                        <option>Cancelled</option>
                                     
                                        <option>No Response</option>
                                        <option>No Show</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <script>
                    const toggleBtn = document.querySelector("#toggleFiltersBtn button");
                    const extraFilters = document.querySelector(".extra-filters");

                    toggleBtn.addEventListener("click", function() {

                        extraFilters.classList.toggle('active');


                    });
                </script>


                <style>
                    .extra-filters {
                        flex-wrap: wrap;
                    }
                </style>
            </div>
            <div class="respo-visit-container mb-3">
                <div class="visit-container ">
                    <!-- HEADER ROW -->
                    <div class="visit-header">
                        <div class="visit-col col-1">
                            <div class="d-flex justify-content-normal gap-3 align-items-center">
                                <span>Assigned to | Date | Time</span>

                            </div>
                        </div>
                        <div class="visit-col col-2">
                            <div class="d-flex justify-content-normal gap-3 align-items-center">
                                <span>Customer | Vehicle</span>

                            </div>
                        </div>
                        <div class="visit-col col-3">
                            <div class="d-flex justify-content-normal gap-3 align-items-center">
                                <span>Lead Status | Sales Status | Lead Type</span>

                            </div>
                        </div>
                        <!-- <div class="visit-col col-4">List Matched</div>
<div class="visit-col col-5"></div> -->




                    </div>

                    <div class="visit-entry">
                        <div class="visit-col col-1 ">
                            <div class="d-flex gap-2 justify-content-normal align-items-center">

                                <div>June 06, 2025 1:17 PM J.Smith</div>
                            </div>


                        </div>
                        <div class="visit-col col-2">
                            <div class="custom-hover-container">
                                <a data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas"
                                    class="text-black text-decoration-underline fw-semibold"
                                    href="#">Sydney Crosbey</a>
                                <div class="custom-hover-box">
                                    <img src="assets/img/users/user-04.jpg" alt="Customer Photo">
                                    <div class="custom-details">
                                        <strong>Sydney Crosbey</strong><br>
                                        123 Main St, Toronto<br>
                                        Cell: (416) 111-2222<br>
                                        Email: sydney.c@example.com<br>
                                        Sales Rep: Alex Green<br>
                                        Last Updated: 7/04/25 8:00am
                                    </div>
                                </div>
                            </div>
                            <br>
                            2022 <a  data-bs-toggle="offcanvas" href="#" data-bs-target="#editvehicleinfo" class="text-decoration-underline">Toyota Camry</a> (34892A) (U)<br>
                            4TIC11AK0NU123456
                        </div>
                        <div class="visit-col col-3">
                            Walk-in (Outbound) (Pending)<br>
                            <div class="d-flex align-items-center justify-content-normal mt-1">
                              <a class="credit-link text-danger fw-bold" href="javascript:void(0)" data-bs-toggle="offcanvas"
                              data-bs-target="#editShowroomVisitCanvas" >Open Showroom Visit</a>
                              <button class="ms-2 btn-sm btn btn-danger"
                              style="cursor: pointer;"
                              title="End Visit"
                              onclick="if (confirm('Are you sure you want to end this visit?')) { window.location.reload(); }">
                              End Visit
                            </button>
                           

                          </div>
                        </div>
                       




                    </div>
                    <div class="visit-entry">
                      <div class="visit-col col-1 ">
                          <div class="d-flex gap-2 justify-content-normal align-items-center">

                              <div>June 06, 2025 1:17 PM J.Smith</div>
                          </div>


                      </div>
                      <div class="visit-col col-2">
                          <div class="custom-hover-container">
                              <a data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas"
                                  class="text-black text-decoration-underline fw-semibold"
                                  href="#">Sydney Crosbey</a>
                              <div class="custom-hover-box">
                                  <img src="assets/img/users/user-04.jpg" alt="Customer Photo">
                                  <div class="custom-details">
                                      <strong>Sydney Crosbey</strong><br>
                                      123 Main St, Toronto<br>
                                      Cell: (416) 111-2222<br>
                                      Email: sydney.c@example.com<br>
                                      Sales Rep: Alex Green<br>
                                      Last Updated: 7/04/25 8:00am
                                  </div>
                              </div>
                          </div>
                          <br>
                          2022 <a  data-bs-toggle="offcanvas" href="#" data-bs-target="#editvehicleinfo" class="text-decoration-underline">Toyota Camry</a> (34892A) (U)<br>
                          4TIC11AK0NU123456
                      </div>
                      <div class="visit-col col-3">
                          Walk-in (Outbound) (Pending)<br>
                          <a class="credit-link " href="#" data-bs-toggle="offcanvas"
                              data-bs-target="#editShowroomVisitCanvas">Edit Showroom Visit</a><br>
                              <div class="checkbox-container">
                                <div class="checkbox-item">
                                    <label for="D">DE</label>
                                    <input type="checkbox" id="D" checked>
                                </div>
                                <div class="checkbox-item">
                                    <label for="WU">WU</label>
                                    <input type="checkbox" id="WU" checked>
                                </div>
                                <div class="checkbox-item">
                                  <label for="TD">TD</label>
                                  <input type="checkbox" id="TD" checked>
                              </div>
                                <div class="checkbox-item">
                                    <label for="FI">PF</label>
                                    <input type="checkbox" id="FI" checked>
                                </div>
                                <div class="checkbox-item">
                                  <label for="TA">TA</label>
                                  <input type="checkbox" id="TA" checked>
                              </div>
                                <div class="checkbox-item">
                                    <label for="SO">SO</label>
                                    <input type="checkbox" id="SO" checked>
                                </div>
                                <div class="checkbox-item">
                                    <label for="LO">LO</label>
                                    <input type="checkbox" id="LO">
                                </div>

                            </div>
                      </div>
                      <div class="custom-alert-box">
                          <div class="alert-text">
                              Deal #42666 is Delivered, sold for $114,888 -
                              Front/Back: $458 / $1,510
                          </div>
                          <a href="#" data-bs-toggle="modal" data-bs-target="#editNoteModal"
                              class="modify-link">modify</a>
                      </div>




                  </div>
                  <div class="visit-entry">
                    <div class="visit-col col-1 ">
                        <div class="d-flex gap-2 justify-content-normal align-items-center">

                            <div>June 06, 2025 1:17 PM J.Smith</div>
                        </div>


                    </div>
                    <div class="visit-col col-2">
                        <div class="custom-hover-container">
                            <a data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas"
                                class="text-black text-decoration-underline fw-semibold"
                                href="#">Sydney Crosbey</a>
                            <div class="custom-hover-box">
                                <img src="assets/img/users/user-04.jpg" alt="Customer Photo">
                                <div class="custom-details">
                                    <strong>Sydney Crosbey</strong><br>
                                    123 Main St, Toronto<br>
                                    Cell: (416) 111-2222<br>
                                    Email: sydney.c@example.com<br>
                                    Sales Rep: Alex Green<br>
                                    Last Updated: 7/04/25 8:00am
                                </div>
                            </div>
                        </div>
                        <br>
                        2022 <a  data-bs-toggle="offcanvas" href="#" data-bs-target="#editvehicleinfo" class="text-decoration-underline">Toyota Camry</a> (34892A) (U)<br>
                        4TIC11AK0NU123456
                    </div>
                    <div class="visit-col col-3">
                        Walk-in (Outbound) (Pending)<br>
                        <a class="credit-link " href="#" data-bs-toggle="offcanvas"
                            data-bs-target="#editShowroomVisitCanvas">Edit Showroom Visit</a><br>
                            <div class="checkbox-container">
                              <div class="checkbox-item">
                                  <label for="D">DE</label>
                                  <input type="checkbox" id="D" checked>
                              </div>
                              <div class="checkbox-item">
                                  <label for="WU">WU</label>
                                  <input type="checkbox" id="WU" checked>
                              </div>
                              <div class="checkbox-item">
                                <label for="TD">TD</label>
                                <input type="checkbox" id="TD" checked>
                            </div>
                              <div class="checkbox-item">
                                  <label for="FI">PF</label>
                                  <input type="checkbox" id="FI" checked>
                              </div>
                              <div class="checkbox-item">
                                <label for="TA">TA</label>
                                <input type="checkbox" id="TA" checked>
                            </div>
                              <div class="checkbox-item">
                                  <label for="SO">SO</label>
                                  <input type="checkbox" id="SO" checked>
                              </div>
                              <div class="checkbox-item">
                                  <label for="LO">LO</label>
                                  <input type="checkbox" id="LO">
                              </div>

                          </div>
                    </div>
                    <div class="custom-alert-box">
                        <div class="alert-text">
                            Deal #42666 is Delivered, sold for $114,888 -
                            Front/Back: $458 / $1,510
                        </div>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#editNoteModal"
                            class="modify-link">modify</a>
                    </div>




                </div>








                </div>
            </div>

            <!-- View 2 -->

        </div>


    </div>
    <!-- End Content -->


    <!-- End Footer-->

</div>




<div class="modal fade" id="editNoteModal" tabindex="-1" aria-labelledby="editNoteModalLabel"
aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editNoteModalLabel">Edit Note</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <label for="noteInput" class="form-label">Note</label>
            <textarea class="form-control" id="noteInput" rows="3">Deal #42666 is Delivered, sold for $114,888 - Front/Back: $458/$1,510</textarea>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light border border-1"
                data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
        </div>
    </div>
</div>
</div>



<div class="offcanvas offcanvas-end" tabindex="-1" id="editShowroomVisitCanvas">
    <div class="offcanvas-header d-block pb-0">
        <div class="border-bottom d-flex align-items-center justify-content-between pb-3">
            <h6 class="offcanvas-title">Edit Showroom Visit</h6>
            <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="offcanvas"
                aria-label="Close">
                <i class="fa-solid fa-x"></i>
            </button>
        </div>
    </div>
    <div class="offcanvas-body pt-3">
        <div class="container ">
<div class="row g-2 mb-3">
<div class="col-md-4 mb-2">
<div class="mb-1">
  <strong>Assigned To:</strong>
</div>
<select class="form-select">
  <option value="" selected>J.Smith</option>
  <option>Aaron Burgess</option>
  <option>Brad Nakuckyj</option>
  <option>Brandon Henderson</option>
  <option>Emily Chan</option>
  <option>Jake Thomson</option>
</select>
</div>
<div class="col-md-4 mb-2">
<div class="mb-1">
  <strong>Assigned Manager:</strong>
</div>
<select class="form-select">
  <option >J.Smith</option>
  <option>Aaron Burgess</option>
  <option>Brad Nakuckyj</option>
  <option selected>Brandon Henderson</option>
  <option>Emily Chan</option>
  <option>Jake Thomson</option>
</select>
</div>
<div class="col-md-4 mb-2">
<div class="mb-1">
  <strong>Lead Type:</strong>
</div>
<select class="form-select">
  <option>Internet</option>
  <option selected>Walk-In</option>
  <option>Phone Up</option>
  <option>Text Up</option>
  <option>Website Chat</option>
  <option>Import</option>
  <option>Wholesale</option>
  <option>Lease Renewal</option>
</select>
</div>
<div class="col-md-4 mb-2">
<div class="mb-1">
  <strong>Deal Type:</strong>
</div>
<select class="form-select">
  <option>Finance</option>
  <option >Lease</option>
  <option selected>Cash</option>

</select>
</div>
<div class="col-md-4 mb-2">
<div class="mb-1">
  <strong>Source:</strong>
</div>
<select class="form-select">
  <option>Facebook</option>
  <option >Marketplace</option>
  <option selected>Dealer Website</option>

</select>
</div>
</div>

            <div class="mb-3">
                <div class="section-title"><img src="assets/img/icons/user_illustration.png"
                        class="title-icon">Did you enter all of their personal information?</div>
                <div class="personal-content">
                    <p> Customer: <a href="#" data-bs-toggle="offcanvas"
                            data-bs-target="#editVisitCanvas">Lovepreet Singh</a></p>
                    <p> Email: jmaldonado@activix.ca</p>
                    <p> Home: (604) 783-2751</p>
                    <p> Work:</p>
                    <p> Cell:</p>
                    <p> Alt Email:</p>


                </div>
            </div>

            <div class="form-section">
                <div class="section-title "><img src="assets/img/icons/vehicle_illustration.png"
                        class="title-icon">Is this the correct vehicle they are interested in?</div>
                <div class="personal-content mb-4 mt-3 ">
                    <p>
                        Vehicle: <a href="#" data-bs-toggle="offcanvas"
                            data-bs-target="#editvehicleinfo">(none)</a></p>
                    <p> Trade-In: <a href="#" data-bs-toggle="modal" data-bs-target="#tradeInModal">(no
                            trade)</a>
                    </p>
                </div>

            </div>

            <div class="form-section checkboxes-area ps-4 pe-4 row">
                <div class="col-md-12 mb-2 d-flex justify-content-between">Demo?
                    <div>
                        <input class="form-check-input me-1" type="radio" name="walkaround" id="walkYes"
                            value="Yes">
                        <label class="form-check-label me-3" for="walkYes">Yes</label>
                        <input class="form-check-input me-1" type="radio" name="walkaround" id="walkNo"
                            value="No" checked>
                        <label class="form-check-label" for="walkNo">No</label>
                    </div>
                </div>

                <div class="col-md-12 mb-2 d-flex justify-content-between">Write-Up?
                    <div>
                        <input class="form-check-input me-1" type="radio" name="demo" id="demoYes"
                            value="Yes">
                        <label class="form-check-label me-3" for="demoYes">Yes</label>
                        <input class="form-check-input me-1" type="radio" name="demo" id="demoNo"
                            value="No" checked>
                        <label class="form-check-label" for="demoNo">No</label>
                    </div>
                </div>

                <div class="col-md-12 mb-2 d-flex justify-content-between">Touch Desk?
                    <div>
                        <input class="form-check-input me-1" type="radio" name="trade" id="tradeYes"
                            value="Yes">
                        <label class="form-check-label me-3" for="tradeYes">Yes</label>
                        <input class="form-check-input me-1" type="radio" name="trade" id="tradeNo"
                            value="No" checked>
                        <label class="form-check-label" for="tradeNo">No</label>
                    </div>
                </div>

                <div class="col-md-12 mb-2 d-flex justify-content-between">Pending F&I?
                    <div>
                        <input class="form-check-input me-1" type="radio" name="desking" id="deskYes"
                            value="Yes">
                        <label class="form-check-label me-3" for="deskYes">Yes</label>
                        <input class="form-check-input me-1" type="radio" name="desking" id="deskNo"
                            value="No" checked>
                        <label class="form-check-label" for="deskNo">No</label>
                    </div>
                </div>

                <div class="col-md-12 mb-2 d-flex justify-content-between">Trade Appraisal?
                    <div>
                        <input class="form-check-input me-1" type="radio" name="managerTurnover"
                            id="managerYes" value="Yes">
                        <label class="form-check-label me-3" for="managerYes">Yes</label>
                        <input class="form-check-input me-1" type="radio" name="managerTurnover"
                            id="managerNo" value="No" checked>
                        <label class="form-check-label" for="managerNo">No</label>
                    </div>
                </div>
                <div class="col-md-12 mb-2 d-flex justify-content-between">Sold?
                    <div>
                        <input class="form-check-input me-1" type="radio" name="managerTurnover"
                            id="managerYes" value="Yes">
                        <label class="form-check-label me-3" for="managerYes">Yes</label>
                        <input class="form-check-input me-1" type="radio" name="managerTurnover"
                            id="managerNo" value="No" checked>
                        <label class="form-check-label" for="managerNo">No</label>
                    </div>
                </div>
                <div class="col-md-12 mb-2 d-flex justify-content-between align-items-center">
                  <span>Lost?</span>
                  <div>
                      <input class="form-check-input me-1" type="radio" name="lostStatus" id="lostYes" value="Yes">
                      <label class="form-check-label me-3" for="lostYes">Yes</label>
                      <input class="form-check-input me-1" type="radio" name="lostStatus" id="lostNo" value="No" checked>
                      <label class="form-check-label" for="lostNo">No</label>
                  </div>
              </div>
                <div class="col-md-12 mt-2" id="lostReasonSection" style="display:none;">
                  <label class="form-label">Select Lost Reason</label>
                  <select class="form-select mb-2" id="lostReason">
                      <option value="" hidden>Select reason...</option>
                      <option value="Price too high">Price too high</option>
                      <option value="Financing declined">Financing declined</option>
                      <option value="Chose competitor">Chose competitor</option>
                      <option value="Vehicle unavailable">Vehicle unavailable</option>
                      <option value="Customer not responsive">Customer not responsive</option>
                      <option value="Other">Other (type custom)</option>
                  </select>
              
                  <!-- Optional Custom Reason Field -->
                  <input type="text" id="customReason" class="form-control mb-2" placeholder="Enter custom reason" style="display:none;">
              
                  <button class="btn btn-primary btn-sm float-end" id="saveLostBtn">
                      <i class="bi bi-save"></i> Save
                  </button>
              </div>
            </div>

            <div class="form-section mt-3 mb-3">
                <label class="form-label">Visit Notes:</label>
                <textarea name="" id="" cols="30" rows="6" class="form-control">looking for 2019+ Jeep Grand Cherokee, Durango, Challenger. Dark colors around 35k budget</textarea>
            </div>


        </div>
      <div class="d-flex justify-content-between align-items-center">
        <a href="#" class="edit-vehicle-link ">Delete Visit</a>
        <button class="btn btn-primary btn-sm" data-bs-dismiss="offcanvas">Save</button>
      </div>
    </div>
</div>
<div class="modal fade" id="tradeInModal" tabindex="-1" aria-labelledby="tradeInModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Trade-In Appraisal</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <form>
                <div class="row g-3">
                    <!-- Row 1 -->
                    <div class="col-md-3">
                        <label class="form-label">Year:</label>
                        <select class="form-select">
                            <option>-- Select --</option>
                            <option>2021</option>
                            <option>2022</option>
                            <option>2023</option>
                            <option>2024</option>
                            <option>2025</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Make:</label>
                        <select class="form-select">
                            <option>-- Select --</option>
                            <option>Toyota</option>
                            <option>Honda</option>
                            <option>Ford</option>
                            <option>Chevrolet</option>
                            <option>BMW</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Model:</label>
                        <select class="form-select">
                            <option>-- Select --</option>
                            <option>Camry</option>
                            <option>Civic</option>
                            <option>F-150</option>
                            <option>Silverado</option>
                            <option>3 Series</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Trim:</label>
                        <select class="form-select">
                            <option>-- Select --</option>
                            <option>Base</option>
                            <option>SE</option>
                            <option>LE</option>
                            <option>XLE</option>
                            <option>Sport</option>
                        </select>
                    </div>

                    <!-- Row 2 -->
                    <div class="col-md-3">
                        <label class="form-label">Mileage:</label>
                        <input type="text" class="form-control" placeholder="e.g. 45000">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Exterior:</label>
                        <input type="text" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Interior:</label>
                        <input type="text" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Condition:</label>
                        <select class="form-select">
                            <option>-- Select --</option>
                            <option>Excellent</option>
                            <option>Good</option>
                            <option>Fair</option>
                            <option>Poor</option>
                            <option>Salvage</option>
                        </select>
                    </div>

                    <!-- Row 3 -->
                    <div class="col-md-3">
                        <label class="form-label">Engine:</label>
                        <input type="text" class="form-control" placeholder="e.g. 2.5L I4">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Trans:</label>
                        <input type="text" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Drive Line:</label>
                        <input type="text" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Body Style:</label>
                        <select class="form-select">
                            <option>-- Select --</option>
                            <option>Sedan</option>
                            <option>SUV</option>
                            <option>Truck</option>
                            <option>Coupe</option>
                            <option>Van</option>
                        </select>
                    </div>

                    <!-- Row 4 -->
                    <div class="col-md-3">
                        <label class="form-label">Doors:</label>
                        <input type="text" class="form-control" placeholder="e.g. 4">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Trade Value:</label>
                        <input type="text" class="form-control" placeholder="$">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Payoff:</label>
                        <input type="text" class="form-control" placeholder="$">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">ACV:</label>
                        <input type="text" class="form-control" placeholder="$">
                    </div>

                    <!-- Row 5 -->
                    <div class="col-md-6">
                        <label class="form-label">Lienholder:</label>
                        <input type="text" class="form-control">
                    </div>

                  

                    <!-- Row 6 -->
                    <div class="col-md-12">
                        <label class="form-label">Memo:</label>
                        <textarea class="form-control" rows="3" placeholder="Notes..."></textarea>
                    </div>

                    <!-- Row 7 -->
                    <div class="col-md-12">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="leaseCheck">
                            <label class="form-check-label" for="leaseCheck">
                                Lease Trade-In
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer d-flex justify-content-between">
            <div>
                <button class="btn btn-light border border-1" onclick="window.location='showroom.html'">Delete
                    Trade</button>
                    <button type="button" class="btn btn-primary ms-1">Appraisal</button>
            </div>
            <div>
                <button class="btn btn-light border border-1 me-1" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    // Elements
    const lostYes = document.getElementById('lostYes');
    const lostNo = document.getElementById('lostNo');
    const lostReasonSection = document.getElementById('lostReasonSection');
    const lostReason = document.getElementById('lostReason');
    const customReason = document.getElementById('customReason');
    const saveLostBtn = document.getElementById('saveLostBtn');
    
    // Show section when Lost = Yes
    lostYes.addEventListener('change', () => {
        if (lostYes.checked) {
            lostReasonSection.style.display = 'block';
        }
    });
    lostNo.addEventListener('change', () => {
        if (lostNo.checked) {
            lostReasonSection.style.display = 'none';
            lostReason.value = '';
            customReason.value = '';
            customReason.style.display = 'none';
        }
    });
    
    // Show custom reason input
    lostReason.addEventListener('change', () => {
        if (lostReason.value === 'Other') {
            customReason.style.display = 'block';
        } else {
            customReason.style.display = 'none';
            customReason.value = '';
        }
    });
    
    // Save button action
    saveLostBtn.addEventListener('click', () => {
        const reason = (lostReason.value === 'Other') ? customReason.value.trim() : lostReason.value;
        if (!reason) {
            alert('Please select or enter a reason.');
            return;
        }
        alert('Lost reason saved: ' + reason);
    });
    </script>
@endsection