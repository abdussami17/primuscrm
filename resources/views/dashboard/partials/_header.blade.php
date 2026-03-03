    <div class="content home-page pt-0">
        <div id="alert-box-container">

        </div>
        <div class="d-flex d-block align-items-center justify-content-end flex-wrap gap-3 mb-0">

            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">



            </div>
        </div>
        <!-- Start Breadcrumb -->
        <div class="ai-header-container  pb-0 mb-2">
            <div class="d-flex align-items-center justify-content-between flex-wrap" style="min-height: 100px;">

                <!-- Left Side: Date + Hello Courtney -->
                <div class="d-flex flex-column">
                    <div class="d-flex align-items-center text-muted small mb-1">
                        <div id="currentDate" class="me-3"></div>
                    </div>
                    <h1 class="fw-bold mb-0">Hello, {{ auth()->user()->name }}</h1>
                </div>

                <!-- Centered Logo -->
                <div class="position-absolute start-50 translate-middle-x text-center">
                    <img src="assets/light_logo.png" alt="Logo" class="logo-img mobile-logo-no"
                        style="max-width: 90px; opacity: 0.9;">
                </div>

                <!-- Right Side: User/Team Dropdown -->
                <div class="d-flex gap-2 align-items-center mt-3 mt-md-0">
                    <select id="selectDealership" class="form-select form-select-sm custom-user-dropdown">
                        <option>Select Dealership</option>

                        <option value="maple_auto_group">Maple Leaf Auto Group</option>
                        <option value="toronto_premium_motors">Toronto Premium Motors</option>
                        <option value="northshore_auto">Northshore Automotive</option>
                        <option value="vancouver_elite_cars">Vancouver Elite Cars</option>
                        <option value="prairie_drive">Prairie Drive Motors</option>
                        <option value="great_lakes_auto">Great Lakes Automotive</option>
                        <option value="canadian_choice_auto">Canadian Choice Auto</option>
                        <option value="aurora_motors">Aurora Motors</option>
                        <option value="polar_auto_group">Polar Auto Group</option>
                        <option value="rocky_mountain_motors">Rocky Mountain Motors</option>
                        <option value="niagara_auto_sales">Niagara Auto Sales</option>
                        <option value="true_north_motors">True North Motors</option>
                    </select>

                    <select id="userTeamDropdown" class="form-select form-select-sm custom-user-dropdown">
                        <option>Select All</option>
                        @foreach($users as $u)
                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                        @endforeach
                    </select>
                     <select  class="form-select form-select-sm custom-user-dropdown">
                        <option value="en" selected>English</option>
                        <option value="fr">French</option>
                        <option value="sp">Spanish</option>

                    </select>
                </div>



            </div>
        </div>


        <!-- End Breadcrumb -->
        <div class="alert-bar mb-4 d-flex flex-wrap align-items-center justify-content-start  rounded shadow-sm">
            <div class="chip chip-red" id="alert-missed-leads">Missed Leads: —</div>
            <div class="chip chip-yellow" id="alert-response-time">Avg Response Time: —</div>
            <div class="chip chip-green" id="alert-tasks-pct">Tasks Completed: —</div>
            <div class="chip chip-green" id="alert-sold-today">Sold Today: —</div>
        </div>

