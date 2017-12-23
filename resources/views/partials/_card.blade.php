<script id="card-template" type="text/x-handlebars-template">
    <div class="ui centered raised card" id="@{{card_hash}}" data-id="@{{card_hash}}" data-inlist="@{{in_list}}">
        <div class="content">
            <div class="header" hidden>
                @{{#if name}}
                    @{{name}}
                @{{else}}
                    New Card
                @{{/if}}
            </div>
            <div class="ui fluid action input description card-header-edit" style="display:none;">
                <input type="text" placeholder="Card header (required)" value="@{{#if name}} @{{name}} @{{/if}}">
                <button class="ui teal icon button">
                    <i class="checkmark icon"></i>
                </button>
            </div>
        </div>
        <div class="extra content">
        @{{#if tags}}
            @{{#each tags}}
                @{{#if name}}
                    <a class="ui tag label @{{color}}">@{{name}}</a>
                @{{else}}
                    <a class="ui tag label @{{color}}">&nbsp;</a>
                @{{/if}}
            @{{/each}}
        @{{/if}}
        </div>
        <div class="extra content">
            @{{#if users}}
                @{{#each users}}
                    <div class="right floated author">
                        <i class="user icon"></i> @{{name}}
                    </div>
                @{{/each}}
            @{{/if}}
        </div>
        <div class="ui two bottom attached buttons">
            <div class="ui button btn-edit-card">
                <i class="edit icon"></i> Edit
            </div>
            <div class="ui button btn-delete-card">
                <i class="remove icon"></i> Delete
            </div>
        </div>
    </div>
</script>
