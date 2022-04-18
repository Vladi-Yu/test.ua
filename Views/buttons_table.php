<div class="group-users-operation row m-0">
    <button type="button" id="add-user" class="btn btn-primary col-1" data-toggle="modal" data-target="#user-form-modal">
        <i class="fa fa-plus"></i> Add</button>
    <form class="row col-5" novalidate="" id="users_actions">
        <div class="input-group col-9">
            <select class="custom-select" id="action_user" name="action" aria-label="Example select with button addon" required>
                <option selected disabled value="">Please Select</option>
                <option value="setActive">Set active</option>
                <option value="setNotActive">Set not active</option>
                <option value="delete">Delete</option>
            </select>
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">OK</button>
            </div>
        </div>
    </form>
</div>