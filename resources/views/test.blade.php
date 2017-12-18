@extends('layouts.app')

@section('style')
<style type="text/css">
	body {
		max-height: 100%;
	}

	.ui.button.column {
		margin: 5px;
	}

	.ui.button.column .input{
		margin: 0px 15px;
	}

	.list-wrapper {
		width: 270px;
		min-width: 270px;
		margin: 12px;

	}

	.list-cards {
		min-width: 255px;
		overflow-x: hidden;
		overflow-y: auto;
	}

	.add-new-card {
		cursor: pointer;
	}

	html, body, #app, .ui.container, .ui.card.segment.centered , .list-cards {
		height: 100%;
	}
</style>
@endsection

@section('content')

<button id="new-list" class="positive ui button">add list</button>

<div id="playground" class="ui horizontal segments" style="padding:6px 6px 36px 6px;overflow-x: auto;overflow-y: hidden;max-height: 100%;">

	<div class="six wide column list-wrapper">
		<div class="ui card segment centered">
			{{-- <h4 class="ui top attached inverted header">Header</h4> --}}
			<div class="content" style="background: #545454; color: white;">
				<i class="right floated large add square icon add-new-card"></i>
				<div class="header" style="color: white;">Cute Dog</div>
			</div>
			<div class="content list-cards" id="alist">
				{{-- TODO:multi card types --}}
				{{-- a card --}}
			    <div class="ui centered raised card">
			        <div class="content">
			            <div class="header">
			                Abbreviated Header
			            </div>
			            <div class="ui fluid action input description">
			                <input type="text" placeholder="text here">
			            </div>
			        </div>
			        <div class="extra content">
			            <div class="right floated author">
			                <i class="user icon"></i> Username
			            </div>
			        </div>
			        <div class="ui two bottom attached buttons">
			            <div class="ui button">
			                Action 1
			            </div>
			            <div class="ui button">
			                Action 2
			            </div>
			        </div>
			    </div>
			</div>
		</div>
	</div>

	<div class="six wide column list-wrapper">
		<div class="ui card segment centered">
			{{-- <h4 class="ui top attached inverted header">Header</h4> --}}
			<div class="content" style="background: #545454; color: white;">
				<i class="right floated large add square icon add-new-card"></i>
				<div class="header" style="color: white;">Cute Dog</div>
			</div>
			<div class="content list-cards" id="b">
				{{-- TODO:multi card types --}}
				{{-- a card --}}
			    <div class="ui centered raised card">
			        <div class="content">
			            <div class="header">
			                Abbreviated Header
			            </div>
			            <div class="ui fluid action input description">
			                <input type="text" placeholder="text here">
			            </div>
			        </div>
			        <div class="extra content">
			            <div class="right floated author">
			                <i class="user icon"></i> Username
			            </div>
			        </div>
			        <div class="ui two bottom attached buttons">
			            <div class="ui button">
			                Action 1
			            </div>
			            <div class="ui button">
			                Action 2
			            </div>
			        </div>
			    </div>
			</div>
		</div>
	</div>

	<div class="six wide column list-wrapper">
		<div class="ui card segment centered">
			{{-- <h4 class="ui top attached inverted header">Header</h4> --}}
			<div class="content" style="background: #545454; color: white;">
				<i class="right floated large add square icon add-new-card"></i>
				<div class="header" style="color: white;">Cute Dog</div>
			</div>
			<div class="content list-cards" id="c">
				{{-- TODO:multi card types --}}
				{{-- a card --}}
			    <div class="ui centered raised card">
			        <div class="content">
			            <div class="header">
			                Abbreviated Header
			            </div>
			            <div class="ui fluid action input description">
			                <input type="text" placeholder="text here">
			            </div>
			        </div>
			        <div class="extra content">
			            <div class="right floated author">
			                <i class="user icon"></i> Username
			            </div>
			        </div>
			        <div class="ui two bottom attached buttons">
			            <div class="ui button">
			                Action 1
			            </div>
			            <div class="ui button">
			                Action 2
			            </div>
			        </div>
			    </div>
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

@endsection

@section('script')

<script src="{{ asset('js/Priority.js') }}"></script>
<script src="{{ asset('js/test.js') }}"></script>

@endsection
