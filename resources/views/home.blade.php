@extends('layouts.app')

@section('content')
<div class="ui container" style="margin-top:5em;">
    <div class="ui two column stackable grid container">
        <div class="column">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <div class="ui three column grid">
                <div class="column">
                    <h2>Teams</h2>
                </div>
                <div class="column new-board">
                    <div class="item" style="margin-bottom:1em;">
                        <button id="new-board-btn" class="brown ui button">New Board</button>
                    </div>
                </div>
                <div class="column"></div>
                <div id="board-name-box" class="ten wide column" style="display:none;">
                    <div class="ui fluid action input description" style="margin-bottom:1em;">
                        <input type="text" placeholder="Board name (required)" value="">
                        <button class="ui teal icon button">
                            <i class="checkmark icon"></i>
                        </button>
                    </div>
                </div>
            </div>
    {{-- {{dd($data)}} --}}
            @foreach ($data['boards'] as $board)
            <div class="ui special cards">
                <div class="card">
                    <div class="blurring dimmable image">
                        <div class="ui dimmer">
                            <div class="content">
                                <div class="center">
                                    <a href="{{route('board', ['board' => $board->board_hash])}}">
                                        <div class="ui inverted button">Get started</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <img class="ui image" src="http://fakeimg.pl/650x400/B5CC18/?text={{$board->name}}">
                    </div>
                    <div class="content">
                    <a class="header">{{$board->name}}</a>
                        <div class="meta">
                            <span class="date">Create in {{$board->created_at}}</span>
                        </div>
                    </div>
                    <div class="extra content">
                        <a>
                            <i class="users icon"></i>
                            {{$board->user_count}} Members
                        </a>
                    </div>
                </div>
            </div>
            @endforeach


        </div>

        <div class="column">
            <h2>Personal</h2>
            {{-- @unless($data['priority'])
                no data
            @endunless --}}
            <div class="ui special cards">
                <div class="card">
                    <div class="blurring dimmable image">
                        <div class="ui dimmer">
                            <div class="content">
                                <div class="center">
                                    <a href="{{route('priority')}}">
                                        <div class="ui inverted button">Get started</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <img class="ui image" src="http://fakeimg.pl/650x400/F2711C/?text=&nbsp;">
                    </div>
                    <div class="content">
                    <a class="header">Personal Board</a>
                        <div class="meta">
                            <span class="text">make things easier...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{{ asset('js/Priority.js') }}"></script>
    <script type="text/javascript">
        $('.special.cards .image').dimmer({
            on: 'hover'
        });


        $(document).on('click', '#new-board-btn', function () {
            $(this).parent().parent().hide();
            $('#board-name-box').show();
        });

        $(document).on('click', '#board-name-box button', function () {
            var name = $(this).siblings('input').val();
            if(name){
                $('#board-name-box').hide();
                $('#board-name-box').siblings('.new-board').show();
                priority.saveData(priority.api_path.new_board,
                    {
                        'name' : name,
                        'board_hash' : priority.uniqueId(10, 'b')
                    },
                    function (response) {
                        location.href = '/board/' + response.data.board_hash;
                    },
                    function (error) {
                        console.log(error);
                    });
            }
        })

    </script>
@endsection
