<div class="modal fade" id="customerImport" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            
            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title">
                    Import Customers
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <form id="customerImportForm" 
                      action="{{ route('customers.import') }}" 
                      method="POST" 
                      enctype="multipart/form-data">
                    
                    @csrf

                    <!-- File Upload -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Upload Excel / CSV File
                        </label>
                        <input type="file"
                               name="file"
                               class="form-control"
                               accept=".xlsx,.csv"
                               required>
                        <small class="text-muted">
                            Supported formats: .xlsx, .csv
                        </small>
                    </div>

                    <!-- Import Options -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Import Options
                        </label>

                        <div class="form-check mb-1">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="update_existing"
                                   value="1"
                                   id="updateExisting">
                            <label class="form-check-label" for="updateExisting">
                                Update existing customers (match by email)
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="skip_duplicates"
                                   value="1"
                                   id="skipDuplicates"
                                   checked>
                            <label class="form-check-label" for="skipDuplicates">
                                Skip duplicate records
                            </label>
                        </div>
                    </div>

                    <!-- Sample File -->
                    <div class="mb-3">
                        <a href="{{ route('customers.import.sample') }}"
                           class="text-decoration-none btn btn-primary">
                            Download sample Excel template
                        </a>
                    </div>

                    <!-- Success / Error Area -->
                    <div class="alert alert-success d-none" id="importSuccess"></div>
                    <div class="alert alert-danger d-none" id="importErrors"></div>

                    <!-- Footer Buttons -->
                    <div class="d-flex  justify-content-end gap-2">
                        <button type="button"
                                class="btn btn-light"
                                data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit"
                                class="btn btn-primary">
                            Import Customers
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('customerImportForm');
    const errorsDiv = document.getElementById('importErrors');
    const successDiv = document.getElementById('importSuccess');

    if (!form) return;

    // When true, reload page once modal is closed so user can read report
    let importReportShown = false;

    // reload page after modal closed if a report was shown
    const modalEl = document.getElementById('customerImport');
    if (modalEl) {
        modalEl.addEventListener('hidden.bs.modal', function () {
            if (importReportShown) {
                window.location.reload();
            }
        });
    }

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
            errorsDiv.classList.add('d-none');
        errorsDiv.innerHTML = '';
        successDiv.classList.add('d-none');
        successDiv.innerHTML = '';

        const submitBtn = form.querySelector('button[type="submit"]');
        const formData = new FormData(form);

        if (submitBtn) { submitBtn.disabled = true; submitBtn.textContent = 'Importing...'; }

        try {
            const res = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData,
                credentials: 'same-origin'
            });

            const contentType = res.headers.get('content-type') || '';
            // Try parse JSON when available
            if (contentType.indexOf('application/json') !== -1) {
                const data = await res.json();
                if (res.ok && data.success) {
                    const msg = data.message || 'File uploaded successfully.';
                    let html = `<div>${msg}</div>`;
                    if (data.report) {
                        html += `<div class="mt-2"><strong>Imported:</strong> ${data.report.imported}</div>`;
                        if (data.report.rows && data.report.rows.length) {
                            html += `<div class="mt-2"><strong>Unmapped assignments:</strong><ul>`;
                            data.report.rows.forEach(r => {
                                html += `<li>Row ${r.row}: ${r.issue} — ${r.value}</li>`;
                            });
                            html += `</ul></div>`;
                        }
                        if (data.report.errors && data.report.errors.length) {
                            html += `<div class="mt-2"><strong>Row errors:</strong><ul>`;
                            data.report.errors.forEach(e => {
                                html += `<li>Row ${e.row}: ${e.error}</li>`;
                            });
                            html += `</ul></div>`;
                        }
                    }

                    successDiv.classList.remove('d-none');
                    successDiv.innerHTML = html;
                    if (window.showToast) showToast(msg);
                    // mark that a report was shown; reload will happen when user closes modal
                    importReportShown = true;
                    return;
                } else {
                    const msg = data && data.message ? data.message : 'Import failed';
                    errorsDiv.classList.remove('d-none');
                    errorsDiv.innerHTML = msg;
                    if (window.showToast) showToast(msg, 'error');
                    return;
                }
            }

            // If response is a redirect or HTML, and not JSON, try to handle common cases
            if (res.redirected) {
                window.location.href = res.url;
                return;
            }

            // If there was an HTTP error with non-JSON body, show its text
            if (!res.ok) {
                try {
                    const text = await res.text();
                    errorsDiv.classList.remove('d-none');
                    errorsDiv.innerHTML = text || 'Import failed with status ' + res.status;
                    if (window.showToast) showToast('Import failed', 'error');
                    return;
                } catch (e) {
                    errorsDiv.classList.remove('d-none');
                    errorsDiv.innerHTML = 'Import failed with status ' + res.status;
                    if (window.showToast) showToast('Import failed', 'error');
                    return;
                }
            }

            // Otherwise reload to reflect changes
            window.location.reload();

        } catch (err) {
            console.error('Import error', err);
            errorsDiv.classList.remove('d-none');
            errorsDiv.innerHTML = 'An error occurred during import. Check console for details.';
            if (window.showToast) showToast('Import error', 'error');
        } finally {
            if (submitBtn) { submitBtn.disabled = false; submitBtn.textContent = 'Import Customers'; }
        }
    });
});
</script>
