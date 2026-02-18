@extends('layouts.app')


@section('title','Email Reply')



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
                            <img class="logo-img" src="assets/light_logo.png" style="height:70px;width: 70px;max-width: 70px;"  class="rounded-circle" alt="Img">
                          </a>
                          <div>
                           
    
                          </div>
                        </div>
                      </div>
                        <a href="javascript:void(0);" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#email-view"><i class="ti ti-edit me-2"></i>Compose</a>
                        <div class="mt-4">
                            <h5 class="mb-2">Emails</h5>
                            <div class="d-block mb-3 pb-3 border-bottom email-tags">
                                <a href="email.html" class="d-flex bg-light align-items-center justify-content-between p-2 rounded active">
                                    <span class="d-flex align-items-center fw-medium"><i class="ti ti-inbox text-gray me-2"></i>Inbox</span>
                                    <span class="badge bg-danger bg-danger rounded-pill badge-xs">56</span>
                                </a>
                                <a href="javascript:void(0);" class="d-flex align-items-center justify-content-between p-2 rounded">
                                    <span class="d-flex align-items-center fw-medium"><i class="ti ti-star text-gray me-2"></i>Starred</span>
                                    <span class="fw-semibold fs-12 rounded-pill">46</span>
                                </a>
                                <a href="javascript:void(0);" class="d-flex align-items-center justify-content-between p-2 rounded">
                                    <span class="d-flex align-items-center fw-medium"><i class="ti ti-rocket text-gray me-2"></i>Sent</span>
                                    <span class="rounded-pill">14</span>
                                </a>
                                <a href="javascript:void(0);" class="d-flex align-items-center justify-content-between p-2 rounded">
                                    <span class="d-flex align-items-center fw-medium"><i class="ti ti-file text-gray me-2"></i>Drafts</span>
                                    <span class="rounded-pill">12</span>
                                </a>
                                <a href="javascript:void(0);" class="d-flex align-items-center justify-content-between p-2 rounded">
                                    <span class="d-flex align-items-center fw-medium"><i class="ti ti-trash text-gray me-2"></i>Deleted</span>
                                    <span class="rounded-pill">08</span>
                                </a>
                            
                            </div>
                        </div>
                       
                      
                    </div>
                </div>
            </div>
        </div>
        <div class="mail-detail bg-white border-bottom p-3">
            <div class="active slimscroll h-100">
                <div class="slimscroll-active-sidebar">
                    <div class="d-flex align-items-center table-header justify-content-between flex-wrap row-gap-2 border-bottom mb-3 pb-3">
                        <div class="dropdown">
                            <button class="btn border dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="badge bg-dark rounded-circle badge-xs me-1">5</span> Peoples
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end p-3">
                                <li>
                                    <a class="dropdown-item rounded-1" href="javascript:void(0);">Peoples</a>
                                </li>
                                <li>
                                    <a class="dropdown-item rounded-1" href="javascript:void(0);">Rufana</a>
                                </li>
                                <li>
                                    <a class="dropdown-item rounded-1" href="javascript:void(0);">Sean Hill</a>
                                </li>
                                <li>
                                    <a class="dropdown-item rounded-1" href="javascript:void(0);">Cameron Drake</a>
                                </li>
                            </ul>
                        </div>
                        <div class="d-flex align-items-center">
                          <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle toggle-reply"><i class="ti ti-arrow-back-up"></i></a>
                          <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle toggle-reply"><i class="ti ti-arrow-back-up-double"></i></a>
                          <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle toggle-reply"><i class="ti ti-arrow-forward"></i></a>
                          
                            <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle"><i class="ti ti-bookmarks-filled"></i></a>
                            <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle"><i class="ti ti-archive-filled"></i></a>
                            <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle"><i class="ti ti-mail-opened-filled"></i></a>
                            <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle"><i class="ti ti-printer"></i></a>
                            <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle"><i class="ti ti-star-filled text-warning"></i></a>
                        </div>
                    </div>
                    <div class="bg-light rounded p-3 mb-3">
                        <div class="d-flex align-items-center flex-fill border-bottom mb-3 pb-3">
                            <a href="javascript:void(0);" class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                <img src="assets/img/users/user-07.jpg" alt="Img">
                            </a>
                            <div class="flex-fill">
                                <div class="d-flex align-items-start justify-content-between flex-wrap row-gap-2">
                                    <div>
                                        <h6 class="mb-1"><a href="javascript:void(0);">Angela Thomas</a></h6>
                                        <p>Subject: Client Dashboard</p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <p class="me-2 mb-0">12:45 AM</p>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column flex-wrap row-gap-2">
                            <p class="mb-0 text-dark me-3"><span class="text-gray">From: </span> Arman Janes</p>
                            <p class="mb-0 text-dark me-3"><span class="text-gray">To: </span> Angela Thomas</p>
                            <p class="mb-0 text-dark"><span class="text-gray">Cc: </span> Angela Thomas, Justin Lapointe</p>
                        </div>
                    </div>
                    <div class="card shadow-none d-none" id="replybackbox">
                      <div class="card-body">
                          <div class="bg-light rounded p-3 mb-3">
                              <div class="d-flex align-items-center flex-wrap row-gap-2 flex-fill">
                                  <a href="javascript:void(0);" class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                      <img src="assets/img/users/user-07.jpg" alt="Img">
                                  </a>
                                  <div class="flex-fill">
                                      <div class="d-flex align-items-start justify-content-between flex-wrap row-gap-2">
                                          <div>
                                              <h6 class="mb-1"><a href="javascript:void(0);">Arman Janes</a></h6>
                                              <div class="d-flex align-items-center">
                                                  <p class="mb-0"><span>To: </span> Me</p>
                                                  <div class="dropdown">
                                                      <button class="btn btn-icon dropdown-toggle bg-transparent text-dark border-0 p-0 btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                      </button>
                                                      <ul class="dropdown-menu dropdown-menu-end">
                                                          <li>
                                                              <a class="dropdown-item" href="javascript:void(0);"><span class="text-gray">From :</span> Arman Janes <span class="__cf_email__" data-cfemail="6b0a19060a05585f582b0e130a061b070e45080406">[email&#160;protected]</span></a>
                                                          </li>
                                                          <li>
                                                              <a class="dropdown-item" href="javascript:void(0);"><span class="text-gray">To :</span> Angela Thomas <span class="__cf_email__" data-cfemail="5d3c333a3869686b681d38253c302d3138733e3230">[email&#160;protected]</span></a>
                                                          </li>
                                                          <li>
                                                              <a class="dropdown-item" href="javascript:void(0);"><span class="text-gray">Date :</span> 12 May 2025, 09:45 PM </a>
                                                          </li>
                                                      </ul>
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="d-flex align-items-center">
                                              <p class="me-2 mb-0">Yesterday 01:22 AM</p>
                                              <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle"><i class="ti ti-arrow-back-up"></i></a>
                                              <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle"><i class="ti ti-arrow-back-up-double"></i></a>
                                              <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle"><i class="ti ti-printer"></i></a>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div>
                              <h6 class="mb-2">Dear Arman</h6>
                              <p class="text-dark">Introduction Mail from Techsolutions!!!</p>
                              <p class="text-dark">Best regards
                                  <br><b class="fw-medium d-inline-flex mt-1">Arman</b></p>
                          </div>
                          <form action="https://kanakku.dreamstechnologies.com/html/template/email.html">
                              <div class="border rounded mt-3">
                                  <div class="p-3 position-relative border-bottom">
                                      <div class="tag-with-img d-flex align-items-center">
                                          <label class="form-label me-2 mb-0">To</label>
                                          <input class="input-tags form-control border-0 h-100" id="inputBox" type="text" data-role="tagsinput" name="Label" value="Angela Thomas">
                                      </div>
                                      <div class="d-flex align-items-center email-cc">
                                          <a href="javascript:void(0);" class="d-inline-flex me-2">Cc</a>
                                          <a href="javascript:void(0);" class="d-inline-flex">Bcc</a>
                                      </div>
                                  </div>
                                  <div class="p-3">
                                      <div class="mb-3">
                                          <textarea rows="2" class="form-control border-0 p-0 bg-transparent"></textarea>
                                      </div>
                                  </div>
                                  <div class="d-flex align-items-center justify-content-between border-top p-3 flex-wrap">
                                      <div class="d-flex align-items-center">
                                          <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle"><i class="ti ti-paperclip"></i></a>
                                          <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle"><i class="ti ti-photo"></i></a>
                                          <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle"><i class="ti ti-link"></i></a>
                                          <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle"><i class="ti ti-pencil"></i></a>
                                          <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle"><i class="ti ti-mood-smile"></i></a>
                                      </div>
                                      <div class="d-flex align-items-center">
                                          <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle"><i class="ti ti-calendar-repeat"></i></a>
                                          <a href="javascript:void(0);" class="btn btn-icon btn-sm rounded-circle"><i class="ti ti-trash"></i></a>
                                          <button type="button" class="btn btn-primary d-inline-flex align-items-center ms-2">Send <i class="ti ti-arrow-right ms-2"></i></button>
                                      </div>
                                  </div>
                              </div>
                          </form>
                      </div>
                  </div>
                    <div class="card shadow-none">
                        <div class="card-body">
                            <div>
                                <h6 class="mb-3">Dear Angela</h6>
                                <p class="text-dark">I am writing to request a meeting to discuss the progress and next steps for Project. We have reached a critical milestone, and I believe a discussion will help align our efforts and ensure we are on track to
                                    meet our goals.
                                </p>
                                <p class="text-dark">
                                    am available on Tuesday and Thursday afternoons, but I am flexible and can adjust to a time that suits you best
                                </p>
                                <p class="text-dark">
                                    Looking forward to your response.
                                </p>
                                <p class="text-dark">Best regards,
                                    <br><b class="fw-medium d-flex mt-1">Arman</b> </p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between my-3 pt-3 border-top">
                                <h5>Attachments</h5>
                                <a href="javascript:void(0);" class="text-primary fw-medium">Download All</a>
                            </div>
                            <div class="d-flex align-items-center email-attach">
                                <a href="assets/img/cars/FORD-ESCAPE.webp" data-fancybox="gallery" class="avatar avatar-xl me-3 gallery-item">
                                    <img src="assets/img/cars/FORD-ESCAPE.webp" class=" rounded" alt="img">
                                    <span class="avatar avatar-md avatar-rounded"><i class="ti ti-eye"></i></span>
                                </a>
                                <a href="assets/img/cars/FORD-ESCAPE.webp" data-fancybox="gallery" class="avatar avatar-xl me-3 gallery-item">
                                    <img src="assets/img/cars/FORD-ESCAPE.webp" class="rounded" alt="img">
                                    <span class="avatar avatar-md avatar-rounded"><i class="ti ti-eye"></i></span>
                                </a>
                                <a href="assets/img/cars/FORD-ESCAPE.webp" data-fancybox="gallery" class="avatar avatar-xl me-3 gallery-item">
                                    <img src="assets/img/cars/FORD-ESCAPE.webp" class="rounded" alt="img">
                                    <span class="avatar avatar-md avatar-rounded"><i class="ti ti-eye"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                  
                    <div class="text-center">
                        <a href="javascript:void(0);" class="btn btn-dark btn-sm">View Older Messages</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    // Select all toggle buttons
    document.querySelectorAll('.toggle-reply').forEach(function(btn) {
      btn.addEventListener('click', function() {
        // Toggle the d-none class on the reply box
        document.getElementById('replybackbox').classList.toggle('d-none');
      });
    });
  </script>

@endsection