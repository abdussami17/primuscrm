{{-- custom date select logic --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {

        function formatDisplayDate(dateStr) {
            let day, month, year;

            // yyyy-mm-dd
            if (dateStr.includes("-")) {
                const parts = dateStr.split("-");
                if (parts.length === 3) {
                    year = parts[0];
                    month = parseInt(parts[1], 10) - 1;
                    day = parts[2];
                }
            }
            // dd/mm/yyyy
            else if (dateStr.includes("/")) {
                const parts = dateStr.split("/");
                if (parts.length === 3) {
                    day = parts[0];
                    month = parseInt(parts[1], 10) - 1;
                    year = parts[2];
                }
            }

            if (!day || !year || month < 0) return dateStr;

            const months = [
                "Jan", "Feb", "Mar", "Apr", "May", "Jun",
                "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
            ];

            return `${months[month]} ${day}, ${year}`;
        }

        const container = document.getElementById("customDateContainer");
        let currentSelect = null;

        document.querySelectorAll(".widgetdateFilter").forEach(select => {
            select.addEventListener("change", function() {

                if (this.value === "custom") {
                    currentSelect = this;
                    container.classList.remove("d-none");

                    const rect = this.getBoundingClientRect();
                    container.style.top = rect.bottom + window.scrollY + "px";
                    container.style.left = rect.left + window.scrollX + "px";

                    container.querySelector(".custom-from").value = "";
                    container.querySelector(".custom-to").value = "";

                } else {
                    container.classList.add("d-none");
                }
            });
        });

        // Close container when clicking outside
        document.addEventListener("click", function(event) {
            const clickedInsideContainer = container.contains(event.target);
            const clickedSelect = currentSelect && currentSelect.contains(event.target);

            if (!clickedInsideContainer && !clickedSelect) {
                container.classList.add("d-none");
                currentSelect = null;
            }
        });


        container.querySelector(".applyCustomDate").addEventListener("click", function() {

            const fromRaw = container.querySelector(".custom-from").value;
            const toRaw = container.querySelector(".custom-to").value;

            if (!fromRaw || !toRaw) {
                alert("Please select both From and To dates.");
                return;
            }

            const from = formatDisplayDate(fromRaw);
            const to = formatDisplayDate(toRaw);

            if (currentSelect) {
                currentSelect.value = "custom";
                currentSelect.options[currentSelect.selectedIndex].text =
                    `Custom: ${from} to ${to}`;
            }

            console.log("Custom Range Applied:", fromRaw, toRaw);
            container.classList.add("d-none");
        });

    });
</script>

{{-- table scrolling optimize logic --}}

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const scrollAmount = 100; // pixels to scroll per key press

        // Select all table-responsive containers
        document.querySelectorAll('.table-responsive').forEach(tableContainer => {
            // Make the container focusable
            tableContainer.setAttribute("tabindex", "0");
            tableContainer.style.outline = "none"; // optional: remove focus outline

            // Listen for arrow key presses
            tableContainer.addEventListener("keydown", function(e) {
                switch (e.key) {
                    case "ArrowLeft":
                        tableContainer.scrollBy({
                            left: -scrollAmount,
                            behavior: "smooth"
                        });
                        e.preventDefault();
                        break;
                    case "ArrowRight":
                        tableContainer.scrollBy({
                            left: scrollAmount,
                            behavior: "smooth"
                        });
                        e.preventDefault();
                        break;
                }
            });
        });
    });
</script>

{{-- Dashboard Date Script --}}
<script>
    // Function to format and display current date
    function updateCurrentDate() {
        const now = new Date();
        const options = {
            weekday: 'short',
            month: 'long',
            day: 'numeric'
        };
        const formattedDate = now.toLocaleDateString('en-US', options);
        document.getElementById('currentDate').textContent = formattedDate;
    }

    // Call the function when the page loads
    updateCurrentDate();
</script>


{{-- Dashboard Tabs Script --}}


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const categoryButtons = document.querySelectorAll(".category-btn");
        const allWidgetAreas = document.querySelectorAll(".widgets-area");

        // Initially hide all widget areas
        allWidgetAreas.forEach((area) => (area.style.display = "none"));
        document.querySelector('.category-lead').style.display = 'flex';
        document.querySelector('.category-btn[data-category="lead"]').classList.add('active');
        categoryButtons.forEach((btn) => {
            btn.addEventListener("click", function() {
                const category = this.dataset.category;

                // Remove active from all buttons
                categoryButtons.forEach((b) => b.classList.remove("active"));
                this.classList.add("active");

                // Hide all widgets
                allWidgetAreas.forEach((area) => (area.style.display = "none"));

                // Show selected category widgets
                const selected = document.querySelector(".category-" + category);
                if (selected) {
                    selected.style.display =
                        "flex"; // or "block" depending on your layout needs
                }
            });
        });

        // Optional: Trigger click on first category button to show initial content
        // categoryButtons[0].click();
    });
</script>



{{-- Tooltip Initialize --}}

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>


{{-- Widgets Color Optimize Script --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const borderPicker = document.getElementById("borderColorPicker");
        const bgPicker = document.getElementById("bgColorPicker");
        const widgets = document.querySelectorAll(".widget-card .card");

        const saveBtn = document.getElementById("saveColorsBtn");
        const resetBtn = document.getElementById("resetColorsBtn");
        const root = document.documentElement;

        const cssVar = (name) =>
            getComputedStyle(root).getPropertyValue(name).trim();

        // Load saved overrides
        const savedBorder = localStorage.getItem("widgetBorderColor");
        const savedBg = localStorage.getItem("widgetBgColor");

        /* ---------------- INITIAL STATE ---------------- */

        // Apply inline styles ONLY if user saved colors
        if (savedBorder || savedBg) {
            applyColors(savedBorder, savedBg);
        }

        syncPickers();

        /* ---------------- EVENTS ---------------- */

        borderPicker.addEventListener("input", () =>
            applyColors(borderPicker.value, bgPicker.value)
        );

        bgPicker.addEventListener("input", () =>
            applyColors(borderPicker.value, bgPicker.value)
        );

        saveBtn.addEventListener("click", () => {
            localStorage.setItem("widgetBorderColor", borderPicker.value);
            localStorage.setItem("widgetBgColor", bgPicker.value);
        });

        resetBtn.addEventListener("click", () => {
            localStorage.removeItem("widgetBorderColor");
            localStorage.removeItem("widgetBgColor");

            widgets.forEach(card => {
                card.style.removeProperty("border");
                card.style.removeProperty("background-color");
            });

            syncPickers();
        });

        /* ---------------- THEME CHANGE HANDLING ---------------- */

        new MutationObserver(() => {
            // If user has NOT overridden colors, restore CSS control
            if (!localStorage.getItem("widgetBorderColor") &&
                !localStorage.getItem("widgetBgColor")) {

                widgets.forEach(card => {
                    card.style.removeProperty("border");
                    card.style.removeProperty("background-color");
                });
            }

            syncPickers();
        }).observe(root, {
            attributes: true,
            attributeFilter: ["data-bs-theme"]
        });

        /* ---------------- HELPERS ---------------- */

        function applyColors(border, bg) {
            widgets.forEach(card => {
                if (border) card.style.border = `2px solid ${border}`;
                if (bg) card.style.backgroundColor = bg;
            });
        }

        function syncPickers() {
            const savedBorder = localStorage.getItem("widgetBorderColor");
            const savedBg = localStorage.getItem("widgetBgColor");

            // BORDER PICKER
            borderPicker.value = savedBorder ?
                savedBorder :
                normalizeHex(cssVar("--widget-border") || "#000000");

            // BG PICKER
            const bg = savedBg || cssVar("--widget-bg");
            bgPicker.value = normalizeHex(
                bg === "transparent" ? "#ffffff" : bg || "#ffffff"
            );
        }

        function normalizeHex(color) {
            if (!color) return "#ffffff";
            if (color === "transparent") return "#ffffff";

            if (/^#([0-9a-f]{3})$/i.test(color)) {
                return "#" + color.slice(1).split("").map(c => c + c).join("");
            }
            return color;
        }
    });
</script>



{{-- Widget Favourites Logic  --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const favContainer = document.getElementById('favorites-container');
        let favoriteWidgets = JSON.parse(localStorage.getItem('favoriteWidgets')) || {};

        // Toggle favorite status
        function toggleFavorite(widgetId, starEl) {
            if (favoriteWidgets[widgetId]) {
                // Remove from favorites
                delete favoriteWidgets[widgetId];
                starEl.className = "ti ti-star star-toggle";
                const favCard = favContainer.querySelector(`[data-widget-id="${widgetId}"]`);
                if (favCard) favCard.remove();
            } else {
                // Add to favorites
                favoriteWidgets[widgetId] = true;
                starEl.className = "ti ti-star-filled star-toggle";
                const original = document.querySelector(`.widget-card[data-widget-id="${widgetId}"]`);
                if (original && !favContainer.querySelector(`[data-widget-id="${widgetId}"]`)) {
                    const clone = original.cloneNode(true);
                    const cloneStar = clone.querySelector('.star-toggle');
                    if (cloneStar) cloneStar.className = "ti ti-star-filled star-toggle";
                    attachStarHandler(cloneStar);
                    favContainer.appendChild(clone);
                }
            }
            // Save state
            localStorage.setItem('favoriteWidgets', JSON.stringify(favoriteWidgets));
        }

        // Attach click handler to star icons
        function attachStarHandler(starEl) {
            if (!starEl || starEl.__favBound) return;
            starEl.__favBound = true;
            starEl.addEventListener('click', e => {
                e.stopPropagation();
                const card = starEl.closest('.widget-card');
                if (!card) return;
                const id = card.getAttribute('data-widget-id');
                toggleFavorite(id, starEl);
            });
        }

        // Initial binding
        document.querySelectorAll('.star-toggle').forEach(attachStarHandler);

        // Initialize favorites from localStorage
        Object.keys(favoriteWidgets).forEach(widgetId => {
            const starEl = document.querySelector(`[data-widget-id="${widgetId}"] .star-toggle`);
            if (starEl) starEl.className = "ti ti-star-filled star-toggle";
            const original = document.querySelector(`.widget-card[data-widget-id="${widgetId}"]`);
            if (original && !favContainer.querySelector(`[data-widget-id="${widgetId}"]`)) {
                const clone = original.cloneNode(true);
                const cloneStar = clone.querySelector('.star-toggle');
                if (cloneStar) cloneStar.className = "ti ti-star-filled star-toggle";
                attachStarHandler(cloneStar);
                favContainer.appendChild(clone);
            }
        });

        console.log("[STAR] Favourites system ready.");
    });

    /**
 * dashboard-stats.js
 * Loads real data from the DashboardController API endpoints
 * and renders all charts / updates all stat badges on the dashboard.
 *
 * Pattern per widget:
 *  - On page-load: fetch count/summary and update badge text
 *  - On modal shown: fetch full data, destroy old chart, render new chart, populate table
 *  - On date-filter change inside modal: repeat the fetch/render cycle
 */

