<!DOCTYPE html>
<html lang="en">
<?php include_once 'includes/head.php'?>
<body>
<?php
session_start();
if (!empty($_POST['cart'])){
    $result = $dbcon->addToCart(session_id(), $_POST['cart']);
    if ($result === -1){
        echo '<div class="info_bar bg-color-fail" onclick="removeBar()" id="infobar"><p>Not enough book in store.</p></div>';
    }elseif ($result === false){
        echo '<div class="info_bar bg-color-fail" onclick="removeBar()" id="infobar"><p>Something has gone wrong during the process. The book has not been put in the cart.</p></div>';
    }elseif ($result === true) {
        echo '<div class="info_bar bg-color-success" onclick="removeBar()" id="infobar"><p>The book has been added to your cart.</p></div>';
    }
}
?>
<?php include_once 'includes/logo.php'?>
<?php include_once 'includes/searchbar.php'?>

<div class="main_container">
    <?php include_once 'includes/nav-bar.php'?>

    <section class="main_screen_wrapper">
        <div class="main_screen">
            <?php

            if (!empty($_GET['categ'])){
                $data = $dbcon->getAllBooksViaCategory($_GET['categ']);
            }elseif (!empty($_POST['search'])) {
                $data = $dbcon->getBooksViaSearch('%' . $_POST['search'] . '%');
            }else {
                $data = $dbcon->getAllQuery("books");
            }
            $displayer ->displayMainPageQuery($data);
            ?>
        </div>
    </section>
</div>

<?php include_once 'includes/footer.php'; ?>

<script>
    function removeBar() {
        let x = document.getElementById("infobar");
        x.remove();
    }
</script>

</body>
</html>