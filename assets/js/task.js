$(document).on('click', '.loadTask', function () {
    $.post('?modal=task', {'t_id': $(this).data('id')}, function (response) {
        $('.taskBody').html(response);
        $('.modalActBtn').html('<button type="submit" class="btn btn-primary saveForm">Сохранить</button>');
    });
});

$(document).on('hidden.bs.modal', '#taskModal', function () {
    $('.taskBody').empty();
});

$(document).on('click', '.orderChange', function () {console.log($(this).data('name'))
    $.post('?modal=orderChange', {'fieldName': $(this).data('name')}, function (response) {
        console.log(response)
        window.location.reload();
    });
});

$(document).on( 'click', '.saveForm', function () {
    var modal = $('.modal.show');
    var error_div = modal.find('.error_msg');

    var forms = modal.find('form');
    var url = '';
    var ids = [];
    var isValid = true;

    isValid = checkIsEmpty($('#t_username')) && isValid;
    isValid = checkIsEmpty($('#t_email')) && isValid;
    isValid = checkIsEmpty($('#t_text')) && isValid;

    if (isValid) {
        error_div.addClass( 'visually-hidden' ).empty();
    } else {
        error_div.html( 'Все обязательные поля должны быть заполнены!' ).removeClass( 'visually-hidden' );
        return false;
    }

    forms.each(function () {
        if (!url) url = $(this).attr( 'action' );
        ids.push( '#' + $(this).attr('id') );
    });

    var data = $(ids.join(',')).serialize();

    $.post(url, data, function (response) {
        console.log(response);
        if (!response.ok) {
            error_div.html(response.msg).removeClass( 'visually-hidden' );
        } else {
            error_div.addClass( 'visually-hidden' ).empty();
            modal.modal( 'hide' );
            window.location.reload();
        }
    }, 'json');

    return false;
} );

function checkIsEmpty(item) {
    if (item.val() === '') {
        isValid = false;
        item.addClass('is-invalid');
        return false;
    } else {
        item.removeClass('is-invalid');
        return true;
    }
}

feather.replace()
