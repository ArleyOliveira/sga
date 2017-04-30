moment.locale('pt-br');
//ACCESSS
function loadAccess() {
    $.ajax({
        type: 'GET',
        url: $('#link_access_load').attr('data-url'),
        dataType: 'json',
        success: function (result) {
            if (result.success) {
                $('#list-last-access').html(tmpl('list-last-access-tmpl', result));
            }
            $('#loading-access')
                .addClass('hide')
                .hide('fast')
            ;
        },
        error: function (result) {
            $('#list-last-access').html(tmpl('list-last-access-tmpl', result.responseText));

            $('#loading-access')
                .addClass('hide')
                .hide('fast')
            ;
        }
    });
}

$(document).on('click', '#link_access_load', function (e) {
    $('#loading-access')
        .removeClass('hide')
        .show('fast')
    ;
    e.preventDefault();
    loadAccess();
});

$('#link_access_load').trigger('click');

window.setInterval(loadAccess, 5000);


function loadEnvironment() {
    $.ajax({
        type: 'GET',
        url: $('#link_get_envirionment').attr('data-url'),
        dataType: 'json',
        success: function (result) {
            if (result.success) {
                $('#list-environment').html(tmpl('list-environment-tmpl', result));
                $('#total-environment').html(result.environments.length)
            }
            $('#loading-environment')
                .addClass('hide')
                .hide('fast')
            ;
        },
        error: function (result) {
            $('#list-environment').html(tmpl('list-environment-tmpl', result.responseText));

            $('#loading-environment')
                .addClass('hide')
                .hide('fast')
            ;
        }
    });
}

$(document).on('click', '#link_get_envirionment', function (e) {
    $('#loading-environment')
        .removeClass('hide')
        .show('fast')
    ;
    e.preventDefault();
    loadAccess();
});

$('#link_get_envirionment').trigger('click');

window.setInterval(loadEnvironment, 5000);


function countItem() {
    $.ajax({
        type: 'GET',
        url: $('#count-item').attr('data-url'),
        dataType: 'json',
        success: function (result) {
            if (result.success) {
                $('#count-teachers').html(result.data.countTeacher);
                $('#count-environments').html(result.data.countEnvironment);
                $('#count-users').html(result.data.countUser);
            }
        },
        error: function (result) {

        }
    });
}

countItem();
window.setInterval(countItem, 5000);