<?php


class Displayer
{


    public function displayMainPageQuery($data)
    {

        if ($data) {
            foreach ($data as $item) {
                echo '<div class="book_card">
                            <div class="author_text_wrapper"><p class="author_text">' . $item['name'] . '</p></div>
                            ' . ((!empty($item['image'])) ? '<img src="resources/' . $item['image'] . '" class="cover_photos" alt="book cover photo">' : '<img src="resources/missingbook.jpg" class="cover_photos" alt="book cover photo">') . '
                            <p>' . $item['author'] . '</p>
                            <p>Price: ' . $item['price'] . ' Ft</p>
                            <p>Quantity: ' . $item['quantity'] . ' db</p>
                            <form class="margin-btm-10" action="index.php" method="post">
                                <button class="btn btn-color-primary" name="cart" value="' . $item['id'] . '">Add to Cart</button>
                            </form>
                          </div>';
            }
        } else {
            echo "Nothing meets criteria ";
        }
    }

    public function displayBasicTable($data, $clickable, $quantity_included, $deletable)
    {
        if ($data) {

            echo '<div class="table_wrapper table_format">
                <table class="basic_table">';
            if ($quantity_included xor $deletable) {
                echo '  <colgroup>
                        <col style="width: 20%">
                        <col style="width: 50%">
                        <col style="width: 20%">
                        <col style="width: 10%">
                    </colgroup>';
            } elseif ($quantity_included && $deletable) {
                echo '<colgroup>
                        <col style="width: 15%">
                        <col style="width: 50%">
                        <col style="width: 20%">
                        <col style="width: 10%">
                        <col style="width: 10%">
                    </colgroup>';
            } else {
                echo '<colgroup>
                        <col style="width: 25%">
                        <col style="width: 55%">
                        <col style="width: 20%">
                    </colgroup>';
            }
            echo '  <tr>
                        <th>Author</th>
                        <th>Title</th>
                        <th>Price</th>';
            if ($quantity_included)
                echo '<th>Quantity</th>';
            if ($deletable)
                echo '<th>Action</th>';
            echo '</tr>';

            if ($clickable) {
                foreach ($data as $item) {
                    echo '<tr>
                            <td>' . $item['author'] . '</td>
                            <td><a class="no_text_decor" href="book.php?book_id=' . $item['id'] . '">' . $item['name'] . '</a></td>
                            <td>' . $item['price'] . ' Ft' . '</td>';
                    if ($quantity_included)
                        echo '<td class="quantity_info">' . $item['quantity'] . '</td>';
                    if ($deletable)
                        echo '<td><form action="my-orders.php" method="post">
                                <button class="btn btn-color-delete" name="id" value="' . $item['id'] . '">X</button>
                            </form></td>';
                    echo '</tr>';
                }
            } else {
                foreach ($data as $item) {
                    echo '<tr>
                            <td>' . $item['author'] . '</td>
                            <td>' . $item['name'] . '</td>                            
                            <td>' . $item['price'] . '</td>';
                    if ($quantity_included)
                        echo '<td class="quantity_info">' . $item['quantity'] . '</td>';
                    if ($deletable)
                        echo '<td><form action="my-orders.php" method="post">
                                <button class="btn btn-color-delete" name="id" value="' . $item['id'] . '">X</button>
                            </form></td>';
                    echo '</tr>';
                }
            }
            echo '</table>
            </div>';
        }
    }

    public function displayCategoriesNavBar($data)
    {
        if ($data) {
            foreach ($data as $item) {
                echo '  <li><a href="./index.php?categ=' . $item['name'] . '">' . ucfirst($item['name']) . '</a></li>';
            }
        }
    }

    public function displayCategoriesForAdmin($data)
    {
        if ($data) {
            echo '<table class="categories_table">
            <tr>
                <th>Name</th>
                <th>Action</th>
            </tr>';
            foreach ($data as $item) {
                echo '  <tr>
                            <td>' . $item['name'] . '</td>
                            <td>
                            <form action="categories_admin.php" style="border:none;" method="post">
                                <button class="btn btn-color-delete" name="category_name" value="' . $item['name'] . '">X</button>
                            </form>
                            </td>
                        </tr>';
            }
            echo '</table>';
        }
    }

