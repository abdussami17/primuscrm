@extends('layouts.app')


@section('title', 'Calendar')


@section('content')

    <div class="content content-two pt-2">

        <!-- Start Breadcrumb -->
        <div class="mb-3 position-relative d-flex align-items-center justify-content-between flex-wrap gap-2"
            style="min-height: 80px;">

            <!-- Left: Title -->
            <div>
                <h4 class="mb-1 fw-bold">Calendar</h4>
            </div>

            <!-- Center: Logo -->
            <img src="assets/light_logo.png" alt="Logo" class="mobile-logo-no logo-img"
                style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); max-width: 80px; height: auto;">

            <!-- Right: Buttons -->
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap table-header">
                <div class="mb-2 me-2">
                    <select id="savedLists" class="form-select disabled" style="width: 200px;">
                        <option>Saved Lists</option>
                    </select>
                </div>
                <div class="mb-2 me-2">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#saveModal"
                        class="btn btn-lg py-1 h-auto btn-primary d-flex align-items-center">
                        <i class="ti ti-check me-2"></i>Save
                    </a>
                </div>
                <div class="mb-2 ">
                    <a href="#" data-bs-toggle="offcanvas" data-bs-target="#customcanvas"
                        class="btn btn-lg py-1 h-auto btn-light border-1 border d-flex align-items-center">
                        <i class="ti ti-filter me-2"></i>Filter
                    </a>
                </div>

            </div>
        </div>

        <!-- End Breadcrumb -->

        <!-- Start Card -->
        <div class="card mb-0">
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
        <!-- end card -->

    </div>



    <div class="offcanvas offcanvas-end" tabindex="-1" id="customcanvas">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Filters</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>

        <div class="offcanvas-body">

            <!-- Lead Status -->
            <div class="col-12 mb-2">
                <label class="form-label">Lead Status</label>
                <select id="leadStatus" multiple placeholder="Select Lead Status"></select>
            </div>

            <!-- Lead Type -->
            <div class="col-12 mb-2">
                <label class="form-label">Lead Type</label>
                <select id="leadType" multiple placeholder="Select Lead Type"></select>
            </div>

            <!-- Inventory Type -->
            <div class="col-12 mb-2">
                <label class="form-label">Inventory Type</label>
                <select id="inventoryType" multiple placeholder="Select Inventory Type"></select>
            </div>

            <!-- Sales Status -->
            <div class="col-12 mb-2">
                <label class="form-label">Sales Status</label>
                <select id="salesStatus" multiple placeholder="Select Sales Status"></select>
            </div>

            <!-- Status Type -->
            <div class="col-12 mb-2">
                <label class="form-label">Status Type</label>
                <select id="statusType" multiple placeholder="Select Status Type"></select>
            </div>

            <!-- Deal Type -->
            <div class="col-12 mb-2">
                <label class="form-label">Deal Type</label>
                <select id="dealType" multiple placeholder="Select Deal Type"></select>
            </div>


            <!-- Sales Type -->
            <div class="col-12 mb-2">
                <label class="form-label">Sales Type</label>
                <select id="salesType" multiple placeholder="Select Sales Type"></select>
            </div>



            <!-- Assigned To -->
            <div class="col-12 mb-2">
                <label class="form-label">Assigned To</label>
                <select id="assignedTo" multiple placeholder="Select Users"></select>
            </div>
            <div class="col-12 mb-2">
                <label class="form-label">Assigned By</label>
                <select id="assignedBy" multiple placeholder="Select Users"></select>
            </div>
            <div class="col-12 mb-2">
                <label class="form-label">Created By</label>
                <select id="createdBy" multiple placeholder="Select Users"></select>
            </div>

            <!-- Automated -->
            <div class="col-12 mb-4">
                <label class="form-label">Automated</label>
                <select id="automated" multiple placeholder="Select Source"></select>
            </div>



            <!-- Saved Pins
          <h6>Saved Pins</h6>
          <ul class="pin-list list-unstyled" id="pinList"></ul> -->
        </div>

        <div class="offcanvas-footer border-top p-3">
            <div class="row g-2">
                <div class="col-6">
                    <a href="#" class="btn btn-light border border-1 w-100" onclick="resetFilter()">Reset</a>
                </div>
                <div class="col-6">
                    <button class="btn btn-primary w-100" onclick="applyFilter()">Apply</button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="add_event">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Event</h4>
                    <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="https://kanakku.dreamstechnologies.com/html/template/calendar.html">
                    <div class="modal-body">
                        <!-- start row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Event Name</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Event Date</label>
                                    <div class="input-icon-end position-relative">
                                        <input type="text" class="form-control datetimepicker">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-calendar text-gray-7"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Start Time</label>
                                    <div class="input-icon-end position-relative">
                                        <input type="text" class="form-control timepicker">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-clock text-gray-7"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">End Time</label>
                                    <div class="input-icon-end position-relative">
                                        <input type="text" class="form-control timepicker">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-clock text-gray-7"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Event Location</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="mb-0">
                                    <label class="form-label">Descriptions</label>
                                    <textarea class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-md btn-primary">Add Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet" />


    <div class="modal fade" id="saveModal" tabindex="-1" aria-labelledby="saveModalLabel" aria-hidden="true">
        <div class=" modal-dialog modal-dialog-centered">
            <div class="modal-content" style="min-height: 500px !important;">
                <div class="modal-header">
                    <h5 class="modal-title" id="saveModalLabel">Save Calendar View</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="viewTitle" class="form-label">Title</label>
                    <input type="text" class="form-control" id="viewTitle" placeholder="My July View">

                    <label for="userSelect" class="form-label mt-3">Share With</label>
                    <select id="userSelect" multiple placeholder="Select users..." style="margin-bottom:100px"></select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button onclick="saveCalendarView()" class="btn btn-primary">Save View</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        // ===============================
        // Saved Views Logic
        // ===============================
        const savedLists = document.getElementById("savedLists");
        const savedViews = [];
        const users = ["Ali", "Sara", "Ahmed", "Zara", "Hamza", "Usman", "Areeba", "Fahad"];

        const userSelect = new TomSelect('#userSelect', {
            options: users.map(user => ({
                value: user,
                text: user
            })),
            plugins: ['remove_button'],
            maxItems: null,
            closeAfterSelect: false,
            persist: false,
            render: {
                option: function(data, escape) {
                    return `<div><input type="checkbox" checked disabled style="margin-right: 5px;">${escape(data.text)}</div>`;
                }
            }
        });

        function saveCalendarView() {
            const title = document.getElementById("viewTitle").value.trim();
            const selectedUsers = userSelect.getValue();

            if (!title) return alert("Please enter a title.");
            if (selectedUsers.length === 0) return alert("Please select at least one user.");

            const filters = {
                type: "Used",
                dateRange: "July 1 - July 31"
            };
            savedViews.push({
                title,
                sharedWith: selectedUsers,
                filters
            });
            updateSavedLists();

            bootstrap.Modal.getInstance(document.getElementById('saveModal')).hide();
            document.getElementById("viewTitle").value = '';
            userSelect.clear();
        }

        function updateSavedLists() {
            savedLists.innerHTML = '';
            if (savedViews.length === 0) {
                savedLists.classList.add("disabled");
                savedLists.innerHTML = `<option>Saved Lists</option>`;
            } else {
                savedLists.classList.remove("disabled");
                savedViews.forEach(view => {
                    const option = document.createElement("option");
                    option.textContent = view.title;
                    savedLists.appendChild(option);
                });
            }
        }

        // ===============================
        // Calendar & Events
        // ===============================
        const eventTypes = ['new', 'used', 'service', 'none'];
        const dayList = [];
        const startDate = new Date('2025-07-01');
        const endDate = new Date('2025-07-31');

        for (let d = new Date(startDate); d <= endDate; d.setDate(d.getDate() + 1)) {
            dayList.push(new Date(d));
        }

        function generateEvents() {
            const titles = ['Call', 'Email', 'Meeting', 'Service', 'Follow-up', 'SMS', 'Demo', 'Visit', 'BDC', 'Review'];
            const client = ['James Unknown', 'Daniel Figueria', 'Ryan French', 'Joan Snell'];
            const salesTypes = ['Sales Inquiry', 'Service Inquiry', 'Parts Inquiry'];
            const leadTypes = ['Internet', 'Phone', 'Walk-In'];
            const all = [];

            dayList.forEach(day => {
                const dayStr = day.toISOString().split('T')[0];
                const count = 15 + Math.floor(Math.random() * 3);

                for (let i = 0; i < count; i++) {
                    const type = eventTypes[Math.floor(Math.random() * eventTypes.length)];
                    const time = 8 + Math.floor(Math.random() * 9);
                    const clientName = client[Math.floor(Math.random() * client.length)];
                    const title =
                        `${time}:00 AM - ${titles[Math.floor(Math.random() * titles.length)]} – ${clientName}`;

                    // Generate AI Data
                    const showProbability = 65 + Math.floor(Math.random() * 35); // 65-99%
                    const leadType = leadTypes[Math.floor(Math.random() * leadTypes.length)];
                    const responseTime = Math.random() > 0.5 ? '<24hr' : '>24hr';
                    const sentiment = ['Very Interested', 'Interested', 'Neutral', 'Hesitant'][Math.floor(Math
                        .random() * 4)];

                    // pick a random status type for demo purposes
                    const statusType = filters.statusType[Math.floor(Math.random() * filters.statusType.length)];

                    all.push({
                        title,
                        start: dayStr,
                        allDay: true,
                        classNames: [type],
                        extendedProps: {
                            type,
                            fullName: clientName,
                            assignedTo: ["John Doe", "Jane Smith", "Michael Johnson"][Math.floor(Math
                                .random() * 3)],
                            statusType,
                            assignedBy: ["Jane Smith", "Michael Johnson", "Emily Davis"][Math.floor(Math
                                .random() * 3)],
                            createdBy: ["John Doe", "Emily Davis"][Math.floor(Math.random() * 2)],
                            apptDate: dayStr,
                            apptTime: `${time}:00 AM`,
                            salesType: salesTypes[Math.floor(Math.random() * 3)],
                            source: ['Phone', 'Website', 'Walk-In', 'Email'][Math.floor(Math.random() * 4)],
                            description: 'Interested in black Civic EX, trade-in pending appraisal',
                            notes: 'Asked about financing options. Follow up with finance manager.',
                            year: [2020, 2021, 2022, 2023, 2024, 2025][Math.floor(Math.random() * 6)],
                            make: ['Toyota', 'Honda', 'Ford', 'BMW'][Math.floor(Math.random() * 4)],
                            model: ['Civic', 'Accord', 'F-150', 'X5'][Math.floor(Math.random() * 4)],
                            location: ['Main Branch', 'Downtown', 'North Park', 'East Side'][Math.floor(Math
                                .random() * 4)],
                            completed: false,
                            // AI Data
                            showProbability,
                            leadType,
                            responseTime,
                            sentiment,
                            confirmationStatus: Math.random() > 0.5 ? 'Confirmed' : 'Unconfirmed',
                            communicationHistory: 'Customer replied to SMS within 2 hours, opened confirmation email',
                            suggestedRescheduleTime: 'Tomorrow 10 AM',
                            rescheduleReasons: Math.random() > 0.5 ? 'Double-booked risk detected' :
                                'Low engagement detected'
                        }
                    });
                }
            });
            return all;
        }

        let calendar;
        let currentView = 'dayGridWeek';
        let currentEditingEvent = null;

        // ===============================
        // Filters (TomSelect)
        // ===============================
        const tsInstances = {};
        const filters = {
            leadStatus: ["Active", "Duplicate", "Invalid", "Lost", "Sold", "Wishlist", "Buy-In"],
            leadType: ["Internet", "Walk-In", "Phone Up", "Text Up", "Website Chat", "Service", "Import", "Wholesale"],
            inventoryType: ["New", "Pre-Owned", "CPO", "Demo", "Wholesale", "Lease Renewal", "Unknown"],
            salesStatus: ["Uncontacted", "Attempted", "Contacted", "Dealer Visit", "Demo", "Write-Up", "Pending F&I",
                "Sold", "Delivered", "Lost"
            ],
            statusType: ["Open", "Confirmed", "Completed", "Missed", "Canceled", "Walk-In", "No Response", "No Show",
                "Left VM"
            ],
            dealType: ["Finance", "Lease", "Cash"],
            salesType: ["Sales", "Service", "Parts"],
            assignedTo: [
                "John Doe", "Jane Smith", "Michael Johnson", "Emily Davis",
                "Christopher Brown", "Amanda Wilson", "David Miller", "Sarah Thompson",
                "Brian Anderson", "Jessica Martinez", "Mark Taylor", "Lauren White"
            ],
            assignedBy: [
                "John Doe", "Jane Smith", "Michael Johnson", "Emily Davis",
                "Christopher Brown", "Amanda Wilson", "David Miller", "Sarah Thompson",
                "Brian Anderson", "Jessica Martinez", "Mark Taylor", "Lauren White"
            ],
            createdBy: [
                "John Doe", "Jane Smith", "Michael Johnson", "Emily Davis",
                "Christopher Brown", "Amanda Wilson", "David Miller", "Sarah Thompson",
                "Brian Anderson", "Jessica Martinez", "Mark Taylor", "Lauren White"
            ],
            automated: ["Manual", "Automated"]
        };

        document.addEventListener('DOMContentLoaded', function() {
            // Init calendar
            const calendarEl = document.getElementById('calendar');
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridWeek',
                initialDate: '2025-07-07',
                headerToolbar: {
                    left: '',
                    center: '',
                    right: 'dayGridMonth,dayGridWeek,dayGridDay'
                },
                buttonText: {
                    dayGridMonth: 'Month',
                    dayGridWeek: 'Week',
                    dayGridDay: 'Day'
                },
                datesSet: function(info) {
                    currentView = info.view.type;
                    updateDateDisplay();
                },
                events: allEvents,
                eventDisplay: 'block',
                dayMaxEventRows: 20,
                height: 'auto',
                eventClick: function(info) {
                    showEventModal(info.event);
                },
                // Apply color styles based on statusType
                eventDidMount: function(info) {
                    try {
                        const status = info.event.extendedProps?.statusType;
                        const statusColorMap = {
                            'Open': '#0d6efd',
                            'Confirmed': '#198754',
                            'Completed': '#6c757d',
                            'Missed': '#dc3545',
                            'Canceled': '#6c757d',
                            'Walk-In': '#6f42c1',
                            'No Response': '#fd7e14',
                            'No Show': '#b02a37',
                            'Left VM': '#ffc107'
                        };

                        const color = statusColorMap[status];
                        if (color) {
                            // event element may contain inner wrappers; set background on root
                            info.el.style.backgroundColor = color;
                            info.el.style.borderColor = color;
                            info.el.style.color = '#ffffff';
                        }
                    } catch (e) {
                        console.error('eventDidMount error', e);
                    }
                }
            });
            calendar.render();

            // Fetch and load real tasks into calendar
            fetchAndLoadTasks();

            // ===============================
            // Create Custom Navigation Header
            // ===============================
            const existingNav = document.querySelector('.custom-nav-container');
            if (!existingNav) {
                const toolbar = document.querySelector('.fc-toolbar');
                const calendarWrapper = toolbar.parentNode;

                const navContainer = document.createElement('div');
                navContainer.className = 'custom-nav-container';
                navContainer.style.cssText =
                    'display: flex; align-items: center; justify-content: center; padding: 0px; padding-bottom: 10px; background: #ffffff; border-bottom: 1px solid #e9ecef; margin-bottom: 10px;';

                const prevBtn = document.createElement('button');
                prevBtn.textContent = '←';
                prevBtn.className = 'nav-btn-custom';
                prevBtn.style.cssText =
                    'background: none; border: 1px solid #dee2e6; padding: 8px 14px; border-radius: 4px; cursor: pointer; font-size: 18px; color: #495057; transition: all 0.2s; margin-right: 15px;';
                prevBtn.onmouseover = () => {
                    prevBtn.style.backgroundColor = '#e9ecef';
                    prevBtn.style.color = '#212529';
                };
                prevBtn.onmouseout = () => {
                    prevBtn.style.backgroundColor = 'transparent';
                    prevBtn.style.color = '#495057';
                };
                prevBtn.onclick = () => calendar.prev();

                const dateDisplay = document.createElement('div');
                dateDisplay.id = 'dateDisplay';
                dateDisplay.style.cssText =
                    'font-size: 18px; font-weight: 600; min-width: 240px; text-align: center; color: #212529;';
                updateDateDisplay();

                const nextBtn = document.createElement('button');
                nextBtn.textContent = '→';
                nextBtn.className = 'nav-btn-custom';
                nextBtn.style.cssText =
                    'background: none; border: 1px solid #dee2e6; padding: 8px 14px; border-radius: 4px; cursor: pointer; font-size: 18px; color: #495057; transition: all 0.2s; margin-left: 15px;';
                nextBtn.onmouseover = () => {
                    nextBtn.style.backgroundColor = '#e9ecef';
                    nextBtn.style.color = '#212529';
                };
                nextBtn.onmouseout = () => {
                    nextBtn.style.backgroundColor = 'transparent';
                    nextBtn.style.color = '#495057';
                };
                nextBtn.onclick = () => calendar.next();

                navContainer.appendChild(prevBtn);
                navContainer.appendChild(dateDisplay);
                navContainer.appendChild(nextBtn);

                calendarWrapper.insertBefore(navContainer, toolbar);
            }

            function updateDateDisplay() {
                const start = calendar.getDate();
                const view = calendar.view;

                let displayText = '';
                if (currentView === 'dayGridDay') {
                    displayText = start.toLocaleDateString('en-US', {
                        month: 'short',
                        day: 'numeric',
                        year: 'numeric'
                    });
                } else if (currentView === 'dayGridWeek') {
                    const end = new Date(view.currentEnd);
                    end.setDate(end.getDate() - 1);
                    const startMonth = start.toLocaleDateString('en-US', {
                        month: 'short'
                    });
                    const endMonth = end.toLocaleDateString('en-US', {
                        month: 'short'
                    });
                    const startDay = start.getDate();
                    const endDay = end.getDate();
                    const year = start.getFullYear();

                    if (startMonth === endMonth) {
                        displayText = `${startMonth} ${startDay} – ${endDay}, ${year}`;
                    } else {
                        displayText = `${startMonth} ${startDay} – ${endMonth} ${endDay}, ${year}`;
                    }
                } else if (currentView === 'dayGridMonth') {
                    displayText = start.toLocaleDateString('en-US', {
                        month: 'long',
                        year: 'numeric'
                    });
                }

                const dateEl = document.getElementById('dateDisplay');
                if (dateEl) {
                    dateEl.textContent = displayText;
                }
            }

            calendar.on('datesSet', updateDateDisplay);

            // Fetch tasks from backend and add to calendar
            function fetchAndLoadTasks() {
                fetch("{{ route('tasks.all') }}")
                    .then(res => res.json())
                    .then(json => {
                        const tasks = (json && json.data) ? json.data : (json.tasks || []);
                        if (!Array.isArray(tasks)) return;

                        // remove existing events
                        calendar.removeAllEvents();

                        tasks.forEach(task => {
                            try {
                                const start = task.due_date || task.created_at || new Date().toISOString();
                                const titleParts = [];
                                if (task.task_type) titleParts.push(task.task_type.replace(/_/g, ' '));
                                if (task.customer) titleParts.push((task.customer.first_name || task.customer.name) || 'Customer');
                                const title = titleParts.join(' — ') || (task.description || 'Task');

                                // Add event with id so we can reference it later
                                calendar.addEvent({
                                    id: String(task.id),
                                    title: title,
                                    start: start,
                                    allDay: true,
                                    extendedProps: {
                                        taskId: task.id,
                                        statusType: task.status_type || task.status || 'Open',
                                        assignedTo: task.assigned_user?.name || null,
                                        description: task.description || '',
                                        customer: task.customer?.first_name ? `${task.customer.first_name} ${task.customer.last_name || ''}`.trim() : (task.customer?.name || '')
                                    }
                                });
                            } catch (e) {
                                console.error('Error adding task to calendar', e, task);
                            }
                        });
                    })
                    .catch(err => console.error('Failed to load tasks for calendar', err));
            }

            // ===============================
            // Init Filters
            // ===============================
            Object.keys(filters).forEach(id => {
                tsInstances[id] = new TomSelect(`#${id}`, {
                    options: filters[id].map(v => ({
                        value: v,
                        text: v
                    })),
                    items: id === "salesType" ? ["Sales"] : [],
                    plugins: id !== "automated" ? ['remove_button'] : [],
                    persist: false,
                    create: false,
                    maxItems: id === "automated" ? 1 : null
                });
            });

            // Check for Smart Timing alerts (randomly show on page load)
            if (Math.random() > 0.7) {
                showSmartTimingAlert();
            }
        });

        // ===============================
        // Event Modal Functions with AI Icons
        // ===============================
        function showEventModal(event) {
            // If this event represents a task (has taskId), fetch full task details first
            const taskId = event.id || event.extendedProps?.taskId;
            currentEditingEvent = event;

            if (taskId) {
                fetch(`/tasks/edit/${taskId}`)
                    .then(r => r.json())
                    .then(res => {
                        const task = res.data || res.task || {};
                        renderEventModalFromTask(taskId, task);
                    })
                    .catch(err => {
                        console.error('Failed to fetch task details', err);
                        // fallback to using extendedProps
                        renderEventModalFromProps(event.extendedProps);
                    });
                return;
            }

            // fallback when no taskId
            renderEventModalFromProps(event.extendedProps);
        }

        function renderEventModalFromProps(props) {
            const modalHTML = `
      <div class="modal fade" id="eventModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <!-- Modal Header -->
  <div class="modal-header d-flex justify-content-between align-items-center" 
       style="background-color: rgb(0, 33, 64); color: #fff; border-bottom: none;">
  
    <h5 class="modal-title mb-0 text-white">Appointment Details</h5>
  
    <div class="d-flex align-items-center" style="gap: 10px;">
      <!-- AI Action Buttons -->
      <button type="button" class="ai-icon-btn" title="Show Probability" onclick="showShowProbability()">
        <i class="ti ti-chart-pie"></i>
      </button>
      <button type="button" class="ai-icon-btn" title="Smart Timing" onclick="showSmartTiming()">
        <i class="ti ti-clock-hour-4"></i>
      </button>
      <button type="button" class="ai-icon-btn" title="AI Assistant" onclick="showAIAssistant()">
        <i class="ti ti-brain"></i>
      </button>
      <button type="button" class="ai-icon-btn" title="AI Insights" onclick="showAIInsights()">
        <i class="ti ti-graph"></i>
      </button>
    
  
      <!-- Close Button -->
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
  </div>
  
            <div class="modal-body">
              <form id="eventForm">
                <div class="mb-3">
                  <label class="form-label"><strong>Full Name</strong></label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="fullName" value="${props.fullName}" readonly>
                    <button type="button" class="btn btn-outline-secondary" onclick="openCustomerProfile('${props.fullName}')">Open Profile</button>
                  </div>
                </div>
  
                <div class="mb-3">
                  <label class="form-label"><strong>Assigned To</strong></label>
                  <select class="form-control" id="assignedTo">
                    ${filters.assignedTo.map(name => `<option value="${name}" ${props.assignedTo === name ? 'selected' : ''}>${name}</option>`).join('')}
                  </select>
                </div>
  
                <div class="mb-3">
                  <label class="form-label"><strong>Assigned By</strong></label>
                  <input type="text" class="form-control" value="${props.assignedBy}" readonly>
                </div>
  
                <div class="mb-3">
                  <label class="form-label"><strong>Created By</strong></label>
                  <input type="text" class="form-control" value="${props.createdBy}" readonly>
                </div>
  
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>Date</strong></label>
                    <input type="date" class="form-control" id="apptDate" value="${props.apptDate}">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label"><strong>Time</strong></label>
                    <input type="time" class="form-control" id="apptTime" value="${props.apptTime.replace(' AM', '').replace(' PM', '')}">
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label"><strong>Description</strong></label>
                  <textarea class="form-control" id="description" rows="2">${props.description}</textarea>
                </div>
  
  <div class="row" >
     <div class="mb-3 col-md-4">
                  <label class="form-label"><strong>Sales Type</strong></label>
                  <select class="form-select" id="salesType">
                   <option selected>Sales</option>
                   <option >Service</option>
                   <option >Parts</option>
  
                  </select>
                </div>
  
                <div class="mb-3 col-md-4">
                  <label class="form-label"><strong>Source</strong></label>
                  <select class="form-select">
                  <option>Walk-In</option>
                                              <option selected>Phone Up</option>
                                              <option>Text</option>
                                              <option>Repeat Customer</option>
                                              <option>Referral</option>
                                              <option>Service to Sales</option>
                                              <option>Lease Renewal</option>
                                              <option>Drive By</option>
                                              <option>Dealer Website</option>
                                            </select>
                </div>
  
                <div class="mb-3 col-md-4">
                  <label class="form-label"><strong>Year / Make / Model</strong></label>
                 <input type="text" readonly value="2024 Ford Escape" class="form-control">
                </div>
    </div>
  
               
  
    <div class="row" >
     <div class="mb-3 col-md-6">
                  <label class="form-label"><strong>Task Type</strong></label>
                  <select class="form-select" id="communicationType" name="communication_type">
      
      <option value="Inbound Call">Inbound Call</option>
      <option selected value="Outbound Call">Outbound Call</option>
      <option value="Inbound Text">Inbound Text</option>
      <option value="Outbound Text">Outbound Text</option>
      <option value="Inbound Email">Inbound Email</option>
      <option value="Outbound Email">Outbound Email</option>
      <option value="CSI">CSI</option>
      <option value="Other">Other</option>
      <option value="Appointment">Appointment</option>
    </select>
                </div>
  
                <div class="mb-3 col-md-6">
                  <label class="form-label"><strong>Status Type</strong></label>
                  <select class="form-select" id="statusType" name="status_type">
  
      <option value="Open"  selected>Open</option>
      <option value="Completed">Completed</option>
      <option value="Missed">Missed</option>
      <option value="Cancelled">Cancelled</option>
      <option value="No Response">No Response</option>
      <option value="No Show">No Show</option>
    </select>
                </div>
  
                
    </div>
  
  
  
                
  
               
                
              </form>
            </div>
  
            <div class="modal-footer d-flex justify-content-end">
              
              <div>
                <button type="button" class="btn btn-light border border-1 btn-sm" data-bs-dismiss="modal">Close</button>
                <button id="saveEventBtn" type="button" class="btn btn-primary btn-sm">Save Changes</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    `;

                        let modalDiv = document.getElementById('eventModal');
                        if (!modalDiv) {
                                modalDiv = document.createElement('div');
                                document.body.appendChild(modalDiv);
                        }
                        modalDiv.outerHTML = modalHTML;

                        const modal = new bootstrap.Modal(document.getElementById('eventModal'));
                        modal.show();
                        // Attach direct handlers to ensure Save button triggers JS and prevents form submit
                        try {
                            const saveBtn = document.getElementById('saveEventBtn');
                            const frm = document.getElementById('eventForm');
                            if (frm) {
                                frm.addEventListener('submit', function (ev) {
                                    ev.preventDefault();
                                    ev.stopPropagation();
                                    console.log('Blocked submit of #eventForm (direct)');
                                }, true);
                            }
                            if (saveBtn) {
                                saveBtn.addEventListener('click', function (ev) {
                                    ev.preventDefault();
                                    ev.stopPropagation();
                                    try { saveEventChanges(); } catch (err) { console.error('saveEventChanges error (direct)', err); }
                                });
                            }
                        } catch (e) { console.error('Failed to attach direct modal handlers', e); }
                        // Attach direct handlers to ensure Save button triggers JS and prevents form submit
                        try {
                            const saveBtn = document.getElementById('saveEventBtn');
                            const frm = document.getElementById('eventForm');
                            if (frm) {
                                frm.addEventListener('submit', function (ev) {
                                    ev.preventDefault();
                                    ev.stopPropagation();
                                    console.log('Blocked submit of #eventForm (direct)');
                                }, true);
                            }
                            if (saveBtn) {
                                saveBtn.addEventListener('click', function (ev) {
                                    ev.preventDefault();
                                    ev.stopPropagation();
                                    try { saveEventChanges(); } catch (err) { console.error('saveEventChanges error (direct)', err); }
                                });
                            }
                        } catch (e) { console.error('Failed to attach direct modal handlers', e); }
                }

                function renderEventModalFromTask(taskId, task) {
                        const props = task;
                        const modalHTML = `
            <div class="modal fade" id="eventModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <!-- Modal Header -->
    <div class="modal-header d-flex justify-content-between align-items-center" 
             style="background-color: rgb(0, 33, 64); color: #fff; border-bottom: none;">
        <h5 class="modal-title mb-0 text-white">Appointment Details</h5>
        <div class="d-flex align-items-center" style="gap: 10px;">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
    </div>
                        <div class="modal-body">
                            <form id="eventForm">
                                <input type="hidden" id="eventTaskId" value="${taskId}">
                                <div class="mb-3">
                                    <label class="form-label"><strong>Full Name</strong></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="fullName" value="${(props.customer?.first_name || props.customer?.name || '')}" >
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><strong>Assigned To</strong></label>
                                    <select class="form-control" id="assignedTo">
                                        ${filters.assignedTo.map(name => `<option value="${name}" ${props.assigned_user?.name === name ? 'selected' : ''}>${name}</option>`).join('')}
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><strong>Assigned By</strong></label>
                                    <input type="text" class="form-control" value="${props.assigned_by?.name || ''}" readonly>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><strong>Created By</strong></label>
                                    <input type="text" class="form-control" value="${props.created_by?.name || ''}" readonly>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><strong>Date</strong></label>
                                        <input type="date" class="form-control" id="apptDate" value="${props.due_date ? props.due_date.split('T')[0] : (props.apptDate || '')}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><strong>Time</strong></label>
                                        <input type="time" class="form-control" id="apptTime" value="${props.apptTime || ''}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><strong>Description</strong></label>
                                    <textarea class="form-control" id="description" rows="2">${props.description || ''}</textarea>
                                </div>

        <div class="row" >
         <div class="mb-3 col-md-4">
                                    <label class="form-label"><strong>Sales Type</strong></label>
                                    <select class="form-select" id="salesType">
                                     <option ${props.salesType === 'Sales' ? 'selected' : ''}>Sales Inquiry</option>
                                     <option ${props.salesType === 'Service' ? 'selected' : ''}>Service Inquiry</option>
                                     <option ${props.salesType === 'Parts' ? 'selected' : ''}>Parts Inquiry</option>
                                    </select>
                                </div>

                                <div class="mb-3 col-md-4">
                                    <label class="form-label"><strong>Source</strong></label>
                                    <select class="form-select">
                                    <option>Walk-In</option>
                                    <option>Phone Up</option>
                                    <option>Text</option>
                                    </select>
                                </div>

                                <div class="mb-3 col-md-4">
                                    <label class="form-label"><strong>Year / Make / Model</strong></label>
                                 <input type="text" readonly value="${props.year || ''} ${props.make || ''} ${props.model || ''}" class="form-control">
                                </div>
        </div>
                            </form>
                        </div>

                        <div class="modal-footer d-flex justify-content-end">
                            <div>
                                <button type="button" class="btn btn-light border border-1 btn-sm" data-bs-dismiss="modal">Close</button>
                                <button id="saveEventBtn" type="button" class="btn btn-primary btn-sm">Save Changes</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    `;

            let modalDiv = document.getElementById('eventModal');
            if (!modalDiv) {
                modalDiv = document.createElement('div');
                document.body.appendChild(modalDiv);
            }
            modalDiv.outerHTML = modalHTML;

            const modal = new bootstrap.Modal(document.getElementById('eventModal'));
            modal.show();
        }

        // ===============================
        // AI Feature Functions
        // ===============================
        function showShowProbability() {
            const props = currentEditingEvent.extendedProps;
            const message = `
      <strong>Primus AI - Show Probability</strong><br><br>
      <strong>High Show Probability (${props.showProbability}%)</strong><br><br>
      <strong>Analysis:</strong><br>
      • Lead Type: ${props.leadType}<br>
      • Response Time: ${props.responseTime}<br>
      • Confirmation: ${props.confirmationStatus}<br><br>
      <strong>Insight:</strong><br>
      ${props.leadType} leads with ${props.responseTime} turnaround have ${props.showProbability > 80 ? '1.8x' : '1.2x'} higher attendance rates.
    `;
            showAIModal('Show Probability', message);
        }

        function showSmartTiming() {
            const props = currentEditingEvent.extendedProps;
            const message = `
      <strong>Primus AI - Smart Timing</strong><br><br>
      <strong>Rescheduling Recommendation:</strong><br><br>
      • Reason: ${props.rescheduleReasons}<br>
      • Current Status: ${props.confirmationStatus}<br>
      • Communication History: ${props.communicationHistory}<br><br>
      <strong>Recommended Action:</strong><br>
      Reschedule to <strong>${props.suggestedRescheduleTime}</strong><br>
      (AI predicts 34% higher show probability at this time)
    `;
            showAIModal('Smart Timing', message);
        }

        function showAIAssistant() {
            const props = currentEditingEvent.extendedProps;
            const message = `
      <strong>Primus AI - Assistant</strong><br><br>
      <strong>Customer Summary:</strong><br>
      ${props.description}<br><br>
      <strong>Sentiment Analysis:</strong> ${props.sentiment}<br><br>
      <strong>Suggested Actions:</strong><br>
      • Bring finance manager in<br>
      • Prepare trade appraisal sheet<br>
      • Have financing options ready<br>
      • Confirm vehicle preference
    `;
            showAIModal('AI Assistant', message);
        }

        function showAIInsights() {
            const message = `
      <strong>Primus AI - Store Insights</strong><br><br>
      <strong>Key Trends:</strong><br>
      • Appointments scheduled within 2 hours of lead have <strong>34% higher close rate</strong><br>
      • Tuesday 5–7 PM has <strong>22% no-show rate</strong> — consider adjusting BDC scheduling<br>
      • Internet leads convert 40% faster than walk-ins<br>
      • Same-day confirmations reduce no-shows by 28%<br><br>
      <strong>Recommendation:</strong><br>
      Schedule more appointments within 2-hour window for better outcomes.
    `;
            showAIModal('AI Insights', message);
        }

        function showAdaptiveFollowUp() {
            const message = `
      <strong>Primus AI - Adaptive Follow-Up</strong><br><br>
      <strong>Recommended Follow-Up Plan:</strong><br><br>
      <strong>If Outcome: No Show</strong><br>
      → Resend friendly reschedule text next morning<br>
      → Template: "We missed you! Let's reschedule..."<br><br>
      <strong>If Outcome: Show but No Sale</strong><br>
      → Schedule next contact in <strong>2 days</strong><br>
      → Use test-drive follow-up template<br><br>
      <strong>If Outcome: Completed Sale</strong><br>
      → Send delivery date confirmation<br>
      → Schedule follow-up in 30 days for satisfaction check
    `;
            showAIModal('Adaptive Follow-Up', message);
        }

        function showAIModal(title, message) {
            const aiModalHTML = `
      <div class="modal fade" id="aiModal" tabindex="-1">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">${title}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              ${message}
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    `;

            let aiModalDiv = document.getElementById('aiModal');
            if (aiModalDiv) aiModalDiv.remove();

            aiModalDiv = document.createElement('div');
            aiModalDiv.innerHTML = aiModalHTML;
            document.body.appendChild(aiModalDiv);

            const aiModal = new bootstrap.Modal(document.getElementById('aiModal'));
            aiModal.show();
        }

        function showSmartTimingAlert() {
            const alertHTML = `
      <div class="modal fade" id="smartTimingAlert" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content" style="border: 2px solid #EC4899; border-radius: 8px;">
            <div class="modal-header" style="background-color: #FEC7E0; border-bottom: 2px solid #EC4899;">
              <h5 class="modal-title">⏰ Smart Timing Alert</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <p><strong>Customer hasn't opened confirmation email or replied to SMS.</strong></p>
              <p>We recommend rescheduling to <strong>tomorrow at 10 AM</strong>.</p>
              <p style="color: #10B981;"><strong>AI Prediction:</strong> 34% higher show probability at this time</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Dismiss</button>
              <button type="button" class="btn btn-primary" onclick="handleReschedule()">Open Customer Profile</button>
            </div>
          </div>
        </div>
      </div>
    `;

            let alertDiv = document.getElementById('smartTimingAlert');
            if (alertDiv) alertDiv.remove();

            alertDiv = document.createElement('div');
            alertDiv.innerHTML = alertHTML;
            document.body.appendChild(alertDiv);

            const alert = new bootstrap.Modal(document.getElementById('smartTimingAlert'));
            alert.show();
        }

        function handleReschedule() {
            alert('Opening customer profile to adjust appointment timing...');
            openCustomerProfile('Selected Customer');
        }

        function openCustomerProfile(fullName) {
            console.log('Opening customer profile for:', fullName);
            const namePlaceholder = document.querySelector('#editVisitCanvas .customer-name');
            if (namePlaceholder) {
                namePlaceholder.textContent = fullName;
            }

            const offcanvasElement = document.getElementById('editVisitCanvas');
            if (offcanvasElement) {
                const offcanvas = new bootstrap.Offcanvas(offcanvasElement);
                offcanvas.show();
            } else {
                console.error('Offcanvas with ID "editVisitCanvas" not found.');
            }
        }

        function logAction(actionType, fullName) {
            const actions = {
                call: 'Call',
                text: 'Text',
                email: 'Email'
            };
            console.log(`${actions[actionType]} logged for ${fullName}`);
            alert(`${actions[actionType]} action logged for ${fullName}\nThis would be added to their Activity Timeline`);
        }

        function markCompleted() {
            if (currentEditingEvent) {
                currentEditingEvent.extendedProps.completed = true;
                console.log('Event marked as completed:', currentEditingEvent.title);
                alert('Appointment marked as completed!');
                bootstrap.Modal.getInstance(document.getElementById('eventModal')).hide();
            }
        }

        // Delegated click handler for dynamic Save Changes button to prevent accidental form submit/navigation
        document.addEventListener('click', function(e) {
            const btn = e.target.closest && e.target.closest('#saveEventBtn');
            if (!btn) return;
            e.preventDefault();
            e.stopPropagation();
            try { saveEventChanges(); } catch (err) { console.error('saveEventChanges error', err); }
        }, false);

        // Prevent actual form submission from the dynamic event form
        document.addEventListener('submit', function(e){
            if (e.target && e.target.id === 'eventForm') {
                e.preventDefault();
                e.stopPropagation();
                console.log('Blocked submit of #eventForm');
            }
        }, true);

        // Intercept server-rendered task modal forms (e.g. #taskModal{ID}) so they don't trigger a full page reload.
        // This handles the pre-rendered modals in the template whose forms POST to /tasks/update/{id}.
        document.addEventListener('submit', function(e){
            const form = e.target;
            if (!form || typeof form.getAttribute !== 'function') return;
            const action = form.getAttribute('action') || '';
            if (!action.includes('/tasks/update')) return;

            e.preventDefault();
            e.stopPropagation();
            console.log('Intercepted task update form submit for', action);

            try {
                const fd = new FormData(form);
                const payload = {};
                fd.forEach((value, key) => {
                    if (payload[key] === undefined) payload[key] = value;
                    else if (Array.isArray(payload[key])) payload[key].push(value);
                    else payload[key] = [payload[key], value];
                });

                // Combine date/time parts into due_date if present
                try {
                    if (payload.due_date_date || payload.due_date_time) {
                        const datePart = payload.due_date_date || '';
                        const timePart = payload.due_date_time || '';
                        let combined = datePart;
                        if (timePart) combined += ' ' + (timePart.length === 5 ? (timePart + ':00') : timePart);
                        else combined += ' 00:00:00';
                        payload.due_date = combined;
                    }
                } catch (e) { console.warn('Could not combine due_date parts', e); }

                fetch(action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(Object.assign({_method: 'PUT'}, payload))
                })
                .then(r => r.json())
                .then(data => {
                    if (!data || String(data.status).toLowerCase() !== 'success') {
                        console.error('Task update failed', data);
                        alert((data && data.message) ? data.message : 'Failed to update task');
                        return;
                    }

                    // Close the modal
                    const modalEl = form.closest('.modal');
                    if (modalEl) {
                        try { bootstrap.Modal.getInstance(modalEl).hide(); } catch (err) { modalEl.classList.remove('show'); }
                    }

                    // Update calendar event if present
                    const m = action.match(/\/tasks\/update\/(\d+)/);
                    const taskId = m ? m[1] : null;
                    if (taskId && typeof calendar !== 'undefined') {
                        try {
                            const ev = calendar.getEventById(String(taskId));
                            if (ev) {
                                const newTitle = payload.description || ev.title;
                                ev.setProp('title', newTitle);
                                if (payload.due_date_date) ev.setStart(payload.due_date_date);
                                ev.setExtendedProp('description', payload.description || ev.extendedProps.description);
                            }
                        } catch (e) { console.error('Failed updating calendar event after task update', e); }
                    }

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({ icon: 'success', title: 'Saved', text: data.message || 'Task updated', timer: 1800, showConfirmButton: false });
                    }
                })
                .catch(err => {
                    console.error('Save error', err);
                    alert('An error occurred while saving.');
                });
            } catch (err) {
                console.error('Failed to submit task update via AJAX', err);
            }
        }, true);

        function saveEventChanges() {
            console.log('saveEventChanges called');
            // Gather values
            const taskId = document.getElementById('eventTaskId') ? document.getElementById('eventTaskId').value : null;
            const payload = {
                description: document.getElementById('description') ? document.getElementById('description').value : '',
                assigned_to: document.getElementById('assignedTo') ? document.getElementById('assignedTo').value : '',
                due_date: document.getElementById('apptDate') ? document.getElementById('apptDate').value : '',
                appt_time: document.getElementById('apptTime') ? document.getElementById('apptTime').value : '',
                salesType: document.getElementById('salesType') ? document.getElementById('salesType').value : ''
            };

            if (!taskId) {
                alert('Task id missing. Cannot save.');
                return;
            }

            // Send update request to server. Use same pattern as tasks form: POST to /tasks/update/{id}
            fetch(`/tasks/update/${taskId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(Object.assign({_method: 'PUT'}, payload))
            })
            .then(r => r.json())
            .then(data => {
                if (!data || String(data.status).toLowerCase() !== 'success') {
                    console.error('Update failed', data);
                    alert((data && data.message) ? data.message : 'Failed to update task');
                    return;
                }

                // Update calendar event visually
                try {
                    const ev = calendar.getEventById(String(taskId));
                    if (ev) {
                        const titleParts = [];
                        if (payload.salesType) titleParts.push(payload.salesType);
                        if (document.getElementById('fullName')) titleParts.push(document.getElementById('fullName').value);
                        const newTitle = titleParts.join(' — ') || payload.description || ev.title;
                        ev.setProp('title', newTitle);
                        if (payload.due_date) ev.setStart(payload.due_date);
                        ev.setExtendedProp('description', payload.description);
                        ev.setExtendedProp('statusType', data.data?.status_type || ev.extendedProps.statusType);
                    }
                } catch (e) { console.error('Failed to update calendar event', e); }

                if (typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'success', title: 'Saved', text: data.message || 'Task updated', timer: 2000, showConfirmButton: false });
                }

                bootstrap.Modal.getInstance(document.getElementById('eventModal')).hide();
            })
            .catch(err => {
                console.error('Save error', err);
                alert('An error occurred while saving.');
            });
        }

        function expandNotes() {
            const notesField = document.getElementById('notes');
            notesField.style.height = '150px';
        }

        // ===============================
        // Filter Logic
        // ===============================
        function applyFilter() {
            const selectedFilters = {};
            Object.keys(tsInstances).forEach(id => {
                selectedFilters[id] = tsInstances[id].getValue();
            });

            console.log("Applied Filters:", selectedFilters);

            calendar.removeAllEvents();
            let filtered = allEvents;

            if (selectedFilters.leadStatus.length > 0) {
                filtered = filtered.filter(e =>
                    selectedFilters.leadStatus.includes(e.extendedProps?.leadStatus)
                );
            }

            filtered.forEach(e => calendar.addEvent(e));
        }

        function saveFilter() {
            const selectedFilters = {};
            Object.keys(tsInstances).forEach(id => {
                selectedFilters[id] = tsInstances[id].getValue();
            });

            const label = Object.entries(selectedFilters)
                .filter(([k, v]) => v.length > 0)
                .map(([k, v]) => `${k}: ${v.join(", ")}`)
                .join(" | ");

            if (!label) return alert("Select at least one filter to save");

            const li = document.createElement("li");
            li.textContent = label;
            li.style.cursor = "pointer";
            li.onclick = () => {
                Object.keys(selectedFilters).forEach(id => {
                    tsInstances[id].setValue(selectedFilters[id]);
                });
                applyFilter();
            };

            document.getElementById("pinList").appendChild(li);
        }

        function resetFilter() {
            Object.keys(tsInstances).forEach(id => {
                tsInstances[id].clear();
                if (id === "salesType") tsInstances[id].setValue(["Sales"]);
            });
            applyFilter();
        }
    </script>
@endsection




@push('styles')
    <style>
        .fc-header-toolbar {
            margin: 0 !important;
        }

        .fc .fc-toolbar {
            padding: 10px;
            background: #fff;
            border-bottom: 1px solid #ddd;
        }

        .fc .fc-daygrid-day-number {
            display: none;
        }

        /* hide date number inside cells */
        .fc-event {
            border: none;
            padding: 5px;
            font-size: 10px;
            margin-bottom: 3px;
            font-weight: 400 !important;
            text-align: start;
        }

        .fc-event.new {
            background-color: rgb(125, 125, 125) !important;
            color: #fff;
        }

        .fc-event.used {
            background-color: rgb(56, 115, 166) !important;
            color: #fff;
        }

        .fc-event.service {
            background-color: rgb(212, 142, 51) !important;
            color: #fff;
        }

        .fc-event.none {
            background-color: rgb(105, 87, 194) !important;
            color: #fff;
        }

        .pin-list {
            padding: 0px;
        }

        .pin-list li {
            cursor: pointer;
            padding: 4px 15px;
            cursor: pointer;
            border: 1px solid #888;
            margin-top: 10px;
            background: #F7F8F9;
            width: fit-content;
            border-radius: 10rem;
            list-style: none;
            color: #000;
            font-size: 13px;
        }

        .offcanvas-footer {
            border-top: 1px solid #ddd;
            padding: 14px;
        }

        #customcanvas {
            width: 400px;
        }

        #customcanvas {
            z-index: 1070 !important;
        }
    </style>
@endpush
