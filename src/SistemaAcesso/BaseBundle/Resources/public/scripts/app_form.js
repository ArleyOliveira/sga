$('.datepicker').datepicker({
    language: 'pt-BR',
    format: "dd/mm/yyyy",
    autoclose: true
});

$('.datepicker-only-year').datepicker({
    format: 'yyyy',
    viewMode: 'years',
    minViewMode: 'years',
    autoclose: true
});

$( ".time" ).each(function( index ) {
    $(this).attr('type', 'text');
});

$('.time').datetimepicker({
    format: 'H:mm'
});

$('[data-provider="timepicker"]').datetimepicker({
    autoclose: true,
    format: 'H:ii'
});


var SPMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    spOptions = {
        onKeyPress: function (val, e, field, options) {
            field.mask(SPMaskBehavior.apply({}, arguments), options);
        }
    };

$('.cpf-mask').mask('000.000.000-00');
$('.cellphone-mask').mask(SPMaskBehavior, spOptions);
$('.phone-mask').mask('(00) 0000-0000');
$('.numeric').mask('0#');

$('.btn, .fa, input, .title').tooltip();

$(".remove-this").confirm({
    text: '<div class="alert alert-info" role="alert"><strong>Deseja realmente excluir este item?</strong> Esta ação não poderá ser desfeita.</div>',
    title: "Confirmar ação",
    confirm: function (button) {
        window.location.href = $(button).attr('href');
    },
    cancel: function (button) {
        // nothing to do
    },
    confirmButton: "Sim",
    cancelButton: "Não",
    post: true,
    confirmButtonClass: "btn-danger",
    cancelButtonClass: "btn-default",
    dialogClass: "modal-dialog" // Bootstrap classes for large modal
});

$('.form_modal').click(function(event) {
    event.preventDefault();
    $('.modal-placeholder').load( $(this).attr('href') );
});

