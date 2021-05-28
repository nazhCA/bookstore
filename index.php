<!DOCTYPE html>
<html lang="en">
<?php include_once 'includes/head.php'?>
<body>

<?php include_once 'includes/logo.php'?>
<?php include_once 'includes/searchbar.php'?>

<div class="main_container">
    <?php include_once 'includes/nav-bar.php'?>
    <section class="main_screen_wrapper">
        <div class="main_screen">
            <?php
            session_start();
            include 'model/DbCon.php';
            $obj = new DbCon();

            if (!empty($_GET['categ'])){
                $data = $obj->getAllBooksViaCategory($_GET['categ']);
            }elseif (!empty($_POST['search'])) {
                $data = $obj->getBooksViaSearch('%' . $_POST['search'] . '%');
            }else {
                $data = $obj->getAllBooks();
            }

            if (!empty($_POST['cart'])){
                $result = $obj->addToCart(session_id(), $_POST['cart']);
                if ($result === -1){
                    echo '<script>alert("Not enough book in store.")</script>';
                }elseif ($result === false){
                    echo '<script>alert("Something has gone wrong during the process. The book has not been put in the cart.")</script>';
                }elseif ($result === true) {
                    echo '<script>alert("The book has been added to your cart.")</script>';
                }
            }

            if ($data){
                foreach ($data as $item){
                    echo '<div class="book_card">
                            <div class="author_text_wrapper"><p class="author_text">' . $item['name'] . '</p></div>
                            <img src="resources/' . $item['image'] . '" class="cover_photos" alt="book cover photo">
                            <p>' . $item['author'] . '</p>
                            <p>Price: ' . $item['price'] . ' Ft</p>
                            <p>Quantity: ' . $item['quantity'] . ' db</p>
                            <form class="margin-btm-10" action="index.php" method="post">
                                <button class="btn" name="cart" value="' . $item['id'] . '">Add to Cart</button>
                            </form>
                          </div>';
                }
            } else {
                echo "Nothing meets criteria ";
            }
            ?>
        </div>
    </section>
</div>

<?php include_once 'includes/footer.php'; ?>

</body>
</html>