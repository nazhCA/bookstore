<?php
$data = $dbcon->getAllQuery("categories");
?>
<div class="navigation_bar_wrapper">
    <ul>
        <li><a href="./index.php">All</a></li>
        <?php
        $displayer->displayCategoriesNavBar($data)
        ?>
        <li><a class="margin-t-30 bg-color-main color-w" href="./my-orders.php">Cart</a></li>
        <li><a class="margin-t-30 bg-color-main color-w" href="./admin.php">Admin</a></li>
    </ul>
</div>