    public function displayIndividualBook($book)
    {
        $dbcon = new DbCon();
        if ($book) {
            echo '<div class="container" style="justify-content: space-around;">
                    <div class="container_inside">
                    ' . ((!empty($book['image'])) ? '<img src="resources/' . $book['image'] .
                    '" class="book_cover_photo" alt="book cover photo">' : '<img src="resources/missingbook.jpg" class="book_cover_photo" alt="book cover photo">') . '               
                        <div class="container_book_info">
                            <div class="main_info height-25per">
                                <p class="info_title">' . $book['name'] . '</p>
                                <div>
                                <span>by</span>
                                <p class="info_author">' . $book['author'] . '</p>
                                </div>
                            </div>
                            <div class="secondary_info height-25per">
                                <div class="secondary_info_part">
                                    <p>Price: </p>
                                    <p class="info_price">' . $book['price'] . ' Ft' . '</p>
                                </div>
                                <div class="secondary_info_part">
                                    <p>Quantitty: </p>
                                    <p id="info_quantity" class="info_quantity">' . $book['quantity'] . '</p>
                                </div>
                            </div>
                            <div class="categories height-25per">';
                            $data = $dbcon->getBookCategories($book['id']);

                            if ($data){
                            foreach ($data as $item) {
                                echo '<form action="book.php?book_id=' . $book['id'] . '" method="post">';
                                echo '
                                    <button class="btn btn-color-primary" value="' . $item['categ_name'] . '" name="categ_delete">' . $item['categ_name'] . '</button>
                                    </form>
                                ';
                            }
                            }else {
                                echo '<p>There is no category here.</p>';
                            }
                            echo '</div>';

            echo  '<div class="categories">
                        <form action="book.php?book_id=' . $book['id'] . '" method="post">
                            <select name="category" id="category">';
                            $data = $dbcon->getAvailableCategoriesForBook($book['id']);
                            foreach ($data as $item){
                                echo '<option value="'.$item['name'].'">'.$item['name'].'</option>';
                            }
                            echo'</select>
                            <button type="submit" class="btn btn-color-primary" name="categ_submit">Submit</button>
                        </form>
                    </div>';


            echo'
                        </div>
                    </div>
                </div>
                <div class="book_controls">
                    <div style="display: flex;">
                        <form style="width: 100%; " action="book.php?book_id=' . $book['id'] . '" method="post">
                        <input type="text" name="book_id" hidden value="' . $book['id'] . '">
                        <input name="img_name" type="file">
                        <button class="btn btn-color-primary" type="submit">Upload</button>
                        </form>
                    </div>
                    <div style="display: flex; width: 30%;">
                     <form style="width: 100%; " action="book.php?book_id=' . $book['id'] . '" method="post">
                        <button class="btn btn-color-delete" name="delete_book" type="submit" value="' . $book['id'] . '" >Delete book</button>
                     </form>
</div>
                   
                </div>    ';
        }
    }

    public function displayActiveCartItems($data)
    {
        if ($data) {
            echo '<table>
                    <caption class="table_caption">Active carts</caption>
                    <colgroup>
                        <col style="width: 60%;">
                        <col style="width: 40%;">
                    </colgroup>
                    <tr>
                        <th>Session id</th>
                        <th>Book id</th>
                    </tr>';
            foreach ($data as $item) {
                echo '  <tr>
                        <td>' . $item['session_id'] . '</td>
                        <td><a href="book.php?book_id=' . $item['book_id'] . '">' . $item['book_id'] . '</a></td>
                    </tr>';
            }

            echo '</table>';
        }

    }

    public function displayOrders($data)
    {
        if ($data) {
            echo '<table>
                    <caption class="table_caption">Orders</caption>
                    <colgroup>
                        <col style="width: 10%; max-width: 10%; min-width: 10%;">
                        <col style="width: 35%; max-width: 35%; min-width: 35%;">
                        <col style="width: 15%; max-width: 15%; min-width: 15%;">
                        <col style="width: 15%; max-width: 15%; min-width: 15%;">
                        <col style="width: 10%; max-width: 10%; min-width: 10%;">
                        <col style="width: 15%; max-width: 15%; min-width: 15%;">
                    </colgroup>
                    <tr>
                        <th>Order id</th>
                        <th>Session id</th>
                        <th>Username</th>
                        <th>Phone number</th>
                        <th>Book id</th>
                        <th>Date</th>
                    </tr>';
            foreach ($data as $item) {
                echo '  <tr>
                        <td>' . $item['order_id'] . '</td>
                        <td>' . $item['session_id'] . '</td>
                        <td>' . $item['user_name'] . '</td>
                        <td>' . $item['user_phone'] . '</td>
                        <td><a href="book.php?book_id=' . $item['book_id'] . '">' . $item['book_id'] . '</a></td>
                        <td>' . $item['date'] . '</td>
                    </tr>';
            }

            echo '</table>';
        }

    }
}