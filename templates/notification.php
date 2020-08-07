<script type="text/javascript">
  const notification_popup = <?php 
    if(isset($_SESSION['notification'])){
      print_r(json_encode($_SESSION['notification']));
      unset($_SESSION['notification']);
    }else{
      echo "false";
    }
  ?>;
  notification_popup ? notify(notification_popup['message'], notification_popup['type'], notification_popup['icon'], notification_popup['title']) : '';
</script>