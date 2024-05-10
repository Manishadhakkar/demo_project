<?php
include_once 'header.php'; ?>
<section class="home">
    <div class="container">
        <?php include 'navbar.php'; ?>
        <div class="row">
            <div class="col-sm-6 p-3">
                <h3 class=""> Lost Products Information</h3>
            </div>
            <div class="col-sm-6 p-3"><a href="lost_products_add.php" class="btn btn-success btn-success1">Add Lost
                    Products</a></div>
        </div>
        <div class="row bg-white">
            <div class="col-sm-12">
                <div class="col-sm-12 row">
                    <?php
                    // if(isset($_SESSION['msg']) && $_SESSION['msg'] != ''){
                    //     echo "<div class='text-center bg-light' style='background:blue; padding:5px; color:red;'><h3 class='text-black'>".$_SESSION['msg']."</h3></div>";
                    //     unset($_SESSION['msg']);
                    // }
                    ?>
                </div>
                <div class="table">
                    <div class="col-md-12">
                        <table id='empTable' class='display dataTable table manage_queue_table'>
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Plateform</th>
                                    <th>Category</th>
                                    <th>Product Name</th>
                                    <th>Batch No.</th>
                                    <th>Quantity</th>
                                    <th>Order ID</th>
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
                'url': 'ajax_lost_product.php'
            },
            'columns': [
                { data: 'id' },
                { data: 'plateform' },
                { data: 'category' },
                { data: 'product' },
                { data: 'batch_no' },
                { data: 'quantity' },
                { data: 'order_id' },
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
                            window.location.href = 'lost_products_delete.php?id=' + id;
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