@extends('layouts.app')

@section('title' , 'Text Inbox')



@section('content')

<div class="content content-two p-0">
    <div class="d-md-flex">
      <div class="email-sidebar border-end ">
        <div class="active slimscroll h-100">
          <div class="slimscroll-active-sidebar">
            <div class="p-3">
              <div class=" bg-white rounded p-2 mb-3">
                <div class="d-flex justify-content-center align-items-center">
                  <a href="javascript:void(0);" class="avatar avatar-md flex-shrink-0 me-2">
                    <img src="assets/light_logo.png" class="logo-img" style="height:70px;width: 70px;max-width: 70px;"  class="rounded-circle" alt="Img">
                  </a>
                  <div>
                   

                  </div>
                </div>
              </div>
              <a href="javascript:void(0);" class="btn btn-primary w-100" data-bs-toggle="modal"
                data-bs-target="#email-view"><i class="ti ti-edit me-2"></i>Compose</a>
              <div class="mt-4">
                <h5 class="mb-2"> Inbox</h5>
                <div class="d-block mb-3 pb-3 border-bottom email-tags">
                  <a href="inbox.html"
                    class="d-flex bg-light align-items-center justify-content-between p-2 rounded active">
                    <span class="d-flex align-items-center fw-medium"><i
                        class="ti ti-inbox text-gray me-2"></i>Inbox</span>
                    <span class="badge bg-danger bg-danger rounded-pill badge-xs">56</span>
                  </a>
                  <a href="javascript:void(0);"
                    class="d-flex align-items-center justify-content-between p-2 rounded">
                    <span class="d-flex align-items-center fw-medium"><i
                        class="ti ti-star text-gray me-2"></i>Starred</span>
                    <span class="fw-semibold fs-12 rounded-pill">46</span>
                  </a>
                  <a href="javascript:void(0);"
                    class="d-flex align-items-center justify-content-between p-2 rounded">
                    <span class="d-flex align-items-center fw-medium"><i
                        class="ti ti-rocket text-gray me-2"></i>Sent</span>
                    <span class="rounded-pill">14</span>
                  </a>
                  <a href="javascript:void(0);"
                    class="d-flex align-items-center justify-content-between p-2 rounded">
                    <span class="d-flex align-items-center fw-medium"><i
                        class="ti ti-file text-gray me-2"></i>Drafts</span>
                    <span class="rounded-pill">12</span>
                  </a>
                  <a href="javascript:void(0);"
                    class="d-flex align-items-center justify-content-between p-2 rounded">
                    <span class="d-flex align-items-center fw-medium"><i
                        class="ti ti-trash text-gray me-2"></i>Deleted</span>
                    <span class="rounded-pill">08</span>
                  </a>

                </div>
              </div>

             



            </div>
          </div>
        </div>
      </div>
      <div class="bg-white flex-fill border-end border-bottom mail-notifications">
        <div class="active slimscroll h-100">
          <div class="slimscroll-active-sidebar">
            <div class="p-3">
              <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                <div>
                  <h5 class="mb-1">Text Inbox</h5>
                  <div class="d-flex align-items-center">
                    <span>2345 Text</span>
                    <i class="ti ti-point-filled text-primary mx-1"></i>
                    <span>56 Unread</span>
                  </div>
                </div>
                <div class="d-flex align-items-center">
                  <div class="position-relative input-icon me-3">
                    <input type="text" class="form-control" placeholder="Search Texts">
                    <span class="input-icon-addon">
                      <i class="ti ti-search"></i>
                    </span>
                  </div>
                  <div class="d-flex align-items-center">
                    <div class="dropdown">
                      <a href="#" class="btn btn-icon btn-sm rounded-circle" data-bs-toggle="dropdown"
                        id="filterDropdownBtn">
                        <i class="ti ti-filter-edit"></i>
                      </a>
                      <ul class="dropdown-menu dropdown-menu-end" id="filterDropdown">
                        <li>
                          <a class="dropdown-item" href="javascript:void(0);" data-value="date_low"
                            onclick="applyFilter(this)">
                            Date: Earliest to Latest
                          </a>
                        </li>
                        <li>
                          <a class="dropdown-item" href="javascript:void(0);" data-value="date_high"
                            onclick="applyFilter(this)">
                            Date: Latest to Earliest
                          </a>
                        </li>
                      </ul>
                    </div>


                    <input type="hidden" id="selectedFilter" name="selectedFilter" value="">

                    <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle"><i
                        class="ti ti-trash"></i></a>
                    <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle"><i
                        class="ti ti-refresh"></i></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="list-group list-group-flush mails-list">
              <div class="list-group-item border-bottom p-3">
                <div class="d-flex align-items-center mb-2">
                  <div class="form-check form-check-md d-flex align-items-center flex-shrink-0 me-1">
                    <input class="form-check-input" type="checkbox">
                  </div>
           

             
                  <div class="d-flex align-items-center flex-wrap row-gap-2 flex-fill">
                    <a href="{{route('text.reply')}}" class="avatar bg-primary avatar-rounded me-2">
                      <span class="avatar-title">CD</span>
                    </a>
                    <div class="flex-fill">
                      <div class="d-flex align-items-start justify-content-between">
                        <div>
                          <h6 class="mb-1"><a href="{{route('text.reply')}}">Justin Lapointe</a></h6>
                          <span class="fw-semibold">Client Dashboard</span>
                        </div>
                        <div class="d-flex align-items-center">
                          <div class="dropdown">
                            <button class="btn btn-icon btn-sm rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end p-3">
                              <li>
                                <a class="dropdown-item rounded-1" href="{{route('text.reply')}}">Open Message Thread</a>
                              </li>
                              <li>
                                <a class="dropdown-item rounded-1" href="javascript:void(0);">Reply</a>
                              </li>
                              <!-- 🚫 No Reply All -->
                              <!-- 🚫 No Forward -->
                              <!-- 🚫 No Forward as Attachment -->
                              <li>
                                <a class="dropdown-item rounded-1" href="javascript:void(0);">Mark as Unread</a>
                              </li>
                              <!-- ✅ Delete (only Managers) -->
                              <li>
                                <a class="dropdown-item rounded-1 text-danger" href="javascript:void(0);">Delete</a>
                              </li>
                              <!-- 🚫 No “Move To Folder” -->
                            </ul>
                            
                        </div>
                          <span><i class="ti ti-point-filled text-success"></i>3:13 PM</span> <div class="ms-2 favorite-icon">
                            <i class="ti ti-star"></i>
                          </div>
                          <script>
                            document.querySelectorAll('.favorite-icon').forEach(icon => {
                              icon.addEventListener('click', function () {
                                const i = this.querySelector('i');
                                if (i.classList.contains('ti-star')) {
                                  i.classList.replace('ti-star', 'ti-star-filled');
                                } else {
                                  i.classList.replace('ti-star-filled', 'ti-star');
                                }
                              });
                            });
                          </script>
                                                        
                        </div>
                        

                      
                        
                      </div>
                      <p>It seems that recipients are receiving...</p>
                    </div>
                  </div>
                </div>

              </div>
              <div class="list-group-item border-bottom p-3">
                <div class="d-flex align-items-center mb-2">
                  <div class="form-check form-check-md d-flex align-items-center flex-shrink-0 me-1">
                    <input class="form-check-input" type="checkbox">
                  </div>
           

             
                  <div class="d-flex align-items-center flex-wrap row-gap-2 flex-fill">
                    <a href="{{route('text.reply')}}" class="avatar bg-primary avatar-rounded me-2">
                      <span class="avatar-title">CD</span>
                    </a>
                    <div class="flex-fill">
                      <div class="d-flex align-items-start justify-content-between">
                        <div>
                          <h6 class="mb-1"><a href="{{route('text.reply')}}">Justin Lapointe</a></h6>
                          <span class="fw-semibold">Client Dashboard</span>
                        </div>
                        <div class="d-flex align-items-center">
                          <div class="dropdown">
                            <button class="btn btn-icon btn-sm rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end p-3">
                              <li>
                                <a class="dropdown-item rounded-1" href="{{route('text.reply')}}">Open Message Thread</a>
                              </li>
                              <li>
                                <a class="dropdown-item rounded-1" href="javascript:void(0);">Reply</a>
                              </li>
                              <!-- 🚫 No Reply All -->
                              <!-- 🚫 No Forward -->
                              <!-- 🚫 No Forward as Attachment -->
                              <li>
                                <a class="dropdown-item rounded-1" href="javascript:void(0);">Mark as Unread</a>
                              </li>
                              <!-- ✅ Delete (only Managers) -->
                              <li>
                                <a class="dropdown-item rounded-1 text-danger" href="javascript:void(0);">Delete</a>
                              </li>
                              <!-- 🚫 No “Move To Folder” -->
                            </ul>
                            
                        </div>
                          <span><i class="ti ti-point-filled text-success"></i>3:13 PM</span> <div class="ms-2 favorite-icon">
                            <i class="ti ti-star"></i>
                          </div>
                          <script>
                            document.querySelectorAll('.favorite-icon').forEach(icon => {
                              icon.addEventListener('click', function () {
                                const i = this.querySelector('i');
                                if (i.classList.contains('ti-star')) {
                                  i.classList.replace('ti-star', 'ti-star-filled');
                                } else {
                                  i.classList.replace('ti-star-filled', 'ti-star');
                                }
                              });
                            });
                          </script>
                                                        
                        </div>
                        

                      
                        
                      </div>
                      <p>It seems that recipients are receiving...</p>
                    </div>
                  </div>
                </div>

              </div>
          
              <div class="list-group-item border-bottom p-3">
                <div class="d-flex align-items-center mb-2">
                  <div class="form-check form-check-md d-flex align-items-center flex-shrink-0 me-1">
                    <input class="form-check-input" type="checkbox">
                  </div>
           

             
                  <div class="d-flex align-items-center flex-wrap row-gap-2 flex-fill">
                    <a href="{{route('text.reply')}}" class="avatar bg-primary avatar-rounded me-2">
                      <span class="avatar-title">CD</span>
                    </a>
                    <div class="flex-fill">
                      <div class="d-flex align-items-start justify-content-between">
                        <div>
                          <h6 class="mb-1"><a href="{{route('text.reply')}}">Justin Lapointe</a></h6>
                          <span class="fw-semibold">Client Dashboard</span>
                        </div>
                        <div class="d-flex align-items-center">
                          <div class="dropdown">
                            <button class="btn btn-icon btn-sm rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end p-3">
                              <li>
                                <a class="dropdown-item rounded-1" href="{{route('text.reply')}}">Open Message Thread</a>
                              </li>
                              <li>
                                <a class="dropdown-item rounded-1" href="javascript:void(0);">Reply</a>
                              </li>
                              <!-- 🚫 No Reply All -->
                              <!-- 🚫 No Forward -->
                              <!-- 🚫 No Forward as Attachment -->
                              <li>
                                <a class="dropdown-item rounded-1" href="javascript:void(0);">Mark as Unread</a>
                              </li>
                              <!-- ✅ Delete (only Managers) -->
                              <li>
                                <a class="dropdown-item rounded-1 text-danger" href="javascript:void(0);">Delete</a>
                              </li>
                              <!-- 🚫 No “Move To Folder” -->
                            </ul>
                            
                        </div>
                          <span><i class="ti ti-point-filled text-success"></i>3:13 PM</span> <div class="ms-2 favorite-icon">
                            <i class="ti ti-star"></i>
                          </div>
                          <script>
                            document.querySelectorAll('.favorite-icon').forEach(icon => {
                              icon.addEventListener('click', function () {
                                const i = this.querySelector('i');
                                if (i.classList.contains('ti-star')) {
                                  i.classList.replace('ti-star', 'ti-star-filled');
                                } else {
                                  i.classList.replace('ti-star-filled', 'ti-star');
                                }
                              });
                            });
                          </script>
                                                        
                        </div>
                        

                      
                        
                      </div>
                      <p>It seems that recipients are receiving...</p>
                    </div>
                  </div>
                </div>

              </div>
          
              <div class="list-group-item border-bottom p-3">
                <div class="d-flex align-items-center mb-2">
                  <div class="form-check form-check-md d-flex align-items-center flex-shrink-0 me-1">
                    <input class="form-check-input" type="checkbox">
                  </div>
           

             
                  <div class="d-flex align-items-center flex-wrap row-gap-2 flex-fill">
                    <a href="{{route('text.reply')}}" class="avatar bg-primary avatar-rounded me-2">
                      <span class="avatar-title">CD</span>
                    </a>
                    <div class="flex-fill">
                      <div class="d-flex align-items-start justify-content-between">
                        <div>
                          <h6 class="mb-1"><a href="{{route('text.reply')}}">Justin Lapointe</a></h6>
                          <span class="fw-semibold">Client Dashboard</span>
                        </div>
                        <div class="d-flex align-items-center">
                          <div class="dropdown">
                            <button class="btn btn-icon btn-sm rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end p-3">
                              <li>
                                <a class="dropdown-item rounded-1" href="{{route('text.reply')}}">Open Message Thread</a>
                              </li>
                              <li>
                                <a class="dropdown-item rounded-1" href="javascript:void(0);">Reply</a>
                              </li>
                              <!-- 🚫 No Reply All -->
                              <!-- 🚫 No Forward -->
                              <!-- 🚫 No Forward as Attachment -->
                              <li>
                                <a class="dropdown-item rounded-1" href="javascript:void(0);">Mark as Unread</a>
                              </li>
                              <!-- ✅ Delete (only Managers) -->
                              <li>
                                <a class="dropdown-item rounded-1 text-danger" href="javascript:void(0);">Delete</a>
                              </li>
                              <!-- 🚫 No “Move To Folder” -->
                            </ul>
                            
                        </div>
                          <span><i class="ti ti-point-filled text-success"></i>3:13 PM</span> <div class="ms-2 favorite-icon">
                            <i class="ti ti-star"></i>
                          </div>
                          <script>
                            document.querySelectorAll('.favorite-icon').forEach(icon => {
                              icon.addEventListener('click', function () {
                                const i = this.querySelector('i');
                                if (i.classList.contains('ti-star')) {
                                  i.classList.replace('ti-star', 'ti-star-filled');
                                } else {
                                  i.classList.replace('ti-star-filled', 'ti-star');
                                }
                              });
                            });
                          </script>
                                                        
                        </div>
                        

                      
                        
                      </div>
                      <p>It seems that recipients are receiving...</p>
                    </div>
                  </div>
                </div>

              </div>
          
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>




  {{-- MODAL --}}


  <!-- Start Compose Text -->
