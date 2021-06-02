<!DOCTYPE html>
<html lang="en">
<?php include_once 'includes/head.php'?>
<body>

<?php
include_once 'includes/logo.php';
$result = null;
if (!empty($_POST['category'])){
    $result = $dbcon->insertNewCategory($_POST['category']);
} elseif (!empty($_POST['category_name'])){
    $dbcon->deleteCategory($_POST['category_name']);
}
if ($result === true){
    echo '<div class="info_bar bg-color-success" onclick="removeBar()" id="infobar"><p>New category created.</p></div>';
}elseif ($result === false) {
    echo '<div class="info_bar bg-color-fail" onclick="removeBar()" id="infobar"><p>Creating category has failed.</p></div>';
}
?>

<div class="container align_start margin-top-30">
    <div class="block table_format">
        <?php
        $data = $dbcon->getAllQuery("categories");
        $displayer->displayCategoriesForAdmin($data);
        ?>
    </div>
    <div class="block control_panel">
        <p>Make a new category</p>

        <form action="categories_admin.php" method="post">
            <input type="text" name="category" placeholder="Category name">
            <button class="btn btn-color-primary">Create</button>
        </form>
    </div>
    <button onclick="location.href='./admin.php'" class="btn btn-color-primary top_left_btn" type="button">Back</button>
</div>

<script>
    function removeBar() {
        let x = document.getElementById("infobar");
        x.remove();
    }
</script>

</body>
</html>
