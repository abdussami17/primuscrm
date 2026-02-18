<script>
(function(){
    if (window.__noteFallbackInstalled) return;
    window.__noteFallbackInstalled = true;

    document.addEventListener('click', function(e){
        const btn = e.target.closest && e.target.closest('#saveNoteBtn');
        if (!btn) return;
        e.preventDefault();

        const noteInput = document.getElementById('noteInput');
        const noteHistoryContainer = document.getElementById('noteHistoryContainer');
        const text = noteInput ? noteInput.value.trim() : '';
        if (!text) { alert('Please enter a note.'); return; }

        const state = window.taskNotesState || {};
        const taskId = state.currentTaskId;
        const customerId = state.currentCustomerId;
        if (!taskId || !customerId) { alert('No task selected.'); return; }

        if (btn.disabled) return;
        btn.disabled = true;

        fetch(`/task-notes/tasks/${taskId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ description: text })
        })
        .then(r => r.json())
        .then(data => {
            if (!data || data.status !== 'success') {
                alert(data && data.message ? data.message : 'Failed to save note');
                return;
            }

            const noteEntry = document.createElement('div');
            noteEntry.className = 'note-entry border-bottom pb-2 mb-2';
            noteEntry.innerHTML = `\n                <div class="fw-bold">${(new Date(data.note.created_at)).toLocaleString()} <span class="text-muted">by ${data.note.createdBy}</span></div>\n                <div class="mt-1">${data.note.description}</div>\n            `;

            if (noteHistoryContainer) noteHistoryContainer.prepend(noteEntry);
            if (noteInput) noteInput.value = '';
            if (typeof Swal !== 'undefined') Swal.fire({ icon: 'success', title: 'Note saved', timer: 2000, showConfirmButton: false });
        })
        .catch(err => {
            console.error(err);
            alert('Something went wrong');
        })
        .finally(() => { btn.disabled = false; });

    }, false);
})();


    document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('filterTable');
    const headers = table.querySelectorAll('thead tr:first-child th:not(.no-sort)');
    let draggingHeader = null;
    let draggingIndex = null;

    headers.forEach(th => {
      th.setAttribute('draggable', true);

      th.addEventListener('dragstart', function(e) {
          draggingHeader = this;
          draggingIndex = [...this.parentNode.children].indexOf(this);
          this.classList.add('dragging');
          e.dataTransfer.effectAllowed = 'move';
      });

      th.addEventListener('dragover', function(e) {
          e.preventDefault();
          e.dataTransfer.dropEffect = 'move';
          if (this !== draggingHeader) this.classList.add('drag-over');
      });

      th.addEventListener('dragleave', function() { this.classList.remove('drag-over'); });

      th.addEventListener('drop', function(e) {
          e.preventDefault();
          if (this !== draggingHeader) {
              const targetIndex = [...this.parentNode.children].indexOf(this);
              moveColumn(draggingIndex, targetIndex);
          }
          this.classList.remove('drag-over');
      });

      th.addEventListener('dragend', function() {
          this.classList.remove('dragging');
          headers.forEach(h => h.classList.remove('drag-over'));
      });
    });

    function moveColumn(from, to) {
      const rows = table.querySelectorAll('tr');
      rows.forEach(row => {
          const cells = [...row.children];
          const movingCell = cells[from];
          if (from < to) {
              row.insertBefore(movingCell, cells[to].nextSibling);
          } else {
              row.insertBefore(movingCell, cells[to]);
          }
      });
    }

    // Initialize Bootstrap tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
    });
    </script>


    <script>
    document.addEventListener("DOMContentLoaded", () => {
      const aiBtn = document.getElementById('aiBtn');
      const aiModalEl = document.getElementById('aiModal');
      const loader = document.getElementById('aiLoader');
      const results = document.getElementById('aiResults');
      const applyBtn = document.getElementById('applyAI');
      const aiModal = new bootstrap.Modal(aiModalEl);
      const tableBody = document.querySelector('#filterTable tbody');

      const viewNoteModalEl = document.getElementById('viewfullnote');
      const viewNoteModal = new bootstrap.Modal(viewNoteModalEl);
      const noteHistoryContainer = document.getElementById('noteHistoryContainer');
      const noteInput = document.getElementById('noteInput');
      const saveNoteBtn = document.getElementById('saveNoteBtn');
      const tagUsers = document.getElementById('tagUsers');
      const taggedUsersInitials = document.getElementById('taggedUsersInitials');
      const recordAudioBtn = document.getElementById('recordAudioBtn');
      const recordVideoBtn = document.getElementById('recordVideoBtn');

            // Enhance Tag Users select to a nicer multi-select dropdown using TomSelect
            try {
                if (tagUsers && typeof TomSelect !== 'undefined') {
                    new TomSelect(tagUsers, {
                        plugins: ['remove_button'],
                        maxItems: null,
                        hideSelected: true,
                        closeAfterSelect: false,
                        placeholder: 'Select users...'
                    });
                }
            } catch (e) {
                console.warn('TomSelect init for #tagUsers failed', e);
            }

      let isAISorted = false;
      let originalOrder = [];
      let currentTaskRow = null;

      // Sort states for columns
      let sortStates = {
          10: 0, // Due Date/Time
          11: 0, // Created Date
          14: 0, // Assigned Date
          15: 0  // Notes
      };

      // Date formatting function
      function formatDate(dateString) {
          const date = new Date(dateString);
          const months = ['January', 'February', 'March', 'April', 'May', 'June',
                          'July', 'August', 'September', 'October', 'November', 'December'];
          const month = months[date.getMonth()];
          const day = date.getDate();
          const year = date.getFullYear();
          let hours = date.getHours();
          const minutes = date.getMinutes();
          const ampm = hours >= 12 ? 'PM' : 'AM';
          hours = hours % 12;
          hours = hours ? hours : 12;
          const minutesStr = minutes < 10 ? '0' + minutes : minutes;

          return `${month} ${day}, ${year} — ${hours}:${minutesStr} ${ampm}`;
      }

      // Store original order
      function storeOriginalOrder() {
          originalOrder = Array.from(tableBody.querySelectorAll('tr'));
      }

      storeOriginalOrder();

      // AI Priority Button Click
      aiBtn.addEventListener('click', () => {
          aiModal.show();
          loader.classList.remove('d-none');
          results.classList.add('d-none');
          applyBtn.classList.add('d-none');

          setTimeout(() => {
              loader.classList.add('d-none');
              results.classList.remove('d-none');
              applyBtn.classList.remove('d-none');
          }, 1500);
      });

      // Apply AI Sorting
      applyBtn.addEventListener('click', () => {
          const rows = Array.from(tableBody.querySelectorAll('tr'));
          const today = new Date();
          today.setHours(0, 0, 0, 0);

          const categorized = rows.map(row => {
              const dueDateStr = row.getAttribute('data-due-date');
              const dueDate = new Date(dueDateStr);
              dueDate.setHours(0, 0, 0, 0);

              let category;
              let statusDot = row.querySelector('.status-dot');

              if (dueDate < today) {
                  category = 'overdue';
                  if (statusDot) {
                      statusDot.className = 'status-dot overdue';
                  }
              } else if (dueDate.getTime() === today.getTime()) {
                  category = 'today';
                  if (statusDot) {
                      statusDot.className = 'status-dot today';
                  }
              } else {
                  category = 'future';
                  if (statusDot) {
                      statusDot.className = 'status-dot future';
                  }
              }

              return { row, category, dueDate };
          });

          categorized.sort((a, b) => {
              const order = { overdue: 1, today: 2, future: 3 };
              if (order[a.category] !== order[b.category]) {
                  return order[a.category] - order[b.category];
              }
              return a.dueDate - b.dueDate;
          });

          tableBody.innerHTML = '';
          categorized.forEach(item => {
              tableBody.appendChild(item.row);
          });

          isAISorted = true;
          aiModal.hide();
      });

      // Priority info icon tooltip
      document.addEventListener('click', (e) => {
          if (e.target.classList.contains('priority-info-icon')) {
              e.preventDefault();
              e.stopPropagation();

              document.querySelectorAll('.priority-tooltip').forEach(t => t.remove());

              const icon = e.target;
              const row = icon.closest('tr');
              const reason = row.getAttribute('data-priority-reason');

              const tooltip = document.createElement('div');
              tooltip.className = 'priority-tooltip';
              tooltip.textContent = reason;
              tooltip.style.display = 'block';

              document.body.appendChild(tooltip);

              const rect = icon.getBoundingClientRect();
              tooltip.style.top = (rect.top - tooltip.offsetHeight - 5 + window.scrollY) + 'px';
              tooltip.style.left = (rect.left - tooltip.offsetWidth / 2 + icon.offsetWidth / 2) + 'px';

              setTimeout(() => tooltip.remove(), 3000);
          } else if (!e.target.classList.contains('priority-info-icon')) {
              document.querySelectorAll('.priority-tooltip').forEach(t => t.remove());
          }
      });

      // View Notes Modal
    window.taskNotesState = window.taskNotesState || { currentTaskId: null, currentCustomerId: null };

document.addEventListener('click', function (e) {
    const link = e.target.closest('.view-notes-link');
    if (!link) return;

    e.preventDefault();

        window.taskNotesState.currentTaskId = link.dataset.taskId || null;
        window.taskNotesState.currentCustomerId = link.dataset.customerId || null;

        const currentTaskId = window.taskNotesState.currentTaskId;

        noteHistoryContainer.innerHTML = '<p class="text-muted">Loading notes...</p>';

        fetch(`/task-notes/tasks/${currentTaskId}`)
        .then(res => res.json())
        .then(data => {

            noteHistoryContainer.innerHTML = '';

                if (!data.notes || !data.notes.length) {
                    noteHistoryContainer.innerHTML = '<p class="text-muted">No notes available yet.</p>';
                return;
            }

            data.notes.forEach(note => {
                const div = document.createElement('div');
                div.className = 'note-entry border-bottom pb-2 mb-2';
                div.innerHTML = `
                    <div class="fw-bold">
                        ${formatDate(note.date)}
                        <span class="text-muted">by ${note.createdBy}</span>
                    </div>
                    <div class="mt-1">${note.text}</div>
                `;
                noteHistoryContainer.appendChild(div);
            });
        })
        .catch(() => {
                noteHistoryContainer.innerHTML = '<p class="text-danger">Failed to load notes.</p>';
        });

    noteInput.value = '';
});

document.addEventListener('DOMContentLoaded', function () {

    // -----------------------------
    // GLOBAL STATE
    // -----------------------------
    window.taskNotesState = window.taskNotesState || { currentTaskId: null, currentCustomerId: null };

    const noteInput = document.getElementById('noteInput');
    const saveNoteBtn = document.getElementById('saveNoteBtn');
    const noteHistoryContainer = document.getElementById('noteHistoryContainer');

    // -----------------------------
    // OPEN NOTES MODAL (SET TASK)
    // -----------------------------
    document.addEventListener('click', function (e) {
        const link = e.target.closest('.view-notes-link');
        if (!link) return;

        e.preventDefault();

        window.taskNotesState.currentTaskId = link.dataset.taskId || null;
        window.taskNotesState.currentCustomerId = link.dataset.customerId || null;

        if (!window.taskNotesState.currentTaskId || !window.taskNotesState.currentCustomerId) {
            alert('Task or Customer not found.');
            return;
        }

        // Clear old input (optional)
        noteInput.value = '';
    });

    // -----------------------------
    // SAVE NOTE
    // -----------------------------
    // Attach save handler robustly. If the button exists now, bind directly. Otherwise use delegated click.
    function handleSaveNoteClick() {
        const noteText = noteInput.value.trim();

        if (!noteText) {
            alert('Please enter a note.');
            return;
        }

        const currentTaskId = window.taskNotesState.currentTaskId;
        const currentCustomerId = window.taskNotesState.currentCustomerId;

        if (!currentTaskId || !currentCustomerId) {
            alert('No task selected.');
            return;
        }

        fetch(`/task-notes/tasks/${currentTaskId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content')
            },
            body: JSON.stringify({ description: noteText })
        })
        .then(res => res.json())
        .then(data => {
             console.log(data);
            if (data.status !== 'success') {
                alert(data.message || 'Failed to save note');
                return;
            }

            // Create note UI
            const noteEntry = document.createElement('div');
            noteEntry.className = 'note-entry border-bottom pb-2 mb-2';
            noteEntry.innerHTML = `
                <div class="fw-bold">
                    ${formatDate(data.note.created_at)}
                    <span class="text-muted">by ${data.note.createdBy}</span>
                </div>
                <div class="mt-1">${data.note.description}</div>
            `;

            // Add note to top
            noteHistoryContainer.prepend(noteEntry);

            // Reset input
            noteInput.value = '';

            if (typeof Swal !== 'undefined') {
                Swal.fire({ icon: 'success', title: 'Success', text: 'Note saved successfully', timer: 3000, showConfirmButton: false });
            }
        })
        .catch(err => {
            console.error(err);
            alert('Something went wrong.');
        });
    }

    if (saveNoteBtn) {
        saveNoteBtn.addEventListener('click', handleSaveNoteClick);
    } else {
        // Delegated listener in case modal/button isn't present at initial binding time
        document.addEventListener('click', function (e) {
            if (e.target.closest && e.target.closest('#saveNoteBtn')) {
                handleSaveNoteClick();
            }
    });
    }

});

      // Tag users change event
      tagUsers.addEventListener('change', () => {
          const selectedOptions = Array.from(tagUsers.selectedOptions);

          taggedUsersInitials.innerHTML = '';
          selectedOptions.forEach(option => {
              const name = option.textContent;
              const initials = name.split(' ').map(n => n[0]).join('');
              const badge = document.createElement('span');
              badge.className = 'tagged-user-badge';
              badge.textContent = initials;
              badge.title = name;
              taggedUsersInitials.appendChild(badge);
          });
      });

      // Record audio/video buttons
      recordAudioBtn.addEventListener('click', () => {
          alert('🎤 Audio recording feature would be implemented here');
      });

      recordVideoBtn.addEventListener('click', () => {
          alert('🎥 Video recording feature would be implemented here');
      });

      // Sort Arrow Click Handler
      document.querySelectorAll('.sort-arrow').forEach(arrow => {
          arrow.addEventListener('click', function() {
              const colIndex = parseInt(this.getAttribute('data-sort-col'));
              sortColumn(colIndex);
          });
      });

      function sortColumn(colIndex) {
          const rows = Array.from(tableBody.querySelectorAll('tr'));

          // Increment sort state (0 -> 1 -> 2 -> 0)
          sortStates[colIndex] = (sortStates[colIndex] + 1) % 3;
          const currentState = sortStates[colIndex];

          // Reset all other column sort states
          Object.keys(sortStates).forEach(key => {
              if (parseInt(key) !== colIndex) {
                  sortStates[key] = 0;
              }
          });



          if (currentState === 0) {
              // Reset to original order
              tableBody.innerHTML = '';
              originalOrder.forEach(row => {
                  tableBody.appendChild(row);
              });
              return;
          }

          // Special handling for Notes column (15)
          if (colIndex === 15) {
              sortByNotes(rows, currentState);
              return;
          }

          // Sort by date columns
          rows.sort((a, b) => {
              let dateA, dateB;

              if (colIndex === 10) { // Due Date/Time
                  dateA = new Date(a.getAttribute('data-due-date'));
                  dateB = new Date(b.getAttribute('data-due-date'));
              } else if (colIndex === 11) { // Created Date
                  dateA = new Date(a.getAttribute('data-created-date'));
                  dateB = new Date(b.getAttribute('data-created-date'));
              } else if (colIndex === 14) { // Assigned Date
                  dateA = new Date(a.getAttribute('data-assigned-date'));
                  dateB = new Date(b.getAttribute('data-assigned-date'));
              }

              if (currentState === 1) {
                  return dateA - dateB; // Ascending
              } else {
                  return dateB - dateA; // Descending
              }
          });

          tableBody.innerHTML = '';
          rows.forEach(row => {
              tableBody.appendChild(row);
          });
      }

      function sortByNotes(rows, state) {
          // Separate rows with notes and without notes
          const withNotes = [];
          const withoutNotes = [];

          rows.forEach(row => {
              const notesData = JSON.parse(row.getAttribute('data-notes') || '[]');
              const noteCell = row.cells[15];
              const noteText = noteCell ? noteCell.textContent.trim() : '';

              if (notesData.length > 0 || noteText.length > 0) {
                  withNotes.push({ row, notesData });
              } else {
                  withoutNotes.push(row);
              }
          });

          // Sort rows with notes by most recent note date
          withNotes.sort((a, b) => {
              const dateA = a.notesData.length > 0 ? new Date(a.notesData[0].date) : new Date(0);
              const dateB = b.notesData.length > 0 ? new Date(b.notesData[0].date) : new Date(0);
              return dateB - dateA; // Most recent first
          });

          // Sort blank rows by created date
          withoutNotes.sort((a, b) => {
              const dateA = new Date(a.getAttribute('data-created-date'));
              const dateB = new Date(b.getAttribute('data-created-date'));
              return dateA - dateB; // Oldest first
          });

          // Clear and rebuild table
          tableBody.innerHTML = '';

          if (state === 1) {
              // First click: Notes at top, blanks at bottom
              withNotes.forEach(item => tableBody.appendChild(item.row));
              withoutNotes.forEach(row => tableBody.appendChild(row));
          } else {
              // Second click: Blanks at top, notes at bottom
              withoutNotes.forEach(row => tableBody.appendChild(row));
              withNotes.forEach(item => tableBody.appendChild(item.row));
          }
      }

      // Restore default order
      function restoreDefaultOrder() {
          if (isAISorted) {
              tableBody.innerHTML = '';
              originalOrder.forEach(row => {
                  tableBody.appendChild(row);
              });
              isAISorted = false;
          }
      }

      window.restoreDefaultOrder = restoreDefaultOrder;
    });
    </script>



