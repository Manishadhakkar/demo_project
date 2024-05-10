   <style>
      .bars{
         padding: 3px;
         font-size: 40px;
      }
   </style>
<div class="row background-gry">
   <div class="col-8 d-inline-flex p-2 bars"><i class="fa fa-bars"></i></div>
   <div class="col-2 d-inline-flex p-3"><span class="btn-success1"></span>
   <?php if($_SESSION['role'] == 1){ ?>
      <a href="notification.php"><i class="fa fa-bell fa-2x"></i></a>
      <span id="notification"></span>
      <?php } ?>
   </div>
   <div class="col-2 d-inline-flexx p-3"><span class="btn-success1">Hi,
         <?php echo ucfirst($_SESSION['name']); ?>
      </span>
      <a href="logout.php"><span class="fa fa-sign-out fa-2x" style=color:red></span></a>
   </div>
</div>

<script>
   $(document).ready(function () {
      setInterval(function () {
         $.ajax({
            url: "notificationCount.php",
            type: "POST",
            success: function (data) {
               if (data) {
                  $("#notification").text(data);
               }else{
                  $("#notification").fadeOut();
               }
            }
         });
      }, 5000);
   });
</script>