/* ====================================================================
   GLOBAL CHART REGISTRY  – stores ApexChart instances by ID so we can
   destroy & recreate them when data refreshes.
   ==================================================================== */
const _dashCharts = {};

function _destroyChart(id) {
    if (_dashCharts[id]) {
        try { _dashCharts[id].destroy(); } catch (_) {}
        _dashCharts[id] = null;
    }
    const el = document.getElementById(id);
    if (el) el.innerHTML = '';
}

/* ====================================================================
   SHARED HELPERS
   ==================================================================== */
const _hours12 = [];
for (let i = 0; i < 24; i++) {
    if (i === 0) _hours12.push('12 AM');
    else if (i === 12) _hours12.push('12 PM');
    else if (i < 12) _hours12.push(`${i} AM`);
    else _hours12.push(`${i - 12} PM`);
}

function _fmtPhone(p) {
    if (!p || p === '—') return '—';
    const d = ('' + p).replace(/\D/g, '');
    if (d.length === 10) return `(${d.slice(0,3)}) ${d.slice(3,6)}-${d.slice(6)}`;
    return p;
}

/** Build a standard lead-table row from a row object returned by the API */
function _leadRow(r) {
    return `<tr>
        <td class="fw-semibold text-decoration-underline text-black" style="cursor:pointer"
            data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">${r.customerName ?? '—'}</td>
        <td>${r.assignedTo ?? '—'}</td>
        <td>${r.email ?? '—'}</td>
        <td>${_fmtPhone(r.cellNumber)}</td>
        <td>${_fmtPhone(r.homeNumber)}</td>
        <td>${_fmtPhone(r.workNumber)}</td>
        <td>${r.assignedBy ?? '—'}</td>
        <td class="fw-semibold text-decoration-underline text-black" style="cursor:pointer"
            data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo">${r.vehicle ?? '—'}</td>
        <td>${r.leadType ?? '—'}</td>
        <td>${r.dealType ?? '—'}</td>
        <td>${r.createdDate ?? '—'}</td>
        <td>${r.leadStatus ?? '—'}</td>
        <td>${r.salesStatus ?? '—'}</td>
        <td>${r.source ?? '—'}</td>
        <td>${r.inventoryType ?? '—'}</td>
        <td>${r.salesType ?? '—'}</td>
    </tr>`;
}

function _taskRow(r) {
    return `<tr>
        <td>${r.taskType ?? '—'}</td>
        <td>${r.statusType ?? '—'}</td>
        <td>${r.dueDate ?? '—'}</td>
        <td class="fw-semibold text-decoration-underline" style="cursor:pointer"
            data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">${r.customerName ?? '—'}</td>
        <td>${r.assignedTo ?? '—'}</td>
        <td>${r.assignedBy ?? '—'}</td>
        <td>${r.createdBy ?? '—'}</td>
        <td>${r.email ?? '—'}</td>
        <td>${_fmtPhone(r.cellNumber)}</td>
        <td>${_fmtPhone(r.homeNumber)}</td>
        <td>${_fmtPhone(r.workNumber)}</td>
        <td class="fw-semibold text-decoration-underline" style="cursor:pointer"
            data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo">${r.vehicle ?? '—'}</td>
        <td>${r.leadType ?? '—'}</td>
        <td>${r.dealType ?? '—'}</td>
        <td>${r.source ?? '—'}</td>
        <td>${r.inventoryType ?? '—'}</td>
        <td>${r.leadStatus ?? '—'}</td>
        <td>${r.salesStatus ?? '—'}</td>
        <td>${r.createdDate ?? '—'}</td>
    </tr>`;
}

function _getModalPeriod(modalEl) {
    const sel = modalEl.querySelector('.widgetdateFilter');
    return sel ? sel.value : 'today';
}

/** Register date-filter change inside a modal to call `callback(period)` */
function _bindDateFilter(modalEl, callback) {
    const sel = modalEl.querySelector('.widgetdateFilter');
    if (!sel || sel._dashBound) return;
    sel._dashBound = true;
    sel.addEventListener('change', () => callback(sel.value));
}

/* Standard ApexCharts bar config for hourly charts */
function _hourlyBarOptions(seriesData, onBarClick) {
    return {
        series: [{ name: 'Count', data: seriesData }],
        chart: {
            type: 'bar', height: 420, toolbar: { show: false },
            events: {
                dataPointSelection(e, ctx, cfg) {
                    if (onBarClick) onBarClick(cfg.dataPointIndex);
                }
            }
        },
        plotOptions: { bar: { horizontal: false, columnWidth: '50%', borderRadius: 4 } },
        colors: ['rgb(0,33,64)'],
        dataLabels: { enabled: true, formatter: v => v === 0 ? '' : v.toString() },
        legend: { show: false },
        xaxis: { categories: _hours12, title: { text: 'Hours of the Day' } },
        yaxis: { title: { text: 'Count' } },
        tooltip: { enabled: false },
        states: {
            normal: { filter: { type: 'none' } },
            hover:  { filter: { type: 'none' } },
            active: { filter: { type: 'none' } }
        }
    };
}

/* ====================================================================
   1. ALERT BAR
   ==================================================================== */
function _loadAlertBar() {
    fetch('/dashboard/stats/alert-bar')
        .then(r => r.json())
        .then(d => {
            const el = {
                missed:   document.getElementById('alert-missed-leads'),
                response: document.getElementById('alert-response-time'),
                tasks:    document.getElementById('alert-tasks-pct'),
                sold:     document.getElementById('alert-sold-today'),
            };
            if (el.missed)   el.missed.textContent   = `Missed Leads: ${d.missedLeads}`;
            if (el.response) el.response.textContent = `Avg Response Time: ${d.avgResponse}`;
            if (el.tasks)    el.tasks.textContent    = `Tasks Completed: ${d.tasksPct}`;
            if (el.sold)     el.sold.textContent     = `Sold Today: ${d.soldToday}`;
        })
        .catch(() => {});
}

/* ====================================================================
   2. UNCONTACTED LEADS  (new-leads widget)
   ==================================================================== */
function _loadUncontactedLeads(period = 'today') {
    return fetch(`/dashboard/stats/uncontacted-leads?period=${period}`)
        .then(r => r.json());
}

