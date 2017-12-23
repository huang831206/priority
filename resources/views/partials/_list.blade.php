<script id="list-template" type="text/x-handlebars-template">
    <div class="six wide column list-wrapper" data-id="@{{list_hash}}">
        <div class="ui card segment centered">
            <!-- <h4 class="ui top attached inverted header">Header</h4> -->
            <div class="content header-section" style="background: #545454; color: white;">
                <div class="ui fluid action input description list-header-edit" style="display:none;">
                    <input type="text" placeholder="List header (required)" value="@{{name}}">
                    <button class="ui teal icon button">
                        <i class="checkmark icon"></i>
                    </button>
                </div>
                <i class="right floated large add square icon add-new-card"></i>
                <i class="right floated large edit icon edit-list-header"></i>
                <div class="header" style="color: white;">@{{name}}</div>
            </div>
            <div class="content list-cards" id="@{{list_hash}}" data-id="@{{list_hash}}">
            </div>
        </div>
    </div>
</script>
