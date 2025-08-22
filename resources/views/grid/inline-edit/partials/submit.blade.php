$(document).off('click', '.ie-content .ie-submit').on('click', '.ie-content .ie-submit', function () {

    var $popover = $(this).closest('.ie-content');
    var $trigger = $popover.data('trigger');

    @isset($val)
        {{ $val }}
    @else
        var val = $popover.find('.ie-input').val();
    @endisset

    var original = $trigger.data('original');

    if (val == original) {
        $('[data-toggle="popover"]').popover('hide');
        return;
    }

    var data = {
        _token: LA.token,
        _method: 'PUT',
        _edit_inline: true,
    };
    data[$trigger.data('name')] = val;

    $.ajax({
        url: "{{ $resource }}/" + $trigger.data('key'),
        type: "POST",
        data: data
    }).done(function (data) {
        toastr.success(data.message);

        {{ $slot }}

        $trigger.data('value', val)
            .data('original', val);

        $('[data-toggle="popover"]').popover('hide');
    }).fail(function (xhr, textStatus, errorThrown) {
        var data = xhr.responseJSON;
        if (data && (data['errors'] || data['message'])) {
            var message = data['message'] || Object.values(data['errors']).join("\n");
            toastr.error(message);
        } else {
            toastr.error('Update failed: ' + errorThrown);
        }
    });
            422: function(xhr) {
                $popover.find('.error').empty();
                var errors = xhr.responseJSON.errors;
                for (var key in errors) {
                    $popover.find('.error').append('<div><i class="fa fa-times-circle-o"></i> '+errors[key]+'</div>')
                }
            }
        }
    });
});
