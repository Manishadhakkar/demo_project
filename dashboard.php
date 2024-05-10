<?php require_once 'header.php'; ?>
<section class="home">
    <div class="container">
        <?php include 'navbar.php'; ?>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3">
                <a href="products.php" class="anchor">
                    <div class="card card-widget stocks">
                        <div class="card-body gradient-3">
                            <div class="media">
                                <div class="media-body">
                                    <h5 class="card-widget__subtitle">TOTAL PRODUCTS</h5>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <?php
                                $pro_sql = "select count(id) as allcount from products";
                                $pro_res = mysqli_query($conn, $pro_sql) or die("query failed : pro_sql");
                                if (mysqli_num_rows($pro_res) > 0) {
                                    $prow = mysqli_fetch_assoc($pro_res); ?>
                                    <span class="allcount">
                                        <?php echo $prow['allcount']; ?>
                                    </span>
                                <?php }
                                ?>
                            </div>
                            <div class="col-md-4">
                                <i class="fa fa-cart-arrow-down fa-3x dash-icon" aria-hidden="true"></i>
                            </div>
                        </div>

                    </div>
                </a>
            </div>
            <div class="col-3">
                <a href="return.php" class="anchor">
                    <div class="card card-widget return">
                        <div class="card-body gradient-4">
                            <div class="media">
                                <h5 class="card-widget__subtitle"> TOTAL RETURN</h5>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <?php
                                $returns = "SELECT `quantity` FROM `return`";
                                $sqls = mysqli_query($conn, $returns);
                                $total_return = 0;
                                if (mysqli_num_rows($sqls) > 0) {
                                    while ($ros = mysqli_fetch_assoc($sqls)) {
                                        $returns_qty[] = $ros['quantity'];
                                    }
                                    for ($i = 0; $i < count($returns_qty); $i++) {
                                        $total_return = $total_return + $returns_qty[$i];
                                    }
                                    ?>

                                    <span class="allcount">
                                        <?php echo $total_return; ?>
                                    </span>
                                <?php }

                                ?>
                            </div>
                            <div class="col-md-4">
                                <i class="fa fa-retweet fa-3x dash-icon" aria-hidden="true"></i>
                            </div>
                        </div>

                    </div>
                </a>
            </div>
            <div class="col-3">
                <a href="category.php" class="anchor">
                    <div class="card card-widget sales">
                        <div class="card-body gradient-4">
                            <div class="media">
                                <div class="media-body">

                                    <h5 class="card-widget__subtitle">TOTAL CATEGORY</h5>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <?php
                                $category = "SELECT * FROM `category`";
                                $sql_category = mysqli_query($conn, $category);

                                if ($rowss = mysqli_num_rows($sql_category)) { ?>
                                    <span class="allcount">
                                        <?php echo $rowss; ?>
                                    </span>
                                <?php }
                                ?>
                            </div>
                            <div class="col-md-4">
                                <i class="fa fa-snowflake-o fa-3x dash-icon" aria-hidden="true"></i>
                            </div>
                        </div>

                    </div>
                </a>
            </div>
            <div class="col-3">
                <a href="gifts.php" class="anchor">
                    <div class="card card-widget gift">
                        <div class="card-body gradient-9">
                            <div class="media">
                                <div class="media-body">
                                    <h5 class="card-widget__subtitle">TOTAL GIFTS</h5>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <?php
                                $gifts = "SELECT `quantity` FROM `gifts`";
                                $sqls = mysqli_query($conn, $gifts);
                                $total_gifts = 0;
                                if (mysqli_num_rows($sqls) > 0) {
                                    while ($rows = mysqli_fetch_assoc($sqls)) {
                                        $gifts_qty[] = $rows['quantity'];
                                    }
                                    for ($i = 0; $i < count($gifts_qty); $i++) {
                                        $total_gifts = $total_gifts + $gifts_qty[$i];
                                    }
                                    ?>

                                    <span class="allcount">
                                        <?php echo $total_gifts; ?>
                                    </span>
                                <?php } ?>
                            </div>
                            <div class="col-md-4">
                                <i class="fa fa-retweet fa-3x dash-icon" aria-hidden="true"></i>
                            </div>
                        </div>

                    </div>
                </a>
            </div>
            <div class="row">
                <div class="col-3">
                    <a href="lost_products.php" class="anchor">
                        <div class="card card-widget lost">
                            <div class="card-body gradient-9">
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="card-widget__subtitle">LOST PRODUCTS</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <?php
                                    $lost = "SELECT `quantity` FROM `lost_product`";
                                    $lost_sqls = mysqli_query($conn, $lost);
                                    $total_losts = 0;
                                    if (mysqli_num_rows($lost_sqls) > 0) {
                                        while ($roows = mysqli_fetch_assoc($lost_sqls)) {
                                            $lost_qty[] = $roows['quantity'];
                                        }
                                        for ($i = 0; $i < count($lost_qty); $i++) {
                                            $total_losts = $total_losts + $lost_qty[$i];
                                        }
                                        ?>
                                        <span class="allcount">
                                            <?php echo $total_losts; ?>
                                        </span>
                                    <?php } ?>
                                </div>
                                <div class="col-md-4">
                                    <i class="fa fa-linode fa-3x dash-icon" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
</section>
<?php include_once 'footer.php'; ?>