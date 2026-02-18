$(document).on('click', 'a[data-ajax-popup="true"], button[data-ajax-popup="true"], div[data-ajax-popup="true"]', function () {

    var data = {};
    var title1 = $(this).data("title");
    var title2 = $(this).data("bs-original-title");
    var title3 = $(this).data("original-title");
    var title = title1 ?? title2 ?? title3;

    // Only reset size on the ajax-loaded commonCanvas, don't touch other modals
    $('#commonCanvas .modal-dialog').removeClass('modal-xl');
    var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');

    var url = $(this).data('url');

    $.ajax({
        url: url,
        data: data,
        success: function (data) {
            $('#commonCanvas .offcanvas-body').html(data);

            // Initialize the Offcanvas properly
            var canvasEl = document.getElementById('commonCanvas');
            var offcanvasInstance = bootstrap.Offcanvas.getOrCreateInstance(canvasEl, {
                backdrop: true, 
                scroll: false
            });

            offcanvasInstance.show();

            bindFormSubmit();
        },
        error: function (data) {
            console.log(data.responseJSON);
        }
    });
});


function bindFormSubmit() {
    $('.btn-close').off('click').on('click', function () {
        var canvasEl = document.getElementById('commonCanvas');
        var offcanvasInstance = bootstrap.Offcanvas.getInstance(canvasEl);
        if (offcanvasInstance) {
            offcanvasInstance.hide();
        }
    });
}

      
$('form').on('submit', function (event) {
    var form = $(this);
    // Allow forms to opt-out of the global AJAX handler
    if (form.hasClass('no-global-ajax')) {
        return true; // let the form's own handler manage submission
    }
    // If form has no explicit action, don't intercept (prevents posting to current URL)
    var actionAttr = form.attr('action');
    if (!actionAttr || String(actionAttr).trim() === '') {
        return true; // allow normal submit or other handlers
    }

    const methodAttr = form.attr('method');
    const method = (methodAttr && typeof methodAttr.toString === 'function') ? methodAttr.toString().toUpperCase() : '';
    if (method === 'POST') {
        event.preventDefault();
        var formData = new FormData(this);
        var loaderTimeout;

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                // Delay showing the loader
                loaderTimeout = setTimeout(function () {
                    $('#preloader').css('display', 'flex').hide().fadeIn();
                }, 1000);

                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();
            },
            success: function (response) {
                console.log(1)
                clearTimeout(loaderTimeout);
                $('#preloader').fadeOut();

                if (response.status === 200) {
                    succeesAlert(response); // Your custom success handler
                }
            },
            error: function (xhr) {
                clearTimeout(loaderTimeout);
                $('#preloader').fadeOut();

                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;

                    $.each(errors, function (key, value) {
                        var input = $('[name="' + key + '"]');
                        input.addClass('is-invalid');
                        input.after('<div class="invalid-feedback">' + value[0] + '</div>');
                    });

                    $.each(errors, function (key, messages) {
                        const parts = key.split('.');
                        const field = parts[0];
                        const index = parts[1];

                        const inputs = $('[name="' + field + '[]"]');
                        const $input = inputs.eq(index);

                        if ($input.length > 0) {
                            $input.addClass('is-invalid');

                            if (!$input.next('.invalid-feedback').length) {
                                $input.after('<div class="invalid-feedback">' + messages[0] + '</div>');
                            }
                        }
                    });
                } else {
                    warningAlert(xhr.responseJSON);
                }
            }
        });
    }
});



 function succeesAlert(response){
  Swal.fire({
                title: 'Success!',
                text: response.message, 
                icon: 'success',
                 showCancelButton: false,
                customClass: {
          confirmButton: 'btn btn-primary waves-effect waves-light'
        },
        buttonsStyling: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = response.redirect_url; // Redirect on OK click
                }
            });
 }

function warningAlert(response) {
    // Normalize response so missing/undefined values don't throw
    if (!response) response = { message: 'An unexpected error occurred.' };
    let errorText = response.message || 'An unexpected error occurred.';

    // Support errors as array or object (validation errors)
    if (response.errors) {
        // If it's an object (field => [msgs]) convert to flat array
        const errs = Array.isArray(response.errors) ? response.errors : Object.values(response.errors).flat();
        if (errs.length) {
            errorText += '<br><br><ul style="text-align: left;">';
            errs.forEach(function(error) {
                errorText += `<li>${error}</li>`;
            });
            errorText += '</ul>';
        }
    }

    Swal.fire({
        title: 'Warning!',
        html: errorText, // Use `html` instead of `text` to support formatting
        icon: 'warning',
        showCancelButton: false,
        customClass: {
            confirmButton: 'btn btn-primary waves-effect waves-light'
        },
        buttonsStyling: false,
    });
}

    