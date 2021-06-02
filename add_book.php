<!DOCTYPE html>
<html lang="en">
<?php include_once 'includes/head.php'?>
<body>

<?php
include_once 'includes/logo.php';
$result = null;
if (!empty($_POST['submit_book'])){
    $result = $dbcon->addBook($_POST['title'], $_POST['author'], $_POST['price'], $_POST['quantity'],  $_POST['image']);
}
if ($result === true){
    echo '<div class="info_bar bg-color-success" onclick="removeBar()" id="infobar"><p>New book created.</p></div>';
}elseif ($result === false) {
    echo '<div class="info_bar bg-color-fail" onclick="removeBar()" id="infobar"><p>Creating book has failed.</p></div>';
}
?>
<button onclick="location.href='./books_admin.php'" class="btn btn-color-primary top_left_btn" type="button">Back</button>
<div>
    <form class="add_book_form" action="add_book.php" method="post">
        <input class="user_input margin-btm-10" required name="author" type="text" placeholder="Author">
        <input class="user_input margin-btm-10" required name="title" type="text" placeholder="Title">
        <input class="user_input margin-btm-10" required name="price" type="number" placeholder="Price">
        <input class="user_input margin-btm-10" required name="quantity" type="number" placeholder="Quantity">
        <input class="user_input margin-btm-10" name="image" type="file" placeholder="Image">
        <div class="add_book_form_controls">
            <button name="submit_book" value="asd" type="submit" class="btn btn-color-primary">Submit</button>
            <button onclick="clearFields()" class="btn btn-color-reset">Reset</button>
        </div>
    </form>
</div>


<script>
    function clearFields() {
        let user_input_fields = document.getElementsByClassName("user_input");
        for (let item of user_input_fields){
            item.value = "";
        }
    }
    function removeBar() {
        let x = document.getElementById("infobar");
        x.remove();
    }
</script>
</body>
</html>
