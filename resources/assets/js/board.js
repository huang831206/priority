
// require('./bootstrap');
// var Priority = require('./Priority');

// make lists sortable
Sortable.create(playground, {

    animation: 150,
    draggable: '.list-wrapper',

    onUpdate: function (event) {
        var item = event.item;
        console.log($(item).find('input').val());
    }

});
// example lists
Sortable.create(alist, {

    animation: 150,
    draggable: '.card',
    group: 'list',

    onUpdate: function (event) {
        var item = event.item;
        console.log($(item).find('input').val());
    }

});
Sortable.create(b, {

    animation: 150,
    draggable: '.card',
    group: 'list',

    onUpdate: function (event) {
        var item = event.item;
        console.log($(item).find('input').val());
    }

});
Sortable.create(c, {

    animation: 150,
    draggable: '.card',
    group: 'list',

    onUpdate: function (event) {
        var item = event.item;
        console.log($(item).find('input').val());
    }

});

$('.ui.sticky').sticky();


$('#new-list').click(function () {
    priority.addNewListToBoard($('#playground'));
    priority.displayData();
});


$(document).on('click', '.add-new-card', function () {
    priority.addNewCardToList($(this).parent().parent().find('.list-cards'));
});

// priority.startGettingData();


// priority.fetchData();
// $('.add-new-card').click(function () {
//     // $('.ui.modal').modal('show');
//
//     Priority.addNewCardToList($(this).parent().parent().find('.list-cards'));
// });
