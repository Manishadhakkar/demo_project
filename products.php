<?php
include_once 'header.php'; ?>
<section class="home">
    <div class="container">
        <?php include 'navbar.php'; ?>

        <div class="row">
            <div class="col-sm-6 p-3">
                <h3 class="">Products Information</h3>
            </div>
            <div class="col-sm-6 p-3"><a href="product_add.php" class="btn btn-success btn-success1">Add Products</a>
            </div>
        </div>
        <div class="row bg-white">
            <div class="col-sm-12">
                <div class="col-sm-12 row">
                </div>
                <div class="table">
                    <div class="col-md-12">
                        <table id='empTable' class='display dataTable table manage_queue_table ig_hover'>
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <!-- <th>Vendor</th> -->
                                    <th>Category</th>
                                    <th>Product Name</th>
                                    <th>SKU</th>
                                    <th>Total Products</th>
                                    <th>Alert Qty</th>
                                    <th>Create At</th>
                                    <th>Status</th>
                                    <th>View Image</th>
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
                'url': 'ajaxproduct.php'
            },
            'columns': [
                { data: 'id', targets: [1, 2] },
                // { data:  'vendor'},
                { data: 'category' },
                { data: 'product_name' },
                { data: 'sku' },
                { data: 'total_products' },
                { data: 'minimum_qty' },
                // { data:  'price'},
                // { data:  'quantity'},
                { data: 'created_date' },
                { data: 'status' },
                { data: 'view_image' },
                { data: 'action' },
            ]
            /* ,
            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                if (aData.total_products < aData.minimum_qty) {
                    $('td', nRow).css('background-color', '#dc3d35b0');
                } /* else {
                    $('td', nRow).css('background-color', '#D2D2D2');
                } 
            } */

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
                            window.location.href = 'products_delete.php?id=' + id;
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