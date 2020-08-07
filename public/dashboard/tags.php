<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/src/Session.php");
require_once($_SERVER['DOCUMENT_ROOT']."/src/Controller/Tag.php");

$tag = new Tag();
if(isset($_GET['tag']) && !empty($_GET['tag'])){
  $tag->insert($_GET['tag']);
}elseif(isset($_GET['delete_tag']) && !empty($_GET['delete_tag'])){
  $tag->delete($_GET['delete_tag']);
}
?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
  <?php require_once($_SERVER['DOCUMENT_ROOT']."/templates/css.php"); ?>
  <script type="text/javascript">
    const tags = <?php count($tag->select()) >= 1 ? print_r(json_encode($tag->select("order by id desc"))) : print("''") ?>;
  </script>
</head>
<body class="app sidebar-mini pace-done"> 
  <?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/header.php"); ?>
  <?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/sidebar.php"); ?>
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1>
          <i class="fa fa-list-alt"></i> Tags
        </h1>
      </div>  
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="/"><i class="fa fa-home fa-lg"></i></a></li>
        <li class="breadcrumb-item">Tags</li>
      </ul>
    </div>

    <div class="row" id="list_tags">
      <div class="col-12">
        <div class="tile">
          <div class="row">
            <div class="col">
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="tile">
          <div class="row">
            <div class="col-4">
              <form method="get">
                <div class="form-group">
                  <label for="title">Tag</label>
                  <input class="form-control" id="tag" name="tag" autocomplete="off">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <?php require_once($_SERVER['DOCUMENT_ROOT']."/templates/js.php"); ?>
  <?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/notification.php"); ?>

  <script type="text/javascript">
    function fetchTags(json){
      let str = '';
      $(json).each(function(index, item){
          str +=  '<span class="badge badge-primary "> '+item.tag_name+' <a href="?delete_tag='+item.id+'" class="badge badge-primary"><i class="fa fa-close"></i></a></span> '
      });
      $('#list_tags .col').append(str);
    }
    $(document).ready(function(){
      fetchTags(tags);
    });
  </script>

</body>
</html>