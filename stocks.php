<?php
include 'header.php';
?>

<section class="home">
    <div class="container">
        <?php include 'navbar.php'; ?>
        <div class="row">
            <div class="col-sm-6 p-3">
                <h3 class="">Stocks Information</h3>
            </div>
            <div class="col-sm-6 p-3"><a href="add_stocks.php"><button class="btn btn-success btn-success1">Add
                        Stocks</button></a></div>
        </div>
        <div class="row bg-white">
            <div class="col-sm-12">
                <div class="col-sm-12 row">
                </div>
                <form action="download_stocks.php" method="post">
                    <div class="row">
                        <div class="col-sm-2 p-3 pull-right">
                            <label class="pull-right" for="from_date">From Date</label>
                        </div>
                        <div class="col-sm-3 p-3">
                            <input class="form-control input" type="date" name="from_date" id="" />
                        </div>
                        <div class="col-sm-2 p-3">
                            <label class="pull-right" for="to_date">To Date</label>
                        </div>
                        <div class="col-sm-3 p-3">
                            <input class="form-control input" type="date" name="to_date" id="" />
                        </div>
                        <div class="col-sm-2 p-3">
                            <input type="submit" name="download" class="btn btn-primary" value="Download CSV" />
                        </div>
                    </div>
                </form>
                <div class="table">
                    <div class="col-md-12">
                        <table id='empTable' class='display dataTable table manage_queue_table'>
                            <thead>
                                <tr>
                                    <!-- <th>S.No.</th> -->
                                    <th>Inv No.</th>
                                    <th>P.Date</th>
                                    <th>Categoty</th>
                                    <th>Product</th>
                                    <th>Batch No.</th>
                                    <th>MFG</th>
                                    <th>EXP</th>
                                    <th>Qty</th>
                                    <!-- <th>Rem Qty</th> -->
                                    <th>Rate/Pcs</th>
                                    <th>IGST</th>
                                    <th>Amount</th>
                                    <!-- <th>Created At</th> -->
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
                'url': 'ajaxstocks.php'
            },
            'columns': [
                { data: 'invoice_no' },
                { data: 'date' },
                { data: 'category' },
                { data: 'product_name' },
                { data: 'batch_no' },
                { data: 'mfg_date' },
                { data: 'exp_date' },
                { data: 'quantity' },
                // { data: 'rem_qty' },
                { data: 'rate/pcs' },
                { data: 'igst' },
                { data: 'total_amount' },
                { data: 'action' }
            ]
        })
    });

    function deleteStocks(id) {

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
                            window.location.href = 'stocksdata_delete.php?id=' + id;
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