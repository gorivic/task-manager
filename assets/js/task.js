$(document).on('click', '.loadTask', function () {
    $.post('?modal=task', {'t_id': $(this).data('id')}, function (response) {
        $('.taskBody').html(response);
        $('.modalActBtn').html('<button type="submit" class="btn btn-primary float-end saveForm">Сохранить</button>');
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

$(document).on( 'change keydown paste input', '#t_email', function () {
    if (!isEmail($(this).val())) {
        $(this).addClass('is-invalid');
    } else {
        $(this).removeClass('is-invalid');
    }
});

$(document).on( 'focusout', '#t_email', function () {
    var modal = $('.modal.show');
    var error_div = modal.find('.error_msg');

    if (!isEmail($(this).val())) {
        error_div.html( 'E-mail не валиден.' ).removeClass( 'visually-hidden' );
        $(this).addClass('is-invalid');
    } else {
        error_div.addClass( 'visually-hidden' ).empty();
        $(this).removeClass('is-invalid');
    }
});

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

function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}

feather.replace()

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})

