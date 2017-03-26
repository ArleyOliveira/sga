
function addItemForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<div></div>').append(newForm);
    $newLinkLi.before($newFormLi);
    addItemFormDeleteLink($newFormLi);
    $('.datepicker').datepicker({
        language: 'pt-BR',
        format: "dd/mm/yyyy"
    });

    $( ".time" ).each(function( index ) {
        $(this).attr('type', 'text');
    });

    $('.time').datetimepicker({
        format: 'H:mm',
    });

    $('.btn').tooltip();
}

function addItemFormDeleteLink($tagFormLi) {
    var $removeFormA = $('<a href="#" class="btn btn-danger btn-sm pull-right waves-effect" title="Excluir Item" style="margin-bottom: 10px"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>');
    //$tagFormLi.append($removeFormA);

    $($tagFormLi).find('.delete').append($removeFormA);

    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the tag form
        $tagFormLi.remove();
    });
}


var $collectionHolderItem;

// setup an "add a tag" link
var $addTagLinkItem = $('<a href="#" class="btn btn-success btn-sm add_item waves-effect" id="btnAdicionar" title="Adicionar Horário"><i class="fa fa-plus"></i> Adicionar Horário</a>');
var $newLinkLiItem = $('#btn-add').append($addTagLinkItem);


$($addTagLinkItem).tooltip();

$(document).ready(function(){
    // Get the ul that holds the collection of tags
    $collectionHolderItem = $('ul.items-schedule');

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolderItem.append($newLinkLiItem);

    // add a delete link to all of the existing tag form li elements
    $collectionHolderItem.find('li.items').each(function() {
        addItemFormDeleteLink($(this));
    });

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolderItem.data('index', $collectionHolderItem.find(':input').length);

    $addTagLinkItem.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see next code block)
        addItemForm($collectionHolderItem, $newLinkLiItem);
    });

    if($collectionHolderItem.find(':input').length == 0){
        addItemForm($collectionHolderItem, $newLinkLiItem);
    }

});
