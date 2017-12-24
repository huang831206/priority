@extends('layouts.app')

@section('style')
	<link href="{{ asset('css/board.css') }}" rel="stylesheet">
@endsection

@section('content')

@include('layouts.sub-nav')

<div id="playground" class="ui horizontal blue inverted segments" data-id="{{$board->board_hash}}">

	@forelse ($board->lists as $list)
		<div class="six wide column list-wrapper" data-id="{{$list->list_hash}}">
			<div class="ui card segment centered">
				<div class="content header-section" style="background: #545454; color: white;">
					<div class="ui fluid action input description list-header-edit" style="display:none;">
						<input type="text" placeholder="List header (required)" value="{{$list->name}}">
						<button class="ui teal icon button">
							<i class="checkmark icon"></i>
						</button>
					</div>
					<i class="right floated large add square icon add-new-card"></i>
					<i class="right floated large edit icon edit-list-header"></i>
					<div class="header" style="color: white;">{{$list->name}}</div>
				</div>
				<div class="content list-cards" id="{{$list->list_hash}}" data-id="{{$list->list_hash}}">
					@forelse ($list->cards as $card)
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
					        <div class="extra content">
								@forelse ($card->users as $user)
									<div class="right floated author">
									   <i class="user icon"></i> {{$user->name}}
								   </div>
							   	@empty
								@endforelse
					        </div>
					        <div class="ui two bottom attached buttons">
					            <div class="ui button btn-edit-card">
					                <i class="edit icon btn-edit-card"></i> Edit
					            </div>
					            <div class="ui button btn-delete-card">
					                <i class="remove icon"></i> Delete
					            </div>
					        </div>
					    </div>
					@empty
					@endforelse
				</div>
			</div>
		</div>
	@empty
	@endforelse

</div>
<script id="aaa" type="text/x-handlebars-template">
	<h1>@{{name}}</h1>
</script>

<div class="ui tiny modal">
	<div class="header">Header</div>
	<div class="content">
    	<p>123</p>
  </div>
</div>

@include('partials/_card')
@include('partials/_list')
@include('partials/_card-modal')
@include('partials/_delete-confirm')
@include('partials/_alert')

@endsection

@section('script')

<script type="text/javascript">
	var board = @json($board)
</script>
<script src="{{ asset('js/Priority.js') }}"></script>
<script src="{{ asset('js/board.js') }}"></script>

@endsection
