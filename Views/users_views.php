<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Users table</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="/styles.css?v=0.1" rel="stylesheet">
  <div class="container">
    <div class="row flex-lg-nowrap">
      <div class="col">
        <div class="row flex-lg-nowrap">
          <div class="col mb-3">
            <div class="e-panel card">
              <div class="card-body">
                <div class="card-title">
                  <h6 class="mr-2"><span>Users</span></h6>
                </div>
                  <?php include ('buttons_table.php'); ?>
                  <div class="e-table">
                  <div class="table-responsive table-lg mt-3">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th class="align-top">
                            <div
                              class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0">
                              <input type="checkbox" class="custom-control-input" id="all-items">
                              <label class="custom-control-label" for="all-items"></label>
                            </div>
                          </th>
                          <th class="max-width">Name</th>
                          <th class="sortable">Role</th>
                          <th>Status</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php foreach ($users as $user) { ?>
                          <tr id="user-row-<?= $user['id']; ?>">
                              <td class="align-middle">
                                  <div class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0 align-top">
                                      <input type="checkbox" class="custom-control-input" id="item-<?= $user['id']; ?>">
                                      <label class="custom-control-label" for="item-<?= $user['id']; ?>"></label>
                                  </div>
                              </td>
                              <td class="text-nowrap align-middle"><?= $user['first_name']; ?> <?= $user['last_name']; ?></td>
                              <td class="text-nowrap align-middle"><span><?= $user['name_role']; ?></span></td>
                              <td class="text-center align-middle"><i class="fa fa-circle <?= ($user['status']) ? 'active' : 'not-active'; ?>-circle"></i></td>
                              <td class="text-center align-middle">
                                  <div class="btn-group align-top">
                                      <button class="btn btn-sm btn-outline-secondary badge" type="button" id="edit-user-<?= $user['id']; ?>"
                                              data-user_id="<?= $user['id']; ?>" data-function="edit" data-toggle="modal" data-target="#user-form-modal">Edit</button>
                                      <button class="btn btn-sm btn-outline-secondary badge delete-user" id="delete_user-<?= $user['id']; ?>" type="button"><i class="fa fa-trash"></i></button>
                                  </div>
                              </td>
                          </tr>
                      <?php }; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                  <?php include ('buttons_table.php'); ?>
              </div>
            </div>
          </div>
        </div>
        <!-- User Form Modal -->
        <div class="modal fade" role="dialog" tabindex="-1" id="user-form-modal">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <form class="form" novalidate="" id="user_form">
                              <input hidden type="text" name="id" value="">
                              <div class="form-group">
                                  <label>First Name*</label>
                                  <input class="form-control" type="text" name="first_name" placeholder="John" value="" required >
                              </div>
                              <div class="form-group">
                                  <label>Last name*</label>
                                  <input class="form-control" type="text" name="last_name" placeholder="Smith" value="" required >
                              </div>
                              <div class="form-group">
                                  <label>Role*</label>
                                  <select class="form-control" aria-label="Default select example" name="id_role" required>
                                      <option selected disabled value="">Select role</option>
                                      <?php foreach ($roles as $role) { ?>
                                          <option value="<?=$role['id'];?>"><?=$role['name'];?></option>
                                      <?php }; ?>
                                  </select>
                              </div>
                              <div class="form-group">
                                  <label class="checkbox-google mt-4">
                                      <input type="checkbox" name="status">
                                      <span class="checkbox-google-switch"></span>
                                      <span class="ml-1">Status</span>
                                  </label>
                              </div>
                          </form>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button class="btn btn-primary" form="user_form" type="submit"></button>
                      </div>

                  </div>
              </div>
        </div>
          <!-- Start Error modal -->
          <div class="modal" id="modal-alert" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title"></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <p></p>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                  </div>
              </div>
          </div>
          <!-- End Error modal -->
      </div>
    </div>
  </div>
