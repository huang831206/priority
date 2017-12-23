
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

        onEnd: function (event) {
            var item = event.item;
            console.log($(item).find('input').val());
            console.log('drag event: ');
            console.log(event);
            // api call, card pos change
            priority.updateCardsPos(event);

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
    var cardHash = $(this).parent().parent().data('id');
    var listHash = $(this).parent().parent().data('inlist');
    console.log(cardHash);
    console.log(listHash);
    // var cardData = _.where(board.lists[0].cards, {'card_hash': cardHash});
    var cardData = priority.findCard(listHash, cardHash);
    // if not found, let it be empty
    // cardData = _.isEmpty(cardData) ? {} : _.first(cardData);
    console.log('cardData: ');
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

    // register tag dropdown and allow fuzzy search
    $('.tag-select-dropdown').dropdown({
        fullTextSearch: true,
        action: 'nothing'
    });

    // register user dropdown and allow fuzzy search
    $('.user-select-dropdown').dropdown({
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
            var cardHash = card.data('id');
            var listHash = card.data('inlist')
            priority.deleteCardFromList(listHash, cardHash);
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

// attempt to add tag to card in modal
$(document).on('click', '.card-tags-selection', function () {
    var tag = $(this);
    console.log(tag);
    var tagHash = tag.data('id');
    var cardHash = tag.data('card-hash');
    var listHash = tag.data('in-list');

    console.log('attempt to add tag, details: ');
    console.log(tagHash + ' ' + cardHash + ' ' + listHash);
    // api call
    var card = priority.addCardTags(listHash, cardHash, tagHash);
    if( card ){
        $(this).parent().parent().siblings('.card-tags-list').append(tag.clone());
        priority.updateCardUI(cardHash, card);
    }
});

// attempt to delete tag from card in modal
$(document).on('click', '.card-tags-list .item', function () {
    var tagHash = $(this).data('id');
    var cardHash = $(this).parent().data('card-hash');
    var listHash = $(this).parent().data('in-list');
    console.log('attempt to delete tag, details: ');
    console.log(tagHash + ' ' + cardHash + ' ' + listHash);

    // api call
    var card = priority.removeCardTags(listHash, cardHash, tagHash);
    if( card ){
        console.log('new card: ');
        console.log(card);
        priority.updateCardUI(cardHash, card);
        $(this).remove();
    }
});

// attempt to add user to card in modal
$(document).on('click', '.card-users-selection', function () {
    var userName = $(this).find('a').text();

    var userId = $(this).data('id');
    var cardHash = $(this).data('card-hash');
    var listHash = $(this).data('in-list');

    console.log('attempt to add user, details: ');
    console.log(userId + ' ' + userName + ' ' + cardHash + ' ' + listHash);
    // api call
    var card = priority.addCardUsers(listHash, cardHash, userId);
    if( card ){
        var cardTemplate = [
            '<div class="ui large icon blue label" data-id="',
            userId,
            '"><i class="user icon"></i>',
            userName,
            '<i class="delete icon btn-delete-user"></i></div>'
        ];
        console.log('new user here: ');
        console.log($(cardTemplate.join('')));
        $(this).parent().parent().parent().siblings('.thirteen.wide.field.column').find('.card-modal-users-list').append($(cardTemplate.join('')));
        priority.updateCardUI(cardHash, card);
    }
});

// attempt to delete user from card in modal
$(document).on('click', '.btn-delete-user', function () {
    var userId = $(this).parent().data('id');
    var cardHash = $(this).parent().parent().data('card-hash');
    var listHash = $(this).parent().parent().data('list-hash');
    console.log(userId + ' ' + cardHash + ' ' + listHash);

    // api call
    var card = priority.removeCardUsers(listHash, cardHash, userId);
    if( card ){
        priority.updateCardUI(cardHash, card);
        $(this).parent().remove();
    }
});

// clicked header of list in board, attempt to modify it
$(document).on('click', '.list-wrapper .card .header-section .header', function () {
    $(this).hide();
    $(this).siblings().hide();
    $(this).siblings('.list-header-edit').show();
});

// attempt to save header of list in board
$(document).on('click', '.list-header-edit button', function () {
    var header = $(this).siblings('input').val();
    console.log(header);

    // api call
    $(this).parent().hide();
    $(this).parent().siblings('.header').text(header);
    $(this).parent().siblings().show();

    var listHash = $(this).parent().parent().parent().parent().data('id');
    console.log(listHash);
    priority.updateListHeader(listHash, header);
});

// clicked header of card in list, attempt to modify it
$(document).on('click', '.list-cards .card .content .header', function () {

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
    var card = priority.updateCard(listHash, cardHash, {name: header});
    priority.updateCardUI(cardHash, card);
});

// priority.startGettingData();

// priority.fetchData();
// $('.add-new-card').click(function () {
//     // $('.ui.modal').modal('show');
//
//     Priority.addNewCardToList($(this).parent().parent().find('.list-cards'));
// });
