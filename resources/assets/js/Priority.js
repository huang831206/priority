class Priority{


    constructor(){
        console.log('Priority.js loaded');

        this.data = ['abc'];

        _.mixin({
            whereNot: function (list, properties) {
                return _.filter(list, function (obj) {
                    return !_.isMatch(list, obj);
                });
            }
        });
    }


    addNewCardToList(list) {
        console.log('adding new card...');

        console.log(list);

        var card_hash = this.uniqueId(10, 'c');
        console.log('card_hash');

        var source   = document.getElementById("card-template").innerHTML;
        var html = Handlebars.compile(source)({'card_hash': card_hash});
        $(list).append(html);

        console.log('finish adding card to list...');
    }

    addNewListToBoard(board){
        console.log('adding new list...');

        console.log(board);

        var list_hash = this.uniqueId(10, 'l');
        console.log('list_hash');

        var source   = document.getElementById("list-template").innerHTML;
        var html = Handlebars.compile(source)({'list_hash': list_hash});
        $(html).appendTo(board);

        Sortable.create(document.getElementById(list_hash), {

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

    findList(list_hash){
        var list = _.where(board.lists, {'list_hash': list_hash})[0];
        // console.log(list);
        return list;
    }

    findCard(list_hash, card_hash){
        var card = _.where(this.findList(list_hash).cards, {'card_hash': card_hash})[0];
        return card;
    }

    findTag(tag_hash){
        return _.where(board.tags, {'tag_hash': tag_hash})[0];
    }

    findUser(user_id){
        return _.where(board.users, {'id': user_id})[0];
    }

    updateCard(listHash, card_hash, data){
        var card = this.findCard(listHash, card_hash);
        card = _.extend(card, data);
    }

    addCardTags(card_hash, tag_hash){
        var card = this.findCard(card_hash);
        // card.
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
            str = prefix + '-' + str;
        }
        return str;
    }

}


var priority = new Priority();
