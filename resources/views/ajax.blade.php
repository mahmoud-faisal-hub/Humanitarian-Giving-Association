<script>
    var form = "form";
    var method = "POST";
    var url = "";
    var submittedForm = "";

    @isset($form)
        form = "{{ $form }}";
    @endisset

    @isset($method)
        method = "{{ $method }}";
    @endisset

    @isset($url)
        url = "{{ $url }}";
    @endisset

    $(form).on('submit', function(e) {
        e.preventDefault();

        @empty($url)
            url = $(this).attr('action');
        @endempty

        submittedForm = this.id;

        const forms = document.querySelectorAll('.needs-validation')
        var valid = true;
        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                valid = false;
            }
        })

        if (!valid) {
            return false;
        }

        $("[id$=_error]").fadeOut(600);
        $("input").removeClass("is-invalid");

        var current = $(this).find("[type='submit']:last").html();

        var formData = new FormData(this);
        // formData.append('key', 'value');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
            },
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            url: url,
            type: method,
            enctype: 'multipart/form-data',
            beforeSend: function() {
                $("[type='submit']:last").html(
                    '<i class="fa fa-circle-o-notch fa-spin fa-lg"></i>');
                if (typeof ajaxBeforeSent === "function") {
                    ajaxBeforeSent();
                }
            },
            complete: function() {
                $("[type='submit']:last").html(current);
                if (typeof ajaxComplete === "function") {
                    ajaxComplete();
                }
            },
            success: function(response) {
                if (response.status) {
                    $(".notification-success .msg").text(response.msg);
                    notify(".notification-success");
                    if (typeof notif === "function") {
                        notif({
                            type: "success",
                            msg: '<i class="fa-solid fa-circle-check ms-2"></i> ' + response.msg,
                            position: "right",
                            fade: true
                        });
                    }
                    @if (isset($clear) && $clear)
                        $(form).removeClass("was-validated");
                        $(form).trigger('reset');
                        if (typeof editors !== 'undefined' && typeof editors.editor !== 'undefined') {
                            editors.editor.setData('');
                        }
                    @endif
                    if (typeof ajaxSuccess === "function") {
                        ajaxSuccess();
                    }
                } else {
                    $(".notification-fail .msg").text(response.msg);
                    notify(".notification-fail");
                    if (typeof notif === "function") {
                        notif({
                            type: "error",
                            msg: '<i class="fa-solid fa-circle-xmark ms-2"></i> ' + response.msg,
                            position: "right",
                            fade: true
                        });
                    }
                }
            },
            error: function(response) {
                console.log(response.status);
                var fisrtError = Object.keys(response.responseJSON.errors)[0];
                // $("#error").hide().text(response.responseJSON.errors[fisrtError][0]).fadeIn(600);
                $.each(response.responseJSON.errors, function(key, val) {
                    console.log(key + ": " + val[0]);
                    // $(form).removeClass("was-validated");
                    $("#" + key + "_error").hide().text(val[0]).fadeIn(600);
                    $("[aria-describedby=" + key + "_error]").addClass("is-invalid");
                    // $("[aria-describedby!=" + key + "_error]").addClass("is-valid");
                });

                if (typeof ajaxError === "function") {
                    ajaxError(response);
                }
            }
        });
    });
</script>
