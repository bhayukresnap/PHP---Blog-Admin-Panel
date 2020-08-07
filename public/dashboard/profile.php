<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/src/Session.php");
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <?php require_once($_SERVER['DOCUMENT_ROOT']."/templates/css.php"); ?>
  <script type="text/javascript">

  </script>
  <style>
    .ck-editor__editable_inline {
      min-height: 250px;
    }
  </style>
</head>
<body class="app sidebar-mini pace-done"> 
  <?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/header.php"); ?>
  <?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/sidebar.php"); ?>
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1>
          <i class="fa fa-list-alt"></i> Create Post
          <p></p>
        </h1>
      </div>  
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="/"><i class="fa fa-home fa-lg"></i></a></li>
        <li class="breadcrumb-item">Create post</li>
      </ul>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="tile">
          <form class="row" method="POST" action="users/update" enctype="multipart/form-data">
            <div class="col-6">
              <div class="form-group">
                <label>Photo</label>
                <br>
                <img id="image-preview" class="img-fluid mb-2" src="<?php !empty($_SESSION['user']['photo']) ? print($_SESSION['user']['photo']) : print('/images/default-photo.png') ?>">
                <input class="form-control-file" type="file" name="photo" id="image-source" onchange="previewImage()" autocomplete="off">
                <input type="hidden" name="photo_current" value="<?php echo $_SESSION['user']['photo']; ?>">
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label for="title">Username</label>
                <input class="form-control" id="title" type="title" autocomplete="off" value="<?php echo $_SESSION['user']['username']; ?>" disabled>
              </div>
              <div class="form-group">
                <label for="title">Name</label>
                <input class="form-control" id="title" name="name" type="title" required="" autocomplete="off" value="<?php echo $_SESSION['user']['name']; ?>">
              </div>
              <div class="form-group">
                <label for="title">Job</label>
                <input class="form-control" id="title" name="job" type="title" required="" autocomplete="off" value="<?php echo $_SESSION['user']['job']; ?>">
              </div>
              <div class="form-group">
                <input type="submit" name="submit_post" value="Submit" class="btn btn-primary">
              </div>

            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
  <?php require_once($_SERVER['DOCUMENT_ROOT']."/templates/js.php"); ?>
  <?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/notification.php"); ?>

</body>
</html>