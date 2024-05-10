
<?php include_once 'header.php'; ?>
<?php 

$id= $_GET['id'];
$product_sql = "SELECT * FROM `gifts` WHERE `id`= '".$id."'";
$product_res = mysqli_query($conn , $product_sql);
if(mysqli_num_rows($product_res) > 0){
	while($row = mysqli_fetch_assoc($product_res)){

		// echo '<pre>'; print_r($row);
        $fetch_gifted_by = $row['gifted_by'];
		$fetch_customer_name = $row['customer_name'];
        $fetch_customer_email = $row['customer_email'];
        $fetch_customer_phone = $row['customer_phone'];
        $fetch_customer_address = $row['customer_address'];
        $fetch_category = $row['category_id'];
        $fetch_product = $row['product_id'];
        $fetch_batch_no = $row['batch_no'];
        $fetch_quantity = $row['quantity'];
        
	}
 }
if(isset($_POST['update'])){
    $gifted_by  = $_POST['gift'];
    $customer_name = $_POST['name'];
    $customer_email = $_POST['email'];
    $customer_phone = $_POST['phone'];
    $customer_address = $_POST['address'];
    $category = $_POST['category'];
    $product = $_POST['product'];
    $batch_no = $_POST['batch_no'];
    $quantity = $_POST['quantity'];

    $pro_sql = "SELECT `total_products` FROM `products` WHERE `id` = '".$product."'";
        $pro_res = mysqli_query($conn, $pro_sql) or die("query failed : pro_sql");
    
        if(mysqli_num_rows($pro_res) > 0){
            while($rows = mysqli_fetch_assoc($pro_res)){
                $bal_products = $rows['total_products'];
            }
        }
    
        if( $fetch_quantity > $quantity){
            // echo "greater";
            $rem = $fetch_quantity - $quantity;
            $total_pro = $bal_products + $rem;
        }else{
            // echo "less";
            $rem = $quantity - $fetch_quantity;
            $total_pro = $bal_products - $rem;
        }

        // echo $rem.'<br>';
        // echo $total_pro;exit;

        $up_pro = "UPDATE `products` SET `total_products` = '".$total_pro."' WHERE `id` = '".$product."'";

        $up_res = mysqli_query($conn, $up_pro) or die("query failed : up_pro");

            $sql = "UPDATE `gifts` SET `gifted_by`='".$gifted_by."',`customer_name`= '".$customer_name."',`customer_email`= '".$customer_email."',`customer_phone`='".$customer_phone."' , `customer_address`= '".$customer_address."',`category_id`='".$category."', `product_id`= '".$product."', `batch_no`= '".$batch_no."',`quantity`= '".$quantity."' WHERE `id`='".$id."'";
            // echo $sql; exit;

            $result = mysqli_query($conn, $sql) or die("query failed : sql");

            if($_SESSION['role'] == '1'){
                $by = 'Admin';
            }else{
                $by = 'User';
            }
            $activity_type = "Gifts Updated";
            $activity_msg = " Gifts Updated by ".$by;   
            user_activity_log($_SESSION['login_user_id'], $activity_type, $activity_msg);
        
            
            ?>
              <script type="text/javascript">
                            $(document).ready(function() {
                                swal({
                                    title: "Done",
                                    text: "Lost Product Updated Successfully!!",
                                    icon: "success",
                                    button: "OK",
                                    timer: 2000
                                });
                            });
                        </script>
                    <script>
                    const myTimeout = setTimeout(
                        function location(){
                                window.location.href="gifts.php";
                        },2000);
                        </script>
     <?php  
        
    }
         
?>
<section class="home"> 
    <div class="container">

<?php include 'navbar.php';?>
    
    <div class="row">
    <div class="col-sm-2 p-2"><h3 class=""></h3></div>

        <div class="col-sm-4 p-3"><h3 class=""> UPDATE GIFTS</h3></div>
        <div class="col-sm-3 p-2"><h3 class=""></h3></div>
        <div class="col-sm-3 p-2"><a href="gifts.php"><button class="btn btn-success">GIFTS</button></a></div>
    </div>
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
        <!-- <span style="background-color:white; color:red; font-size:20px;"><?php echo isset($message)?$message:''; ?></span> -->
        <form class="form1" action="" method="POST">
        <div class="mt-3">
           <label class="block text-gray-700">Gifted By * </label>
                <select name="gift" id="gift" class="form-control input">
                <option value="Atul Sir"
                <?php if($fetch_gifted_by == 'Atul Sir'){ echo 'selected'; }else{echo '';}?>
                >Atul Sir</option>
                <option value="Jatin Sir"
                <?php if($fetch_gifted_by == 'Jatin Sir'){ echo 'selected'; }else{echo '';}?>
                >Jatin Sir</option>
