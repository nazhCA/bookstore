<!DOCTYPE html>
<html lang="en">
<?php include_once 'includes/head.php'?>
<body>

<?php
include_once 'includes/logo.php';
$carts = $dbcon->getAllQuery("carts");
$orders = $dbcon->getAllQuery("orders");

?>

<button onclick="location.href='./admin.php'" class="btn btn-color-primary top_left_btn" type="button">Back</button>

<div class="container align_start">
    <div class="container_part table_format">
        <?php
        $displayer->displayActiveCartItems($carts);
        ?>
    </div>
    <div class="container_part table_format">
        <?php
        $displayer->displayOrders($orders);
        ?>
    </div>

</div>


</body>
</html>
