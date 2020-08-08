<?php 
  require_once($_SERVER['DOCUMENT_ROOT']."/src/Session.php");
  require_once($_SERVER['DOCUMENT_ROOT']."/src/Controller/Post.php");
  $posts = new Post();
  $select = $condition = '';

  if(isset($_GET['search']) && !empty($_GET['search'])){
    $select = "posts.id, posts.image, posts.title, posts.created_at, posts.updated_at, tags.tag_name, users.name";
    $condition = "inner join users on posts.last_update_by = users.id left join tags_posts on posts.id = tags_posts.post_id left join tags on tags.id = tags_posts.tag_id where posts.title like '%".$_GET['search']."%'";
  }
  
 ?>
 
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/templates/css.php"); ?>
  <script type="text/javascript">
    const posts = <?php print_r(json_encode($posts = $posts->select($condition, $select)));?>;
  </script>
</head>
<body class="app sidebar-mini pace-done"> 
	<?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/header.php"); ?>
	<?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/sidebar.php"); ?>
    <main class="app-content">
    <div class="app-title">
        <div>
          <h1><i class="fa fa-list-alt"></i> Search Posts</h1>
        </div>  
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><a href="/"><i class="fa fa-home fa-lg"></i></a></li>
          <li class="breadcrumb-item">Search posts</li>
        </ul>
      </div>
    <div class="row">
      <div class="col-4">
        <form class="mb-4">
            <div class="form-group">
                <label>Search</label>
                <input type="text" name="search" class="form-control">
            </div>
          </form>
      </div>
      <div class="col-md-12">
        <div class="tile">
          <section class="invoice">
            <div class="row">
              <div class="col-12 table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>No. </th>
                      <th>Image</th>
                      <th>Title</th>
                      <th>Tags</th>
                      <th>Created at</th>
                      <th>Updated at</th>
                      <th>Last update</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="posts-table">
                  </tbody>
                </table>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </main>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/templates/js.php"); ?>
  <?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/notification.php"); ?>
  <script type="text/javascript">
    function fetchPosts(json){
      let str = '';
      let temp = {}
      let count = 1;
      $(json).each(function(index, item){
        if(!temp[item.id]){
          str +=  '<tr id="user_tags_'+item.id+'">'
          str +=    '<td>'+(count)+'</td>'
          str +=    '<td><img src="'+item.image+'" width="100px" class="rounded"></td>'
          str +=    '<td>'+item.title+'</td>'
          str +=    '<td class="tags"></td>'
          str +=    '<td>'+item.created_at+'</td>'
          str +=    '<td>'+item.updated_at+'</td>'
          str +=    '<td>'+item.name+'</td>'
          str +=    '<td>'
          str +=      '<a class="btn btn-warning mx-1" href="/dashboard/posts/edit?id='+item.id+'">Edit</a>'
          str +=      '<a class="btn btn-danger mx-1" href="?delete_post='+item.id+'">Delete</a>'
          str +=    '</td>'
          str +=  '</tr>'
          temp[item.id] = []
          count++;
        }
        item.tag_name ? temp[item.id].push(item.tag_name) : "";
      });
      console.log(temp)
      $('#posts-table').append(str)
      str = '';
      for (id in temp) {
        if(temp[id].length > 0){
          for(data in temp[id]){
            $('#user_tags_'+id+" > .tags").append('<span class="badge badge-pill badge-primary m-1">'+temp[id][data]+'</span>');
          }
        }else{
          $('#user_tags_'+id+" > .tags").append('<span class="badge badge-pill badge-secondary m-1">no tags</span>');
        }
      }
      
    }

    $(document).ready(function(){
      fetchPosts(posts);
    });

  </script>
</body>
</html>