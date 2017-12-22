<script id="card-template" type="text/x-handlebars-template">
    <div class="ui centered raised card" id="@{{card_hash}}" data-id="@{{card_hash}}">
        <div class="content">
            <div class="header" hidden>
                New Card
            </div>
            <div class="ui fluid action input description card-header-edit" style="display:none;">
                <input type="text" placeholder="Card header (required)" value="">
                <button class="ui teal icon button">
                    <i class="checkmark icon"></i>
                </button>
            </div>
        </div>
        <div class="extra content">
            <div class="right floated author">
            </div>
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
