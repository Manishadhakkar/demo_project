<?php include_once 'header.php'; ?>
<section class="home">
  <div class="container">

    <?php include 'navbar.php'; ?>

    <div class="row">
      <div class="col-sm-6 p-3">
        <h3 class="">Warehouses Information</h3>
      </div>
      <div class="col-sm-6 p-3"><a href="warehouse_add.php"><button class="btn btn-success btn-success1">Add
            Warehouse</button></a></div>
    </div>
    <div class="row bg-white">
      <div class="col-sm-12">
        <div class="col-sm-12 row">
        </div>
        <div class="table">
          <div class="col-md-12">
            <table id='empTable' class='display dataTable table manage_queue_table'>
              <thead>
                <tr>
                  <th>Id</th>
                  <th> Warehouse Name</th>
                  <th>Warehouse Code</th>
                  <th>Warehouse Address</th>
                  <th>Status</th>
                  <th>Create At</th>
                  <th>Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
  $(document).ready(function () {
    $("#empTable").dataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      'ajax': {
        'url': 'warehouse_ajax.php'
      },
      'columns': [
        { data: 'id' },
        { data: 'name' },
        { data: 'code' },
        { data: 'address' },
        { data: 'status' },
        { data: 'created_at' },
        { data: 'action' }
      ]
    })
  });

  function deleteUser(id) {

    swal({
      title: "Are you sure?",
      text: "Are you sure want to delete this?",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
      .then((willDelete) => {
        if (willDelete) {
          swal({
            title: "Record has been deleted!",
            icon: "success",
            // timer: 2000,
          });
          const myTimeout = setTimeout(
            function location() {
              window.location.href = 'warehouse_delete.php?id=' + id;
            }, 1000);
        } else {
          swal({
            title: "Your record is safe!",
            // icon: "info",
            timer: 2000,
          });
        }
      });
  }
</script>

<?php include_once 'footer.php'; ?>