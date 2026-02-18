@props(['customerId'])

<div class="col-md-12" id="generalCustomerNotesSection" data-customer-id="{{ $customerId }}">
    <div class="card shadow-sm border-0 position-relative">

        <!-- Header -->
        <div class="card-body py-3 d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0">General Customer Notes</h6>

            <button id="toggleNotesBtn"
                    class="btn btn-sm btn-primary d-flex align-items-center"
                    style="border-radius:20px;">
                <span class="me-1">Open</span>
                <i class="bi bi-chevron-down"></i>
            </button>
        </div>

        <!-- Collapsible Content -->
        <div id="generalNotesContent" class="px-3 pb-3 d-none">

            <!-- Add Note Panel -->
            <div class="mb-3">
                <textarea
                    id="generalNoteText"
                    class="form-control"
                    rows="3"
                    placeholder="Write personal customer notes (birthday, family, preferences, vacations, etc.)"
                ></textarea>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between align-items-center mt-2">

                    <div class="d-flex gap-2">

                        <button id="recordAudioBtn" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-mic me-1"></i> Record Audio
                        </button>

                        <button id="recordVideoBtn" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-camera-video me-1"></i> Record Video
                        </button>

                        <video id="previewVideo" style="display:none;" autoplay muted width="200"></video>

                        <label class="btn btn-outline-secondary btn-sm mb-0">
                            <i class="bi bi-image me-1"></i> Attach Image
                            <input id="attachImageInput" type="file" accept="image/*" hidden>
                        </label>

                    </div>

                    <button id="addGeneralNoteBtn" class="btn btn-primary btn-sm">
                        Add Note
                    </button>

                </div>
            </div>

            <!-- Notes History -->
            <div>
                <h6 class="fw-bold mb-3">Notes History</h6>
                <div id="generalNotesHistory" class="d-flex flex-column gap-3"></div>
            </div>

        </div>
    </div>
</div>

<script>
    var toggleBtn = document.getElementById('toggleNotesBtn');
    var notesContent = document.getElementById('generalNotesContent');
    var addNoteBtn = document.getElementById('addGeneralNoteBtn');
    var notesHistory = document.getElementById('generalNotesHistory');
    var noteTextarea = document.getElementById('generalNoteText');
    var customerId = document.getElementById('generalCustomerNotesSection').dataset.customerId;
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Toggle open/close
    toggleBtn.addEventListener('click', function() {
        notesContent.classList.toggle('d-none');
        toggleBtn.querySelector('span').textContent = notesContent.classList.contains('d-none') ? 'Open' : 'Close';
        toggleBtn.querySelector('i').classList.toggle('bi-chevron-down');
        toggleBtn.querySelector('i').classList.toggle('bi-chevron-up');
    });

    // ---------- Add Text Note via AJAX ----------
    addNoteBtn.addEventListener('click', function() {
        var note = noteTextarea.value.trim();
        if (!note) return alert('Please enter a note.');

        var formData = new FormData();
        formData.append('customer_id', customerId);
        formData.append('note', note);

        fetch(`/customers/notes`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            prependNoteToHistory(data);
            noteTextarea.value = '';
        })
        .catch(err => { console.error(err); alert('Failed to add note.'); });
    });

    // ---------- Load existing notes ----------
    fetch(`/customers/${customerId}/notes`)
        .then(res => res.json())
        .then(data => {
            data.forEach(note => prependNoteToHistory(note));
        });

    function prependNoteToHistory(data) {
        var item = document.createElement('div');
        item.className = 'history-item border-bottom pb-2';

        var mediaHtml = '';
        if (data.audio_url) mediaHtml = `<audio controls src="${data.audio_url}"></audio>`;
        if (data.video_url) mediaHtml = `<video controls width="300" src="${data.video_url}"></video>`;
        if (data.image_url) mediaHtml = `<img src="${data.image_url}" style="max-width:200px;">`;

        item.innerHTML = `
            <div>
                <span class="fw-bold">${data.user_name}</span>
                <span class="text-muted ms-2">${data.created_at}</span>
            </div>
            <p class="mb-1 mt-1">${data.note}</p>
            ${mediaHtml}
        `;
        notesHistory.prepend(item);
    }

    // ---------- Record Audio ----------
    var mediaRecorder, audioChunks = [];
    var recordAudioBtn = document.getElementById('recordAudioBtn');

    recordAudioBtn.addEventListener('click', async function() {
        if (mediaRecorder && mediaRecorder.state === "recording") {
            mediaRecorder.stop();
            this.textContent = ' Record Audio';
            this.querySelector('i').className = 'bi bi-mic me-1';
            return;
        }
        var stream = await navigator.mediaDevices.getUserMedia({ audio: true });
        mediaRecorder = new MediaRecorder(stream);
        audioChunks = [];
        mediaRecorder.ondataavailable = e => audioChunks.push(e.data);
        mediaRecorder.onstop = async () => {
            var blob = new Blob(audioChunks, { type: 'audio/webm' });
            var formData = new FormData();
            formData.append('customer_id', customerId);
            formData.append('note', 'Audio note');
            formData.append('audio', blob, 'audio_note.webm');

            fetch(`/customers/notes`, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken }, body: formData })
                .then(res => res.json()).then(data => prependNoteToHistory(data));
        };
        mediaRecorder.start();
        this.textContent = ' Stop Recording';
        this.querySelector('i').className = 'bi bi-stop-circle me-1';
    });

    // ---------- Record Video ----------
    var videoRecorder, videoChunks = [];
    var recordVideoBtn = document.getElementById('recordVideoBtn');
    var previewVideo = document.getElementById('previewVideo');

    recordVideoBtn.addEventListener('click', async function() {
        if (videoRecorder && videoRecorder.state === "recording") {
            videoRecorder.stop();
            previewVideo.style.display = 'none';
            this.textContent = ' Record Video';
            this.querySelector('i').className = 'bi bi-camera-video me-1';
            return;
        }
        var stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
        previewVideo.srcObject = stream;
        previewVideo.style.display = 'block';

        videoRecorder = new MediaRecorder(stream);
        videoChunks = [];
        videoRecorder.ondataavailable = e => videoChunks.push(e.data);
        videoRecorder.onstop = async () => {
            var blob = new Blob(videoChunks, { type: 'video/webm' });
            var formData = new FormData();
            formData.append('customer_id', customerId);
            formData.append('note', 'Video note');
            formData.append('video', blob, 'video_note.webm');

            fetch(`/customers/notes`, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken }, body: formData })
                .then(res => res.json()).then(data => prependNoteToHistory(data));

            stream.getTracks().forEach(track => track.stop());
            previewVideo.style.display = 'none';
        };
        videoRecorder.start();
        this.textContent = ' Stop Recording';
        this.querySelector('i').className = 'bi bi-stop-circle me-1';
    });

    // ---------- Attach Image ----------
    document.getElementById('attachImageInput').addEventListener('change', function() {
        var file = this.files[0];
        if (!file) return;

        var formData = new FormData();
        formData.append('customer_id', customerId);
        formData.append('note', 'Image note');
        formData.append('image', file);

        fetch(`/customers/notes`, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken }, body: formData })
            .then(res => res.json())
            .then(data => prependNoteToHistory(data));
    });

</script>
