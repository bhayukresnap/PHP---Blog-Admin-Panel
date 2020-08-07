

<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">

  <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" id="user-photo" src="<?php !empty($_SESSION['user']['photo']) ? print($_SESSION['user']['photo']) : print('/images/default-photo.png') ?>" alt="User Image" width="60px">
    <div>
      <p class="app-sidebar__user-name" id="user-id"><?php echo $_SESSION['user']['name']?></p>
      <p class="app-sidebar__user-designation" id="user-job"><?php echo $_SESSION['user']['job'] ?></p>
    </div>
  </div>
  <ul class="app-menu">
    <?php 
  $side_bar_list = array(
    array(
      "id"=>"dashboard-menu",
      "text"=> "Dashboard",
      "url"=> "/dashboard/home",
      "role_id"=> "1",
      "icon"=> "fa-dashboard",
      "child" => ""      
    ),
    array(
      "id"=>"users-menu",
      "text"=> "User Management",
      "url"=> "/dashboard/users",
      "role_id"=> "2",
      "icon"=> "fa-users",
      "child" => ""      
    ),
    array(
      "id"=>"",
      "text"=> "Posts",
      "url"=> "#",
      "role_id"=> "1",
      "icon"=> "fa-list-alt",
      "child" => array(
          array(
            "text"=> "All Posts",
            "url"=> "/dashboard/posts/index",
          ),
          array(
            "text"=> "Create Post",
            "url"=> "/dashboard/posts/create",
          ),
          array(
            "text"=> "Search Post",
            "url"=> "/dashboard/posts/search",
          ),
      )      
    ),
    array(
      "id"=>"tags-menu",
      "text"=> "Tags",
      "url"=> "/dashboard/tags",
      "role_id"=> "1",
      "icon"=> "fa-tags",
      "child" => ""      
    ),
    // array(
    //   "id"=>"comments-menu",
    //   "text"=> "Comments (Maintenance)",
    //   "url"=> "#",
    //   "role_id"=> "1",
    //   "icon"=> "fa-comments",
    //   "child" => ""      
    // ),
  );
  foreach($side_bar_list as $key => $data){
    $child_text = "";
    $toggle = "";
    $icon_right = '';
    if(!empty($data['child'])){
      $icon_right = '<i class="treeview-indicator fa fa-angle-right"></i>';
      $child_text = '<ul class="treeview-menu">';
      $toggle = "treeview";
      foreach($data['child'] as $key2 => $child){
        $child_text .= '<li><a class="treeview-item " href="'.$child["url"].'"><i class="icon fa fa-circle-o"></i> '.$child["text"].'</a></li>';
      }
      $child_text .= '</ul>';
    }
    if($data['role_id'] <= $_SESSION['user']['role_id']){
      echo '
        <li class="'.$toggle.'">
          <a id="'.$data["id"].'" class="app-menu__item" href="'.$data["url"].'" data-toggle="'.$toggle.'">
            <i class="app-menu__icon fa '.$data["icon"].'"></i>
            <span class="app-menu__label">'.$data["text"].'</span>
            '.$icon_right.'
          </a>
          '.$child_text.'
        </li>';
    }
  }
 ?>
</aside>