<?php include_once 'header.php'; ?>
<section class="home">
    <div class="container">

        <?php include 'navbar.php'; ?>

        <div class="row">
            <div class="col-sm-6 p-3">
                <h3 class="">User Information</h3>
            </div>
            <div class="col-sm-6 p-3"><a href="add_user.php"><button class="btn btn-success btn-success1">Add
                        User</button></a></div>
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
                                    <th>Name</th>
                                    <th>Username/Email</th>
                                    <th>Role</th>
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
                'url': 'ajaxusers.php'
            },
            'columns': [
                { data: 'id' },
                { data: 'name' },
                { data: 'email' },
                { data: 'role' },
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
                        title: "User has been deleted!",
                        icon: "success",
                        // timer: 2000,
                    });
                    const myTimeout = setTimeout(
                        function location() {
                            window.location.href = 'userdata_delete.php?id=' + id;
                        }, 1000);
                } else {
                    swal({
                        title: "User is safe!",
                        // icon: "info",
                        timer: 2000,
                    });
                }
            });
        //        if(confirm('Are you sure you want to delete this ?')) {
        //        window.location='userdata_delete.php?id='+id;
        //        }
        //    return false;
    }
</script>

<?php include_once 'footer.php'; ?>