<div id="email-view" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-md">
      <div class="modal-content">
        <div class="bg-white border-0 rounded compose-view">
          <div class="compose-header d-flex align-items-center justify-content-between bg-dark p-3">
            <h5 class="text-white">Compose Text</h5>
            <div class="d-flex align-items-center">
              <a href="javascript:void(0);" class="d-inline-flex me-2 text-white fs-16"><i class="ti ti-minus"></i></a>
              <a href="javascript:void(0);" class="d-inline-flex me-2 fs-16 text-white"><i class="ti ti-maximize"></i></a>
              <button type="button"
                class="btn-close btn-close-modal custom-btn-close bg-transparent fs-16 text-white position-static"
                data-bs-dismiss="modal" aria-label="Close">
                <i class="ti ti-x"></i>
              </button>
            </div>
          </div>
  
          <form action="text-inbox.html">
            <!-- Recipient Field -->
            <div class="p-3 position-relative pb-2 border-bottom">
              <div class="tag-with-img d-flex align-items-center">
                <label class="form-label me-2 mb-0">To</label>
                <input class="input-tags form-control border-0 h-100" id="inputBox" type="text"
                  placeholder="Type to search..." />
                <ul id="suggestions-list" class="list-group position-absolute shadow-sm d-none"
                  style="top: 65px; z-index: 1000;width:90%;left:50%;transform: translateX(-50%);"></ul>
              </div>
            </div>
  
            <!-- Text Body & Template Selection -->
            <div class="p-3 border-bottom position-relative">
              <div class="mb-3">
                <textarea id="text-body" rows="7" class="form-control" placeholder="Message body"></textarea>
              </div>
  
              <!-- Insert Template Dropdown -->
              <div class="position-relative">
                <label class="form-label fw-semibold">Insert Template</label>
                <select id="templateSelect" class="form-select border border-1">
                  <option value="">Select a template...</option>
                  <option value="Follow-Up Message">Follow-Up Message</option>
                  <option value="Appointment Reminder">Appointment Reminder</option>
                  <option value="Thank You Message">Thank You Message</option>
                  <option value="Payment Reminder">Payment Reminder</option>
                </select>
              </div>
            </div>
  
            <!-- Footer -->
            <div class="p-3 d-flex align-items-center justify-content-between">
              <div class="d-flex align-items-center">
                <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle"><i class="ti ti-paperclip"></i></a>
              </div>
              <div class="d-flex align-items-center compose-footer">
                <button type="submit" class="btn btn-primary d-inline-flex align-items-center ms-2">
                  Send <i class="ti ti-arrow-right ms-2"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Script -->
  <script>
    const templateSelect = document.getElementById('templateSelect');
    const textBody = document.getElementById('text-body');
  
    const templates = {
      "Follow-Up Message": "Hi [Name],\n\nJust following up to see if you had a chance to review my previous message.\n\nBest regards,\n[Your Name]",
      "Appointment Reminder": "Hi [Name],\n\nThis is a reminder for your upcoming appointment on [Date] at [Time].\n\nThank you,\n[Your Name]",
      "Thank You Message": "Hi [Name],\n\nThank you for your time today! I appreciate the opportunity to connect.\n\nBest regards,\n[Your Name]",
      "Payment Reminder": "Hi [Name],\n\nThis is a friendly reminder that your payment is due on [Date]. Please let us know if you have any questions.\n\nBest,\n[Your Name]"
    };
  
    // Auto-fill text body when template selected
    templateSelect.addEventListener('change', () => {
      const selected = templateSelect.value;
      textBody.value = templates[selected] || '';
    });
  </script>

@endsection