<script id="card-modal-template" type="text/x-handlebars-template">
    <div class="ui small modal">
    	<div class="header">@{{name}}</div>
        <!-- TODO: card header edit -->
    	<div class="scrolling content">

            <div class="ui form grid">
                <div class="thirteen wide field column">

                    <div class="field card-modal-users-list" data-card-hash="@{{card_hash}}" data-list-hash="@{{in_list}}">
                        {{-- rendering users in js --}}
                        @{{#each users}}
                            <div class="ui large icon blue label" data-id="@{{id}}">
                                <i class="user icon"></i>
                                    @{{name}}
                                <i class="delete icon btn-delete-user"></i>
                            </div>
                        @{{/each}}
                    </div>

                    <div class="field card-modal-content">
                        <pre>@{{content}}</pre>
                        <div class="ui labeled icon button btn-edit-card-content">
                            <i class="icon edit"></i> edit
                        </div>
                    </div>

                    <div class="field card-modal-edit" hidden>
                        <textarea style="margin-bottom:1em;">@{{content}}</textarea>
                        <div class="ui buttons">
                            <button class="ui cancel button">Cancel</button>
                            <div class="or"></div>
                            <button class="ui positive button active btn-confirm-edit-modal-content">Save</button>
                        </div>
                    </div>

                    <h4 class="ui horizontal divider header">
                        <i class="comments icon"></i>
                        Comments
                    </h4>

                    <form class="ui reply form">
                        <div class="field hidden">
                            <textarea style="max-height: 5em;min-height: 5em;"></textarea>
                        </div>
                        <!-- <div class="ui blue labeled submit icon button">
                            <i class="icon edit"></i> Submit
                        </div> -->
                        <div class="ui teal labeled icon button submit-comment">
                            <i class="icon edit"></i> Add Comment
                        </div>


                    </form>

                </div>
                <div class="three wide column">

                    <div class="ui icon right pointing dropdown button right floated user-select-dropdown" style="margin-bottom:1em;">
                        <i class="users icon"></i>
                        <div class="menu">
                            <div class="ui search icon input">
                                <i class="search icon"></i>
                                <input type="text" name="search" placeholder="Search users...">
                            </div>
                            <div class="header">
                                <i class="users icon"></i>
                                Users
                            </div>
                            {{-- serving the dropdown to all users in board --}}
                            @forelse ($board->users as $user)
                                <div class="item card-users-selection" data-id="{{$user->id}}" data-in-list="@{{in_list}}" data-card-hash=@{{card_hash}}>
                                    <a class="ui item label">{{$user->name}}</a>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>

                    <div class="ui icon right pointing dropdown button right floated tag-select-dropdown" style="margin-bottom:1em;">
                        <i class="tags icon"></i>
                        <div class="menu">
                            <div class="ui search icon input">
                                <i class="search icon"></i>
                                <input type="text" name="search" placeholder="Search tags...">
                            </div>
                            <div class="header">
                                <i class="tags icon"></i>
                                Tags
                            </div>
                            {{-- serving the dropdown to all tags in board --}}
                            @forelse ($board->tags as $tag)
                                <div class="item card-tags-selection" data-id="{{$tag->tag_hash}}" data-in-list="@{{in_list}}" data-card-hash=@{{card_hash}}>
                                    @if(isset($tag->name))
                                        <a class="ui item tag label {{$tag->color}}">{{$tag->name}}</a>
                                    @else
                                        <a class="ui item tag label {{$tag->color}}">&nbsp;</a>
                                    @endif
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>

                    <div class="ui right floated list field card-tags-list" data-in-list="@{{in_list}}" data-card-hash="@{{card_hash}}">
                        {{-- rendering tags tagged on card --}}
                        @{{#each tags}}
                            @{{#if name}}
                                <div class="item" data-id="@{{tag_hash}}">
                                    <a class="ui tag label @{{color}}">@{{name}}</a>
                                </div>
                                <!-- <a class="item"><div class="ui @{{color}} tag label">@{{name}}</div></a> -->
                            @{{else}}
                                <div class="item" data-id="@{{tag_hash}}">
                                    <a class="ui tag label @{{color}}">&nbsp;</a>
                                </div>
                            @{{/if}}
                        @{{/each}}
                        <!-- <div class="item"><a class="ui red tag label">&nbsp;</a></div>
                        <div class="item"><a class="ui orange tag label">&nbsp;</a></div>
                        <div class="item"><a class="ui yellow tag label">&nbsp;</a></div>
                        <div class="item"><a class="ui green tag label">&nbsp;</a></div>
                        <div class="item"><a class="ui teal tag label">&nbsp;</a></div>
                        <div class="item"><a class="ui blue tag label">&nbsp;</a></div>
                        <div class="item"><a class="ui purple tag label">&nbsp;</a></div>
                        <div class="item"><a class="ui pink tag label">&nbsp;</a></div>
                        <div class="item"><a class="ui white tag label">&nbsp;</a></div>
                        <div class="item"><a class="ui black tag label">&nbsp;</a></div> -->
                    </div>

                </div>
            </div>

      </div>
    </div>
</script>
