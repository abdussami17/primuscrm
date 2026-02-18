<div>
  <form id="socialFormServer">
    <div class="mb-3">
      <label class="form-label">{{ ucfirst($platform) }} URL</label>
      <input type="url" id="socialUrlInputServer" class="form-control" placeholder="https://" value="{{ $url }}">
      <div class="form-text">Enter the customer's social media profile URL</div>
    </div>
    <div class="d-flex justify-content-between">
      <div>
        <button type="button" class="btn btn-outline-danger" id="removeSocialBtnServer">Remove</button>
      </div>
      <div>
        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="saveSocialBtnServer">Save</button>
      </div>
    </div>
  </form>
</div>

<script>
  // Wire server-side modal buttons to reuse existing handlers via parent window
  document.getElementById('saveSocialBtnServer')?.addEventListener('click', async function(){
    const url = document.getElementById('socialUrlInputServer').value;
    // POST to same endpoint as client expects
    const res = await fetch(`/customers/{{ $customer->id }}/social/{{ $platform }}`, {
      method: 'POST',
      credentials: 'same-origin',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify({ url })
    });

    if (res.ok) {
      const data = await res.json().catch(()=>({}));
      // close modal and show toast
      const modalEl = document.getElementById('customerSocialModal');
      bootstrap.Modal.getInstance(modalEl).hide();
      Swal.fire({ title: 'Saved', icon: 'success', timer: 1000, showConfirmButton: false });
    } else {
      Swal.fire({ title: 'Error', text: 'Failed to save social link.', icon: 'error' });
    }
  });

  document.getElementById('removeSocialBtnServer')?.addEventListener('click', async function(){
    const res = await fetch(`/customers/{{ $customer->id }}/social/{{ $platform }}`, {
      method: 'DELETE',
      credentials: 'same-origin',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      }
    });

    if (res.ok) {
      const modalEl = document.getElementById('customerSocialModal');
      bootstrap.Modal.getInstance(modalEl).hide();
      Swal.fire({ title: 'Removed', icon: 'success', timer: 900, showConfirmButton: false });
    } else {
      Swal.fire({ title: 'Error', text: 'Failed to remove social link.', icon: 'error' });
    }
  });
</script>