<script>
    let currentNotesRowId = null;
    let checkboxFilterInstances = {};
    let activeFilterDropdown = null;

    document.addEventListener("DOMContentLoaded", function () {
        const table = document.getElementById("filterTable");
        const filtersRow = document.getElementById("filtersRow");
        const filterWrappers = filtersRow.querySelectorAll(".filter-wrapper");
        const rows = Array.from(table.querySelectorAll("tbody tr"));

        // Centralized filter state management
        const filterState = {
            currentOpenFilter: null,
            isApplyingFilter: false
        };

        // Helper function to determine if value is blank
        function isBlankValue(value) {
            if (value === null || value === undefined) return true;
            const strValue = String(value).trim();
            return strValue === '' || strValue === 'N/A' || strValue === '-' || strValue === 'null' || strValue === 'undefined';
        }

        // Extract text from cell considering various content types
        function extractTextFromCell(cell) {
            if (!cell) return '';

            // Check for badge first (priority indicator)
            const badge = cell.querySelector('span.badge, .badge');
            if (badge) return badge.textContent.trim();

            // Check for link with text content
            const link = cell.querySelector('a');
            if (link && link.textContent.trim()) return link.textContent.trim();

            // Check for nested text in divs
            const innerDiv = cell.querySelector('div');
            if (innerDiv && innerDiv.textContent.trim()) return innerDiv.textContent.trim();

            // Fallback to cell text
            return cell.textContent.trim();
        }

        // Format date consistently
        function formatDateForFilter(dateStr) {
            if (!dateStr) return '';
            try {
                const date = new Date(dateStr);
                if (isNaN(date.getTime())) return dateStr;

                const months = [
                    'January', 'February', 'March', 'April', 'May', 'June',
                    'July', 'August', 'September', 'October', 'November', 'December'
                ];
                return `${months[date.getMonth()]} ${date.getDate()}, ${date.getFullYear()}`;
            } catch (e) {
                return dateStr;
            }
        }

        // Extract value from row for specific column
        function getCellValue(row, colIndex) {
            if (colIndex === 13) { // Due Date
                const dateStr = row.getAttribute('data-due-date');
                return formatDateForFilter(dateStr);
            } else if (colIndex === 14) { // Created Date
                const dateStr = row.getAttribute('data-created-date');
                return formatDateForFilter(dateStr);
            } else if (colIndex === 17) { // Assigned Date
                const dateStr = row.getAttribute('data-assigned-date');
                return formatDateForFilter(dateStr);
            } else if (colIndex === 18) { // Notes column
                const notesData = JSON.parse(row.getAttribute('data-notes') || '[]');
                const cellText = extractTextFromCell(row.cells[colIndex]);

                if (notesData.length > 0) {
                    return notesData.map(note => note.text?.trim()).filter(text => text).join(' ') || cellText;
                }
                return cellText;
            } else {
                const cell = row.cells[colIndex];
                return cell ? extractTextFromCell(cell) : '';
            }
        }

        // Initialize all filter dropdowns
        function initializeFilterDropdowns() {
            filterWrappers.forEach((wrapper) => {
                const colIndex = parseInt(wrapper.getAttribute("data-col"));

                // Skip if already initialized
                if (wrapper.querySelector(".filter-dropdown-trigger")) return;

                // Create filter trigger button
                const triggerBtn = document.createElement("button");
                triggerBtn.className = "btn btn-sm btn-light filter-dropdown-trigger w-100 text-start";
                triggerBtn.type = "button";
                triggerBtn.innerHTML = `
                    <span class="filter-text">Filter</span>
                    <span class="filter-icon float-end"><i class="ti ti-caret-down-filled ms-1"></i></span>
                `;
                triggerBtn.setAttribute("data-col", colIndex);

                wrapper.appendChild(triggerBtn);

                // Initialize filter data for this column
                initializeFilterData(colIndex);

                // Add click event
                triggerBtn.addEventListener("click", function(e) {
                    e.stopPropagation();
                    toggleFilterDropdown(colIndex, this);
                });
            });
        }

        // Initialize filter data for a specific column
        function initializeFilterData(colIndex) {
            const values = new Set();
            const hasAnyValues = rows.some(row => {
                const value = getCellValue(row, colIndex);
                return !isBlankValue(value);
            });

            // Collect all unique values from the column
            rows.forEach(row => {
                const value = getCellValue(row, colIndex);
                if (!isBlankValue(value) && value) {
                    values.add(value);
                }
            });

            // Initialize filter instance - always show (Blanks) option
            checkboxFilterInstances[colIndex] = {
                values: Array.from(values).sort(),
                // ALWAYS set hasBlanks to true to show (Blanks) option for all columns
                hasBlanks: true, // This is the key change - always true
                selectedValues: new Set(),
                triggerBtn: null,
                selectAllChecked: false,
                columnHasData: hasAnyValues // Track if column has any non-blank values
            };
        }

        // Toggle filter dropdown visibility
        function toggleFilterDropdown(colIndex, triggerBtn) {
            // Close any currently open dropdown
            if (activeFilterDropdown) {
                activeFilterDropdown.remove();
                activeFilterDropdown = null;
            }

            // Create dropdown element
            const dropdown = document.createElement("div");
            dropdown.className = "checkbox-filter-dropdown card shadow-lg";
            dropdown.style.position = "absolute";
            dropdown.style.zIndex = "1060";
            dropdown.style.minWidth = "250px";
            dropdown.style.maxHeight = "400px";
            dropdown.style.overflow = "hidden";

            // Position the dropdown relative to the trigger button
            const rect = triggerBtn.getBoundingClientRect();
            dropdown.style.top = (rect.bottom + window.scrollY) + "px";
            dropdown.style.left = (rect.left + window.scrollX) + "px";

            // Get filter data
            const filterData = checkboxFilterInstances[colIndex];
            if (!filterData) return;

            // Store reference to trigger button
            filterData.triggerBtn = triggerBtn;

            // Build dropdown content
            dropdown.innerHTML = `
                <div class="card-body p-3">
                    <div class="checkbox-filter-header">
                        <div class="form-check mb-2">
                            <input class="form-check-input select-all-checkbox" type="checkbox"
                                   id="selectAllCheckbox_${colIndex}"
                                   ${filterData.selectAllChecked ? 'checked' : ''}>
                            <label class="form-check-label fw-semibold" for="selectAllCheckbox_${colIndex}">
                                Select All
                            </label>
                        </div>
                        <input type="text" class="form-control form-control-sm mb-2 search-filter-input"
                               placeholder="Search options..." data-col="${colIndex}">
                    </div>
                    <div class="checkbox-filter-options" style="max-height: 250px; overflow-y: auto;">
                        ${generateCheckboxOptions(colIndex, filterData)}
                    </div>
                    <div class="checkbox-filter-footer mt-3 pt-2 border-top">
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-sm btn-primary apply-filter-btn" data-col="${colIndex}">
                                Apply Filter
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary clear-filter-btn" data-col="${colIndex}">
                                Clear
                            </button>
                        </div>
                        <div class="mt-2 small text-muted selected-count" data-col="${colIndex}">
                            Selected: ${filterData.selectedValues.size}
                        </div>
                    </div>
                </div>
            `;

            document.body.appendChild(dropdown);
            activeFilterDropdown = dropdown;
            filterState.currentOpenFilter = colIndex;

            // Initialize dropdown interactions
            initializeDropdownInteractions(colIndex, dropdown);

            // Set up click outside handler
            setTimeout(() => {
                const clickOutsideHandler = (e) => {
                    if (!dropdown.contains(e.target) && e.target !== triggerBtn) {
                        dropdown.remove();
                        activeFilterDropdown = null;
                        filterState.currentOpenFilter = null;
                        document.removeEventListener('click', clickOutsideHandler);
                    }
                };
                document.addEventListener('click', clickOutsideHandler);
            }, 10);
        }

        // Generate HTML for checkbox options - ALWAYS includes (Blanks)
        function generateCheckboxOptions(colIndex, filterData) {
            let html = '';

            // ALWAYS add (Blanks) option for consistency across all columns
            const isBlanksChecked = filterData.selectedValues.has('(Blanks)') || filterData.selectAllChecked;
            html += `
                <div class="form-check mb-1">
                    <input class="form-check-input filter-checkbox" type="checkbox"
                           value="(Blanks)" id="blank_${colIndex}"
                           data-col="${colIndex}" ${isBlanksChecked ? 'checked' : ''}>
                    <label class="form-check-label" for="blank_${colIndex}">
                        <span class="text-muted">(Blanks)</span>
                    </label>
                </div>
            `;

            // Add regular value options if they exist
            if (filterData.values && filterData.values.length > 0) {
                filterData.values.forEach((value, index) => {
                    const isChecked = filterData.selectedValues.has(value) || filterData.selectAllChecked;
                    html += `
                        <div class="form-check mb-1">
                            <input class="form-check-input filter-checkbox" type="checkbox"
                                   value="${value}" id="opt_${colIndex}_${index}"
                                   data-col="${colIndex}" ${isChecked ? 'checked' : ''}>
                            <label class="form-check-label" for="opt_${colIndex}_${index}">
                                ${value}
                            </label>
                        </div>
                    `;
                });
            } else {
                // Show message if no other values exist
                html += `
                    <div class="small text-muted p-2">
                        No other values in this column
                    </div>
                `;
            }

            return html;
        }

        // Initialize dropdown interactions
        function initializeDropdownInteractions(colIndex, dropdown) {
            const filterData = checkboxFilterInstances[colIndex];
            const selectAllCheckbox = dropdown.querySelector('.select-all-checkbox');
            const searchInput = dropdown.querySelector('.search-filter-input');
            const applyBtn = dropdown.querySelector('.apply-filter-btn');
            const clearBtn = dropdown.querySelector('.clear-filter-btn');
            const selectedCount = dropdown.querySelector('.selected-count');
            const optionsContainer = dropdown.querySelector('.checkbox-filter-options');

            // Update UI based on selection state
            function updateUI() {
                const allCheckboxes = optionsContainer.querySelectorAll('.filter-checkbox');
                const checkedCheckboxes = Array.from(allCheckboxes).filter(cb => cb.checked);

                // Update select all state
                selectAllCheckbox.checked = checkedCheckboxes.length === allCheckboxes.length;
                selectAllCheckbox.indeterminate = checkedCheckboxes.length > 0 &&
                                                checkedCheckboxes.length < allCheckboxes.length;

                // Update selected count
                selectedCount.textContent = `Selected: ${checkedCheckboxes.length}`;

                // Update trigger button text
                const triggerBtn = filterData.triggerBtn;
                if (triggerBtn) {
                    const filterText = triggerBtn.querySelector('.filter-text');
                    if (checkedCheckboxes.length === 0) {
                        filterText.textContent = 'Filter';
                    } else {
                        filterText.textContent = `Filter (${checkedCheckboxes.length})`;
                    }
                }
            }

            // Search functionality
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                const checkboxes = optionsContainer.querySelectorAll('.form-check');

                checkboxes.forEach(div => {
                    const label = div.querySelector('label');
                    const text = label.textContent.toLowerCase();
                    div.style.display = text.includes(searchTerm) ? 'block' : 'none';
                });
            });

            // Select All functionality
            selectAllCheckbox.addEventListener('change', function() {
                const allCheckboxes = optionsContainer.querySelectorAll('.filter-checkbox');
                const wasChecked = filterData.selectAllChecked;

                // Toggle all checkboxes
                allCheckboxes.forEach(cb => {
                    cb.checked = this.checked;
                    if (this.checked) {
                        filterData.selectedValues.add(cb.value);
                    } else {
                        filterData.selectedValues.delete(cb.value);
                    }
                });

                filterData.selectAllChecked = this.checked;
                updateUI();
            });

            // Individual checkbox functionality
            optionsContainer.addEventListener('change', function(e) {
                if (e.target.classList.contains('filter-checkbox')) {
                    const checkbox = e.target;

                    if (checkbox.checked) {
                        filterData.selectedValues.add(checkbox.value);
                    } else {
                        filterData.selectedValues.delete(checkbox.value);
                        filterData.selectAllChecked = false;
                    }

                    updateUI();
                }
            });

            // Apply filter
            applyBtn.addEventListener('click', function() {
                closeDropdown();
                applyAllFilters();
            });

            // Clear filter
            clearBtn.addEventListener('click', function() {
                // Clear all selections
                filterData.selectedValues.clear();
                filterData.selectAllChecked = false;

                // Uncheck all checkboxes
                const allCheckboxes = optionsContainer.querySelectorAll('.filter-checkbox');
                allCheckboxes.forEach(cb => cb.checked = false);

                // Update UI and apply filter
                updateUI();
                closeDropdown();
                applyAllFilters();
            });

            // Close dropdown
            function closeDropdown() {
                if (activeFilterDropdown) {
                    activeFilterDropdown.remove();
                    activeFilterDropdown = null;
                    filterState.currentOpenFilter = null;
                }
            }

            // Initial UI update
            updateUI();
        }

        // Apply all active filters
        function applyAllFilters() {
            // Reset all rows to visible
            rows.forEach(row => row.style.display = '');

            // Apply each column filter
            Object.entries(checkboxFilterInstances).forEach(([colIndexStr, filterData]) => {
                const colIndex = parseInt(colIndexStr);

                // Skip if no filter is applied for this column
                if (filterData.selectedValues.size === 0) return;

                // Filter rows based on this column
                rows.forEach(row => {
                    if (row.style.display === 'none') return; // Already hidden by another filter

                    const cellValue = getCellValue(row, colIndex);
                    let matches = false;

                    // Check against selected values
                    for (const selectedValue of filterData.selectedValues) {
                        if (selectedValue === '(Blanks)') {
                            if (isBlankValue(cellValue)) {
                                matches = true;
                                break;
                            }
                        } else if (selectedValue === cellValue) {
                            matches = true;
                            break;
                        }
                    }

                    // Hide row if it doesn't match any selected value
                    if (!matches) {
                        row.style.display = 'none';
                    }
                });
            });

            updateRowCount();
            updateSelectAllCheckboxState();
        }

        // Update visible row count
        function updateRowCount() {
            const visibleCount = rows.filter(row => row.style.display !== 'none').length;
            console.log(`Showing ${visibleCount} of ${rows.length} rows`);
            // You could update a counter display here if needed
        }

        // Update the main select all checkbox state
        function updateSelectAllCheckboxState() {
            const selectAllCheckbox = document.getElementById("select-all");
            if (!selectAllCheckbox) return;

            const visibleRows = rows.filter(row => row.style.display !== 'none');
            const visibleCheckboxes = visibleRows.flatMap(row =>
                Array.from(row.querySelectorAll(".form-check-input:not(#select-all)"))
            );

            if (visibleCheckboxes.length === 0) {
                selectAllCheckbox.checked = false;
                selectAllCheckbox.indeterminate = false;
                return;
            }

            const checkedCount = visibleCheckboxes.filter(cb => cb.checked).length;
            selectAllCheckbox.checked = checkedCount === visibleCheckboxes.length;
            selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < visibleCheckboxes.length;
        }

        // Initialize main table select all checkbox
        function initializeSelectAllCheckbox() {
            const selectAllCheckbox = document.getElementById("select-all");
            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener("change", function () {
                    const visibleRows = rows.filter(row => row.style.display !== 'none');
                    const visibleCheckboxes = visibleRows.flatMap(row =>
                        Array.from(row.querySelectorAll(".form-check-input:not(#select-all)"))
                    );

                    visibleCheckboxes.forEach(cb => {
                        cb.checked = this.checked;
                    });
                });

                // Update select all state when individual checkboxes change
                table.addEventListener("change", function (e) {
                    if (e.target.classList.contains("form-check-input") && e.target.id !== "select-all") {
                        updateSelectAllCheckboxState();
                    }
                });
            }
        }

        // Initialize everything
        function initialize() {
            initializeFilterDropdowns();
            initializeSelectAllCheckbox();
            applyAllFilters(); // Apply any initial filters (none initially)
        }

        // Start the initialization
        initialize();
    });
  </script>


