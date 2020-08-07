<?php 
  require_once($_SERVER['DOCUMENT_ROOT']."/src/Session.php");
  if($_SESSION['user']['role_id'] != 2){
    $notification = array(
      "message"=>"You don't have permission to access this panel",
      "type"=>'danger',
      "icon"=>'exclamation-circle'
    );
    $_SESSION['notification'] = $notification;
    header("Location: /");
    exit;
  }


  require_once($_SERVER['DOCUMENT_ROOT']."/src/Controller/User.php");
  $users = new User();
  $condition = "join roles on users.role_id = roles.id and users.id = users.id where role_id != 2";
  $select = "users.id as id, users.name, users.username, roles.role_name, users.job, users.role_id";
  if(isset($_GET['grant_access']) && !empty($_GET['grant_access'])){
    $users->grant_access($_GET['grant_access']);
  }elseif(isset($_GET['revoke_access']) && !empty($_GET['revoke_access'])){
    $users->revoke_access($_GET['revoke_access']);
  }elseif(isset($_GET['delete_users']) && !empty($_GET['delete_users'])){
   $users->delete($_GET['delete_users']);
}
  

?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <?php require_once($_SERVER['DOCUMENT_ROOT']."/templates/css.php"); ?>
  <script type="text/javascript">
    const users = <?php print_r(json_encode($users->select($condition, $select)));?>;
  </script>
</head>
<body class="app sidebar-mini pace-done"> 
  <?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/header.php"); ?>
  <?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/sidebar.php"); ?>
  <main class="app-content">
    <div class="app-title">
        <div>
          <h1><i class="fa fa-users"></i> User Management</h1>
        </div>  
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><a href="/"><i class="fa fa-home fa-lg"></i></a></li>
          <li class="breadcrumb-item">User Management</li>
        </ul>
      </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#exampleModal">
          Create user
        </button>
          <section class="invoice">
            <div class="row">
              <div class="col-12 table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>No. </th>
                      <th>Username</th>
                      <th>Name</th>
                      <th>Job</th>
                      <th>Role</th>
                      <th>Grant Access</th>
                    </tr>
                  </thead>
                  <tbody id="users-table">
                  </tbody>
                </table>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </main>
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form class="modal-content" method="post" action="users/insert">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Create user</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-12">
              <label for="title">Username</label>
              <input class="form-control" name="username" type="username" required="" autocomplete="off">
            </div>
            <div class="form-group col-12">
              <label for="title">Name</label>
              <input class="form-control" name="name" type="name" required="" autocomplete="off">
            </div>
            <div class="form-group col-12">
              <label for="title">Password</label>
              <input class="form-control" name="password" type="password" required="" autocomplete="off">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
          <input type="submit" name="submit_post" value="Save data" class="btn btn-primary">
        </div>
      </form>
    </div>
  </div>
  <?php require_once($_SERVER['DOCUMENT_ROOT']."/templates/js.php"); ?>
  <?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/notification.php"); ?>
  <script type="text/javascript">
    function fetchUsers(json){
      let str = '';
      $(json).each(function(index, item){
        str +=  '<tr>'
        str +=    '<td>'+(index+1)+'</td>'
        str +=    '<td>'+item.username+'</td>'
        str +=    '<td>'+item.name+'</td>'
        str +=    '<td>'+item.job+'</td>'
        str +=    '<td>'+capitalize(item.role_name)+'</td>'
        str +=    '<td><a class="mx-1 btn '+(item.role_id == 1 ? 'btn-warning' : 'btn-primary')+'" href="'+(item.role_id == 1 ? '?revoke_access=' : '?grant_access=')+item.id+'" >'+(item.role_id == 1 ? 'Revoke' : 'Grant Access')+'</a><a class="btn btn-danger mx-1" href="?delete_users='+item.id+'">Delete</a></td>'
        str +=  '</tr>'
      });     
      $('#users-table').append(str)
    }

    $(document).ready(function(){
      fetchUsers(users);
    });

  </script>
</body>
</html>