<script>
    $("#all-items").click(function(){
        $('input:checkbox').prop('checked', this.checked)
    });
    $(".e-table").on("click", "input[id^='item-']", function(){

        var allCheckboxes = $(".e-table").find("input[id^='item-']");
        var checked = true;
        allCheckboxes.each(function (index, element){
            if(!element.checked) {
                checked = element.checked;
                return false;
            }
        });
        $('#all-items').prop('checked', checked)
    });

    $("#users_actions").on("submit", function(e){
        e.preventDefault();
        if ($("#users_actions")[0].checkValidity() === false) {
            var modal = {
                title: "Error",
                body: "Please choose operation"
            };
            modalError(modal);
            return;
        }

        var users = [];
        $('.e-table tbody input:checked').each(function() {
            users.push($(this).attr('id').split('-').pop());
        });
        if (!users.length) {
            var modal = {
                title: "Error",
                body: "Please choose users"
            };
            modalError(modal);
            return;
        }
        var action = $(this).find("option:selected" ).val();
        var dataSend = {
            action: action,
            users_id: users,
        };

        $.ajax({
            url: '/?action=groupSelect',
            method: 'post',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify(dataSend),
            beforeSend: function (){
                $('#users_actions').find("button").prop('disabled', true);
            },
            success: (function (data) {
                if(data.status) {
                    data.users_id.forEach(function (id) {
                        if(action === 'delete') {
                            $("#user-row-"+id).fadeOut();
                        } else {
                            $("#user-row-"+id).find(".fa-circle").attr("class","fa fa-circle "+ (action === 'setActive' ? 'active' : 'not-active') + "-circle")
                        }

                    })
                } else {
                    var modal = {
                        title: "Error: "+data.error.code ,
                        body: data.error.message
                    };
                    modalError(modal);
                }
                $('.e-table tbody input:checked').prop('checked', false)
            })

        }).done(function(){
            $("#users_actions").find("button").prop('disabled', false)
                                .find("option:disabled" ).prop('selected', true);
        });


    });

    $("#user_form").on("submit", function(e){
        e.preventDefault();
        $(this).find(".error-form").remove();
        if ($("#user_form")[0].checkValidity() === false) {
            $("<div class='error-form' style='color:red'><span>Please fill in the all fields</span></div>").prependTo(this);
            return;
        }
        var button = $(this).find(':submit');
        button.prop('disabled', true);
        var user_id =  $(this).find('input[name=id]').val();
        var action = user_id ? 'update' : 'add';
        $.ajax({
            url: '/?action='+action,
            method: 'post',
            dataType: 'json',
            data: $(this).serialize(),
            success: (function (data) {
                $('#user-form-modal').modal('hide');
                if(data.status){
                    var newUserRow = viewUser(data);
                    if(action === 'add') {
                        $("table tbody").append(newUserRow);
                    } else {
                        $("table tbody").find("tr[id^=user-row-"+user_id+"]").replaceWith($(newUserRow));
                    }
                } else {
                    var modal = {
                        title: "Error: "+data.error.code ,
                        body: data.error.message
                    };
                    modalError(modal);
                }
                button.prop('disabled', false);
            })

        });
    });

    $('#user-form-modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var operation = button.data('function');
        operation = operation.charAt(0).toUpperCase() + operation.slice(1);
        var modal = $(this);
        modal.find('.modal-title').text(operation+' user');
        modal.find('.modal-footer .btn-primary').text(operation)
    })
    $('#user-form-modal').on('hide.bs.modal', function (event) {
        $("#user_form").trigger("reset");
        $("#user_form input[type=text]").attr("value", "");
    });


    $(".e-table").on("click", "button[id^='delete_user-']", function (e) {
        e.preventDefault();
        var id = $(this).attr('id').split('-').pop();
        var name = $("table tbody").find("tr[id^=user-row-"+id+"] td:eq(1)").text();
        var modal = {
            title: "Are you sure???",
            body: "Do you want delete: " + name ,
            button: {
                id: 'delete_button-' + id,
                text: 'Delete'
            }
        };
        modalError(modal);
    })

    $("#modal-alert").on("click", "button[id^='delete_button-']", function(e){
        var user_id = $(this).attr('id').split('-').pop();
        $(this).prop('disabled', true);
        $.ajax({
            url: '/?action=delete&id=' + user_id,
            method: 'post',
            dataType: 'html',
            data: $(this).serialize(),
            success: (function () {
                $("table").find('#user-row-' + user_id).fadeOut();
                $('#modal-alert').modal('hide');
                $('#delete-button').prop('disabled', false);
            })
        }).done(function(){

        });
    });
    $(".e-table").on("click", "button[id^='edit-user-']", function (e) {
        e.preventDefault();
        $(this).text('Wait');
        var user_id = $(this).data('user_id');
        editUser(user_id, this);
    })


    function editUser(user_id, button) {
        var modal = $("#user-form-modal");
        $.ajax({
            url: '/?action=getUser&id=' + user_id,
            method: 'post',
            dataType: 'json',
            data: $(this).serialize()
        }).done(function(data){

            modal.find('input[name="id"]').attr('value', data.user.id);
            modal.find('input[name=first_name]').attr('value', data.user.first_name);
            modal.find('input[name=last_name]').attr('value', data.user.last_name);
            modal.find('select[name=id_role] option[value='+data.user.id_role+']').prop('selected', true);
            modal.find('input[name=status]').prop('checked', (data.user.status === '1'));
            modal.modal('show');
            $(button).text('Edit');
        });
    }

    function viewUser(data) {
        return '<tr id="user-row-'+data.user.id+'">'+
            '<td class="align-middle">'+
            '<div class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0 align-top">'+
            '<input type="checkbox" class="custom-control-input" id="item-'+data.user.id+'">'+
            '<label class="custom-control-label" for="item-'+data.user.id+'"></label>' +
            '</div>'+
            '</td>'+
            '<td class="text-nowrap align-middle">'+data.user.first_name+' '+data.user.last_name+'</td>'+
            '<td class="text-nowrap align-middle"><span>'+data.user.name_role+'</span></td>'+
            '<td class="text-center align-middle"><i class="fa fa-circle '+((data.user.status === '1') ? 'active' : 'not-active')+'-circle"></i></td>'+
           ' <td class="text-center align-middle">'+
                '<div class="btn-group align-top">'+
                    '<button class="btn btn-sm btn-outline-secondary badge" type="button" id="edit-user-'+data.user.id+'"'+
                            ' data-user_id="'+data.user.id+'" data-function="edit" data-toggle="modal" data-target="#user-form-modal">Edit</button>'+
                    '<button class="btn btn-sm btn-outline-secondary badge delete-user" id="delete_user-'+data.user.id+'" type="button"><i class="fa fa-trash"></i></button>'+
                '</div></td></tr>';
    }
    function modalError(data) {
        var modal = $("#modal-alert");
        modal.find('.modal-title').text(data.title);
        modal.find('.modal-body').text(data.body);

        modal.find(".modal-footer button:not(:first)").remove();
        // <button type="button" id="delete-button" class="btn btn-primary" data-user_id>Ok</button>
        if(data.button){
            modal.find(".modal-footer").append('<button type="button" id="'+data.button.id+'" class="btn btn-primary">'+data.button.text+'</button>')
        }
        modal.modal('show');
    }


</script>
</body>
</html>
