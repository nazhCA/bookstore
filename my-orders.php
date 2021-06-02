<!DOCTYPE html>
<html lang="en">
<?php include_once 'includes/head.php'?>

<body>
<?php include_once 'includes/logo.php';

session_start();
if (!empty($_POST['order'])){
    $dbcon->orderBooks(session_id(), $_POST['user_name'], $_POST['user_phone']);
    $data = [];
}else {
    $data = $dbcon->getBooksBySessionId(session_id());
}
if (!empty($_POST['id'])){
    $dbcon->deleteBookFromCart(session_id(), $_POST['id']);
    header("Refresh:0");

}


?>
<div class="main_container_orders margin-top-30">

<?php
    $displayer->displayBasicTable($data, false, false, true);
?>

    <button onclick="location.href='./index.php'" class="btn btn-color-primary top_left_btn" type="button">Back</button>
<div class="button_container">
    <form class="user_form" action="my-orders.php" method="post">
        <input type="text" name="user_name" class="user_input" placeholder="Name" required>
        <input type="text" name="user_phone" class="user_input" placeholder="Telephone" required>
        <button class="btn btn-color-primary" name="order" value="valami">Submit order</button>
    </form>
</div>
</div>



<?php include_once 'includes/footer.php'; ?>
</body>
</html>
