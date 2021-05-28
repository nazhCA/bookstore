<!DOCTYPE html>
<html lang="en">
<?php include_once 'includes/head.php'?>

<body>
<?php include_once 'includes/logo.php';
include 'model/DbCon.php';
session_start();
$obj = new DbCon();
if (!empty($_POST['order'])){
    $obj->orderBooks(session_id(), $_POST['user_name'], $_POST['user_phone']);
    $data = [];
}else {
    $data = $obj->getBooksBySessionId(session_id());
}


?>
<div class="main_container_orders">
            <div class="table_wrapper">
                <table>
                    <colgroup>
                        <col style="width: 25%">
                        <col style="width: 60%">
                        <col style="width: 15%">
                    </colgroup>
                    <tr>
                        <th>Author</th>
                        <th>Title</th>
                        <th>Price</th>
                    </tr>
<?php
if ($data){
    foreach ($data as $item){
        echo '        <tr>
                        <td>' . $item['author'] . '</td>
                        <td>' . $item['name'] . '</td>
                        <td>' . $item['price'] . '</td>
                    </tr>
                ';
    }
}
?>
                </table>
            </div>

<div class="button_container">

    <button onclick="location.href='./index.php'" class="btn" type="button">
        Back</button>
    <form class="user_form" action="my-orders.php" method="post">
        <input type="text" name="user_name" class="user_input" placeholder="Name" required>
        <input type="text" name="user_phone" class="user_input" placeholder="Telephone" required>
        <button class="btn" name="order" value="valami">Submit</button>
    </form>
</div>
</div>



<?php include_once 'includes/footer.php'; ?>
</body>
</html>
