
// require('./bootstrap');
// var Priority = require('./Priority');

if(typeof board == 'undefined'){
    location.href = '/boards';
    alert('an error occurred!')
    console.log('board not found!!');
} else {
    console.log('board found!');
}

$('.sidebar')
    .sidebar({
        context: $('#app')
    })
    .sidebar('attach events', '#settings')
    .sidebar('setting', 'transition', 'overlay')
    .sidebar('setting', 'dimPage', false);

$('.ui.dropdown').dropdown();

// make lists sortable
Sortable.create(playground, {

    animation: 150,
    draggable: '.list-wrapper',

    onUpdate: function (event) {
        var item = event.item;
        console.log($(item).find('input').val());
        // api call, list pos change
    }

});

// initial list sorting
_.each(board.lists, function (list) {
    Sortable.create(document.getElementById(list.list_hash), {

        animation: 150,
        draggable: '.card',
        group: 'list',

        onUpdate: function (event) {
            var item = event.item;
            console.log($(item).find('input').val());
            // api call, card pos change
        }

    });
})

$('.ui.sticky').sticky();

$('.ui.accordion').accordion();

$('#new-list').click(function () {
    priority.addNewListToBoard($('#playground'));
    priority.displayData();
});

// attempt to add a ne card
$(document).on('click', '.add-new-card', function () {
    priority.addNewCardToList($(this).parent().parent().find('.list-cards'));
});

// card edit is clicked
$(document).on('click', '.btn-edit-card', function () {
    console.log('btn clicked!');

    // find data by card_hash
    var card_hash = $(this).parent().parent().data('id');
    console.log(card_hash);
    var cardData = _.where(board.lists[0].cards, {'card_hash': card_hash});
    // if not found, let it be empty
    cardData = _.isEmpty(cardData) ? {} : _.first(cardData);
    console.log(cardData);

    var source   = document.getElementById("card-modal-template").innerHTML;
    var html = Handlebars.compile(source)(cardData);

    // register modal for edit details
    $(html).modal({
        onHidden:function () {
            $(this).remove();
        }
    })
    .modal('setting', 'transition', 'vertical flip')
    .modal('show');

    // register dropdown and allow fuzzy search
    $('.tag-select-dropdown').dropdown({
        fullTextSearch: true,
        action: 'nothing'
    });

});

// card delete is clicked
$(document).on('click', '.btn-delete-card', function () {
    console.log('btn clicked!');
    var source   = document.getElementById("delete-confirm-template").innerHTML;
    var html = Handlebars.compile(source)();

    var card = $(this).parent().parent();

    $(html).modal({
        onHidden:function () {
            console.log($(this).remove());
        },
        onApprove : function() {
            // TODO: find card hash
            // api call
            card.remove();
        }
    }).modal('show');

});

// attempt to edit catd details in modal
$(document).on('click', '.btn-edit-card-content', function () {
    $(this).parent().hide();
    $(this).parent().siblings('.card-modal-edit').show();
});

// confirm edit card detail and submit to server
$(document).on('click', '.btn-confirm-edit-modal-content', function () {
    // get new content
    var content = $(this).parent().siblings('textarea').val();
    // api call
    $(this).parent().parent().hide();
    $(this).parent().parent().siblings('.card-modal-content').find('pre').text(content);
    $(this).parent().parent().siblings('.card-modal-content').show();
});

// cancel edit card detail
$(document).on('click', '.card-modal-edit .buttons .cancel', function () {

    $(this).parent().parent().hide();
    var oldContent = $(this).parent().parent().siblings('.card-modal-content').find('pre').text();
    $(this).parent().siblings('textarea').val(oldContent);
    $(this).parent().parent().siblings('.card-modal-content').show();
});

// attempt to ad tag to card in modal
$(document).on('click', '.card-tags-selection', function () {
    var tag = $(this);
    var tagHash = tag.data('id');
    // TODO: handle nultiple tags in card
    console.log(tagHash);
    // api call
    $(this).parent().parent().siblings('.card-tags-list').append(tag.clone());
});

// attempt to delete tag from card in modal
$(document).on('click', '.card-tags-list .item', function () {
    var tagId = $(this).data('id');
    console.log(tagId);

    // api call
    $(this).remove();
});

// attempt to delete user from card in modal
$(document).on('click', '.btn-delete-user', function () {
    var userId = $(this).parent().data('id');
    console.log(userId);

    // api call
    $(this).parent().remove();
});

// clicked header of card in list, attempt to modify it
$(document).on('click', '.card .content .header', function () {

    $(this).hide();
    $(this).siblings('.card-header-edit').show();

});

// attempt to save header of card in list
$(document).on('click', '.card-header-edit button', function () {
    var header = $(this).siblings('input').val();
    console.log(header);

    // api call
    $(this).parent().hide();
    $(this).parent().siblings('.header').text(header);
    $(this).parent().siblings('.header').show();

    var cardHash = $(this).parent().parent().parent().data('id');
    var listHash = $(this).parent().parent().parent().data('inlist');
    priority.updateCard(listHash, cardHash, {name: header});
});

// priority.startGettingData();

// priority.fetchData();
// $('.add-new-card').click(function () {
//     // $('.ui.modal').modal('show');
//
//     Priority.addNewCardToList($(this).parent().parent().find('.list-cards'));
// });