<script>
document.addEventListener('DOMContentLoaded', function() {

  // -----------------------------
  // VARIABLES
  // -----------------------------
  let customers = [];
  let selectedCustomer = null;
  let selectedDeal = null;
    window.phoneScriptSelect = window.phoneScriptSelect || null;

  const customerInput = document.getElementById("customerSearchModal");
  const suggestionsBox = document.getElementById("customerSuggestionsModal");
  const dealSection = document.getElementById("dealSectionModal");
  const dealList = document.getElementById("dealListModal");
  const descriptionField = document.getElementById("descriptionFieldModal");
  const charCount = document.getElementById("charCountModal");
  const taskForm = document.getElementById("taskFormModal");
  const dueDatePicker = document.getElementById("dueDatePickerModal");

  const phoneScriptsDB = [
    { id: "s1", name: "Follow-up Call", body: "Hi, I'm calling to follow up on your recent inquiry..." },
    { id: "s2", name: "Sales Introduction", body: "Hello! I wanted to tell you about our latest offers..." },
    { id: "s3", name: "Service Reminder", body: "Good morning! Your vehicle is due for maintenance..." },
    { id: "s4", name: "Feedback Request", body: "Hi there! We'd love to hear about your experience..." },
    { id: "s5", name: "Appointment Confirmation", body: "Thank you for scheduling with us. Your appointment is..." }
  ];

  // -----------------------------
  // FLATPICKR INIT
  // -----------------------------
  flatpickr(dueDatePicker, {
    minDate: "today",
    dateFormat: "Y-m-d",
    theme: "light"
  });

  // -----------------------------
  // TOMSELECT INIT FOR PHONE SCRIPTS
  // -----------------------------
    window.phoneScriptSelect = new TomSelect("#phoneScriptSelectModal", {
    options: phoneScriptsDB.map(script => ({
      value: script.id,
      text: script.name
    })),
    items: [],
    maxItems: 1,
    placeholder: "Search & select script...",
    searchField: 'text',
    allowEmptyOption: true,
    closeAfterSelect: true
  });

    // -----------------------------
    // FETCH CUSTOMERS FROM API (include credentials so session auth works)
    // -----------------------------
    fetch('/customers/all', { credentials: 'same-origin' })
        .then(async res => {
            if (!res.ok) {
                const text = await res.text().catch(() => '');
                console.error('Failed to fetch customers:', res.status, text);
                return {};
            }
            return res.json().catch(() => ({}));
        })
        .then(res => {
            if (res && res.success) {
                customers = res.customers || [];
            } else {
                console.warn('customers API returned unexpected payload', res);
            }
        })
        .catch(err => console.error('Error fetching customers:', err));

  // -----------------------------
  // FUZZY MATCH FUNCTION
  // -----------------------------
  function isFuzzyMatch(a, b) {
    a = (a || '').toLowerCase(); // handle null
    b = b.toLowerCase();
    let mismatch = 0;
    for (let i = 0; i < Math.max(a.length, b.length); i++) {
      if (a[i] !== b[i]) mismatch++;
      if (mismatch > 2) return false;
    }
    return true;
  }

  // -----------------------------
  // CUSTOMER SEARCH INPUT
  // -----------------------------
  customerInput.addEventListener("input", () => {
    const search = customerInput.value.toLowerCase().trim();
    suggestionsBox.innerHTML = "";

    if (!search) {
      suggestionsBox.classList.add("d-none");
      return;
    }

    const matches = customers.filter(c => {
      const name = c.name || '';
      const email = c.email || '';
      const phone = c.phone || '';
      return (
        isFuzzyMatch(name, search) ||
        email.toLowerCase().includes(search) ||
        phone.includes(search)
      );
    });

    if (matches.length === 0) {
      suggestionsBox.classList.add("d-none");
      return;
    }

    matches.forEach(c => {
      const displayName = c.name || c.email; // fallback to email
      const item = document.createElement("a");
      item.href = "#";
      item.className = "list-group-item list-group-item-action";
      item.innerHTML = `<strong>${displayName}</strong><br><small>${c.email} - ${c.phone}</small>`;
      item.addEventListener("click", (e) => {
        e.preventDefault();
        customerInput.value = displayName;
        suggestionsBox.classList.add("d-none");
        selectedCustomer = c;
        selectedDeal = null;
        showDeals(c.deals);
      });
      suggestionsBox.appendChild(item);
    });

    suggestionsBox.classList.remove("d-none");
  });

  // -----------------------------
  // SHOW DEALS FOR SELECTED CUSTOMER
  // -----------------------------
  function showDeals(deals) {
     console.log(deals);
        const dealListEl = document.getElementById('dealListModal');
        const dealSectionEl = document.getElementById('dealSectionModal');
        if (!dealListEl || !dealSectionEl) return console.warn('Deal list or section element missing');

        dealListEl.innerHTML = '';
        dealSectionEl.classList.remove('d-none');

    deals.forEach(deal => {
            const dealItem = document.createElement('a');
            dealItem.href = '#';
            dealItem.className = 'list-group-item list-group-item-action';
      dealItem.textContent = `${deal.year} - Deal #${deal.dealNumber}`;
      dealItem.dataset.id = deal.id;
            dealItem.addEventListener('click', (e) => {
        e.preventDefault();
         selectedDeal = deal;
        highlightSelected(dealItem);
      });
            dealListEl.appendChild(dealItem);
    });
  }

  function highlightSelected(item) {
    document.querySelectorAll("#dealListModal a").forEach(i => i.classList.remove("active"));
    item.classList.add("active");
  }

  // -----------------------------
  // DESCRIPTION CHAR COUNT
  // -----------------------------
  descriptionField.addEventListener("input", () => {
    const length = descriptionField.value.length;
    charCount.textContent = Math.min(length, 140);
    if (length > 140) descriptionField.value = descriptionField.value.substring(0, 140);
    charCount.parentElement.classList.toggle("warning", length >= 120);
  });

  // -----------------------------
  // TASK FORM SUBMIT
  // -----------------------------

 taskForm.addEventListener("submit", function (e) {
    e.preventDefault();

    if (!selectedCustomer) return alert("Please select a customer.");
    if (!selectedDeal) return alert("Please select a deal.");

    const taskId = document.getElementById("taskIdModal").value;
    const isEdit = taskId !== "";

    // Safely read TomSelect value (guard if not initialized)
    const scriptValue = (window.phoneScriptSelect && typeof window.phoneScriptSelect.getValue === 'function')
        ? (window.phoneScriptSelect.getValue()[0] || null)
        : null;

    const payload = {
        customer_id: selectedCustomer.id,
        deal_number: selectedDeal.dealNumber,
        deal_id: selectedDeal.id,
        due_date: dueDatePicker.value,
        assigned_to: document.getElementById("assignedToModal").value,
        status_type: document.getElementById("statusTypeModal").value,
        task_type: document.getElementById("taskTypeModal").value,
        priority: document.getElementById("priorityModal").value,
        script: scriptValue,
        description: descriptionField.value
    };

    if (isEdit) payload._method = "PUT"; // Important for Laravel

    $.ajax({
        url: isEdit ? `/tasks/update/${taskId}` : "{{ route('tasks.store') }}",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        data: payload,
        success: function(response) {
            console.log("AJAX success:", response);
            if (response && response.status && String(response.status).toLowerCase() === 'success') {
                try { $('#add_modal').modal('hide'); } catch(e) {}
                resetForm();
                fetchTasks();

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message || 'Task added successfully',
                        timer: 3000,
                        showConfirmButton: false
                    });
                }
            } else {
                console.warn('Unexpected success response:', response);
                const msg = (response && response.message) ? response.message : 'Unexpected response from server';
                if (typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'error', title: 'Error', text: msg });
                } else {
                    alert(msg);
                }
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX error:", status, error, xhr);

            // Try to parse validation errors or JSON response
            let message = 'An error occurred while saving the task.';
            try {
                const json = xhr.responseJSON || (xhr.responseText ? JSON.parse(xhr.responseText) : null);
                if (json) {
                    if (json.message) message = json.message;
                    if (json.errors) {
                        const all = Object.values(json.errors).flat().join('\n');
                        message = all || message;
                    }
                }
            } catch (e) {
                // ignore parse errors
            }

            if (typeof Swal !== 'undefined') {
                Swal.fire({ icon: 'error', title: 'Error', text: message });
            } else {
                alert(message);
            }
        }
    });
});


  // -----------------------------
  // RESET FORM
  // -----------------------------
  function resetForm() {
    taskForm.reset();
    selectedCustomer = null;
    selectedDeal = null;
        const dealSectionEl = document.getElementById('dealSectionModal');
        const dealListEl = document.getElementById('dealListModal');
        if (dealSectionEl) dealSectionEl.classList.add('d-none');
        if (dealListEl) dealListEl.innerHTML = '';
        charCount.textContent = '0';
        if (charCount && charCount.parentElement) charCount.parentElement.classList.remove('warning');
        try { if (window.phoneScriptSelect && typeof window.phoneScriptSelect.clear === 'function') window.phoneScriptSelect.clear(); } catch (e) {}
  }

  // -----------------------------
  // CLICK OUTSIDE TO CLOSE SUGGESTIONS
  // -----------------------------
  document.addEventListener("click", (e) => {
    if (!customerInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
      suggestionsBox.classList.add("d-none");
    }
  });
});


