class Priority{


    constructor(){
        console.log('Priority.js loaded');

        this.data = ['abc'];
    }


    addNewCardToList(list) {
        console.log('adding new card...');

        console.log(list);

        var source   = document.getElementById("card-template").innerHTML;
        var html = Handlebars.compile(source)({});
        $(list).append(html);

        console.log('finish adding card to list...');
    }

    addNewListToBoard(board){
        console.log('adding new list...');

        console.log(board);

        var list_id = this.uniqueId(10, 'l');
        console.log('list_id');

        var source   = document.getElementById("list-template").innerHTML;
        var html = Handlebars.compile(source)({'list_id': list_id});
        $(html).appendTo(board);

        Sortable.create(document.getElementById(list_id), {

            animation: 150,
            draggable: '.card',
            group: 'list',

            onUpdate: function (event) {
                var item = event.item;
                console.log($(item).find('input').val());
            }

        });

        console.log('finish adding list to board...');
    }

    /* ----- dirty ----- */
    // TODO: use WS

    startGettingData(){
        var _this = this;
        console.log('start getting data');
        this.timerId = setInterval(function () {
            axios.get('/tt')
                .then(function (response) {
                    console.log(response);
                    _this.data.push(response.data);
                })
                .catch(function (error) {
                    console.log(error);
                });
        }, 1000);
    }

    stopGettingData(){
        if(this.timerId){
            clearInterval(this.timerId);
        }else{
            console.log('looper does not exist. ' + timerId);
        }
    }

    saveData(data){
        axios.post('/url', {
            'param' : 'value'
        })
        .then(function (response) {

        })
        .catch(function (error) {

        });
    }

    /* ----------------- */


    displayData(){
        console.log(this.data);
    }


    uniqueId(length, prefix){
        var chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz';
        if (! length) {
            length = 12;
        }
        var str = '';
        for (var i = 0; i < length; i++) {
            str += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        if(prefix){
            str = prefix + str;
        }
        return str;
    }

}


var priority = new Priority();