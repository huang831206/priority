@extends('layouts.app')

@section('style')
	<link href="{{ asset('css/board.css') }}" rel="stylesheet">
@endsection

@section('content')

@include('layouts.sub-nav')

<div id="playground" class="ui horizontal blue inverted segments">

		<div class="six wide column list-wrapper">
			<div class="ui card segment centered">
				<div class="content header-section" style="background: #A333C8; color: white;">
					<div class="header" style="color: white;">Inbox</div>
				</div>
				<div class="content list-cards" id="inbox">
                    {{-- {{dd($board->inbox[0])}} --}}
					@forelse ($board->inbox as $card)
					    <div class="ui centered raised card" id="{{$card->card_hash}}" data-id="{{$card->card_hash}}" data-inlist="{{$card->in_list}}">
					        <div class="content">
					            <div class="header">
					                {{$card->name}}
					            </div>
					            <div class="ui fluid action input description card-header-edit" style="display:none;">
					                <input type="text" placeholder="Card header (required)" value="{{$card->name}}">
									<button class="ui teal icon button">
										<i class="checkmark icon"></i>
									</button>
					            </div>
					        </div>
					        <div class="extra content">
								@forelse ($card->tags as $tag)
									@if(isset($tag->name))
										<a class="ui tag label {{$tag->color}}">{{$tag->name}}</a>
									@else
										<a class="ui tag label {{$tag->color}}">&nbsp;</a>
									@endif
								@empty
								@endforelse
					        </div>
					    </div>
					@empty
					@endforelse
				</div>
			</div>
		</div>

		<div class="six wide column list-wrapper">
			<div class="ui card segment centered">
				<div class="content header-section" style="background: #F2711C; color: white;">
					<div class="header" style="color: white;">My Tasks</div>
				</div>
				<div class="content list-cards" id="priority">
    					@forelse ($board->priority as $card)
    					    <div class="ui centered raised card" id="{{$card->card_hash}}" data-id="{{$card->card_hash}}" data-inlist="{{$card->in_list}}">
    					        <div class="content">
    					            <div class="header">
    					                {{$card->name}}
    					            </div>
    					            <div class="ui fluid action input description card-header-edit" style="display:none;">
    					                <input type="text" placeholder="Card header (required)" value="{{$card->name}}">
    									<button class="ui teal icon button">
    										<i class="checkmark icon"></i>
    									</button>
    					            </div>
    					        </div>
    					        <div class="extra content">
    								@forelse ($card->tags as $tag)
    									@if(isset($tag->name))
    										<a class="ui tag label {{$tag->color}}">{{$tag->name}}</a>
    									@else
    										<a class="ui tag label {{$tag->color}}">&nbsp;</a>
    									@endif
    								@empty
    								@endforelse
    					        </div>
    					    </div>
    					@empty
    					@endforelse
				</div>
			</div>
		</div>

</div>

<div class="ui tiny modal">
	<div class="header">Header</div>
	<div class="content">
    	<p>123</p>
  </div>
</div>

@include('partials/_card')
@include('partials/_list')
@include('partials/_delete-confirm')

@endsection

@section('script')

<script type="text/javascript">
	var board = @json($board)
</script>
<script src="{{ asset('js/Priority.js') }}"></script>
<script src="{{ asset('js/personal.js') }}"></script>

@endsection