document.addEventListener('DOMContentLoaded', function () {
    fetchTasks();
});

function fetchTasks() {
    $.ajax({
        url: "{{ route('tasks.all') }}",
        type: "GET",
        success: function (res) {
            if (res.status === 'success') {
                renderTasks(res.data);
            }
        },
        error: function (err) {
            console.error(err);
        }
    });
}

function renderTasks(tasks) {
    const tbody = document.querySelector("tbody");
    tbody.innerHTML = "";

    tasks.forEach(task => {
        tbody.innerHTML += `
<tr
 data-due-date="${task.due_date}"
 data-created-date="${task.created_at}"
 data-assigned-date="${task.updated_at}"
 data-priority-reason="${task.description}"

data-task-id="${task.id}"
  data-customer-id="${task.customer?.id ?? ''}"
    data-notes='${JSON.stringify(task.notes.map(note => ({
        id: note.id,
        text: note.description,
        date: note.created_at,
        by: note.created_by?.name ?? "Unknown"
    })))}'
>
<td>
  <div class="form-check">
    <input class="form-check-input" type="checkbox">
  </div>
</td>

<td>${task.priority ?? '-'}</td>

<td>
  <span class="status-dot today"></span>
${formatTaskType(task.task_type)}

  <span class="priority-info-icon">i</span>
</td>

<td>${task.assigned_user?.name ?? '-'}</td>

<td>${task.deal?.deal_type ?? 'Walk-In'}</td>

<td>
  <a class="fw-semibold text-decoration-underline customer-link"
   style="cursor:pointer"
   href="#"
   data-url="/customers/${task.customer_id}/edit"
   data-ajax-popup="true"
   data-title="Customer Details">
   ${task.customer?.first_name ?? '-'}
</a>

</td>

<td>
  <div class="vehicle-info">
    <div class="text-decoration-underline text-primary fw-semibold"
         style="cursor:pointer"
         data-bs-toggle="offcanvas"
         data-bs-target="#editvehicleinfo">
         ${task.deal?.vehicle_description ?? ''}
    </div>
  </div>
</td>

<td>${task.deal?.source ?? 'Referral'}</td>

<td>${task.status_type ?? 'Not Completed'}</td>

<td>
  <span class="badge bg-warning">
    ${task.priority ?? 'Pending'}
  </span>
</td>

<!-- New Data Columns -->
<td>${task.created_by?.name ?? 'System Auto-Assign'}</td>
<td>${task.created_at ?? '-'}</td>
<td></td>
<!-- End -->

<td>${task.due_date ?? '-'}</td>
<td>${task.created_at ?? '-'}</td>
<td>${task.created_by?.name ?? 'Admin User'}</td>
<td>${task.assigned_user?.name ?? 'Manager'}</td>
<td>${task.updated_at ?? '-'}</td>

<td style="white-space:normal;">
  <div class="note-area">
    ${task.notes.length ? task.notes[0].description : ''}
    <a href="#" class="view-notes-link" data-bs-toggle="modal" data-customer-id="${task.customer.id}"  data-task-id="${task.id }" data-bs-target="#viewfullnote">
      <i class="fas fa-edit" title="View & Edit Notes"></i>
    </a>
  </div>
</td>


<td>
  <a href="#" data-bs-toggle="dropdown">
    <i class="fas fa-ellipsis-v"></i>
  </a>
  <ul class="dropdown-menu">

    <li><a class="dropdown-item edit-task" data-bs-toggle="modal" data-bs-target="#add_modal" data-id="${task.id}" href="#">Edit Task</a></li>
    <li><a class="dropdown-item delete-task text-danger" data-id="${task.id}" href="#">Delete Task</a></li>
  </ul>
</td>
</tr>
`;
    });
}
function formatTaskType(value) {
  if (!value) return '-';

  return value
    .replace(/_/g, ' ')
    .replace(/\b\w/g, char => char.toUpperCase());
}
$(document).on('click', '.edit-task', function (e) {
    e.preventDefault();
    let taskId = $(this).data('id');

    $.ajax({
        url: `/tasks/edit/${taskId}`,
        type: 'GET',
        success: function (res) {
            if (res.status === 'success') {

                fillTaskForm(res.data);
                $('#add_modal').modal('show');
            }
        }
    });
});

