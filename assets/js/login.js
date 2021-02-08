$(document).on('click', '.tryToLogin', function () {
    $.post('?modal=login', {}, function (response) {
        $('.taskBody').html(response);
        $('.modalActBtn').html('<button type="submit" class="btn btn-primary actLoginForm">Войти</button>');
    });
});

$(document).on('click', '.actLoginForm', function () {
    var modal = $('.modal.show');
    var error_div = modal.find('.error_msg');
    var isValid = true;

    isValid = checkIsEmpty($('#u_name')) && isValid;
    isValid = checkIsEmpty($('#u_pass')) && isValid;

    if (isValid) {
        error_div.addClass( 'visually-hidden' ).empty();
    } else {
        error_div.html( 'Все обязательные поля должны быть заполнены!' ).removeClass( 'visually-hidden' );
        return false;
    }

    $.post('?modal=loginAct', {'u_name': $('#u_name').val(), 'u_pass': $('#u_pass').val()}, function (response) {
        if (!response.ok) {
            error_div.html(response.msg).removeClass( 'visually-hidden' );
        } else {
            error_div.addClass( 'visually-hidden' ).empty();
            modal.modal( 'hide' );
            window.location.reload();
        }
    }, 'json');

    return false;
});

$(document).on('click', '.logout', function () {
    $.post('?modal=logout', {}, function (response) {
        window.location.reload();
    });

    return false;
});