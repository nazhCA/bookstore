<!DOCTYPE html>
<html lang="en">
<?php include_once 'includes/head.php'?>
<body>

<?php
include_once 'includes/logo.php';
$result = null;
if (isset($_GET['book_id'])){
    $data = $dbcon->selectBookViaId($_GET['book_id']);

if (isset($_POST['img_name'])){
    $dbcon->uploadImage($_POST['book_id'], $_POST['img_name']);
    header("Refresh:0");
}
if (isset($_POST['category'])){
    $dbcon->updateBookWithCateg($_GET['book_id'], $_POST['category']);
}
if (isset($_POST['categ_delete'])){
    $dbcon->deleteCategoryFromBook($_GET['book_id'], $_POST['categ_delete']);
}
if (isset($_POST['delete_book'])){
    $result = $dbcon->deleteBook($_GET['book_id']);
    if ($result){
        header("Location: ./books_admin.php");
    }
}
?>
    <button onclick="location.href='./admin.php'" class="btn btn-color-primary top_left_btn" type="button">Back</button>
<?php
    $displayer->displayIndividualBook($data);
?>
    <script>
        let quntity_field = document.getElementById("info_quantity");
            console.log(quntity_field.innerText);
            if (parseInt(quntity_field.innerText) <= 3) {
                quntity_field.style.color = 'red';
            }
    </script>
<?php } ?>
</body>
</html>
