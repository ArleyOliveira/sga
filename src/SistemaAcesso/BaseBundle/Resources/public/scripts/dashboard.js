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
        },
        error: function (result) {
            $('#list-last-access').html(tmpl('list-last-access-tmpl', result.responseText));
        }
    });
}

$(document).on('click', '#link_access_load', function (e) {
    e.preventDefault();
    loadAccess();
});

loadAccess();

window.setInterval(loadAccess, 5000);