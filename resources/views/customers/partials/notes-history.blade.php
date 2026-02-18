{{-- Notes & History Section - resources/views/customers/partials/notes-history.blade.php --}}

@props(['customerId', 'users' => []])

<div class="col-md-12" id="notesHistory" data-requires-deal style="display:none;">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold mb-0">Notes & History</h6>
                <select class="form-select form-select-sm" id="historyTypeFilter" style="width:auto;" onchange="loadNotes()">
                    <option value="">All</option>
                    <option value="call_inbound">Inbound Call</option>
                    <option value="call_outbound">Outbound Call</option>
                    <option value="Showroom Visit">Showroom Visit</option>
                    <option value="Note">Notes</option>
                </select>
            </div>

            {{-- Showroom Visit Component --}}
            @include('customers.partials.showroom-visit')

            {{-- Add Note --}}
            <div class="mb-3">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="privateNote">
                    <label class="form-check-label" for="privateNote">Private Note</label>
                </div>
                <div class="mb-2">
                    <select id="tagUsers" multiple class="form-select form-select-sm">
                        @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <textarea id="noteText" class="form-control mb-2" rows="3" placeholder="Type a note…"></textarea>
                <button id="addNoteBtn" class="btn btn-primary btn-sm" onclick="addNote()">Add Note</button>
            </div>

            {{-- History --}}
            <h6 class="fw-bold mb-3">Recent History</h6>
            <div id="recentHistory" class="d-flex flex-column gap-3">
                <p class="text-muted text-center">Select a deal to view history</p>
            </div>
            <div class="text-center mt-3">
                <button id="showMoreHistory" class="btn btn-light border btn-sm" onclick="loadMoreHistory()">Show More</button>
            </div>
        </div>
    </div>
</div>
  <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>


<script>

       new TomSelect("#tagUsers", {
        plugins: ['remove_button'],
        create: false,
        onChange: function(values) {
          renderUserInitials(values);
        }
      });

      function renderUserInitials(userIds) {
        let users = {
          "1": "John Smith",
          "2": "Sarah Johnson",
          "3": "David Brown",
          "4": "Emily Davis"
        };
        let container = document.getElementById("taggedUsersInitials");
        container.innerHTML = "";
        userIds.forEach(id => {
          let name = users[id];
          let initials = name.split(" ").map(n => n[0]).join("");
          let badge = `<span class="badge bg-secondary rounded-circle p-2 me-1" data-bs-toggle="tooltip" title="${name}">${initials}</span>`;
          container.innerHTML += badge;
        });
        new bootstrap.Tooltip(document.body, { selector: '[data-bs-toggle="tooltip"]' });
      }
var notesPage = 1;

document.addEventListener('deal:selected', function(e) {
    notesPage = 1;
    loadNotes();
});

async function loadNotes() {
    if (!AppState.currentDealId) return;
    const container = document.getElementById('recentHistory');
    const filter = document.getElementById('historyTypeFilter').value;
    
    try {
        let url = `/api/notes?customer_id={{ $customerId }}&deal_id=${AppState.currentDealId}&page=${notesPage}`;
        if (filter) url += `&type=${filter}`;
        
        const result = await api(url);
        const notes = result.data || [];
        
        const html = notes.length ? notes.map(note => `
            <div class="history-item border-bottom pb-2">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="fw-bold">${note.created_by?.name || 'System'}</span>
                        <span class="text-muted ms-2">${new Date(note.created_at).toLocaleDateString()}</span>
                    </div>
                    <span class="badge bg-light text-dark">${note.type || 'Note'}</span>
                </div>
                <p class="mb-0 mt-1">${note.description}</p>
            </div>
        `).join('') : '<p class="text-muted text-center">No history yet</p>';
        
        if (notesPage === 1) {
            container.innerHTML = html;
        } else {
            container.insertAdjacentHTML('beforeend', html);
        }
    } catch (error) {
        container.innerHTML = '<p class="text-danger text-center">Failed to load history</p>';
    }
}

async function addNote() {
    const text = document.getElementById('noteText').value.trim();
    if (!text || !AppState.currentDealId) return;
    
    try {
        await api('/api/notes', 'POST', {
            customer_id: {{ $customerId }},
            deal_id: AppState.currentDealId,
            description: text,
            type: 'Note',
            is_private: document.getElementById('privateNote').checked
        });
        document.getElementById('noteText').value = '';
        showToast('Note added');
        loadNotes();
    } catch (error) {
        showToast('Failed to add note', 'error');
    }
}

function loadMoreHistory() {
    notesPage++;
    loadNotes();
}
</script>