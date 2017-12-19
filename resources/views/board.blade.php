@extends('layouts.app')

@section('style')
	<link href="{{ asset('css/board.css') }}" rel="stylesheet">
@endsection

@section('content')

@include('layouts.sub-nav')

<div id="playground" class="ui horizontal blue inverted segments">

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
<script src="{{ asset('js/board.js') }}"></script>

@endsection