function _initUncontactedLeadsModal(modalEl, period) {
    _loadUncontactedLeads(period).then(data => {
        // Update badge
        const badge = document.getElementById('newLeadsCount');
        if (badge) badge.textContent = data.count;

        // Chart
        const hourly = Array.isArray(data.hourly) ? data.hourly : Array(24).fill(0);
        _destroyChart('newLeadsChart');
        const opts = _hourlyBarOptions(hourly, (idx) => {
            const title = document.getElementById('leadTableTitle');
            if (title) title.textContent = `Lead Details – ${_hours12[idx]}`;
            // Fetch rows for this hour
            fetch(`/dashboard/stats/uncontacted-leads?period=${period}&hour=${idx}`)
                .then(r => r.json())
                .then(d => {
                    const container = document.getElementById('newLeadsTableContainer');
                    const tbody     = document.getElementById('newLeadsDetailsBody');
                    if (container) container.classList.remove('d-none');
                    if (tbody)     tbody.innerHTML = (d.rows || []).map(_leadRow).join('') || '<tr><td colspan="16" class="text-center text-muted">No data</td></tr>';
                    if (container) container.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
        });
        opts.series[0].name = 'Uncontacted Leads';
        _dashCharts['newLeadsChart'] = new ApexCharts(document.getElementById('newLeadsChart'), opts);
        _dashCharts['newLeadsChart'].render();

        // Always show table with placeholder
        const initContainer = document.getElementById('newLeadsTableContainer');
        if (initContainer) {
            initContainer.classList.remove('d-none');
            const initTbody = document.getElementById('newLeadsDetailsBody');
            if (initTbody) initTbody.innerHTML = '<tr><td colspan="16" class="text-center text-muted">Click on a bar to view details</td></tr>';
        }
    }).catch(() => {});
}

/* ====================================================================
   3. INTERNET LEADS
   ==================================================================== */
function _loadInternetLeads(period = 'today') {
    return fetch(`/dashboard/stats/internet-leads?period=${period}`)
        .then(r => r.json());
}

function _initInternetLeadsModal(modalEl, period) {
    _loadInternetLeads(period).then(data => {
        const badge = document.getElementById('internetLeadsCount');
        if (badge) badge.textContent = data.count;

        const hourly = Array.isArray(data.hourly) ? data.hourly : Array(24).fill(0);
        _destroyChart('internetLeadsChart');
        const opts = _hourlyBarOptions(hourly, (idx) => {
            const title = document.getElementById('internetLeadTableTitle');
            if (title) title.textContent = `Internet Leads – ${_hours12[idx]}`;
            fetch(`/dashboard/stats/internet-leads?period=${period}&hour=${idx}`)
                .then(r => r.json())
                .then(d => {
                    const container = document.getElementById('internetLeadsTableContainer');
                    const tbody     = document.getElementById('internetLeadsDetailsBody');
                    if (container) container.classList.remove('d-none');
                    if (tbody)     tbody.innerHTML = (d.rows || []).map(_leadRow).join('') || '<tr><td colspan="16" class="text-center text-muted">No data</td></tr>';
                    if (container) container.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
        });
        opts.series[0].name = 'Internet Leads';
        _dashCharts['internetLeadsChart'] = new ApexCharts(document.getElementById('internetLeadsChart'), opts);
        _dashCharts['internetLeadsChart'].render();

        // Always show table with placeholder
        const initContainer = document.getElementById('internetLeadsTableContainer');
        if (initContainer) {
            initContainer.classList.remove('d-none');
            const initTbody = document.getElementById('internetLeadsDetailsBody');
            if (initTbody) initTbody.innerHTML = '<tr><td colspan="16" class="text-center text-muted">Click on a bar to view details</td></tr>';
        }
    }).catch(() => {});
}

/* ====================================================================
   4. WALK-IN LEADS
   ==================================================================== */
function _loadWalkInLeads(period = 'today') {
    return fetch(`/dashboard/stats/walk-in-leads?period=${period}`)
        .then(r => r.json());
}

function _initWalkInModal(modalEl, period) {
    _loadWalkInLeads(period).then(data => {
        const badge = document.getElementById('walkInCount');
        if (badge) badge.textContent = data.count;

        const hourly = Array.isArray(data.hourly) ? data.hourly : Array(24).fill(0);
        _destroyChart('walkInChart');
        const opts = _hourlyBarOptions(hourly, (idx) => {
            document.getElementById('walkInTableTitle').textContent = `Lead Details – ${_hours12[idx]}`;
            fetch(`/dashboard/stats/walk-in-leads?period=${period}&hour=${idx}`)
                .then(r => r.json())
                .then(d => {
                    const table = document.getElementById('walkInDetailsTable');
                    const tbody = document.getElementById('walkInDetailsBody');
                    if (table)  table.style.display = 'block';
                    if (tbody)  tbody.innerHTML = (d.rows || []).map(r => `<tr>
                        <td>${r.leadStatus ?? '—'}</td><td>${r.salesStatus ?? '—'}</td>
                        <td>${r.createdDate ?? '—'}</td>
                        <td class="fw-semibold text-decoration-underline" style="cursor:pointer"
                            data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">${r.customerName ?? '—'}</td>
                        <td>${r.assignedTo ?? '—'}</td><td>${r.assignedBy ?? '—'}</td>
                        <td>${r.email ?? '—'}</td>
                        <td>${_fmtPhone(r.cellNumber)}</td><td>${_fmtPhone(r.homeNumber)}</td><td>${_fmtPhone(r.workNumber)}</td>
                        <td class="fw-semibold text-decoration-underline" style="cursor:pointer"
                            data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo">${r.vehicle ?? '—'}</td>
                        <td>${r.dealType ?? '—'}</td><td>${r.source ?? '—'}</td>
                        <td>${r.inventoryType ?? '—'}</td><td>${r.salesType ?? '—'}</td>
                    </tr>`).join('') || '<tr><td colspan="15" class="text-center text-muted">No data</td></tr>';
                    if (table) table.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
        });
        opts.series[0].name = 'Walk-In Leads';
        _dashCharts['walkInChart'] = new ApexCharts(document.getElementById('walkInChart'), opts);
        _dashCharts['walkInChart'].render();

        // Always show table with placeholder
        const initTable = document.getElementById('walkInDetailsTable');
        if (initTable) {
            initTable.style.display = 'block';
            const initTbody = document.getElementById('walkInDetailsBody');
            if (initTbody) initTbody.innerHTML = '<tr><td colspan="15" class="text-center text-muted">Click on a bar to view details</td></tr>';
        }
    }).catch(() => {});
}

/* ====================================================================
   5. LEAD TYPES
   ==================================================================== */
function _initLeadTypesModal(modalEl, period) {
    fetch(`/dashboard/stats/lead-types?period=${period}`)
        .then(r => r.json())
        .then(data => {
            const chart = data.chart || {};
            const labels = Object.keys(chart);
            const values = Object.values(chart);

            _destroyChart('leadTypesChart');
            const opts = {
                series: [{ name: 'Leads', data: values }],
                chart: {
                    type: 'bar', height: 350, toolbar: { show: false },
                    events: {
                        dataPointSelection(e, ctx, cfg) {
                            const type = labels[cfg.dataPointIndex];
                            fetch(`/dashboard/stats/lead-types?period=${period}&type=${encodeURIComponent(type)}`)
                                .then(r => r.json())
                                .then(d => {
                                    const el = document.getElementById('leadTypesTableContainer');
                                    const tb = document.getElementById('leadTypesDetailsBody');
                                    if (el) el.classList.remove('d-none');
                                    if (tb) tb.innerHTML = (d.rows || []).map(_leadRow).join('') || '<tr><td colspan="16" class="text-center text-muted">No data</td></tr>';
                                    const ttl = document.getElementById('leadTypeTableTitle');
                                    if (ttl) ttl.textContent = `Lead Details – ${type}`;
                                });
                        }
                    }
                },
                plotOptions: { bar: { horizontal: true, barHeight: '60%', borderRadius: 4 } },
                colors: ['rgb(0,33,64)'],
                dataLabels: { enabled: true },
                xaxis: { categories: labels, title: { text: 'Count' } },
                tooltip: { enabled: false },
                states: {
                    normal: { filter: { type: 'none' } },
                    hover:  { filter: { type: 'none' } },
                    active: { filter: { type: 'none' } }
                }
            };
            if (document.getElementById('leadTypesChart')) {
                _dashCharts['leadTypesChart'] = new ApexCharts(document.getElementById('leadTypesChart'), opts);
                _dashCharts['leadTypesChart'].render();
            }

            // Always show table with placeholder
            const initContainer = document.getElementById('leadTypesTableContainer');
            if (initContainer) {
                initContainer.classList.remove('d-none');
                const initTbody = document.getElementById('leadTypesDetailsBody');
                if (initTbody) initTbody.innerHTML = '<tr><td colspan="16" class="text-center text-muted">Click on a bar to view details</td></tr>';
            }
        }).catch(() => {});
}

/* ====================================================================
   6. OVERDUE TASKS
   ==================================================================== */
function _overdueTaskRow(r) {
    return `<tr>
        <td>${r.taskType ?? '—'}</td>
        <td>${r.leadStatus ?? '—'}</td>
        <td>${r.salesStatus ?? '—'}</td>
        <td>${r.createdDate ?? '—'}</td>
        <td>${r.direction ?? '—'}</td>
        <td class="fw-semibold text-decoration-underline" style="cursor:pointer"
            data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">${r.customerName ?? '—'}</td>
        <td>${r.assignedTo ?? '—'}</td>
        <td>${r.assignedBy ?? '—'}</td>
    </tr>`;
}

function _initOverdueTasksModal(modalEl, period) {
    fetch(`/dashboard/stats/overdue-tasks?period=${period}`)
        .then(r => r.json())
        .then(data => {
            // Update badge
            const badge = document.getElementById('overdue-count');
            if (badge) badge.textContent = data.count;

            const grouped = data.grouped || {};
            const labels  = Object.keys(grouped);
            const values  = Object.values(grouped);

            // Color map matching the design
            const colorMap = {
                'Call':        '#2E5A88',
                'Text':        '#2BAE66',
                'Email':       '#45BFC5',
                'CSI':         '#E8A838',
                'Other':       '#D04437',
                'Appointment': '#7C8B97',
            };
            const defaultPalette = ['#2E5A88','#2BAE66','#45BFC5','#E8A838','#D04437','#7C8B97','#6c5ce7','#b2bec3'];
            const colors = labels.map((l, i) => colorMap[l] || defaultPalette[i % defaultPalette.length]);

            _destroyChart('overdueTasksChart');

            // If no data, show an empty placeholder donut
            const hasData = values.length > 0 && values.some(v => v > 0);
            const chartLabels  = hasData ? labels  : ['No Data'];
            const chartValues  = hasData ? values  : [1];
            const chartColors  = hasData ? colors  : ['#e0e0e0'];

            const opts = {
                series: chartValues,
                chart: {
                    type: 'donut', height: 350,
                    events: {
                        dataPointSelection(e, ctx, cfg) {
                            if (!hasData) return;
                            const type = labels[cfg.dataPointIndex];
                            fetch(`/dashboard/stats/overdue-tasks?period=${period}&type=${encodeURIComponent(type)}`)
                                .then(r => r.json())
                                .then(d => {
                                    const tbody = document.getElementById('overdueTaskDetailsBody');
                                    if (tbody) tbody.innerHTML = (d.rows || []).map(_overdueTaskRow).join('') || '<tr><td colspan="8" class="text-center text-muted">No data</td></tr>';
                                    const container = document.getElementById('overdueTaskTableContainer');
                                    if (container) { container.classList.remove('d-none'); container.scrollIntoView({behavior:'smooth',block:'start'}); }
                                    const ttl = document.getElementById('overdueTaskTableTitle');
                                    if (ttl) ttl.textContent = `Task Details \u2013 ${type}`;
                                });
                        }
                    }
                },
                labels: chartLabels,
                colors: chartColors,
                legend: { position: 'left', fontSize: '14px' },
                tooltip: { enabled: hasData },
                dataLabels: { enabled: hasData },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '55%',
                            labels: { show: false }
                        }
                    }
                },
                stroke: { show: true, width: 2, colors: ['#fff'] },
            };

            if (!hasData) {
                opts.states = { normal:{filter:{type:'none'}}, hover:{filter:{type:'none'}}, active:{filter:{type:'none'}} };
            }

            const el = document.getElementById('overdueTasksChart');
            if (el) {
                _dashCharts['overdueTasksChart'] = new ApexCharts(el, opts);
                _dashCharts['overdueTasksChart'].render();
            }

            // Always show table with placeholder
            const initContainer = document.getElementById('overdueTaskTableContainer');
            if (initContainer) {
                initContainer.classList.remove('d-none');
                const initTbody = document.getElementById('overdueTaskDetailsBody');
                if (initTbody) initTbody.innerHTML = '<tr><td colspan="8" class="text-center text-muted">Click on a chart segment to view details</td></tr>';
            }
        }).catch(() => {});
}

/* ====================================================================
   7. OPEN TASKS  (donut)
   ==================================================================== */
function _initOpenTasksModal(modalEl, period) {
    fetch(`/dashboard/stats/open-tasks?period=${period}`)
        .then(r => r.json())
        .then(data => {
            const badge = document.getElementById('openTasksCount');
            if (badge) badge.textContent = data.count;

            const grouped = data.grouped || {};
            const labels  = Object.keys(grouped);
            const values  = Object.values(grouped);

            _destroyChart('tasksDonutChart');
            const palette = ['#002140','#1a3a5c','#4a7fad','#7ab3d4','#aed6f1','#d6eaf8'];
            const opts = {
                series: values,
                chart: {
                    type: 'donut', height: 350,
                    events: {
                        dataPointSelection(e, ctx, cfg) {
                            const type = labels[cfg.dataPointIndex];
                            fetch(`/dashboard/stats/open-tasks?period=${period}&type=${encodeURIComponent(type)}`)
                                .then(r => r.json())
                                .then(d => {
                                    const tbody = document.getElementById('openTaskDetailsBody');
                                    if (tbody) tbody.innerHTML = (d.rows || []).map(_taskRow).join('') || '<tr><td colspan="19" class="text-center text-muted">No data</td></tr>';
                                    const container = document.getElementById('openTaskTableContainer');
                                    if (container) { container.classList.remove('d-none'); container.scrollIntoView({behavior:'smooth',block:'start'}); }
                                    const ttl = document.getElementById('openTaskTableTitle');
                                    if (ttl) ttl.textContent = `Task Details – ${type}`;
                                });
                        }
                    }
                },
                labels: labels,
                colors: palette.slice(0, labels.length),
                legend: { position: 'bottom' },
                tooltip: { enabled: false },
                dataLabels: { enabled: true }
            };
            const el = document.getElementById('tasksDonutChart');
            if (el) {
                _dashCharts['tasksDonutChart'] = new ApexCharts(el, opts);
                _dashCharts['tasksDonutChart'].render();
            }

            // Always show table with placeholder
            const initContainer = document.getElementById('openTaskTableContainer');
            if (initContainer) {
                initContainer.classList.remove('d-none');
                const initTbody = document.getElementById('openTaskDetailsBody');
                if (initTbody) initTbody.innerHTML = '<tr><td colspan="19" class="text-center text-muted">Click on a chart segment to view details</td></tr>';
            }
        }).catch(() => {});
}

/* ====================================================================
   8. ASSIGNED BY
   ==================================================================== */
function _initAssignedByModal(modalEl, period) {
    fetch(`/dashboard/stats/assigned-by?period=${period}`)
        .then(r => r.json())
        .then(data => {
            const chart   = data.chart || [];
            const labels  = chart.map(r => r.name);
            const values  = chart.map(r => r.count);

            _destroyChart('assignedByChart');
            const opts = {
                series: [{ name: 'Leads', data: values }],
                chart: {
                    type: 'bar', height: 380, toolbar: { show: false },
                    events: {
                        dataPointSelection(e, ctx, cfg) {
                            const userId = chart[cfg.dataPointIndex]?.user_id;
                            if (!userId) return;
                            fetch(`/dashboard/stats/assigned-by?period=${period}&user_id=${userId}`)
                                .then(r => r.json())
                                .then(d => {
                                    const tbody = document.getElementById('assignedByDetailsBody');
                                    if (tbody) tbody.innerHTML = (d.rows || []).map(_leadRow).join('') || '<tr><td colspan="16" class="text-center text-muted">No data</td></tr>';
                                    const container = document.getElementById('assignedByTableContainer');
                                    if (container) { container.classList.remove('d-none'); container.scrollIntoView({behavior:'smooth',block:'start'}); }
                                    const ttl = document.getElementById('assignedByTableTitle');
                                    if (ttl) ttl.textContent = `Lead Details – ${labels[cfg.dataPointIndex]}`;
                                });
                        }
                    }
                },
                plotOptions: { bar: { horizontal: false, columnWidth: '55%', borderRadius: 4 } },
                colors: ['rgb(0,33,64)'],
                dataLabels: { enabled: true },
                xaxis: { categories: labels },
                tooltip: { enabled: false },
                states: { normal:{filter:{type:'none'}}, hover:{filter:{type:'none'}}, active:{filter:{type:'none'}} }
            };
            const el = document.getElementById('assignedByChart');
            if (el) {
                _dashCharts['assignedByChart'] = new ApexCharts(el, opts);
                _dashCharts['assignedByChart'].render();
            }

            // Always show table with placeholder
            const initContainer = document.getElementById('assignedByTableContainer');
            if (initContainer) {
                initContainer.classList.remove('d-none');
                const initTbody = document.getElementById('assignedByDetailsBody');
                if (initTbody) initTbody.innerHTML = '<tr><td colspan="16" class="text-center text-muted">Click on a bar to view details</td></tr>';
            }
        }).catch(() => {});
}

/* ====================================================================
   9. APPOINTMENTS
   ==================================================================== */
function _initAppointmentsModal(modalEl, period) {
    fetch(`/dashboard/stats/appointments?period=${period}`)
        .then(r => r.json())
        .then(data => {
            const badge = document.getElementById('appointmentsCount');
            if (badge) badge.textContent = data.count;

            const grouped = data.grouped || {};
            const labels  = Object.keys(grouped);
            const values  = Object.values(grouped);

            _destroyChart('appointmentsChart');
            const opts = {
                series: [{ name: 'Count', data: values }],
                chart: {
                    type: 'bar', height: 350, toolbar: { show: false },
                    events: {
                        dataPointSelection(e, ctx, cfg) {
                            const status = labels[cfg.dataPointIndex];
                            fetch(`/dashboard/stats/appointments?period=${period}&status=${encodeURIComponent(status)}`)
                                .then(r => r.json())
                                .then(d => {
                                    const tbody = document.getElementById('appointmentsDetailsBody');
                                    if (tbody) tbody.innerHTML = (d.rows || []).map(_taskRow).join('') || '<tr><td colspan="19" class="text-center text-muted">No data</td></tr>';
                                    const container = document.getElementById('appointmentsTableContainer');
                                    if (container) { container.classList.remove('d-none'); container.scrollIntoView({behavior:'smooth',block:'start'}); }
                                    const ttl = document.getElementById('appointmentsTableTitle');
                                    if (ttl) ttl.textContent = `Appointment Details \u2013 ${status}`;
                                });
                        }
                    }
                },
                plotOptions: { bar: { horizontal: true, barHeight: '60%', borderRadius: 4 } },
                colors: ['rgb(0,33,64)'],
                dataLabels: { enabled: true },
                xaxis: { categories: labels, title: { text: 'Count' } },
                tooltip: { enabled: false },
                states: { normal:{filter:{type:'none'}}, hover:{filter:{type:'none'}}, active:{filter:{type:'none'}} }
            };
            const el = document.getElementById('appointmentsChart');
            if (el) {
                _dashCharts['appointmentsChart'] = new ApexCharts(el, opts);
                _dashCharts['appointmentsChart'].render();
            }

            // Always show table with placeholder
            const initContainer = document.getElementById('appointmentsTableContainer');
            if (initContainer) {
                initContainer.classList.remove('d-none');
                const initTbody = document.getElementById('appointmentsDetailsBody');
                if (initTbody) initTbody.innerHTML = '<tr><td colspan="19" class="text-center text-muted">Click on a bar to view details</td></tr>';
            }
        }).catch(() => {});
}

/* ====================================================================
   10. PURCHASE TYPES
   ==================================================================== */
function _purchaseRow(r) {
    return `<tr>
        <td>${r.leadStatus ?? '\u2014'}</td>
        <td>${r.salesStatus ?? '\u2014'}</td>
        <td>${r.createdDate ?? '\u2014'}</td>
        <td class="fw-semibold text-decoration-underline" style="cursor:pointer"
            data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">${r.customerName ?? '\u2014'}</td>
        <td>${r.assignedTo ?? '\u2014'}</td>
        <td>${r.assignedBy ?? '\u2014'}</td>
        <td>${r.createdBy ?? '\u2014'}</td>
        <td>${r.email ?? '\u2014'}</td>
        <td>${_fmtPhone(r.cellNumber)}</td>
        <td>${_fmtPhone(r.homeNumber)}</td>
        <td>${_fmtPhone(r.workNumber)}</td>
        <td class="fw-semibold text-decoration-underline" style="cursor:pointer"
            data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo">${r.vehicle ?? '\u2014'}</td>
        <td>${r.leadType ?? '\u2014'}</td>
        <td>${r.dealType ?? '\u2014'}</td>
        <td>${r.source ?? '\u2014'}</td>
        <td>${r.inventoryType ?? '\u2014'}</td>
        <td>${r.salesType ?? '\u2014'}</td>
    </tr>`;
}

function _initPurchaseTypesModal(modalEl, period) {
    fetch(`/dashboard/stats/purchase-types?period=${period}`)
        .then(r => r.json())
        .then(data => {
            const chart   = data.chart || {};
            const labels  = Object.keys(chart);
            const values  = Object.values(chart);

            _destroyChart('purchaseTypesChart');
            const opts = {
                series: [{ name: 'Count', data: values }],
                chart: {
                    type: 'bar', height: 350, toolbar: { show: false },
                    events: {
                        dataPointSelection(e, ctx, cfg) {
                            const type = labels[cfg.dataPointIndex];
                            fetch(`/dashboard/stats/purchase-types?period=${period}&type=${encodeURIComponent(type)}`)
                                .then(r => r.json())
                                .then(d => {
                                    const tbody = document.getElementById('purchaseTypesDetailsBody');
                                    if (tbody) tbody.innerHTML = (d.rows || []).map(_purchaseRow).join('') || '<tr><td colspan="17" class="text-center text-muted">No data</td></tr>';
                                    const container = document.getElementById('purchaseTypesTableContainer');
                                    if (container) { container.classList.remove('d-none'); container.scrollIntoView({behavior:'smooth',block:'start'}); }
                                    const ttl = document.getElementById('purchaseTypesTableTitle');
                                    if (ttl) ttl.textContent = `Purchase Details \u2013 ${type}`;
                                });
                        }
                    }
                },
                plotOptions: { bar: { horizontal: false, columnWidth: '50%', borderRadius: 4 } },
                colors: ['rgb(0,33,64)'],
                dataLabels: { enabled: true, formatter: v => v === 0 ? '' : v.toString() },
                xaxis: { categories: labels, title: { text: 'Purchase Type' } },
                yaxis: { title: { text: 'Count' } },
                tooltip: { enabled: false },
                states: { normal:{filter:{type:'none'}}, hover:{filter:{type:'none'}}, active:{filter:{type:'none'}} }
            };
            const el = document.getElementById('purchaseTypesChart');
            if (el) {
                _dashCharts['purchaseTypesChart'] = new ApexCharts(el, opts);
                _dashCharts['purchaseTypesChart'].render();
            }

            // Always show table with placeholder
            const initContainer = document.getElementById('purchaseTypesTableContainer');
            if (initContainer) {
                initContainer.classList.remove('d-none');
                const initTbody = document.getElementById('purchaseTypesDetailsBody');
                if (initTbody) initTbody.innerHTML = '<tr><td colspan="17" class="text-center text-muted">Click on a bar to view details</td></tr>';
            }
        }).catch(() => {});
}

/* ====================================================================
   11. CONTACT RATE
   ==================================================================== */
function _initContactRateModal(modalEl, period) {
    fetch(`/dashboard/stats/contact-rate?period=${period}`)
        .then(r => r.json())
        .then(data => {
            const badge = document.getElementById('viewContactRate');
            if (badge) badge.textContent = `${data.percentage}%`;

            const pctEl      = document.getElementById('contactPercentage');
            const cntEl      = document.getElementById('contactedLeads');
            const totalEl    = document.getElementById('totalLeads');
            if (pctEl)   pctEl.textContent   = data.percentage;
            if (cntEl)   cntEl.textContent   = data.contacted;
            if (totalEl) totalEl.textContent = data.total;

            // Always show table section with data
            const btn = document.getElementById('showContactTableBtn');
            if (btn) btn.style.display = 'none';
            const section = document.getElementById('contactTableSection');
            if (section) section.style.display = 'block';
            const contactTbody = document.getElementById('contactRateDetailsBody');
            if (contactTbody) contactTbody.innerHTML = (data.rows || []).map(r => `<tr>
                <td>${r.leadStatus??'—'}</td><td>${r.salesStatus??'—'}</td>
                <td>${r.createdDate??'—'}</td>
                <td class="fw-semibold text-decoration-underline" style="cursor:pointer"
                    data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">${r.customerName??'—'}</td>
                <td>${r.assignedBy??'—'}</td><td>${r.createdBy??'—'}</td>
                <td>${r.email??'—'}</td>
                <td>${_fmtPhone(r.cellNumber)}</td><td>${_fmtPhone(r.homeNumber)}</td><td>${_fmtPhone(r.workNumber)}</td>
                <td class="fw-semibold text-decoration-underline" style="cursor:pointer"
                    data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo">${r.vehicle??'—'}</td>
                <td>${r.leadType??'—'}</td><td>${r.dealType??'—'}</td>
                <td>${r.source??'—'}</td><td>${r.inventoryType??'—'}</td>
                <td>${r.salesType??'—'}</td><td>${r.contacted??'—'}</td>
            </tr>`).join('') || '<tr><td colspan="17" class="text-center text-muted">No data</td></tr>';
        }).catch(() => {});
}

/* ====================================================================
   12. APPOINTMENTS SHOWED RATE
   ==================================================================== */
function _initApptsShowedModal(modalEl, period) {
    fetch(`/dashboard/stats/appointments-showed?period=${period}`)
        .then(r => r.json())
        .then(data => {
            const badge = document.getElementById('apptsShowedRateValue');
            if (badge) badge.textContent = `${data.percentage}%`;

            const chart   = data.chart || {};
            const labels  = Object.keys(chart);
            const values  = Object.values(chart);

            _destroyChart('appointmentsShowedRateChart');
            const opts = {
                series: [{ name: 'Appointments', data: values }],
                chart: {
                    type: 'bar', height: 300, toolbar: { show: false },
                    events: {
                        dataPointSelection(e, ctx, cfg) {
                            const status = labels[cfg.dataPointIndex];
                            fetch(`/dashboard/stats/appointments-showed?period=${period}&status=${encodeURIComponent(status)}`)
                                .then(r => r.json())
                                .then(d => {
                                    const tbody = document.getElementById('appointmentsShowedRateBody');
                                    if (!tbody) return;
                                    tbody.innerHTML = (d.rows || []).map(r => `<tr>
                                        <td>${r.taskType??'—'}</td>
                                        <td>${r.statusType??'—'}</td>
                                        <td>${r.dueDate??'—'}</td>
                                        <td class="fw-semibold text-decoration-underline" style="cursor:pointer"
                                            data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">${r.customerName??'—'}</td>
                                        <td>${r.assignedTo??'—'}</td>
                                        <td>${r.assignedBy??'—'}</td>
                                        <td>${_fmtPhone(r.cellNumber)}</td>
                                        <td>${_fmtPhone(r.workNumber)}</td>
                                        <td>${_fmtPhone(r.homeNumber)}</td>
                                    </tr>`).join('') || '<tr><td colspan="9" class="text-center text-muted">No data</td></tr>';
                                    tbody.scrollIntoView({behavior:'smooth',block:'start'});
                                });
                        }
                    }
                },
                plotOptions: { bar: { horizontal: true, barHeight: '75%', borderRadius: 4 } },
                colors: ['rgb(0,33,64)'],
                dataLabels: { enabled: true },
                xaxis: { categories: labels, title: { text: 'Count' } },
                tooltip: { enabled: false },
                states: { normal:{filter:{type:'none'}}, hover:{filter:{type:'none'}}, active:{filter:{type:'none'}} }
            };
            const el = document.getElementById('appointmentsShowedRateChart');
            if (el) {
                _dashCharts['appointmentsShowedRateChart'] = new ApexCharts(el, opts);
                _dashCharts['appointmentsShowedRateChart'].render();
            }

            // Show table with placeholder
            const initTbody = document.getElementById('appointmentsShowedRateBody');
            if (initTbody) initTbody.innerHTML = '<tr><td colspan="9" class="text-center text-muted">Click on a bar to view details</td></tr>';
        }).catch(() => {});
}

/* ====================================================================
   13. TASK COMPLETION RATE
   ==================================================================== */
function _initTaskCompletionModal(modalEl, period) {
    fetch(`/dashboard/stats/task-completion?period=${period}`)
        .then(r => r.json())
        .then(data => {
            const badge = document.getElementById('viewTaskCompletion');
            if (badge) badge.textContent = `${data.percentage}%`;

            const pctEl = document.getElementById('taskCompletionPct');
            const cmpEl = document.getElementById('taskCompletedCount');
            const opnEl = document.getElementById('taskOpenCount');
            if (pctEl) pctEl.textContent = `${data.percentage}%`;
            if (cmpEl) cmpEl.textContent = data.completed;
            if (opnEl) opnEl.textContent = data.open;

            const tbody = document.getElementById('taskCompletionDetailsBody');
            if (tbody) tbody.innerHTML = (data.rows || []).map(_taskRow).join('') || '<tr><td colspan="19" class="text-center text-muted">No data</td></tr>';
        }).catch(() => {});
}

/* ====================================================================
   14. SPEED-TO-SALE
   ==================================================================== */
function _initSpeedToSaleModal(modalEl, period) {
    fetch(`/dashboard/stats/speed-to-sale?period=${period}`)
        .then(r => r.json())
        .then(data => {
            const speedEl = document.getElementById('speedToLeadValue');
            const convEl  = document.getElementById('conversionDaysValue');
            if (speedEl) speedEl.textContent = data.speedToLead  ?? '— min';
            if (convEl)  convEl.textContent  = data.conversionDays ?? '— Days';
        }).catch(() => {});
}

/* ====================================================================
   15. FINANCE CONTACT RATE
   ==================================================================== */
function _initFinanceRateModal(modalEl, period) {
    fetch(`/dashboard/stats/finance-contact-rate?period=${period}`)
        .then(r => r.json())
        .then(data => {
            const badge = document.getElementById('financeRateValue');
            if (badge) badge.textContent = `${data.percentage}%`;

            const pctEl   = document.getElementById('financePenetrationPct');
            const finEl   = document.getElementById('financeDealsCount');
            const totEl   = document.getElementById('financeTotalDeals');
            if (pctEl)  pctEl.textContent  = `${data.percentage}%`;
            if (finEl)  finEl.textContent  = data.finance;
            if (totEl)  totEl.textContent  = data.total;

            const tbody = document.getElementById('financePenetrationBody');
            if (tbody) tbody.innerHTML = (data.rows || []).map(r => `<tr>
                <td>${r.leadStatus??'—'}</td><td>${r.salesStatus??'—'}</td>
                <td>${r.createdDate??'—'}</td>
                <td class="fw-semibold text-decoration-underline" style="cursor:pointer"
                    data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">${r.customerName??'—'}</td>
                <td>${r.assignedBy??'—'}</td><td>${r.createdBy??'—'}</td>
                <td>${r.email??'—'}</td>
                <td>${_fmtPhone(r.cellNumber)}</td><td>${_fmtPhone(r.homeNumber)}</td><td>${_fmtPhone(r.workNumber)}</td>
                <td class="fw-semibold text-decoration-underline" style="cursor:pointer"
                    data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo">${r.vehicle??'—'}</td>
                <td>${r.leadType??'—'}</td><td>${r.dealType??'—'}</td>
                <td>${r.source??'—'}</td><td>${r.inventoryType??'—'}</td>
                <td>${r.salesType??'—'}</td><td>${r.contacted??'—'}</td>
            </tr>`).join('') || '<tr><td colspan="17" class="text-center text-muted">No data</td></tr>';
        }).catch(() => {});
}

/* ====================================================================
   16. STORE-VISIT CLOSING RATIO
   ==================================================================== */
function _initStoreVisitClosingModal(modalEl, period) {
    fetch(`/dashboard/stats/store-visit-closing?period=${period}`)
        .then(r => r.json())
        .then(data => {
            const pctEl  = document.getElementById('storeVisitClosingRatioPercentage');
            const pctElcount = document.getElementById('storeVisitClosingRatioPercentageCount');
            const soldEl = document.getElementById('closedStoreVisits');
            const totEl  = document.getElementById('totalStoreVisits');
            if(pctElcount) pctElcount.textContent = `${data.percentage}%`;
            if (pctEl)  pctEl.textContent  = data.percentage;
            if (soldEl) soldEl.textContent = data.sold;
            if (totEl)  totEl.textContent  = data.total;

            const tbody = document.getElementById('storeVisitClosingRatioDetailsBody');
            if (tbody) tbody.innerHTML = (data.rows || []).map(r => `<tr>
                <td>${r.taskType??'—'}</td><td>${r.statusType??'—'}</td>
                <td>${r.dueDate??'—'}</td>
                <td class="fw-semibold text-decoration-underline" style="cursor:pointer"
                    data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">${r.customerName??'—'}</td>
                <td>${r.assignedTo??'—'}</td><td>${r.assignedBy??'—'}</td><td>${r.createdBy??'—'}</td>
                <td>${r.email??'—'}</td>
                <td>${_fmtPhone(r.cellNumber)}</td><td>${_fmtPhone(r.homeNumber)}</td><td>${_fmtPhone(r.workNumber)}</td>
                <td class="fw-semibold text-decoration-underline" style="cursor:pointer"
                    data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo">${r.vehicle??'—'}</td>
                <td>${r.leadType??'—'}</td><td>${r.dealType??'—'}</td>
                <td>${r.source??'—'}</td><td>${r.inventoryType??'—'}</td>
                <td>${r.leadStatus??'—'}</td><td>${r.salesStatus??'—'}</td>
                <td>${r.createdDate??'—'}</td><td>${r.closed??'—'}</td>
            </tr>`).join('') || '<tr><td colspan="20" class="text-center text-muted">No data</td></tr>';

            // Always show table section
            const btn     = document.getElementById('showStoreVisitClosingRatioTableBtn');
            const section = document.getElementById('storeVisitClosingRatioTableSection');
            if (btn) btn.style.display = 'none';
            if (section) section.style.display = 'block';
        }).catch(() => {});
}

/* ====================================================================
   16b. LEASE PENETRATION
   ==================================================================== */
function _initLeasePenetrationModal(modalEl, period) {
    fetch(`/dashboard/stats/lease-penetration?period=${period}`)
        .then(r => r.json())
        .then(data => {
            const pctEl   = document.getElementById('leasePenetrationPercentage');
            const pctElcount = document.getElementById('leasePenetrationPercentageCount'); 
            const leaseEl = document.getElementById('contactedLeadsLeasePenetration');
            const totEl   = document.getElementById('leasePenetrationTotalLeads');
            if (pctEl)   pctEl.textContent  = data.percentage;
            if (leaseEl) leaseEl.textContent = data.lease;
            if (totEl)   totEl.textContent  = data.total;
            if (pctElcount) pctElcount.textContent = `${data.percentage}%`;
 
            const tbody = document.getElementById('leasePenetrationDetailsBody');
            if (tbody) tbody.innerHTML = (data.rows || []).map(r => `<tr>
                <td>${r.leadStatus??'—'}</td><td>${r.salesStatus??'—'}</td>
                <td>${r.createdDate??'—'}</td>
                <td class="fw-semibold text-decoration-underline" style="cursor:pointer"
                    data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">${r.customerName??'—'}</td>
                <td>${r.assignedBy??'—'}</td><td>${r.createdBy??'—'}</td>
                <td>${r.email??'—'}</td>
                <td>${_fmtPhone(r.cellNumber)}</td><td>${_fmtPhone(r.homeNumber)}</td><td>${_fmtPhone(r.workNumber)}</td>
                <td class="fw-semibold text-decoration-underline" style="cursor:pointer"
                    data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo">${r.vehicle??'—'}</td>
                <td>${r.leadType??'—'}</td><td>${r.dealType??'—'}</td>
                <td>${r.source??'—'}</td><td>${r.inventoryType??'—'}</td>
                <td>${r.salesType??'—'}</td><td>${r.contacted??'—'}</td>
            </tr>`).join('') || '<tr><td colspan="17" class="text-center text-muted">No data</td></tr>';

            // Always show table section
            const btn     = document.getElementById('showLeasePenetrationTableBtn');
            const section = document.getElementById('leasePenetrationTableSection');
            if (btn) btn.style.display = 'none';
            if (section) section.style.display = 'block';
        }).catch(() => {});
}

/* ====================================================================
   17. BEBACK CUSTOMERS
   ==================================================================== */
function _initBebackModal(modalEl, period) {
    fetch(`/dashboard/stats/beback-customers?period=${period}`)
        .then(r => r.json())
        .then(data => {
            const badge = document.getElementById('bebackCount');
            if (badge) badge.textContent = data.count;

            const tbody = document.getElementById('bebackCustomerDetailsBody');
            if (tbody) tbody.innerHTML = (data.rows || []).map(_leadRow).join('') || '<tr><td colspan="17" class="text-center text-muted">No data</td></tr>';
        }).catch(() => {});
}

/* ====================================================================
   18. SOLD DEAL SOURCES
   ==================================================================== */
function _initSoldDealSourcesModal(modalEl, period) {
    fetch(`/dashboard/stats/sold-deal-sources?period=${period}`)
        .then(r => r.json())
        .then(data => {
            const sources = data.sources || [];
            const labels  = sources.map(s => s.source);
            const values  = sources.map(s => s.count);

            _destroyChart('soldDealSourcesChart');
            const opts = {
                series: [{ name: 'Deals', data: values }],
                chart: {
                    type: 'bar', height: 350, toolbar: { show: false },
                    events: {
                        dataPointSelection(e, ctx, cfg) {
                            const src = labels[cfg.dataPointIndex];
                            fetch(`/dashboard/stats/sold-deal-sources?period=${period}&source=${encodeURIComponent(src)}`)
                                .then(r => r.json())
                                .then(d => {
                                    const tbody = document.getElementById('soldDealSourcesBody');
                                    if (tbody) tbody.innerHTML = (d.rows || []).map(_leadRow).join('') || '<tr><td colspan="16" class="text-center text-muted">No data</td></tr>';
                                    const container = document.getElementById('soldDealSourcesTableContainer');
                                    if (container) { container.classList.remove('d-none'); container.scrollIntoView({behavior:'smooth',block:'start'}); }
                                });
                        }
                    }
                },
                plotOptions: { bar: { horizontal: true, barHeight: '60%', borderRadius: 4 } },
                colors: ['rgb(0,33,64)'],
                dataLabels: { enabled: true },
                xaxis: { categories: labels },
                tooltip: { enabled: false },
                states: { normal:{filter:{type:'none'}}, hover:{filter:{type:'none'}}, active:{filter:{type:'none'}} }
            };
            const el = document.getElementById('soldDealSourcesChart');
            if (el) {
                _dashCharts['soldDealSourcesChart'] = new ApexCharts(el, opts);
                _dashCharts['soldDealSourcesChart'].render();
            }

            // Always show table with placeholder
            const initContainer = document.getElementById('soldDealSourcesTableContainer');
            if (initContainer) {
                initContainer.classList.remove('d-none');
                const initTbody = document.getElementById('soldDealSourcesBody');
                if (initTbody) initTbody.innerHTML = '<tr><td colspan="16" class="text-center text-muted">Click on a bar to view details</td></tr>';
            }
        }).catch(() => {});
}

/* ====================================================================
   19. PENDING F&I DEALS
   ==================================================================== */
function _initPendingFiModal(modalEl, period) {
    fetch(`/dashboard/stats/pending-fi-deals?period=${period}`)
        .then(r => r.json())
        .then(data => {
            const badge = document.getElementById('pendingFiCount');
            if (badge) badge.textContent = data.count;

            const tbody = document.getElementById('pendingFiDetailsBody');
            if (tbody) tbody.innerHTML = (data.rows || []).map(r => `<tr>
                <td class="fw-semibold text-decoration-underline" style="cursor:pointer"
                    data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">${r.customer??'—'}</td>
                <td>${r.email??'—'}</td><td>${_fmtPhone(r.cellNumber)}</td>
                <td class="fw-semibold text-decoration-underline" style="cursor:pointer"
                    data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo">${r.vehicle??'—'}</td>
                <td>${r.daysPending??0} days</td><td>${r.startTime??'—'}</td>
            </tr>`).join('') || '<tr><td colspan="6" class="text-center text-muted">No data</td></tr>';
        }).catch(() => {});
}

/* ====================================================================
   20. STORE-VISIT AGING
   ==================================================================== */
function _initStoreVisitAgingModal(modalEl, period) {
    fetch(`/dashboard/stats/store-visit-aging?period=${period}`)
        .then(r => r.json())
        .then(data => {
            const badge = document.getElementById('storeVisitAgingCount');
            if (badge) badge.textContent = data.count;

            const tbody = document.getElementById('storeVisitAgingBody');
            if (tbody) tbody.innerHTML = (data.rows || []).map(r => `<tr>
                <td class="fw-semibold text-decoration-underline" style="cursor:pointer"
                    data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">${r.customer??'—'}</td>
                <td>${r.email??'—'}</td><td>${_fmtPhone(r.cellNumber)}</td>
                <td class="fw-semibold text-decoration-underline" style="cursor:pointer"
                    data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo">${r.vehicle??'—'}</td>
                <td>${r.daysPending??0} days</td><td>${r.startTime??'—'}</td><td>${r.status??'—'}</td>
            </tr>`).join('') || '<tr><td colspan="7" class="text-center text-muted">No data</td></tr>';
        }).catch(() => {});
}

/* ====================================================================
   21. SALES FUNNEL
   ==================================================================== */
function _initSalesFunnelModal(modalEl, period) {
    fetch(`/dashboard/stats/sales-funnel?period=${period}`)
        .then(r => r.json())
        .then(data => {
            const order = ['customers','contacted','apptSet','apptShown','sold'];
            const vals  = {};

            // Update count elements
            order.forEach(key => {
                vals[key] = data[key] ?? 0;
                const el = document.getElementById(`funnel-${key}`);
                if (el) el.textContent = vals[key];
            });

            // Compute conversion badges + progress bars
            order.forEach((key, idx) => {
                const badge = document.querySelector(`[data-from="${key}"]`);
                const bar   = document.querySelector(`[data-bar="${key}"]`);
                if (idx === 0) {
                    if (badge) badge.textContent = 'Start';
                    if (bar)   { bar.style.width = '100%'; bar.setAttribute('aria-valuenow', 100); }
                } else {
                    const prev = vals[order[idx - 1]];
                    const cur  = vals[key];
                    const pct  = prev > 0 ? Math.round((cur / prev) * 100) : 0;
                    if (badge) badge.textContent = prev === 0 ? '—' : `${pct}%`;
                    if (bar)   { bar.style.width = `${Math.min(100, pct)}%`; bar.setAttribute('aria-valuenow', pct); }
                }
            });

            // Overall conversion (sold / customers)
            const overall = vals.customers > 0 ? Math.round((vals.sold / vals.customers) * 100) : 0;
            const overallEl = document.getElementById('overallConv');
            if (overallEl) overallEl.textContent = `${overall}%`;

            // Store Visit Closing Ratio (fetch separately)
            fetch(`/dashboard/stats/store-visit-closing?period=${period}`)
                .then(r => r.json())
                .then(sv => {
                    const el = document.getElementById('funnelStoreVisitPct');
                    if (el) el.textContent = `${sv.percentage ?? 0}%`;
                }).catch(() => {});
        }).catch(() => {});
}

/* ====================================================================
   22. INTERNET RESPONSE TIME  (updates the widget list)
   ==================================================================== */
function _initInternetResponseWidget() {
    fetch('/dashboard/stats/internet-response-time?period=today')
        .then(r => r.json())
        .then(data => {
            const buckets = data.buckets || {};
            const map = {
                '0-5':   'irt-0-5',
                '6-10':  'irt-6-10',
                '11-15': 'irt-11-15',
                '16-30': 'irt-16-30',
                '31-60': 'irt-31-60',
                '61+':   'irt-61plus',
                'No Contact': 'irt-no-contact',
            };
            Object.entries(map).forEach(([key, id]) => {
                const el = document.getElementById(id);
                if (el) el.textContent = buckets[key] ?? 0;
            });
        }).catch(() => {});
}

function _initInternetResponseModal(modalEl, period) {
    fetch(`/dashboard/stats/internet-response-time?period=${period}`)
        .then(r => r.json())
        .then(data => {
            const buckets = data.buckets || {};
            const labelMap = {
                '0-5':        'irt-legend-05',
                '6-10':       'irt-legend-10',
                '11-15':      'irt-legend-15',
                '16-30':      'irt-legend-30',
                '31-60':      'irt-legend-60',
                '61+':        'irt-legend-61plus',
                'No Contact': 'irt-legend-nc',
            };
            const colors = ['#28a745','#6c757d','rgb(0,33,64)','#ffc107','#17a2b8','#6f42c1','#dc3545'];
            const labels  = Object.keys(labelMap);
            const values  = labels.map(k => buckets[k] ?? 0);

            // Update legend counts
            labels.forEach((key, i) => {
                const el = document.getElementById(labelMap[key]);
                if (el) el.textContent = values[i];
            });

            // Shared: fetch rows for a bucket and populate the detail table
            function loadBucketRows(bucketKey) {
                fetch(`/dashboard/stats/internet-response-time?period=${period}&bucket=${encodeURIComponent(bucketKey)}`)
                    .then(r => r.json())
                    .then(d => {
                        const section = document.getElementById('filter-details');
                        const tbody   = document.getElementById('filter-details-body');
                        if (tbody) {
                            tbody.innerHTML = (d.rows || []).map(r => `<tr>
                                <td>${r.createdDate ?? '—'}</td>
                                <td>${r.responseTime ?? '—'}</td>
                                <td>${r.assignedTo ?? '—'}</td>
                                <td>${r.assignedBy ?? '—'}</td>
                                <td>${r.customerName ?? '—'}</td>
                                <td>${r.vehicle ?? '—'}</td>
                                <td>${r.dealType ?? '—'}</td>
                                <td>${r.source ?? '—'}</td>
                                <td>${r.leadStatus ?? '—'}</td>
                            </tr>`).join('') || '<tr><td colspan="9" class="text-center text-muted">No data</td></tr>';
                        }
                        if (section) {
                            section.style.display = 'block';
                            section.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    }).catch(() => {});
            }

            // Donut chart — segments are clickable via dataPointSelection
            _destroyChart('internetResponseTimeChart');
            const chartEl = document.getElementById('internetResponseTimeChart');
            if (chartEl) {
                const opts = {
                    series: values,
                    chart: {
                        type: 'donut',
                        height: 320,
                        toolbar: { show: false },
                        events: {
                            dataPointSelection: function (event, chartContext, config) {
                                const bucketKey = labels[config.dataPointIndex];
                                if (bucketKey) loadBucketRows(bucketKey);
                            }
                        }
                    },
                    labels: labels,
                    colors: colors,
                    legend: { show: false },
                    dataLabels: { enabled: true, formatter: (val) => Math.round(val) + '%' },
                    tooltip: { enabled: false },
                    states: { normal:{filter:{type:'none'}}, hover:{filter:{type:'lighten', value: 0.15}}, active:{filter:{type:'none'}} },
                    plotOptions: { pie: { donut: { size: '60%' } } }
                };
                _dashCharts['internetResponseTimeChart'] = new ApexCharts(chartEl, opts);
                _dashCharts['internetResponseTimeChart'].render();
            }

            // Always show table with placeholder
            const initSection = document.getElementById('filter-details');
            if (initSection) {
                initSection.style.display = 'block';
                const initTbody = document.getElementById('filter-details-body');
                if (initTbody) initTbody.innerHTML = '<tr><td colspan="9" class="text-center text-muted">Click on a chart segment or legend item to view details</td></tr>';
            }

            // Clickable legend items → filter table by bucket
            const filterMap = {
                'under5':    '0-5',
                'under10':   '6-10',
                'under15':   '11-15',
                'under30':   '16-30',
                'under60':   '31-60',
                'over60':    '61+',
                'nocontact': 'No Contact',
            };
            document.querySelectorAll('#internetresponsetimeModal .clickable-legend').forEach(item => {
                item.style.cursor = 'pointer';
                item.addEventListener('click', function () {
                    const bucketKey = filterMap[this.dataset.filter];
                    if (bucketKey) loadBucketRows(bucketKey);
                });
            });
        }).catch(() => {});
}

/* ====================================================================
   23. LEAD FLOW  (bar chart + table)
   ==================================================================== */
function _initLeadFlowModal(modalEl, period) {

    const el = document.getElementById('statusTimeline');
    if (!el) return;

    // instant visual feedback
    el.innerHTML = `
        <div class="d-flex justify-content-center align-items-center" style="height:320px">
            <div class="spinner-border text-primary"></div>
        </div>
    `;

    // async load
    setTimeout(() => {
        fetch(`/dashboard/stats/lead-flow?period=${period}`)
            .then(r => r.json())
            .then(data => {

                const grouped = data.grouped || {};
                const labels  = Object.keys(grouped);
                const values  = Object.values(grouped);

                const colorMap = {
                    'Uncontacted': '#dc3545',
                    'Attempted':   '#fd7e14',
                    'Contacted':   '#4a7fad',
                    'Dealer Visit':'#17a2b8',
                    'Demo':        '#20c997',
                    'Write-Up':    '#6f42c1',
                    'Pending F&I': '#e8a838',
                    'Sold':        '#28a745',
                    'Delivered':   '#002140',
                };

                const defaultColors = ['#002140','#4a7fad','#dc3545','#fd7e14','#17a2b8','#20c997','#6f42c1','#e8a838','#28a745'];
                const colors = labels.map((l, i) => colorMap[l] || defaultColors[i % defaultColors.length]);

                if (_dashCharts['statusTimeline']) {
                    _dashCharts['statusTimeline'].destroy();
                    delete _dashCharts['statusTimeline'];
                }

                el.innerHTML = ''; // remove spinner

                const opts = {
                    series: [{ name: 'Leads', data: values }],
                    chart: {
    type: 'bar',
    height: 320,
    toolbar: { show: false },
    animations: { enabled: false },

    events: {
        dataPointSelection(e, ctx, cfg) {

            const status = labels[cfg.dataPointIndex];

            fetch(`/dashboard/stats/lead-flow?period=${period}&status=${encodeURIComponent(status)}`)
                .then(r => r.json())
                .then(d => {

                    const tbody = document.getElementById('dealflowDetailsBody');
                    if (tbody) {
                        tbody.innerHTML =
                            (d.rows || []).map(_leadRow).join('') ||
                            '<tr><td colspan="16" class="text-center text-muted">No data</td></tr>';
                    }

                    const container = document.getElementById('dealflowTableContainer');
                    if (container) {
                        container.style.display = '';
                        container.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }

                    const ttl = document.getElementById('leadFlowTableTitle');
                    if (ttl) ttl.textContent = `Lead Details – ${status}`;
                });
        }
    }
},
                    plotOptions: { bar: { columnWidth: '50%', borderRadius: 4, distributed: true } },
                    colors: colors,
                    dataLabels: { enabled: true },
                    xaxis: { categories: labels },
                    yaxis: { title: { text: 'Count' } },
                    tooltip: { enabled: false },
                    legend: { show: false }
                };

                _dashCharts['statusTimeline'] = new ApexCharts(el, opts);
                _dashCharts['statusTimeline'].render();

            })
            .catch(() => {
                el.innerHTML = `<div class="text-center text-danger">Failed to load</div>`;
            });
    }, 0);
}
/* ====================================================================
   24. TOP REPS / COMPLETED APPTS PER REP  (widget + modal)
   ==================================================================== */
function _loadTopRepsWidget() {
    fetch('/dashboard/stats/top-reps?period=today')
        .then(r => r.json())
        .then(data => {
            const list = document.getElementById('topRepList');
            if (!list) return;
            list.innerHTML = (data.reps || []).slice(0, 5).map((r, i) => `
                <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-1">
                    <span>${i + 1}. ${r.name}</span>
                    <span class="badge bg-dark rounded-pill">${r.count}</span>
                </li>`).join('') || '<li class="list-group-item text-muted">No data</li>';
        }).catch(() => {});
}

function _initTopRepsModal(modalEl, period) {
    const list      = document.getElementById('fullRepList');
    const container = document.getElementById('repTaskTableContainer');
    const title     = document.getElementById('repTaskTableTitle');
    const tbody     = document.getElementById('repTaskDetailsBody');

    function loadReps(p) {
        fetch(`/dashboard/stats/top-reps?period=${p}`)
            .then(r => r.json())
            .then(data => {
                if (list) {
                    list.innerHTML = (data.reps || []).map((r, i) => `
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            style="cursor:pointer" data-rep-id="${r.user_id}">
                            <span class="fw-semibold">${i + 1}. ${r.name}</span>
                            <span class="badge bg-dark rounded-pill">${r.count}</span>
                        </li>`).join('') || '<li class="list-group-item text-muted">No data</li>';

                    list.querySelectorAll('[data-rep-id]').forEach(li => {
                        li.addEventListener('click', () => {
                            list.querySelectorAll('li').forEach(el => el.classList.remove('active'));
                            li.classList.add('active');
                            loadRepTasks(p, li.dataset.repId, li.querySelector('.fw-semibold')?.textContent || 'Rep');
                        });
                    });
                }
                // Hide task table when reps reload
                if (container) container.style.display = 'none';
                if (tbody) tbody.innerHTML = '<tr><td colspan="19" class="text-center text-muted">Click a rep above to view their tasks</td></tr>';
            }).catch(() => {});
    }

    function loadRepTasks(p, repId, repName) {
        if (tbody) tbody.innerHTML = '<tr><td colspan="19" class="text-center text-muted">Loading…</td></tr>';
        if (container) container.style.display = '';
        if (title) title.textContent = `Tasks – ${repName.replace(/^\d+\.\s*/, '')}`;

        fetch(`/dashboard/stats/top-reps?period=${p}&rep_id=${repId}`)
            .then(r => r.json())
            .then(data => {
                if (tbody) {
                    tbody.innerHTML = (data.rows || []).map(r => _taskRow(r)).join('')
                        || '<tr><td colspan="19" class="text-center text-muted">No tasks found</td></tr>';
                }
            }).catch(() => {
                if (tbody) tbody.innerHTML = '<tr><td colspan="19" class="text-center text-danger">Error loading tasks</td></tr>';
            });
    }

    loadReps(period);
    _bindDateFilter(modalEl, (p) => loadReps(p));
}

/* ====================================================================
   25. LOST REASONS  (widget list + modal)
   ==================================================================== */
function _loadLostReasonsWidget() {
    fetch('/dashboard/stats/lost-reasons?period=today')
        .then(r => r.json())
        .then(data => {
            const list = document.getElementById('lostReasonWidgetList');
            if (!list) return;
            list.innerHTML = (data.reasons || []).slice(0, 5).map((r, i) => `
                <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-1">
                    <span>${i + 1}. ${r.reason}</span>
                    <span class="badge bg-dark rounded-pill">${r.count}</span>
                </li>`).join('') || '<li class="list-group-item text-muted px-0">No data</li>';
        }).catch(() => {});
}

function _initLostReasonsModal(modalEl, period) {
    fetch(`/dashboard/stats/lost-reasons?period=${period}`)
        .then(r => r.json())
        .then(data => {
            const list = document.getElementById('lostReasonList');
            const reasons = data.reasons || [];
            if (list) list.innerHTML = reasons.map((r) => `
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>${r.reason}</span>
                    <span class="badge bg-danger rounded-pill">${r.count}</span>
                </li>`).join('') || '<li class="list-group-item text-muted">No data</li>';
        }).catch(() => {});
}

/* ====================================================================
   26. LAST LOGIN
   ==================================================================== */
function _initLastLoginModal(modalEl) {
    fetch('/dashboard/stats/last-login')
        .then(r => r.json())
        .then(data => {
            const tbody = document.getElementById('lastLoginBody');
            if (tbody) tbody.innerHTML = (data.users || []).map(u => `
                <tr>
                    <td>${u.name}</td>
                    <td>${u.lastLogin}</td>
                    <td>${u.lastUpdate}</td>
                </tr>`).join('') || '<tr><td colspan="3" class="text-center text-muted">No data</td></tr>';
        }).catch(() => {});
}

/* ====================================================================
   MODAL REGISTRY
   Map modal-id → { initFn, modalIdForBind }
   ==================================================================== */
const _modalRegistry = {
    'newLeadsModal':               (el, p) => _initUncontactedLeadsModal(el, p),
    'internetLeadsModal':          (el, p) => _initInternetLeadsModal(el, p),
    'walkInModal':                 (el, p) => _initWalkInModal(el, p),
    'leadTypesModal':              (el, p) => _initLeadTypesModal(el, p),
    'overdueTaskModal':            (el, p) => _initOverdueTasksModal(el, p),
    'tasksDonutModal':             (el, p) => _initOpenTasksModal(el, p),
    'assignedByModal':             (el, p) => _initAssignedByModal(el, p),
    'appointmentsModal':           (el, p) => _initAppointmentsModal(el, p),
    'purchaseTypesModal':          (el, p) => _initPurchaseTypesModal(el, p),
    'contactRateModal':            (el, p) => _initContactRateModal(el, p),
    'appointmentsShowedRateModal': (el, p) => _initApptsShowedModal(el, p),
    'taskCompletionRateModal':     (el, p) => _initTaskCompletionModal(el, p),
    'speedToSaleModal':            (el, p) => _initSpeedToSaleModal(el, p),
    'financePenetrationModal':     (el, p) => _initFinanceRateModal(el, p),
    'storeVisitClosingRatioModal':  (el, p) => _initStoreVisitClosingModal(el, p),
    'leasePenetrationModal':        (el, p) => _initLeasePenetrationModal(el, p),
    'bebackCustomerModal':          (el, p) => _initBebackModal(el, p),
    'soldDealSourcesModal':        (el, p) => _initSoldDealSourcesModal(el, p),
    'pendingFiModal':              (el, p) => _initPendingFiModal(el, p),
    'storeVisitAgingModal':        (el, p) => _initStoreVisitAgingModal(el, p),
    'salesfunnelModal':            (el, p) => _initSalesFunnelModal(el, p),
    'internetresponsetimeModal':   (el, p) => _initInternetResponseModal(el, p),
    'dealflowModal':               (el, p) => _initLeadFlowModal(el, p),
    'repListModal':                (el, p) => _initTopRepsModal(el, p),
    'lostListModal':               (el, p) => _initLostReasonsModal(el, p),
    'lastLoginModal':              (el, _p) => _initLastLoginModal(el),
};

/* ====================================================================
   BOOTSTRAP  – registers all modal listeners and initial page-load fetches
   ==================================================================== */
document.addEventListener('DOMContentLoaded', function () {

    /* ---------- page-load stat fetches ---------- */
    _loadAlertBar();
    _loadTopRepsWidget();
    _loadLostReasonsWidget();
    _initInternetResponseWidget();

    // Pre-fetch counts so the h6 badges show real numbers immediately
    [
        ['/dashboard/stats/uncontacted-leads?period=today', 'newLeadsCount',         d => d.count],
        ['/dashboard/stats/internet-leads?period=today',    'internetLeadsCount',    d => d.count],
        ['/dashboard/stats/walk-in-leads?period=today',     'walkInCount',           d => d.count],
        ['/dashboard/stats/overdue-tasks?period=today',     'overdue-count',         d => d.count],
        ['/dashboard/stats/open-tasks?period=today',        'openTasksCount',        d => d.count],
        ['/dashboard/stats/appointments?period=today',      'appointmentsCount',     d => d.count],
        ['/dashboard/stats/contact-rate?period=today',      'viewContactRate',       d => `${d.percentage}%`],
        ['/dashboard/stats/appointments-showed?period=today','apptsShowedRateValue', d => `${d.percentage}%`],
        ['/dashboard/stats/task-completion?period=today',   'viewTaskCompletion',    d => `${d.percentage}%`],
        ['/dashboard/stats/finance-contact-rate?period=today','financeRateValue',    d => `${d.percentage}%`],
        ['/dashboard/stats/lease-penetration?period=today' , 'leasePenetrationPercentageCount' , d=> `${d.percentage}%`],
        ['/dashboard/stats/store-visit-closing?period=today','storeVisitClosingRatioPercentageCount',    d => `${d.percentage}%`],
        ['/dashboard/stats/beback-customers?period=today',  'bebackCount',           d => d.count],
    ].forEach(([url, id, getter]) => {
        fetch(url)
            .then(r => r.json())
            .then(d => {
                const el = document.getElementById(id);
                if (el) el.textContent = getter(d);
            })
            .catch(() => {});
    });

    /* ---------- modal event listeners ---------- */
    Object.entries(_modalRegistry).forEach(([modalId, initFn]) => {
        const modalEl = document.getElementById(modalId);
        if (!modalEl) return;

        modalEl.addEventListener('shown.bs.modal', function () {
            const period = _getModalPeriod(modalEl);
            initFn(modalEl, period);
            _bindDateFilter(modalEl, (newPeriod) => {
                // Destroy charts inside this modal before re-init with new period
                modalEl.querySelectorAll('[id]').forEach(el => {
                    if (_dashCharts[el.id]) _destroyChart(el.id);
                });
                initFn(modalEl, newPeriod);
            });
        });

        // Destroy charts when modal closes to avoid stale state on next open
        modalEl.addEventListener('hidden.bs.modal', function () {
            modalEl.querySelectorAll('[id]').forEach(el => {
                if (_dashCharts[el.id]) _destroyChart(el.id);
            });
        });
    });

    console.log('[Dashboard Stats] Initialised.');
});

</script>

<script src="{{ asset('assets/js/index.js') }}"></script>
@endpush