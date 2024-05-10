<?php include_once 'header.php'; ?>
<section class="home">
    <div class="container">
        <?php include 'navbar.php'; ?>
        <div class="row">
            <div class="col-sm-6 p-3">
                <h3 class="">Notifications</h3>
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
                                    <th>SNo.</th>
                                    <th style="text-align:left;">User Name</th>
                                    <th style="text-align:left;">Notification Type</th>
                                    <th style="text-align:left;">Message</th>
                                    <th style="text-align:left;">Date</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function () {
                    $('#empTable').DataTable({
                        'processing': true,
                        'serverSide': true,
                        'order': [[0, 'desc']],
                        'serverMethod': 'post',
                        'ajax': {
                            'url': 'ajaxnotification.php'
                        },
                        'columns': [
                            { data: 'id' },
                            { data: 'username' },
                            { data: 'activity_type' },
                            { data: 'message' },
                            { data: 'activity_time' }

                        ],
                        fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                            if (aData.status == "0") {
                                $('td', nRow).css('background-color', 'rgb(169, 243, 119)');
                            } /* else {
                        $('td', nRow).css('background-color', '#e2f4a0');
                    } */
                        }
                    });
                });
            </script>
            <br>
            <br>
            <br>

        </div>
    </div>
    </div>
    </div>
    </div>

    <script>
        $(document).ready(function () {
            $(window).on("load", function () {
                setTimeout(function () {
                    $.ajax({
                        url: "ajaxnotification_update.php",
                        type: "POST",
                        success: function (data) {
                            if (data) {
                                $("#empTable tbody td").removeAttr('style');
                            }
                        }
                    });
                }, 5000);
            });
        });
    </script>
    <?php require_once('footer.php'); ?>