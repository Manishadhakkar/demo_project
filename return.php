<?php
include_once 'header.php'; ?>
<section class="home">
    <div class="container">
        <?php include 'navbar.php'; ?>
        <div class="row">
            <div class="col-sm-6 p-3">
                <h3 class="">Return Information</h3>
            </div>
            <div class="col-sm-6 p-3">
                <!-- <a href="retrun_csv.php" class="btn-success"><button class="btn btn-success">Return CSV
                        Import</button></a> -->
                <a href="retrun_add.php" class="btn-success"><button class="btn btn-success btn-success1">Add
                        Return</button></a>
            </div>
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
                                    <!-- <th>S.No.</th> -->
                                    <th>Plateform</th>
                                    <th>Order ID</th>
                                    <th>Category</th>
                                    <th>Product</th>
                                    <th>Batch No.</th>
                                    <th>SKU</th>
                                    <th>QTY</th>
                                    <th>C Amount</th>
                                    <th>DOR</th>
                                    <th>Reason</th>
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
                'url': 'ajaxreturn.php'
            },
            'columns': [
                { data: 'plateform' },
                { data: 'order_id' },
                { data: 'category' },
                { data: 'product' },
                { data: 'batch_no' },
                { data: 'sku' },
                { data: 'quantity' },
                { data: 'claim_amount' },
                { data: 'dateofreturn' },
                { data: 'reason' },
                { data: 'action' }
            ],
        })
    });

    function deleteReturn(id) {

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
                            window.location.href = 'return_delete.php?id=' + id;
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