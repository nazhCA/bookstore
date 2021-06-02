<!DOCTYPE html>
<html lang="en">
<?php include_once 'includes/head.php';?>
<body>

<?php
include_once 'includes/logo.php';
?>
<button onclick="location.href='./admin.php'" class="btn btn-color-primary top_left_btn" type="button">Back</button>
<div class="book_container margin-top-30">

    <div class="wrapper">
        <button onclick="location.href='./add_book.php'" class="btn btn-color-primary margin-btm-10" type="button">Add Book...</button>
    </div>
    <?php
    $data = $dbcon->getAllQuery("books");
    $displayer->displayBasicTable($data, true, true, false);
    ?>
    <span>*Please click on the titles to see the book's page.</span>
</div>

<script>
    let quantity_fields = document.getElementsByClassName("quantity_info");
    for (let item of quantity_fields){
        if (parseInt(item.innerText) <= 3) {
            item.style.color = 'red';
        }
    }

</script>

</body>
</html>
