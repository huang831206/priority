class Priority{


    constructor(){
        console.log('Priority.js loaded');

        this.data = ['abc'];

        this.api_path = {
            'update_priority' : '/a/priority/update',
            'update_lists' : '/a/list/update',
            'new_list' : '/a/list/create',
            'new_board' : '/a/board/create'
        };

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

        var cardHash = this.uniqueId(10, 'c');

        var card = {
            card_hash: cardHash,
            content: '',
            in_list: list.data('id'),
            name: 'New Card',
            point: 0,
            pos: list.children().length,
            tags: [],
            users: []
        };
        console.log(card);

        var source   = document.getElementById("card-template").innerHTML;
        var html = Handlebars.compile(source)(card);
        $(list).append(html);

        this.findList(list.data('id')).cards.push(card);

        this.saveListsCards();

        console.log('finish adding card to list...');
    }

    addNewListToBoard(viewPort){
        console.log('adding new list...');

        console.log(viewPort);

        var listHash = this.uniqueId(10, 'l');

        var list = {
            list_hash: listHash,
            in_board: viewPort.data('id'),
            name: 'New List',
            pos: viewPort.children().length,
            cards: []
        };

        console.log('listHash');

        var source   = document.getElementById("list-template").innerHTML;
        var html = Handlebars.compile(source)(list);
        $(html).appendTo(viewPort);

        var _this = this;
        Sortable.create(document.getElementById(listHash), {

            animation: 150,
            draggable: '.card',
            group: 'list',


            onEnd: function (event) {
                var item = event.item;
                console.log($(item).find('input').val());
                console.log('drag event: ');
                console.log(event);

                _this.updateCardsPos(event);
            }

        });

        board.lists.push(list);

        this.saveData( this.api_path.new_list,
            _.pick(list, 'list_hash', 'in_board', 'name', 'pos'),
            function (response) {
                console.log(response);
            },
            function (error) {
                console.log(error);
            }
        );

        console.log('finish adding list to board...');
    }

    deleteCardFromList(listHash, cardHash){
        console.log('deleting card from list: ');
        console.log(cardHash + ' ' + listHash);
        var list = this.findList(listHash);
        var card = this.findCard(listHash, cardHash);
        // remove from list
        list.cards = _.filter(list.cards, function (card) {
            return card.card_hash != cardHash;
        });
        this.saveListsCards();
    }

    findList(list_hash){
        var list = _.where(board.lists, {'list_hash': list_hash})[0];
        console.log(list_hash + 'list found: ');
        console.log(list);
        return list;
    }

    findCard(list_hash, card_hash){
        var card = _.where(this.findList(list_hash).cards, {'card_hash': card_hash})[0];
        console.log(card_hash + 'card found: ');
        console.log(card);
        return card;
    }

    findTag(tag_hash){
        return _.where(board.tags, {'tag_hash': tag_hash})[0];
    }

    findUser(user_id){
        return _.where(board.users, {'id': user_id})[0];
    }

    updateListHeader(listHash, data){
        var list = this.findList(listHash);
        list.name = data;
        console.log('before send:');
        console.log(board.lists);
        this.saveListsCards();
        return list;
    }

    updateCard(listHash, card_hash, data){
        var card = this.findCard(listHash, card_hash);
        card = _.extend(card, data);
        this.saveListsCards();
        return card;
    }

    addCardTags(list_hash, card_hash, tag_hash){
        var card = this.findCard(list_hash, card_hash);

        if(_.findWhere(card.tags, {tag_hash: tag_hash})){
            // tag exists
            return false;
        } else {
            var tag = _.pick(this.findTag(tag_hash), 'color', 'name', 'tag_hash');
            card.tags.push(tag);
            this.saveListsCards();
            return card;
        }
    }

    removeCardTags(list_hash, card_hash, tag_hash){
        var card = this.findCard(list_hash, card_hash);

        var tag = _.findWhere(card.tags, {tag_hash: tag_hash});
        if(tag){
            // tag exists
            card.tags = _.reject(card.tags, function (val) {
                return val.tag_hash == tag.tag_hash;
            });
            this.saveListsCards();
            return card;
        } else {
            // tag doesn't exist
            return false;
        }

    }

    addCardUsers(list_hash, card_hash, user_id){
        var card = this.findCard(list_hash, card_hash);

        if(_.findWhere(card.users, {id: user_id})){
            // user exists
            return false;
        } else {
            var user = _.pick(this.findUser(user_id), 'id', 'name');
            card.users.push(user);
            this.saveListsCards();
            return card;
        }
    }

    removeCardUsers(list_hash, card_hash, user_id){
        var card = this.findCard(list_hash, card_hash);

        var user = _.findWhere(card.users, {id: user_id});
        if(user){
            // user exists
            card.users = _.reject(card.users, function (val) {
                return val.id == user.id;
            });
            this.saveListsCards();
            return card;
        } else {
            // user doesn't exist
            return false;
        }
    }

    updateCardUI(card_hash, card){
        var oldCard = $('.ui.centered.raised.card[data-id="' + card_hash + '"]');
        console.log(card);
        var source   = document.getElementById("card-template").innerHTML;
        var html = Handlebars.compile(source)(card);
        $(oldCard).after(html);
        $(oldCard).remove();
    }

    updateListPos(event){
        var list_hash = $(event.item).data('id');
        var oldList = $('.list-wrapper[data-id="' + list_hash + '"]');
        _.each(board.lists, function (list) {
            list.pos = $('#playground').find('.list-wrapper[data-id="' + list.list_hash + '"]').index();
        });

        console.log(board.lists);

        this.saveListsCards();
    }

    updateCardsPos(event){
        console.log('update card pos');
        var fromListHash = $(event.from).data('id');
        var toListHash = $(event.to).data('id');
        var cardHash = $(event.item).data('id');

        var fromList = this.findList(fromListHash);   // the from list obj
        var toList = this.findList(toListHash);   // the to list obj
        var card = this.findCard(fromListHash, cardHash);     // the moved card obj
        // remove from fromList
        fromList.cards = _.filter(fromList.cards, function (card) {
            return card.card_hash != cardHash;
        });
        // add to toList
        toList.cards.push(card);
        card.in_list = toListHash;
        // change all card's pos by its current pos
        _.each(fromList.cards, function (card) {
            card.pos = $(event.from).find('#' + card.card_hash).index();
        });
        _.each(toList.cards, function (card) {
            card.pos = $(event.to).find('#' + card.card_hash).index();
        });

        // change in_list data in cards
        $(event.item).data('inlist', toListHash);

        // this.sortCards(fromList.cards);
        // this.sortCards(toList.cards);

        this.saveData( this.api_path.update_lists,
            _.pick(board, 'board_hash', 'lists'),
            function (response) {
                console.log(response);
            },
            function (error) {
                console.log(error);
            }
        );
    }

    updatePriority(event){
        var cardHash = $(event.item).data('id');

        var list = board.priority;   // the priority list obj
        var card = _.where(board.inbox, {'card_hash': cardHash})[0];     // the moved card obj

        // if card was not in priority
        if( ! _.findWhere(list, {'card_hash': cardHash}) ) {
            // add to priority ist
            console.log('was not in priority, pushing it...');
            list.push(card);
        }

        _.each(list, function (card) {
            // set priority position
            card.priority_pos = $(event.to).find('#' + card.card_hash).index();
        });

        this.sortCards(list)
    }

    sortCards(list){
        list = _.sortBy(list, function (card) {
            return card.priority_pos;
        });
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

    saveListsCards(){
        this.saveData( this.api_path.update_lists,
            _.pick(board, 'board_hash', 'lists'),
            function (response) {
                console.log(response);
            },
            function (error) {
                console.log(error);
            }
        );
    }

    saveData(url, data, onSuccess, onFail){
        axios.post(url, data)
        .then(function (response) {
            onSuccess(response);
        })
        .catch(function (error) {
            onFail(error);
        });
    }

    /* ----------------- */


    displayData(){
        console.log(this.data);
    }


    uniqueId(length, prefix){
        var chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
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