</select>   
    </div>

    <div class="mt-3">
    <label class="block text-gray-700">Customer Name</label>
        <input type="text" name="name" id="" placeholder="Enter customer name" value="<?php echo $fetch_customer_name ?>" class="form-control input" >
    </div>
    <div class="mt-3">
    <label class="block text-gray-700">Customer Email</label>
        <input type="email" name="email" id="" placeholder="Enter customer Email" value="<?php echo $fetch_customer_email?>" class="form-control input" >
    </div>
    <div class="mt-3">
    <label class="block text-gray-700">Customer Phone</label>
        <input type="number" name="phone" id="" placeholder="Enter customer Phone No." value="<?php echo $fetch_customer_phone?>" class="form-control input" >
    </div>
    <div class="mt-3">
    <label class="block text-gray-700">Customer Address</label>
        <input type="text" name="address" id="" placeholder="Enter customer Address." value="<?php echo $fetch_customer_address?>" class="form-control input" >
    </div>
    
    <div class="mt-3">
    <label class="block text-gray-700">Category </label>
        <select name="category" id="category" class="form-control input">
        <option value="">Select Category</option>
            <?php 
            $category_sql = "SELECT * FROM `category`";
            $category_res = mysqli_query($conn, $category_sql) or die("query failed : sql");
            if(mysqli_num_rows($category_res) > 0){
                while($row = mysqli_fetch_assoc($category_res)){
                    if($row['id']== $fetch_category){
                        $select = "selected";
                    }else{
                        $select = "";
                    }
            ?>
            <option <?php echo $select;?> value="<?php echo $row['id']; ?>"><?php echo $row['category_name']; ?></option>
            <?php }
            } ?>
        </select>

        </div>
    <div class="mt-3">
    <label class="block text-gray-700">Product Name</label>
        <select name="product" id="product" class="form-control input">
        <option value="">Select Product</option>
        <?php
            $options = ''; 
            $product_sql = "SELECT * FROM `products` WHERE `category` = '".$fetch_category."'";
            $product_res = mysqli_query($conn, $product_sql) or die("query failed : product_sql");
            if(mysqli_num_rows($product_res) > 0){
                while($row = mysqli_fetch_assoc($product_res)){
                    if($row['id'] == $fetch_product){
                        $select = "selected";
                    }else{
                        $select = "";
                    }
                    ?>
                     <option <?php echo $select; ?> value="<?php echo $row['id'] ?>"><?php echo $row['product_name'] ?></option>
                     <?php } } ?>
        </select>
    </div>
    <div class="mt-3">
                      <label class="block text-gray-700">Batch No.</label>
                       <select name="batch_no[]" id="batch_no" rel="total_products" class="form-control input batch_no">
                    <option value="">Select Batch</option>
                         <option value=""></option>                   
                </select>
                <b><span id="total_products" style="color:green;font-size:16px;"></span></b>
                <input type="hidden" name="total_products[]" class="total_products" value="" />	
        </div>
    <div class="mt-3">
        <label class="block text-gray-700">Quantity</label>
        <input type="number" name="quantity" id="" placeholder="" value="<?php echo $fetch_quantity ?>" class="form-control input" >
    </div><br>
    <button type="submit" name="update" class="btn btn-success btn-sm btn-block">UPDATE GIFT </button>
    </form>
            </div>
            <div class="col-sm-2"></div>
    </div>
    </div>
</section>
<script>
    $(document).ready(function(){
        $("#category").on("change",function(){
            var c_id = $("#category").val();
            $.ajax({
                url : "product_catg.php",
                type : "POST",
                data : {c_id : c_id},
                success : function(data){
                    $("#product").html(data)
                }
            });
        });
        $("#product").on("change",function(){
            var p_id = $("#product").val();
            $.ajax({
                url : "pro_batch.php",
                type : "POST",
                data : {p_id : p_id},
                success : function(data){
                    $("#batch_no").html(data)
                }
            });
        });
        $(document).on("change",".batch_no",function(){
            var bid = $(this).attr('rel');
            var batch_id = $(this).val();
            // alert(pro_id);
            // alert(bid);
            $.ajax({
                url : "getProductsno.php",
                type : "POST",
                data : {batch_id, batch_id},
                success : function(data){
                    $("#"+bid).text(data);
                    $("."+bid).val(data);
                }
            });
        });
    });
</script>
<?php include_once 'footer.php'; ?>
