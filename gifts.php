<?php
include_once 'header.php'; ?>
<section class="home">
  <div class="container">
    <?php include 'navbar.php'; ?>
    <div class="row">
      <div class="col-sm-6 p-3">
        <h3 class=""> Gifts Information</h3>
      </div>
      <div class="col-sm-6 p-3"><a href="gifts_add.php" class="btn btn-success btn-success1">Add Gifts</a></div>
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
                  <!-- <th>Id</th> -->
                  <th>Gifted By</th>
                  <th>Customer Name</th>
                  <th> Email</th>
                  <th> Phone</th>
                  <th> Address</th>
                  <th>Category</th>
                  <th>Product Name</th>
                  <th>Batch No.</th>
                  <th>Quantity</th>
                  <th>Date</th>
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
        'url': 'ajax_gift_product.php'
      },
      'columns': [
        // { data: 'id' },
        { data: 'gifted_by' },
        { data: 'customer_name' },
        { data: 'customer_email' },
        { data: 'customer_phone' },
        { data: 'customer_address' },
        { data: 'category' },
        { data: 'product' },
        { data: 'batch_no' },
        { data: 'quantity' },
        { data: 'date' },
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
              window.location.href = 'gifts_delete.php?id=' + id;
            }, 1000);
        } else {
          swal({
            title: "Your record is safe!",
            // icon: "info",
            timer: 1500,
          });
        }
      });
  }
</script>

<?php include_once 'footer.php'; ?>