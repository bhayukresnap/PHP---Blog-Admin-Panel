<?php 

  if(!isset($_GET['id']) && empty($_GET['id'])){
    header("Location: /dashboard/posts/index");
    exit;
  }

require_once($_SERVER['DOCUMENT_ROOT']."/src/Session.php");
require_once($_SERVER['DOCUMENT_ROOT']."/src/Controller/Tag.php");
require_once($_SERVER['DOCUMENT_ROOT']."/src/Controller/Post.php");
$tags = new Tag();
$post = new Post();
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <?php require_once($_SERVER['DOCUMENT_ROOT']."/templates/css.php"); ?>
  <script type="text/javascript">
    const post = <?php print_r(json_encode($post->select('where id = '.$_GET['id']))); ?>;
    const tags = <?php print_r(json_encode($tags->select()));?>;
    const tags_selected_by_user = <?php print_r(json_encode($post->select('inner join tags_posts on posts.id = tags_posts.post_id where posts.id = '.$_GET['id'], 'tags_posts.tag_id'))); ?>;
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
          <i class="fa fa-list-alt"></i> Update Post
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
          <form class="row" method="POST" action="method/update" enctype="multipart/form-data">
            <div class="col-6">
              <div class="form-group">
                <label>Image</label>
                <img id="image-preview" class="img-fluid mb-2">
                <input class="form-control-file" type="file" name="image" id="image-source" onchange="previewImage()" autocomplete="off">
                <input type="hidden" name="image_current">
                <input type="hidden" name="post_id">
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label for="title">Published at</label>
                <input class="form-control" name="published_at" id="demoDate" type="text" placeholder="Select Date" required="" autocomplete="off">
              </div>
              <div class="form-group">
                <select id="tags" name="tags[]" multiple="multiple" class="form-control"></select>
              </div>
              <div class="form-group">
                <label for="title">Title</label>
                <input class="form-control" id="title" name="title" type="title" required="" autocomplete="off">
              </div>
              <div class="form-group">
                <label>Body</label>
                <textarea name="body" id="editor"></textarea>
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
  <script type="text/javascript">
    const image = post[0]['image'];
    const title = post[0]['title'];
    const body = post[0]['body'];
    const published_at = post[0]['published_at'].replace(" 00:00:00", "");

    ClassicEditor.create( document.querySelector( '#editor' ), {
      removePlugins: ["Image", "ImageCaption", "ImageStyle", "ImageToolbar","ImageUpload", "MediaEmbed"]
    }).then( editor => {
        editor.setData(body);
    } ).catch( error => {
      console.error( error );
    });


    $('#demoDate').datepicker({
      format: "yyyy-mm-dd",
      autoclose: true,
      todayHighlight: true
    });
    $('#demoDate').datepicker('update', published_at);
    function fetchTags(json, selected){
      let str = '';
      $(json).each(function(index, item){
        str +=  '<option value="'+item.id+'">'+capitalize(item.tag_name)+'</option>'
      });
      $('#tags').append(str);
      $(selected).each(function(index, item){
        $('#tags > option[value="'+item.tag_id+'"]').attr('selected', 'selected');
      });
    }
    $(document).ready(function() {
      fetchTags(tags, tags_selected_by_user);
      $('#tags').multiselect();

      $('#image-preview').attr('src', image);
      $('input[name="title"]').val(title);
      $('input[name="image_current"]').val(image);
      $('input[name="post_id"]').val(post[0]['id']);
    });
  </script>
</body>
</html>