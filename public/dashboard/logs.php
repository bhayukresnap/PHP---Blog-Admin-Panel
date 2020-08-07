<?php 
  require_once($_SERVER['DOCUMENT_ROOT']."/src/Session.php");
  require_once($_SERVER['DOCUMENT_ROOT']."/src/Controller/Log.php");
  $log = new Log();
  $condition = "join users on logs.user_id = users.id order by id desc";
  $select = "logs.id as id, users.name, logs.text, logs.date, logs.log_type";
  $pagination = isset($_GET['page']) && !empty($_GET['page']) ? $_GET['page'] : 1;
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <?php require_once($_SERVER['DOCUMENT_ROOT']."/templates/css.php"); ?>
  <script type="text/javascript">
    const logs = <?php count($log->select()) >= 1 ? print_r(json_encode($log->select($condition, $select, $pagination))) : print("''") ?>;
  </script>
</head>
<body class="app sidebar-mini pace-done"> 
  <?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/header.php"); ?>
  <?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/sidebar.php"); ?>
  <main class="app-content">
    <div class="app-title">
        <div>
          <h1><i class="fa fa-book"></i> Logs</h1>
          <?php $log->select($condition, $select) ?>
        </div>  
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><a href="/"><i class="fa fa-home fa-lg"></i></a></li>
          <li class="breadcrumb-item">Logs</li>
        </ul>
      </div>
    <div class="row">
      <div class="col-12 paginations_container"></div>
      <div class="col-md-12" id="logs"></div>
      <div class="col-12 paginations_container"></div>
    </div>
  </main>
  <?php require_once($_SERVER['DOCUMENT_ROOT']."/templates/js.php"); ?>
  <?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/notification.php"); ?>
  <script type="text/javascript">
    function fetchLogs(json){
      let str = '';
      $(json).each(function(index, item){
        str +=  '<div class="card mb-3 text-white '+(item.log_type == 0 ? "bg-danger" : item.log_type == 1 ? "bg-primary" : "bg-info")+'">'
        str +=    '<div class="card-body">'
        str +=      '<blockquote class="card-blockquote">'
        str +=        item.name
        str +=        (item.log_type == 0 ? " has removed " : item.log_type == 1 ? " has created " : " has modified ")
        str +=        capitalize(item.text)
        str +=      '<footer><cite>'+item.date+'</cite></footer>'
        str +=      '</blockquote>'
        str +=    '</div>'
        str +=  '</div>'
      });     
      $('#logs').append(str)
    }

    function fetchPaginations(json){
      let str = '';
      str +=  '<ul class="pagination pull-right">'
      $(json).each(function(index, item){
        str +=  item
      });
      str +=  '</ul>'
      $('.paginations_container').append(str)
    }

    $(document).ready(function(){
      fetchLogs(logs["data"]);
      fetchPaginations(logs["page"]);
    });

  </script>
</body>
</html>