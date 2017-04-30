moment.locale('pt-br');
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