function fillTaskForm(task) {
    console.log(task);

    document.getElementById("taskIdModal").value = task.id;
    $('#dueDatePickerModal').val(task.due_date);
    $('#assignedToModal').val(task.assigned_to);
    $('#statusTypeModal').val(task.status_type);
    $('#taskTypeModal').val(task.task_type);
    $('#priorityModal').val(task.priority);
    document.getElementById("descriptionFieldModal").value = task.description ?? "";

    // Normalize customer so frontend always has an id
    const cust = task.customer || {};
    const customerId = cust.id ?? task.customer_id ?? null;
    const displayName = (cust.first_name || cust.last_name)
        ? `${cust.first_name || ''} ${cust.last_name || ''}`.trim()
        : (cust.name || cust.email || '');

    selectedCustomer = {
        id: customerId,
        name: displayName,
        email: cust.email,
        phone: cust.phone,
        deals: cust.deals || []
    };

    const customerInputEl = document.getElementById("customerSearchModal");
    if (customerInputEl) customerInputEl.value = selectedCustomer.name || selectedCustomer.email || "";

    // Normalize deal
    selectedDeal = task.deal ?? null;
    const customerDeals = (cust.deals && Array.isArray(cust.deals)) ? cust.deals : [];
    if (customerDeals.length) {
        showDeals1(customerDeals, task.deal?.id ?? selectedDeal?.id ?? null);
    } else if (selectedDeal) {
        showDeals1([selectedDeal], selectedDeal.id);
    } else {
        console.warn("No deals found for this customer");
    }

    // Phone script (guarded)
    try { if (window.phoneScriptSelect && typeof window.phoneScriptSelect.clear === 'function') window.phoneScriptSelect.clear(); } catch(e) {}
    if (task.script) {
        try { if (window.phoneScriptSelect && typeof window.phoneScriptSelect.addItem === 'function') window.phoneScriptSelect.addItem(task.script); } catch(e) {}
    }
}

