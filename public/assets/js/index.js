document.addEventListener('DOMContentLoaded', function () {
  // Dummy data for Internet Response Time table
  const dummyData = {
    under5: [
      {
        datetime: "2025-05-28 08:01:23",
        type: "Walk In",
        rep: "A Lee",
        time: "2m 34s",
        salesStatus: "Demo",
        year: "2022",
        make: "Toyota",
        model: "Camry",
        customer: "Harinder Dalam",
        source: "Facebook",
        image: "assets/img/users/user-01.jpg",
        dealType: "Cash",
        leadStatus: "Active"
      },
      {
        datetime: "2025-05-28 08:10:55",
        type: "Write In",
        rep: "B Singh",
        time: "3m 12s",
        salesStatus: "Contacted",
        year: "2021",
        make: "Honda",
        model: "Civic",
        customer: "Priya Kaur",
        source: "Google Ads",
        image: "assets/img/users/user-02.jpg",
        dealType: "Lease",
        leadStatus: "Active"
      },
      {
        datetime: "2025-05-28 08:20:00",
        type: "Walk In",
        rep: "C Kumar",
        time: "4m 05s",
        salesStatus: "Untouched",
        year: "2020",
        make: "Ford",
        model: "Focus",
        customer: "Anil Sharma",
        source: "Instagram",
        image: "assets/img/users/user-03.jpg",
        dealType: "Cash",
        leadStatus: "Wishlist"
      },
      {
        datetime: "2025-05-28 08:35:49",
        type: "Write In",
        rep: "D Patel",
        time: "2m 58s",
        salesStatus: "Dealer Visit",
        year: "2023",
        make: "Hyundai",
        model: "Elantra",
        customer: "Neha Joshi",
        source: "LinkedIn",
        image: "assets/img/users/user-04.jpg",
        dealType: "Lease",
        leadStatus: "Buy-In"
      },
      {
        datetime: "2025-05-28 08:47:33",
        type: "Walk In",
        rep: "E Khan",
        time: "3m 45s",
        salesStatus: "Walk In",
        year: "2019",
        make: "Nissan",
        model: "Altima",
        customer: "Raj Verma",
        source: "Twitter",
        image: "assets/img/users/user-05.jpg",
        dealType: "Cash",
        leadStatus: "Active"
      }
    ],
    under10: [
      {
        datetime: "2025-05-28 09:01:12",
        type: "Write In",
        rep: "F Singh",
        time: "6m 21s",
        salesStatus: "Demo",
        year: "2022",
        make: "Toyota",
        model: "Corolla",
        customer: "Simran Gill",
        source: "Facebook",
        image: "assets/img/users/user-06.jpg",
        dealType: "Cash",
        leadStatus: "Sold"
      },
      {
        datetime: "2025-05-28 09:12:42",
        type: "Walk In",
        rep: "G Lee",
        time: "7m 15s",
        salesStatus: "Contacted",
        year: "2020",
        make: "Honda",
        model: "Accord",
        customer: "Vikram Singh",
        source: "Google Ads",
        image: "assets/img/users/user-07.jpg",
        dealType: "Lease",
        leadStatus: "Active"
      },
      {
        datetime: "2025-05-28 09:23:33",
        type: "Write In",
        rep: "H Kumar",
        time: "9m 58s",
        salesStatus: "Untouched",
        year: "2018",
        make: "Ford",
        model: "Fusion",
        customer: "Tina Mehta",
        source: "Instagram",
        image: "assets/img/users/user-08.jpg",
        dealType: "Cash",
        leadStatus: "Duplicate"
      },
      {
        datetime: "2025-05-28 09:36:17",
        type: "Walk In",
        rep: "I Patel",
        time: "8m 01s",
        salesStatus: "Dealer Visit",
        year: "2021",
        make: "Hyundai",
        model: "Sonata",
        customer: "Karan Malhotra",
        source: "LinkedIn",
        image: "assets/img/users/user-09.jpg",
        dealType: "Lease",
        leadStatus: "Buy-In"
      },
      {
        datetime: "2025-05-28 09:47:44",
        type: "Write In",
        rep: "J Khan",
        time: "7m 49s",
        salesStatus: "Walk In",
        year: "2023",
        make: "Nissan",
        model: "Rogue",
        customer: "Sneha Kapoor",
        source: "Twitter",
        image: "assets/img/users/user-10.jpg",
        dealType: "Cash",
        leadStatus: "Wishlist"
      }
    ],
    under15: [
      {
        datetime: "2025-05-28 10:01:23",
        type: "Walk In",
        rep: "K Lee",
        time: "12m 45s",
        salesStatus: "Demo",
        year: "2020",
        make: "Toyota",
        model: "Yaris",
        customer: "Ananya Sharma",
        source: "Facebook",
        image: "assets/img/users/user-11.jpg",
        dealType: "Lease",
        leadStatus: "Active"
      },
      {
        datetime: "2025-05-28 10:15:34",
        type: "Write In",
        rep: "L Singh",
        time: "13m 12s",
        salesStatus: "Contacted",
        year: "2019",
        make: "Honda",
        model: "Jazz",
        customer: "Deepak Jain",
        source: "Google Ads",
        image: "assets/img/users/user-12.jpg",
        dealType: "Cash",
        leadStatus: "Lost"
      },
      {
        datetime: "2025-05-28 10:25:11",
        type: "Walk In",
        rep: "M Kumar",
        time: "14m 00s",
        salesStatus: "Untouched",
        year: "2018",
        make: "Ford",
        model: "Escape",
        customer: "Rohit Yadav",
        source: "Instagram",
        image: "assets/img/users/user-13.jpg",
        dealType: "Lease",
        leadStatus: "Invalid"
      },
      {
        datetime: "2025-05-28 10:39:50",
        type: "Write In",
        rep: "N Patel",
        time: "11m 43s",
        salesStatus: "Dealer Visit",
        year: "2021",
        make: "Hyundai",
        model: "Venue",
        customer: "Jyoti Chauhan",
        source: "LinkedIn",
        image: "assets/img/users/user-14.jpg",
        dealType: "Cash",
        leadStatus: "Sold"
      },
      {
        datetime: "2025-05-28 10:52:03",
        type: "Walk In",
        rep: "O Khan",
        time: "12m 11s",
        salesStatus: "Walk In",
        year: "2023",
        make: "Nissan",
        model: "Murano",
        customer: "Bhavesh Thakur",
        source: "Twitter",
        image: "assets/img/users/user-15.jpg",
        dealType: "Lease",
        leadStatus: "Active"
      }
    ],
    missed: [
      {
        datetime: "2025-05-28 11:05:00",
        type: "Write In",
        rep: "P Lee",
        time: "16m 45s",
        salesStatus: "Demo",
        year: "2022",
        make: "Toyota",
        model: "Prius",
        customer: "Maya Gill",
        source: "Facebook",
        image: "assets/img/users/user-16.jpg",
        dealType: "Cash",
        leadStatus: "Lost"
      },
      {
        datetime: "2025-05-28 11:15:45",
        type: "Walk In",
        rep: "Q Singh",
        time: "21m 30s",
        salesStatus: "Contacted",
        year: "2021",
        make: "Honda",
        model: "Fit",
        customer: "Nitin Bansal",
        source: "Google Ads",
        image: "assets/img/users/user-17.jpg",
        dealType: "Lease",
        leadStatus: "Invalid"
      },
      {
        datetime: "2025-05-28 11:29:32",
        type: "Write In",
        rep: "R Kumar",
        time: "18m 15s",
        salesStatus: "Untouched",
        year: "2019",
        make: "Ford",
        model: "Edge",
        customer: "Nisha Kapoor",
        source: "Instagram",
        image: "assets/img/users/user-18.jpg",
        dealType: "Cash",
        leadStatus: "Duplicate"
      },
      {
        datetime: "2025-05-28 11:40:01",
        type: "Walk In",
        rep: "S Patel",
        time: "22m 10s",
        salesStatus: "Dealer Visit",
        year: "2020",
        make: "Hyundai",
        model: "Tucson",
        customer: "Devendra Joshi",
        source: "LinkedIn",
        image: "assets/img/users/user-19.jpg",
        dealType: "Lease",
        leadStatus: "Lost"
      },
      {
        datetime: "2025-05-28 11:55:18",
        type: "Write In",
        rep: "T Khan",
        time: "19m 22s",
        salesStatus: "Walk In",
        year: "2023",
        make: "Nissan",
        model: "Versa",
        customer: "Rekha Agarwal",
        source: "Twitter",
        image: "assets/img/users/user-20.jpg",
        dealType: "Cash",
        leadStatus: "Active"
      }
    ],
    nocontact: [
      {
        datetime: "2025-05-28 12:12:43",
        type: "Walk In",
        rep: "Jimmy",
        time: "0m 00s",
        salesStatus: "Demo",
        year: "2022",
        make: "Toyota",
        model: "Sienna",
        customer: "Arun Mehta",
        source: "Google",
        image: "assets/img/users/user-21.jpg",
        dealType: "Cash",
        leadStatus: "Active"
      },
      {
        datetime: "2025-05-28 12:23:01",
        type: "Write In",
        rep: "Alexa",
        time: "0m 00s",
        salesStatus: "Contacted",
        year: "2021",
        make: "Honda",
        model: "Odyssey",
        customer: "Chitra Sinha",
        source: "Facebook",
        image: "assets/img/users/user-22.jpg",
        dealType: "Lease",
        leadStatus: "Wishlist"
      },
      {
        datetime: "2025-05-28 12:34:28",
        type: "Walk In",
        rep: "Tom",
        time: "0m 00s",
        salesStatus: "Untouched",
        year: "2019",
        make: "Ford",
        model: "Explorer",
        customer: "Hemant Kulkarni",
        source: "Instagram",
        image: "assets/img/users/user-23.jpg",
        dealType: "Cash",
        leadStatus: "Active"
      },
      {
        datetime: "2025-05-28 12:48:19",
        type: "Write In",
        rep: "John Smith ",
        time: "0m 00s",
        salesStatus: "Dealer Visit",
        year: "2020",
        make: "Hyundai",
        model: "Santa Fe",
        customer: "Ishita Shah",
        source: "Twitter",
        image: "assets/img/users/user-24.jpg",
        dealType: "Lease",
        leadStatus: "Buy-In"
      },
      {
        datetime: "2025-05-28 13:00:00",
        type: "Walk In",
        rep: "Michael",
        time: "0m 00s",
        salesStatus: "Walk In",
        year: "2023",
        make: "Nissan",
        model: "Pathfinder",
        customer: "Jayant Mishra",
        source: "LinkedIn",
        image: "assets/img/users/user-25.jpg",
        dealType: "Cash",
        leadStatus: "Active"
      }
    ]
  };

// 🕒 Utility: Format datetime to 12-hour format
function formatDateTime(datetimeStr) {
  if (!datetimeStr) return '---';
  const dt = new Date(datetimeStr.replace(" ", "T"));
  const options = {
    year: "numeric",
    month: "short",
    day: "numeric",
    hour: "numeric",
    minute: "2-digit",
    hour12: true
  };
  return dt.toLocaleString("en-US", options);
}

// 🧮 Update table for Internet Response Time
function updateTable(type, container) {
  const data = dummyData[type] || [];
  const tbody = container.querySelector('#filter-details-body');
  const thead = container.querySelector('#filter-details thead tr');
  tbody.innerHTML = '';



  // ✅ Update table header dynamically
  if (thead) {
    thead.innerHTML = `
      <th>Date/Time</th>
      <th>Response Time</th>
      <th>Assigned To</th>
      <th>Assigned By</th>
      <th>Customer</th>
      <th>Vehicle</th>
      <th>Deal Type</th>
      <th>Source</th>
      <th>Status</th>
    `;
  }

  // ✅ Populate table rows
  data.forEach(row => {
    const responseTime = row.time && row.time.trim() !== '' ? row.time : '00ms';


    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${formatDateTime(row.datetime)}</td>
      <td>${responseTime}</td>
      <td>${row.rep || '---'}</td>
      <td>${row.assignedBy ? row.assignedBy : 'Primus CRM'}</td>
      <td style="text-decoration:underline;cursor:pointer;color:#000" 
          data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">${row.customer || '---'}</td>
      <td style="text-decoration:underline;cursor:pointer;color:#000" 
      data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo">${row.year && row.make && row.model ? `${row.year} ${row.make} ${row.model}` : '---'}</td>
      <td>${row.dealType || '---'}</td>
      <td>${row.source || '---'}</td>
      <td>${row.leadStatus || '---'}</td>
    `;
    tbody.appendChild(tr);
  });

  // ✅ Show table section
  container.querySelector('#filter-details').style.display = 'block';
}
function initInternetResponseChart(container) {
  const ctx = container.querySelector('#salesChart').getContext('2d');

  // Chart data
  const chartData = {
    labels: [
      'Responded in 0–5 Mins',
      'Responded in 6–10 Mins',
      'Responded in 11–15 Mins',
      'Responded in 16–30 Mins',
      'Responded in 31–60 Mins',
      'Responded in 61+ Mins',
      'No Contact Made'
    ],
    datasets: [{
      data: [30, 25, 20, 15, 12, 8, 10],
      backgroundColor: [
        '#28a745',
        '#6c757d',
        'rgb(0, 33, 64)',
        '#ffc107',
        '#17a2b8',
        '#6f42c1',
        '#dc3545'
      ],
      borderColor: '#ffffff',
      borderWidth: 3,
      borderRadius: 10,
      hoverOffset: 8
    }]
  };

  // Create chart
  const chart = new Chart(ctx, {
    type: 'doughnut',
    data: chartData,
    options: {
      responsive: true,
      cutout: '65%',
      plugins: {
        legend: { display: false },
        tooltip: {
          enabled: true,
          callbacks: {
            label: function(context) {
              const label = context.label || '';
              const value = context.parsed || 0;
              return `${label}: ${value}`;
            }
          }
        }
      },
      onClick: (evt, activeEls) => {
        if (!activeEls.length) return;
        const index = activeEls[0].index;

        // Highlight clicked slice
        chart.setActiveElements([{ datasetIndex: 0, index }]);
        chart.tooltip.setActiveElements([{ datasetIndex: 0, index }], { x: evt.offsetX, y: evt.offsetY });
        chart.update();

        // Map chart segment to table key
        const filterMap = ['under5', 'under10', 'under15', 'missed', 'missed', 'missed', 'nocontact'];
        updateTable(filterMap[index], container);
      }
    }
  });

  // --- Show default "No Contact Made" on page load ---
  const defaultIndex = 6; // "No Contact Made"
  chart.setActiveElements([{ datasetIndex: 0, index: defaultIndex }]);
  chart.tooltip.setActiveElements([{ datasetIndex: 0, index: defaultIndex }], { 
    x: chart.chartArea.left + chart.chartArea.width / 2, 
    y: chart.chartArea.top + chart.chartArea.height / 2 
  });
  chart.update();
  updateTable('nocontact', container);

  // Legend click handling
  container.querySelectorAll('.clickable-legend').forEach(item => {
    item.addEventListener('click', e => {
      const filterKey = e.currentTarget.dataset.filter;
      updateTable(filterKey, container);

      // Highlight corresponding chart slice
      let index = chartData.labels.findIndex(label => {
        return filterKey === 'under5' && label.includes('0–5') ||
               filterKey === 'under10' && label.includes('6–10') ||
               filterKey === 'under15' && label.includes('11–15') ||
               filterKey === 'nocontact' && label.includes('No Contact');
      });
      if (index < 0) index = null;

      chart.setActiveElements(index !== null ? [{ datasetIndex: 0, index }] : []);
      chart.tooltip.setActiveElements(index !== null ? [{ datasetIndex: 0, index }] : [], { x: 0, y: 0 });
      chart.update();
    });
  });

  // Dropdown filter clicks
  container.querySelectorAll('.filter-option').forEach(item => {
    item.addEventListener('click', e => {
      const filterKey = e.target.dataset.filter;
      updateTable(filterKey, container);

      // Clear chart highlights
      chart.setActiveElements([]);
      chart.tooltip.setActiveElements([], {});
      chart.update();
    });
  });
}

// Utility: Convert to 12-hour format
function formatDateTime(dateStr) {
  const dt = new Date(dateStr);
  if (isNaN(dt)) return dateStr;
  return dt.toLocaleString("en-US", {
    hour: "numeric",
    minute: "2-digit",
    hour12: true,
    month: "short",
    day: "numeric",
    year: "numeric"
  });
}

// Statuses in reversed order: bottom to top (Lost at bottom)
const statuses = [
  'Uncontacted',
  'Attempted',
  'Contacted',
  'Dealer Visit',
  'Demo',
  'Write Up',
  'Pending F&I',
  'Sold',
  'Delivered',
  'Lost'
];

// Global variable to track current selected status
let currentSelectedStatus = '';

// Example series data (random counts)
const seriesData = [{
  name: 'Leads Count',
  data: statuses.map(() => Math.floor(Math.random() * 20) + 1)
}];

// Function to toggle Sub-Lost Reason column visibility
function toggleSubLostReasonColumn(show) {
  const subLostReasonHeader = document.querySelector('.sub-lost-reason-col');
  const subLostReasonCells = document.querySelectorAll('.sub-lost-reason-cell');
  
  if (subLostReasonHeader) {
    subLostReasonHeader.style.display = show ? 'table-cell' : 'none';
  }
  
  subLostReasonCells.forEach(cell => {
    cell.style.display = show ? 'table-cell' : 'none';
  });
}

// Function to generate table rows based on status
function generateTableRows(status) {
  // Different data for Lost status vs other statuses
  let sampleData;
  
  if (status === 'Lost') {
    // Data for Lost status with Sub-Lost Reason
    sampleData = [
      ["2025-09-17T10:17:00", "Ali Khan", "John", "2022 Toyota Corolla", "Hot", "Cash", "Price too high", "Facebook", "New"],
      ["2025-09-17T14:45:00", "Sara Malik", "Ahmed", "2021 Honda Civic", "Warm", "Finance", "Found better deal elsewhere", "Website", "Used"],
      ["2025-09-17T09:30:00", "Imran", "Bilal", "2020 Kia Sportage", "Cold", "Lease", "Not interested anymore", "Walk-in", "New"]
    ];
    
    return sampleData.map(row => `
      <tr>
        <td>${formatDateTime(row[0])}</td>
        <td style="text-decoration:underline;cursor:pointer;color:#000" data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">${row[1]}</td>
        <td>${row[2]}</td>
        <td>Primus CRM</td>
        <td style="text-decoration:underline;cursor:pointer;color:#000" data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo">${row[3]}</td>
        <td>${row[4]}</td>
        <td>${row[5]}</td>
        <td class="sub-lost-reason-cell" style="display: table-cell;">${row[6]}</td>
        <td>${row[7]}</td>
        <td>${row[8]}</td>
      </tr>`).join("");
  } else {
    // Data for other statuses without Sub-Lost Reason
    sampleData = [
      ["2025-09-17T10:17:00", "Ali Khan", "John", "2022 Toyota Corolla", "Hot", "Cash", "Facebook", "New"],
      ["2025-09-17T14:45:00", "Sara Malik", "Ahmed", "2021 Honda Civic", "Warm", "Finance", "Website", "Used"],
      ["2025-09-17T09:30:00", "Imran", "Bilal", "2020 Kia Sportage", "Cold", "Lease", "Walk-in", "New"]
    ];
    
    return sampleData.map(row => `
      <tr>
        <td>${formatDateTime(row[0])}</td>
        <td style="text-decoration:underline;cursor:pointer;color:#000" data-bs-toggle="offcanvas" data-bs-target="#editVisitCanvas">${row[1]}</td>
        <td>${row[2]}</td>
        <td>Primus CRM</td>
        <td style="text-decoration:underline;cursor:pointer;color:#000" data-bs-toggle="offcanvas" data-bs-target="#editvehicleinfo">${row[3]}</td>
        <td>${row[4]}</td>
        <td>${row[5]}</td>
        <td class="sub-lost-reason-cell" style="display: none;">-</td>
        <td>${row[6]}</td>
        <td>${row[7]}</td>
      </tr>`).join("");
  }
}

// Chart Options
const options = {
  series: seriesData,
  chart: {
    type: 'bar',
    height: 420,
    toolbar: { show: false },
    foreColor: '#333',
    events: {
      dataPointSelection: function(event, chartContext, config) {
        currentSelectedStatus = statuses[config.dataPointIndex];
        const isLostStatus = currentSelectedStatus === 'Lost';

        // Show modal and table
        const modalElement = document.getElementById("dealflowModal");
        const tableContainer = document.getElementById("dealflowTableContainer");

        if (modalElement && tableContainer) {
          modalElement.classList.add('modal-backdrop-darken');
          tableContainer.style.display = 'block';
          tableContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        // Toggle Sub-Lost Reason column based on status
        toggleSubLostReasonColumn(isLostStatus);

        // Generate table rows based on status
        const tbody = document.getElementById("dealflowDetailsBody");
        if (tbody) {
          tbody.innerHTML = generateTableRows(currentSelectedStatus);
        }

        // Open modal
        if (modalElement && window.bootstrap && !modalElement.classList.contains('show')) {
          const modal = new bootstrap.Modal(modalElement);
          modal.show();
        }
      }
    }
  },
  plotOptions: {
    bar: {
      horizontal: false,
      columnWidth: '55%',
      borderRadius: 4
    }
  },
  colors: ['rgb(0, 33, 64)'],
  fill: { type: 'solid', opacity: 1 },
  dataLabels: { enabled: true },
  legend: { show: false },
  xaxis: {
    categories: statuses,
    title: { text: 'Status', style: { fontWeight: 600 } }
  },
  yaxis: {
    title: {
      text: "Leads\nCount",
      rotate: 0,
      offsetY: 0,
      offsetX: -30,
      style: {
        fontSize: '14px',
        fontWeight: 'bold',
        color: '#000',
        lineHeight: 1.2
      }
    }
  },
  grid: {
    borderColor: '#e0e0e0',
    strokeDashArray: 4
  },
  tooltip: { 
    enabled: false
    

  }
};

// Initialize Deal Flow Chart
function initDealFlowChart() {
  const chartElement = document.querySelector("#statusTimeline");
  if (chartElement && window.ApexCharts) {
    const chart = new ApexCharts(chartElement, options);
    chart.render();
  }
}



// Reset table visibility when modal is closed
(function(){
  const dealflowModalEl = document.getElementById('dealflowModal');
  if (!dealflowModalEl) return;

  dealflowModalEl.addEventListener('hidden.bs.modal', function () {
  const tableContainer = document.getElementById("dealflowTableContainer");
    const modalElement = dealflowModalEl;
  
  if (tableContainer) {
    tableContainer.style.display = 'none';
  }
  if (modalElement) {
    modalElement.classList.remove('modal-backdrop-darken');
  }
  
  // Reset column visibility for next time
    if (typeof toggleSubLostReasonColumn === 'function') toggleSubLostReasonColumn(false);
});
})();
function formatDateTime(dateString) {
  const date = new Date(dateString);
  if (isNaN(date)) return dateString; // handle invalid date

  const options = { month: 'short', day: 'numeric', year: 'numeric' };
  const formattedDate = date.toLocaleDateString("en-US", options);
  const formattedTime = date.toLocaleTimeString("en-US", { hour: '2-digit', minute: '2-digit', hour12: true });

  return `${formattedDate} ${formattedTime}`;
}


  // Heatmap functionality
  const heatmapTable = document.getElementById('heatmapTable');
  const typeRadios = document.querySelectorAll('input[name="heatmapType"]');
  const timeRangeSelect = document.getElementById('heatmapTimeRange');

  function formatHourBlock(hour) {
    const start = (hour % 12 === 0) ? 12 : hour % 12;
    const end = ((hour + 1) % 12 === 0) ? 12 : (hour + 1) % 12;
    const suffixStart = hour < 12 ? 'AM' : 'PM';
    const suffixEnd = (hour + 1) < 12 || (hour + 1) === 24 ? 'AM' : 'PM';
    return `${start}${suffixStart}–${end}${suffixEnd}`;
  }

  function getColor(value) {
    if (value === 0) return '#6c757d';
    if (value <= 3) return '#dc3545';
    if (value <= 7) return '#ff9800';
    if (value <= 12) return '#8bc34a';
    return '#28a745';
  }

  function generateFakeData(type, timeRange) {
    const days = 7;
    const hours = 24;
    const data = [];

    for (let i = 0; i < days; i++) {
      data[i] = [];
      for (let j = 0; j < hours; j++) {
        let base = {
          received: 20,
          responded: 10,
          appointments: 5
        }[type];

        let modifier = {
          today: 1,
          yesterday: 0.9,
          last7: 0.75,
          rolling30: 0.5
        }[timeRange];

        const value = Math.floor(Math.random() * base * modifier);
        data[i][j] = value;
      }
    }
    return data;
  }

  function populateHeatmap() {
    if (!heatmapTable) return;
    
    heatmapTable.innerHTML = '';

    const selectedTypeEl = document.querySelector('input[name="heatmapType"]:checked');
    const selectedType = selectedTypeEl ? selectedTypeEl.value : 'received';
    const selectedTime = timeRangeSelect ? timeRangeSelect.value : 'today';
    const data = generateFakeData(selectedType, selectedTime);

    const today = new Date();

    const thead = document.createElement('thead');
    const headRow = document.createElement('tr');
    headRow.innerHTML = '<th>Time</th>';
    for (let i = 0; i < 7; i++) {
      const date = new Date(today);
      date.setDate(today.getDate() - (6 - i));
      const dayName = date.toLocaleDateString('en-US', { weekday: 'short' });
      const dateStr = date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
      headRow.innerHTML += `<th>${dayName}<br>${dateStr}</th>`;
    }
    thead.appendChild(headRow);
    heatmapTable.appendChild(thead);

    const tbody = document.createElement('tbody');
    for (let hour = 0; hour < 24; hour++) {
      const row = document.createElement('tr');
      row.innerHTML = `<td>${formatHourBlock(hour)}</td>`;

      for (let day = 0; day < 7; day++) {
        const value = data[day][hour];
        const color = getColor(value);

        const cell = document.createElement('td');
        cell.innerText = value;
        cell.style.backgroundColor = color;
        cell.style.cursor = 'pointer';
        cell.dataset.value = value;
        cell.dataset.day = day;
        cell.dataset.hour = hour;
        cell.dataset.type = selectedType;
        cell.setAttribute('data-bs-toggle', 'modal');
        cell.setAttribute('data-bs-target', '#leadDetailModal');

        cell.addEventListener('click', () => {
          const leadDetailsContent = document.getElementById('leadDetailsContent');
          if (leadDetailsContent) {
            leadDetailsContent.innerHTML = `
              <strong>Type:</strong> ${selectedType.toUpperCase()}<br>
              <strong>Day:</strong> ${headRow.children[day + 1].innerText.replace('\n', ' ')}<br>
              <strong>Time:</strong> ${formatHourBlock(hour)}<br>
              <strong>Leads:</strong> ${value}<hr>
              <ul>
                <li>👤 John Doe — +123456789</li>
                <li>👤 Jane Smith — +987654321</li>
                <li>👤 Ahmed Ali — +111223344</li>
              </ul>
            `;
          }
        });

        row.appendChild(cell);
      }

      tbody.appendChild(row);
    }

    heatmapTable.appendChild(tbody);
  }

  // Event listeners for heatmap
  if (typeRadios) {
    typeRadios.forEach(r => r.addEventListener('change', populateHeatmap));
  }
  if (timeRangeSelect) {
    timeRangeSelect.addEventListener('change', populateHeatmap);
  }

  // Initialize heatmap when modal is shown
  const heatmapModal = document.getElementById('heatmapModal');
  if (heatmapModal) {
    heatmapModal.addEventListener('shown.bs.modal', () => {
      populateHeatmap();
    });
  }

  // Widget card click handlers
  document.querySelectorAll('.widget-card h6').forEach(viewBtn => {
    viewBtn.addEventListener('click', function () {
      const widgetText = this.closest('.widget-card').querySelector('p').textContent.trim();
     
      if (widgetText === 'Internet Response Time') {
        const previewContent = document.querySelector('#internetResponsePreview');
        if (previewContent) {
          const clonedContent = previewContent.cloneNode(true);
          clonedContent.classList.remove('d-none');
          const graphPreview = document.getElementById('graphPreview');
          if (graphPreview) {
            graphPreview.appendChild(clonedContent);
            initInternetResponseChart(clonedContent);
          }
        }
      }
      // Add other widget handlers here as needed
    });
  });

  // Modal event listeners
  // Internet Response Time Modal
  const internetResponseModal = document.getElementById('internetresponsetimeModal');
  if (internetResponseModal) {
    internetResponseModal.addEventListener('shown.bs.modal', function () {
      const container = this;
      
      // Prevent duplicate charts
      if (container.chartInitialized) return;
      container.chartInitialized = true;
      
      initInternetResponseChart(container);
    });
  }

  // Lead Source Mix Modal - THIS IS THE KEY FIX


  // Initialize Deal Flow Chart if element exists
  initDealFlowChart();

  // Initialize other charts/components on page load if needed
  // You can add other initialization calls here

});


    document.addEventListener('DOMContentLoaded', function () {
      const widgetsContainers = document.querySelectorAll('.widgets-container');
      if (widgetsContainers.length === 0) {
        // no widgets on this page — silent skip to avoid noisy console errors
        console.debug("No .widgets-container on page, skipping widget init.");
        return;
      }

      const isMobile = window.innerWidth <= 1024;

      widgetsContainers.forEach(function (container) {
        // Make sure all child widgets have unique IDs
        container.querySelectorAll('.widget-card').forEach((card, index) => {
          if (!card.id) card.id = container.id + '-widget-' + index;
        });

        // Load saved order from localStorage
        const savedOrder = localStorage.getItem(container.id);
        if (savedOrder) {
          const orderArray = JSON.parse(savedOrder);
          orderArray.forEach(id => {
            const el = document.getElementById(id);
            if (el) container.appendChild(el); // reorder DOM
          });
        }

        let options = {
          animation: 150,
          ghostClass: 'sortable-ghost',
          handle: '.widget-card',
          filter: '.ignore-drag',
          preventOnFilter: false,
          direction: 'vertical',
          swapThreshold: 0.65,
          fallbackOnBody: true,
          forceFallback: false,
          onEnd: function (evt) {
            console.log('Moved from', evt.oldIndex, 'to', evt.newIndex);
            // Save current order in localStorage
            const ids = Array.from(container.children).map(child => child.id);
            localStorage.setItem(container.id, JSON.stringify(ids));
          }
        };

        if (isMobile) {
          options.delay = 150;           // hold for mobile drag
          options.touchStartThreshold = 5;
          options.scroll = true;         // allow scrolling while dragging
        } else {
          options.delay = 0;             // instant drag for desktop
          options.forceFallback = false;
        }

        new Sortable(container, options);
      });

      console.log("✅ Sortable working with persistent order in localStorage");
    });




    document.querySelectorAll(".submenu > a").forEach(function (link) {
      link.addEventListener("click", function (e) {
        e.preventDefault();
        const parent = this.parentElement;
        const submenu = parent.querySelector("ul");

        // agar hidden hai to show karo
        if (submenu.style.display === "block") {
          submenu.style.display = "none";
          this.classList.remove("subdrop");
        } else {
          submenu.style.display = "block";
          this.classList.add("subdrop");
        }
      });
    });
