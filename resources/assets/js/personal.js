
var modified = false;

$('.sidebar')
    .sidebar({
        context: $('#app')
    })
    .sidebar('attach events', '#settings')
    .sidebar('setting', 'transition', 'overlay')
    .sidebar('setting', 'dimPage', false);

$('.ui.dropdown').dropdown();


Sortable.create(document.getElementById('inbox'), {

    animation: 150,
    draggable: '.card',
    group: {
        name: 'list',
        pull: 'clone',
        put: false
    },

    onEnd: function (event) {
        var item = event.item;
    }

});

Sortable.create(document.getElementById('priority'), {

    animation: 150,
    draggable: '.card',
    group: {
        name: 'list',
        pull: false,
        put: function (to, from, item) {
            console.log('attempt to put card in priority...');
            var cardHash = $(item).data('id');
            console.log(cardHash);
            if ( ! _.findWhere(board.priority, {'card_hash': cardHash}) ) {
                return true;
            } else {
                return false;
            }
        },
    },

    onSort: function (event) {
        var item = event.item;
        console.log($(item).find('input').val());
        console.log('drag event: ');
        console.log(event);
        // api call, card pos change
        priority.updatePriority(event);
        priority.saveData(priority.api_path.update_priority, board.priority,
            function (response) {
                console.log(response);
            },
            function (errre) {

        });
    }

});