function showDeals1(deals, selectedDealId = null) {
    const dealListEl = document.getElementById('dealListModal');
    const dealSectionEl = document.getElementById('dealSectionModal');
    if (!dealListEl || !dealSectionEl) return console.warn('Deal list or section element missing');

    dealListEl.innerHTML = '';
    dealSectionEl.classList.remove('d-none');

    deals.forEach(deal => {
        const dealItem = document.createElement('a');
        dealItem.href = '#';
        dealItem.className = 'list-group-item list-group-item-action';
        dealItem.textContent = `${deal.year || 'N/A'} - Deal #${deal.dealNumber}`;
        dealItem.dataset.id = deal.id;

        dealItem.addEventListener('click', (e) => {
            e.preventDefault();
            selectedDeal = deal;
            highlightSelected1(dealItem);
        });

        // ✅ AUTO SELECT by ID, convert both to string to be safe
        if (selectedDealId && String(deal.id) === String(selectedDealId)) {
            selectedDeal = deal; // assign the exact deal object from customer.deals
            dealItem.classList.add('active');
        }

        dealListEl.appendChild(dealItem);
    });

    // ✅ If no deal is selected, pick the first one automatically
    if (!selectedDeal && deals.length > 0) {
        selectedDeal = deals[0];
        const first = dealListEl.querySelector('a');
        if (first) first.classList.add('active');
    }
}

  function highlightSelected1(item) {
    document.querySelectorAll("#dealListModal a").forEach(i => i.classList.remove("active"));
    item.classList.add("active");
  }

let deleteTaskId = null;

// Open modal when delete button is clicked
$(document).on('click', '.delete-task', function() {
    deleteTaskId = $(this).data('id'); // store task/customer id
    $('#delete_modal').modal('show');
});

// Handle "Yes, Delete" click
$('#confirm_delete_btn').on('click', function() {
    if (!deleteTaskId) return;

    $.ajax({
        url: `/tasks/delete/${deleteTaskId}`, // Laravel route
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            $('#delete_modal').modal('hide'); // hide modal

            if (data.status === 'success') {
                // Remove the task row from table
                $(`.delete-task[data-id="${deleteTaskId}"]`).closest('tr').remove();

                // Optional: show success toast
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: data.message || 'Task has been deleted.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: data.message || 'Failed to delete task.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            }

            deleteTaskId = null;
        },
        error: function(err) {
            $('#delete_modal').modal('hide'); // hide modal
            console.error('Delete error:', err);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'An error occurred while deleting the task.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            deleteTaskId = null;
        }
    });
});


</script>
